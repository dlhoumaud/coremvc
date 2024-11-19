<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:28:24
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 13:55:09
 * @ Description: Class responsible for handling routing and URL parsing.
 */

namespace App\Core;

use App\Controllers\ErrorController;

class Router
{
    private $routes = [];

    public function __construct()
    {
        $this->loadRoutes();
    }

    private function loadRoutes()
    {
        $jsonFile = '../config/routes.json';
        $cacheFile =  '../storage/cache/routes.php';

        // Vérifier si le fichier de cache existe et est à jour
        if (file_exists($cacheFile) && filemtime($cacheFile) >= filemtime($jsonFile)) {
            // Charger les routes depuis le fichier de cache
            $this->routes = include $cacheFile;
        } else {
            // Charger les routes depuis le fichier JSON
            $this->routes = json_decode(file_get_contents($jsonFile), true);

            // Générer le fichier de cache en écrivant un tableau PHP
            $this->generateCache($cacheFile);
        }
    }

    private function generateCache($cacheFile)
    {
        $content = '<?php return ' . var_export($this->routes, true) . ';';
        file_put_contents($cacheFile, $content);
    }

    /**
     * Dispatches the requested URI to the appropriate controller and action.
     *
     * @param string $uri The requested URI.
     */
    public function dispatch($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        // Vérifier si la route existe
        if (array_key_exists($uri, $this->routes)) {
            $controllerName = 'App\Controllers\\'.$this->routes[$uri]['controller'];
            $actionName = $this->routes[$uri]['action'];

            // Instancier le contrôleur et appeler l'action
            $controller = new $controllerName();
            $controller->$actionName();
            return;
        } else {
            // Vérifier les routes avec paramètres
            foreach ($this->routes as $route => $routeInfo) {
                // Utiliser une expression régulière pour vérifier si la route correspond
                $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route);
                if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                    // Extraire les paramètres
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    $controllerName = 'App\Controllers\\' . $routeInfo['controller'];
                    $actionName = $routeInfo['action'];

                    // Instancier le contrôleur et appeler l'action avec les paramètres
                    $controller = new $controllerName();
                    call_user_func_array([$controller, $actionName], $params);
                    return;
                }
            }
        }
        $controller = new ErrorController();
        $controller->e404();
    }
}
