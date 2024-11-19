<?php
/**
 * @ Author: David Lhoumaud
 * @ Create Time: 2024-11-14 09:12:03
 * @ Modified by: David Lhoumaud
 * @ Modified time: 2024-11-19 13:54:37
 * @ Description: Classe de connexion à la base de données
 */

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    protected $pdo;

    public function __construct()
    {
        // Utiliser les variables d'environnement pour la configuration
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = !empty(getenv('DB_NAME'))?";dbname=".getenv('DB_NAME'):'';
        $charset = !empty(getenv('DB_NAME'))?";charset=".getenv('DB_CHARSET'):'';
        $user = getenv('DB_USER');
        $password = getenv('DB_PASS');

        // Créer la connexion PDO
        $dsn = "mysql:host=$host$dbname;port=$port$charset";
        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Gérer les erreurs de connexion ici si nécessaire
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
