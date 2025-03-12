<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-12 17:28:12
 * @ Description: outil de développement
 */
namespace App\Bin;

use Exception;

use App\Core\Autoloader;
use App\Helpers\LogTerminal;

include_once 'app/core/Functions.php'; // Fonctions globales
// Charger l'autoloader personnalisé
require_once 'app/core/Autoloader.php';

// Initialiser l'autoloader
Autoloader::register();


function runTests($dir)
{
    $terminal = new LogTerminal('cmd');
    foreach (scandir($dir) as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $path = "$dir/$file";
        if (is_dir($path)) {
            runTests($path);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            require_once $path;
            $className = 'Tests\\' . str_replace('/', '\\', substr($path, 6, -4));
            $terminal->i("Running $className");
            $testClass = new $className();
            foreach (get_class_methods($testClass) as $method) {
                if (strpos($method, 'test') === 0) {
                    try {
                        $testClass->$method();
                        $terminal->o("$method");
                    } catch (\Exception $e) {
                        $terminal->e("$method : " . $e->getMessage() );
                        exit(1);
                    }
                }
            }
        }
    }
}

runTests('tests');
exit(0);