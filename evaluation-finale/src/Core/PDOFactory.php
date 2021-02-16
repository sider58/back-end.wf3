<?php 

namespace App\Core;

use \PDO;

class PDOFactory {

    static private $pdo = null;

    /**
     * Crée la connexion PDO
     */
    static public function get()
    {
        if (self::$pdo === null) {
  
            // Construction du Data Source Name
            $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;

            // Tableau d'options pour la connexion PDO
            $options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            // Création de la connexion PDO (création d'un objet PDO)
            self::$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
            self::$pdo->exec('SET NAMES UTF8');
        }

        return self::$pdo;
    }
}