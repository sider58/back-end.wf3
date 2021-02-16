<?php 

// Déclaration du namespace
namespace App\Core;

// Import des classes auxquelles on fait référence dans le fichier
use \PDO;
use \PDOStatement;

class Database {

    // Propriétés
    private $pdo;

    // Constructeur
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Prépare et exécute une requête SQL
     */
    function prepareAndExecuteQuery(string $sql, array $criteria = []): PDOStatement
    {
        // Préparation de la requête SQL
        $query = $this->pdo->prepare($sql);

        // Exécution de la requête
        $query->execute($criteria);

        // Retour du résultat
        return $query;
    }

    /**
     * Exécute une requête de sélection et retourne plusieurs résultats
     */
    function selectAll(string $sql, array $criteria = [])
    {
        $query = $this->prepareAndExecuteQuery($sql, $criteria);

        $nbResults = $query->rowCount();

        return $query->fetchAll();
    }


    /**
     * Exécute une requête de sélection et retourne UN résultat
     */
    function selectOne(string $sql, array $criteria = [])
    {
        $query = $this->prepareAndExecuteQuery($sql, $criteria);

        return $query->fetch();
    }
}