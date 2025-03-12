<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: GloomShade
 * @ Modified time: 2025-03-12 10:50:32
 * @ Description: outil de développement
 */
namespace App\Bin;

use Exception;

use App\Core\Autoloader;
use App\Core\Router;
use App\Core\Model;
use App\Helpers\Log;
use App\Helpers\LogTerminal;

include_once 'bin/includes/functions.php'; // Fonctions Spécifique à morty
// Inclure les fichiers nécessaires
include_once 'app/core/Functions.php'; // Fonctions globales

if (file_exists('settings/.env')){
    loadEnvWithCache('settings/.env', 'storage/cache/env.php');
}

// Charger l'autoloader personnalisé
require_once 'app/core/Autoloader.php';

// Initialiser l'autoloader
Autoloader::register();

$terminal = new LogTerminal('cmd');

// Définition des options
$options = getopt("s:e:d:k:t:M:S:c:n:r:v:C:h", ["server:", "encrypt:", "decrypt:", "key:", "type:", "migrate:", "seed:", "create:", "name:", "route:","view:", "cache:", "help"]);

// Affichage de l'aide si l'option -h ou --help est utilisée
if (isset($options['h']) || isset($options['help'])) {
    echo "CoreMVC - Un framework MVC en PHP\n
Copyright (C) 2024  David Lhoumaud
This program comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions.\n\n"
    . "Utilisation : php bin/morty.php [options]\n"
    . "Options disponibles :\n"
    . "  -s, --server [adresse:port]                 : Lance un serveur de développement PHP à l'adresse et au port spécifiés.\n"
    . "  -e, --encrypt [file]                        : Chiffre un fichier spécifique.\n"
    . "  -d, --decrypt [file]                        : Déchiffre un fichier spécifique.\n"
    . "  -k, --key [key]                             : Spécifiez une clé de chiffrement personnalisée.\n"
    . "  -t, --type [prod|devel|local]               : Spécifiez une extension à ajouter ou à supprimer pour le fichier chiffré.\n"
    . "  -M, --migrate [up|down|create]              : Exécute les migrations.\n"
    . "  -S, --seed [up|down|create]                 : Exécute les seeders.\n"
    . "  -c, --create [controller|model|service|all] : Créer une classe.\n"
    . "  -n, --name [classname]                      : Nom de la classe.\n"
    . "  -r, --route [/path:controller@action]       : Ajoute une route.\n"
    . "  -v, --view [path view]                      : Ajoute une vue.\n"
    . "  -C, --cache [all|views|logs|routes|env]     : Nettoyage des caches.\n"
    . "  -h, --help                                  : Affiche ce message d'aide.\n";
    exit(0);
}

// Vérification de l'option -s pour lancer le serveur
if (isset($options['s']) || isset($options['server'])) {
    $host = 'localhost'; // L'adresse de votre serveur
    $port = 8000; // Le port sur lequel le serveur écoutera

    // Le répertoire racine de votre projet (assurez-vous que 'public' existe)
    $documentRoot = './public'; // Utiliser le répertoire public
    
    // Récupération de l'adresse et du port
    $address = isset($options['s']) ? $options['s'] : $options['server'];
    if (!$address) {
        $address = $host . ':' . $port;
    }

    // Vérifiez si le répertoire public existe avant de démarrer le serveur
    if (!is_dir($documentRoot)) {
        $terminal->e("Le répertoire '$documentRoot' n'existe pas.");
        exit(1);
    }

    // Démarrer le serveur de développement PHP
    $terminal->i("Lancement du serveur PHP sur http://$address");
    // echo "Lancement du serveur PHP sur http://$address\n";

    // Si vous utilisez exec(), vous pouvez également capturer la sortie d'erreur
    exec("php -S $address -t $documentRoot", $output, $returnVar);

    // Si une erreur se produit avec exec(), afficher un message d'erreur
    if ($returnVar !== 0) {
        $terminal->e("Erreur lors du démarrage du serveur PHP :");
        echo implode("\n", $output);
        exit(1);
    }
    exit(0);
}

if (isset($options['e']) || isset($options['encrypt'])) {
    $fileToEncrypt = $options['e'] ?? $options['encrypt'];
    if (!file_exists($fileToEncrypt)) {
        $terminal->e("aucun fichier spécifié pour le chiffrement.");
        exit(1);
    }
    // Chiffrement du fichier
    $ext='';
    if (isset($options['t']) || isset($options['type'])) {
        $ext='.'.$options['t'] ?? $options['type'];
    }
    $encryptedContent = encryptFile($fileToEncrypt, $fileToEncrypt.$ext, $options['k'] ?? $options['key']);
    $terminal->o("Le fichier a été chiffré avec succès.");
    exit(0);
}

if (isset($options['d']) || isset($options['decrypt'])) {
    $fileToDecrypt = $options['d'] ?? $options['decrypt'];
    $ext='';
    if (isset($options['t']) || isset($options['type'])) {
        $ext='.'.$options['t'] ?? $options['type'];
    }
    if (!file_exists($fileToDecrypt.$ext)) {
        $terminal->e("aucun fichier spécifié pour le déchiffrement.");
        exit(1);
    }
    // Déchiffrement du fichier
    $decryptedContent = decryptFile($fileToDecrypt.$ext, $fileToDecrypt, $options['k'] ?? $options['key']);
    $terminal->o("Le fichier a été déchiffré avec succès.");
    exit(0);
}

if ((isset($options['M']) || isset($options['migrate'])) || (isset($options['S']) || isset($options['seed']))) {
    if (isset($options['M']) || isset($options['migrate'])) {
        $action = $options['M'] ?? $options['migrate'];
        $is_seed = false;
        $migrationDir ='database/migrate/';
    } else {
        $action = $options['S'] ?? $options['seed'];
        $is_seed = true;
        $migrationDir ='database/seeders/';
    }

    if ($action == 'create') {
        file_put_contents($migrationDir.microtime(true).'.action_name_table.php', '<?php return [
    \'up\' => "",
    \'down\' => "",
]; ');
        exit(0);
    }
    
    try {
        $files = scanDirectory($migrationDir);
        foreach ($files as $file) {
            if (!is_dir($migrationDir.$file)) {
                // Exécution de la migration 'up' pour créer la table
                runMigration(new Model(), $migrationDir.$file, $action, $is_seed);
            }
        }
        
        
        // Exécution de la migration 'down' pour supprimer la table
        // runMigration($db, $migrationFile, 'down');
    } catch (Exception $e) {
        $terminal->e($e->getMessage());
    }
    exit(0);
}


$create_controller=false;
$is_ok=false;
if ((isset($options['c']) || isset($options['create'])) && (isset($options['n']) || isset($options['name']))) {
    $type = $options['c'] ?? $options['create'];
    $name = $options['n'] ?? $options['name'];
    switch ($type) {
        case 'controller':
            createController($name);
            $create_controller=true;
            break;
        case 'model':
            createModel($name);
            break;
        case 'service':
            createService($name);
            break;
        case 'all':
            createController($name, '');
            createService($name);
            createModel($name);
            $create_controller=true;
            break;
        default:
            $terminal->e("Type de classe non valide.");
            exit(1);
    }
    $is_ok=true;
}

if (isset($options['r']) || isset($options['route'])) {
    $route = explode("@", $options['r'] ?? $options['route']);
    if ($create_controller) {
        $pc = explode(":", $route[0]);
        $pc = [$pc[0], ucfirst($name)];
    } else {
        $pc = explode(":", $route[0]);
    }
    if (!isset($pc[1])) {
        $terminal->e("Le controller n'est pas spécifié.");
        exit(1);
    }
    $routes = json_decode(file_get_contents('settings/routes.json'), true);
    $routes[$pc[0]] = [
        'controller' => $pc[1].'Controller',
        'action' => $route[1]??'show',
    ];
    file_put_contents('settings/routes.json', json_encode($routes, JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    $is_ok=true;
}

if (isset($options['v']) || isset($options['view'])) {
    file_put_contents('app/views/'.($options['v'] ?? $options['view']).'.view', '<div class="container my-5">
    
</div>');
    $is_ok=true;
}

if (isset($options['C']) || isset($options['cache'])) {
    switch ($options['C'] ?? $options['cache']) {
        case 'all':
            $cacheDir = 'storage/cache/views/';
            if (is_dir($cacheDir)) {
                $files = scandir($cacheDir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        unlink($cacheDir . $file);
                    }
                }
                $terminal->o("Le cache des vus a été vidé avec succès.");
            } 
            $cacheDir = 'storage/cache/logs/';
            if (is_dir($cacheDir)) {
                $files = scandir($cacheDir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        unlink($cacheDir . $file);
                    }
                }
                $terminal->o("Le cache des logs a été vidé avec succès.");
            } 
            unlink('storage/cache/routes.php');
            $terminal->o("Le cache des routes a été vidé avec succès.");
            unlink('storage/cache/env.php');
            $terminal->o("Le cache de l'environement a été vidé avec succès.");
        break;
        case 'views':
            $cacheDir = 'storage/cache/views/';
            if (is_dir($cacheDir)) {
                $files = scandir($cacheDir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        unlink($cacheDir . $file);
                    }
                }
                $terminal->o("Le cache des vus a été vidé avec succès.");
            } 
        break;
        case 'logs':
            $cacheDir = 'storage/cache/logs/';
            if (is_dir($cacheDir)) {
                $files = scandir($cacheDir);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        unlink($cacheDir . $file);
                    }
                }
                $terminal->o("Le cache des logs a été vidé avec succès.");
            }
        break;
        case 'routes':
            unlink('storage/cache/routes.php');
            $terminal->o("Le cache des routes a été vidé avec succès.");
        break;
        case 'env':
            unlink('storage/cache/env.php');
            $terminal->o("Le cache de l'environement a été vidé avec succès.");
        break;
        default:
            $terminal->e("Option de cache non valide.");
            exit(1);
    }
    $is_ok=true;
}

// Si aucune option valide n'est fournie
if ($is_ok) exit(0);
$terminal->e("aucune option valide fournie. Utilisez -h ou --help pour l'aide.");
exit(1);

?>
