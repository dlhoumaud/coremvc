<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-12 10:27:58
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 13:52:11
 * @ Description: outil de développement
 */
namespace App\Bin;

use App\Core\Autoloader;
use App\Core\Router;
use App\Core\Database;

// Inclure les fichiers nécessaires
require_once 'config/config.php'; // Configurations de l'application

loadEnvWithCache('.env', 'storage/cache/env.php');

// Charger l'autoloader personnalisé
require_once 'app/core/Autoloader.php';

// Initialiser l'autoloader
Autoloader::register();

// Définition des options
$options = getopt("s:e:d:k:M:S:h", ["server:", "encrypt:", "decrypt:", "key:", "migrate:", "seed:", "help"]);

// Affichage de l'aide si l'option -h ou --help est utilisée
if (isset($options['h']) || isset($options['help'])) {
    echo "CoreMVC - Un framework MVC en PHP\n
Copyright (C) 2024  David Lhoumaud
This program comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions.\n\n"
    . "Utilisation : php bin/core.php [options]\n"
    . "Options disponibles :\n"
    . "  -s, --server [adresse:port]     : Lance un serveur de développement PHP à l'adresse et au port spécifiés.\n"
    . "  -e, --encrypt [file]            : Chiffre un fichier spécifique.\n"
    . "  -d, --decrypt [file]            : Déchiffre un fichier spécifique.\n"
    . "  -k, --key [key]                 : Spécifiez une clé de chiffrement personnalisée.\n"
    . "  -M, --migrate [up|down|create]  : Exécute les migrations.\n"
    . "  -S, --seed [up|down|create]     : Exécute les seeders.\n"
    . "  -h, --help                      : Affiche ce message d'aide.\n";
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
        echo "Erreur : Le répertoire '$documentRoot' n'existe pas.\n";
        exit(1);
    }

    // Démarrer le serveur de développement PHP
    echo "Lancement du serveur PHP sur http://$address\n";

    // Si vous utilisez exec(), vous pouvez également capturer la sortie d'erreur
    exec("php -S $address -t $documentRoot", $output, $returnVar);

    // Si une erreur se produit avec exec(), afficher un message d'erreur
    if ($returnVar !== 0) {
        echo "Erreur lors du démarrage du serveur PHP :\n";
        echo implode("\n", $output);
        exit(1);
    }

    echo "Serveur PHP lancé avec succès !\n";
    exit(0);
}

if (isset($options['e']) || isset($options['encrypt'])) {
    $fileToEncrypt = $options['e'] ?? $options['encrypt'];
    if (!file_exists($fileToEncrypt)) {
        echo "Erreur : aucun fichier spécifié pour le chiffrement.\n";
        exit(1);
    }
    // Chiffrement du fichier
    $encryptedContent = encryptFile($fileToEncrypt, $fileToEncrypt, $options['k'] ?? $options['key']);
    echo "Le fichier a été chiffré avec succès.\n";
    exit(0);
}

if (isset($options['d']) || isset($options['decrypt'])) {
    $fileToDecrypt = $options['d'] ?? $options['decrypt'];
    if (!file_exists($fileToDecrypt)) {
        echo "Erreur : aucun fichier spécifié pour le déchiffrement.\n";
        exit(1);
    }
    // Déchiffrement du fichier
    $decryptedContent = decryptFile($fileToDecrypt, $fileToDecrypt, $options['k'] ?? $options['key']);
    echo "Le fichier a été déchiffré avec succès.\n";
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
        // Instance de la classe Database
        $db = new Database();
        

        $files = scanDirectory($migrationDir);
        foreach ($files as $file) {
            if (!is_dir($migrationDir.$file)) {
                // Exécution de la migration 'up' pour créer la table
                runMigration($db, $migrationDir.$file, $action, $is_seed);
            }
        }
        
        
        // Exécution de la migration 'down' pour supprimer la table
        // runMigration($db, $migrationFile, 'down');
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage() . "\n";
    }
    exit(0);
}


// Si aucune option valide n'est fournie
echo "Erreur : aucune option valide fournie. Utilisez -h ou --help pour l'aide.\n";
exit(1);

?>
