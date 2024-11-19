<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 14:05:40
 * @ Description: Script de démarrage de l'application
 */

use App\Core\Autoloader;
use App\Core\Router;

session_start();

require_once '../config/config.php'; // Configurations de l'application

loadEnvWithCache('../.env', '../storage/cache/env.php');

// Charger l'autoloader personnalisé
require_once '../app/core/Autoloader.php';

// Initialiser l'autoloader
Autoloader::register();

// Créer une instance du routeur et gérer la requête
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
