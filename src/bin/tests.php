<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-13 01:19:05
 * @ Description: outil de développement
 */
namespace App\Bin;

use Exception;

use App\Core\Autoloader;
use App\Helpers\LogTerminal;
session_start();

include_once 'app/core/Functions.php'; // Fonctions globales

if (file_exists('settings/.env')){
    loadEnvWithCache('settings/.env', 'storage/cache/env.php');
}


if (getenv('APP_DEBUG')) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

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
            $testClass->setUp();
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
            $testClass->tearDown();
        }
    }
}

runTests('tests');
exit(0);