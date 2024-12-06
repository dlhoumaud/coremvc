<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:28:24
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-06 10:39:24
 * @ Description: Classe responsable de la gestion du routage et de l'analyse d'URL.
 */

namespace App\Core;

use App\Core\Language;
use App\Controllers\ErrorController as Error;

class Router
{
    private $routes = [];

    public function __construct()
    {
        Language::set_language();
        $this->loadRoutes();
    }

    /**
     * Charge les routes de l'application à partir d'un fichier JSON et les cache dans un fichier PHP.
     *
     * Cette méthode vérifie d'abord si une version en cache des routes existe et est à jour.
     * Si le cache est valide, il charge les itinéraires à partir du fichier mis en cache.Sinon, c'est
     * Charge les routes à partir du fichier JSON, puis génère un nouveau fichier de cache.
     */
    private function loadRoutes()
    {
        $jsonFile = '../settings/routes.json';
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

    /**
     * Génère un fichier de cache contenant les itinéraires de l'application.
     *
     * Cette méthode écrit le tableau $ this-> routes vers un fichier PHP, qui peut être chargé
     * Plus efficacement que l'analyse du fichier JSON d'origine.
     *
     * @param string $cacheFile Le chemin d'accès au fichier de cache à générer.
     */
    private function generateCache($cacheFile)
    {
        $content = '<?php return ' . var_export($this->routes, true) . ';';
        file_put_contents($cacheFile, $content);
    }

    /**
     * Envoie l'URI demandé au contrôleur et à l'action appropriés.
     *
     * @param string $uri L'URI demandé.
     */
    public function dispatch($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        // Vérifier si la route existe
        if (array_key_exists($uri, $this->routes)) {
            $controllerName = 'App\Controllers\\'.$this->routes[$uri]['controller'];
            $_SESSION['controller']=preg_replace('/Controller$/','',$this->routes[$uri]['controller']);
            Language::load_language();
            $actionName = $this->routes[$uri]['action'];
            // Instancier le contrôleur et appeler l'action
            $controller = new $controllerName();
            $controller->$actionName();
            return;
        } 
        // Vérifier les routes avec paramètres
        foreach ($this->routes as $route => $routeInfo) {
            // Convertir la route en expression régulière, y compris les extensions
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                // Extraire les paramètres
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $controllerName = 'App\Controllers\\' . $routeInfo['controller'];
                $_SESSION['controller']=preg_replace('/Controller$/','',$routeInfo['controller']);
                Language::load_language();
                $actionName = $routeInfo['action'];
                // Instancier le contrôleur et appeler l'action avec les paramètres
                $controller = new $controllerName();
                call_user_func_array([$controller, $actionName], $params);
                return;
            }
        }
        Error::e404();
    }

    
}
