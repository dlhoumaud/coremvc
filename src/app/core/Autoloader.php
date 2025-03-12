<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-12 16:37:02
 * @ Description: Classe AutolOader responsable du chargement automatique des classes en fonction de leur chemin de fichier.
 */

namespace App\Core;

/**
 * Classe AutolOader responsable du chargement automatique des classes en fonction de leur chemin de fichier.
 *
 * Cette classe enregistre une fonction Autoload avec le registre SPL Autoload, qui est appelé
 * Chaque fois qu'une classe est référencée qui n'a pas encore été définie.La fonction automatique
 * tente de charger la classe à partir du chemin de fichier approprié, vérifiant d'abord le noyau
 * Répertoire, puis le répertoire des contrôleurs, et enfin le répertoire des modèles.
 */
class Autoloader
{
    /**
     * Enregistre la fonction Autoload avec le registre SPL Autoload.
     * Cela permet à la classe AutolOader de charger automatiquement les classes
     * Comme ils sont référencés tout au long de la demande.
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Autoloads une classe en essayant de le charger à partir du chemin de fichier approprié.
     *
     * Cette méthode est appelée par le registre SPL Autoload chaque fois qu'une classe est référencée
     * Cela n'a pas encore été défini.Il vérifie le répertoire approprié en fonction de l'espace de noms de classe.
     *
     * @param string $class Le nom de la classe à être automatiquement.
     */
    public static function autoload($class)
    {
        $directories = [
            'App\\Core\\'        => '../app/core/',
            'App\\Controllers\\' => '../app/controllers/',
            'App\\Helpers\\'    =>  '../app/helpers/',
            'App\\Models\\'      => '../app/models/',
            'App\\Services\\'    => '../app/services/',
            'Tests\\'            => '../tests/',
        ];
        if(self::searchClass($class, $directories)) {
            return;
        }

        $directories = [
            'App\\Core\\'        => 'app/core/',
            'App\\Controllers\\' => 'app/controllers/',
            'App\\Helpers\\'     => 'app/helpers/',
            'App\\Models\\'      => 'app/models/',
            'App\\Services\\'    => 'app/services/',
            'Tests\\'            => 'tests/',
        ];

        if(!self::searchClass($class, $directories)) {
            throw new \Exception("Class $class not found.");
        }
    }

    /**
     * Recherche une classe dans les répertoires spécifiés et le charge si elle est trouvée.
     *
     * Cette méthode est une fonction d'assistance pour la méthode Autoload.Il itére à travers
     * Les répertoires fournis, vérifient si la classe est dans l'espace de noms et tente
     * Pour charger la classe à partir du chemin de fichier correspondant.
     *
     * @param string $class Le nom de la classe à rechercher et à charger.
     * @param array $directories Un tableau associatif d'espace de noms => mappages de répertoires.
     * @return bool Vrai si la classe a été trouvée et chargée, fausse autrement.
     */
    private static function searchClass($class, $directories) {
        foreach ($directories as $namespace => $directory) {
            if (strpos($class, $namespace) === 0) {  // Check if the class is in the namespace
                $class_final = str_replace([$namespace], '', $class); // Remove the namespace part
                $class_final = str_replace('\\', '/', $class_final); // Convert namespace to file path

                $classPath = $directory . $class_final . '.php';
                if (file_exists($classPath)) {
                    require_once $classPath;
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Obtient l'espace de noms de la classe donnée.
     *
     * Cette méthode extrait l'espace de noms du nom de classe entièrement qualifié.
     *
     * @param string $class Le nom de classe entièrement qualifié.
     * @return string L'espace de noms de la classe.
     */
    private static function getNamespace($class) {
        $namespace = explode('\\', $class);
        return $namespace[0];
    }
}
