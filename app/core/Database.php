<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-14 09:12:03
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-12-01 14:42:25
 * @ Description: Classe de base de données pour gérer la connexion à la base de données.
 */

namespace App\Core;

use PDO; 
use PDOException;

class Database
{
    private static ?PDO $pdoInstance = null;

    /**
     * Construit une nouvelle instance de la classe de base de données et initialise la connexion PDO.
     * Cette méthode est appelée interne pour créer l'instance singleton de la classe de base de données.
     * Il lit les détails de la connexion de la base de données à partir des variables d'environnement et établit un
     * Connexion à la base de données à l'aide de l'APD.
     */
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

    /**
     * Obtient l'instance singleton de la classe de base de données.
     * Si l'instance n'existe pas, elle crée une nouvelle instance.
     *
     * @return PDO The singleton instance of the Database class.
     */
    public static function getInstance(): PDO
    {
        // Créer l'instance si elle n'existe pas
        if (self::$pdoInstance === null) {
            new self();
        }
        return self::$pdoInstance;
    }

    /**
     * Disconnects the singleton instance of the Database class by setting the `$pdoInstance` property to `null`.
     */
    public static function disconnect(): void
    {
        self::$pdoInstance = null;
    }

    // Interdire le clonage et la sérialisation
    private function __clone() {}
    private function __wakeup() {}
}
