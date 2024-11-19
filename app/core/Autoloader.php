<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 15:24:42
 * @ Description: Auto-chargements des classes
 */

namespace App\Core;

/**
 * Autoloader class responsible for automatically loading classes based on their file path.
 *
 * This class registers an autoload function with the SPL autoload registry, which is called
 * whenever a class is referenced that has not been defined yet. The autoload function
 * attempts to load the class from the appropriate file path, first checking the core
 * directory, then the controllers directory, and finally the models directory.
 */
class Autoloader
{
    /**
     * Registers the autoload function with the SPL autoload registry.
     * This allows the Autoloader class to automatically load classes
     * as they are referenced throughout the application.
     */
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    /**
     * Autoloads a class by attempting to load it from the appropriate file path.
     *
     * This method is called by the SPL autoload registry whenever a class is referenced
     * that has not been defined yet. It checks the appropriate directory based on the class namespace.
     *
     * @param string $class The name of the class to be autoloaded.
     */
    public static function autoload($class)
    {
        $directories = [
            'App\\Core\\'        => '../app/core/',
            'App\\Controllers\\' => '../app/controllers/',
            'App\\Helpers\\'    =>  '../app/helpers/',
            'App\\Models\\'      => '../app/models/',
            'App\\Services\\'    => '../app/services/',
        ];
        if(self::searchClass($class, $directories)) {
            return;
        }

        $directories = [
            'App\\Core\\'        => 'app/core/',
            'App\\Controllers\\' => 'app/controllers/',
            'App\\Helpers\\'    =>  'app/helpers/',
            'App\\Models\\'      => 'app/models/',
            'App\\Services\\'    => 'app/services/',
        ];

        if(!self::searchClass($class, $directories)) {
            throw new \Exception("Class $class not found.");
        }
    }

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

    private static function getNamespace($class) {
        $namespace = explode('\\', $class);
        return $namespace[0];
    }
}
