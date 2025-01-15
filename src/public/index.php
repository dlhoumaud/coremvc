<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: GloomShade
 * @ Modified time: 2025-01-14 16:27:18
 * @ Description: Script de démarrage de l'application
 */

use App\Core\Autoloader;
use App\Core\Router;
use App\Helpers\Session;
session_start();

require_once '../app/core/Functions.php'; // Functions globales

loadEnvWithCache('../settings/.env', '../storage/cache/env.php');

// Charger l'autoloader personnalisé
require_once '../app/core/Autoloader.php';

// Initialiser l'autoloader
Autoloader::register();

// Créer une instance du routeur et gérer la requête
$router = new Router();
$router->dispatch($_SERVER['REQUEST_URI']);
