<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-14 09:12:03
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-01 12:46:37
 * @ Description: Classe de connexion à la base de données
 */

namespace App\Core;

use PDO; 
use PDOException;

class Database
{
    private static ?PDO $pdoInstance = null;

    private function __construct()
    {
        // Utiliser les variables d'environnement pour la configuration
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = !empty(getenv('DB_NAME')) ? ";dbname=" . getenv('DB_NAME') : '';
        $charset = !empty(getenv('DB_NAME')) ? ";charset=" . getenv('DB_CHARSET') : '';
        $user = getenv('DB_USER');
        $password = getenv('DB_PASS');

        // Construire le DSN
        $dsn = "mysql:host=$host$dbname;port=$port$charset";

        try {
            // Créer l'instance PDO unique
            self::$pdoInstance = new PDO($dsn, $user, $password);
            self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance(): PDO
    {
        // Créer l'instance si elle n'existe pas
        if (self::$pdoInstance === null) {
            new self();
        }
        return self::$pdoInstance;
    }

    public static function disconnect(): void
    {
        self::$pdoInstance = null;
    }

    // Interdire le clonage et la sérialisation
    private function __clone() {}
    private function __wakeup() {}
}
