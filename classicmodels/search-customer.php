<?php 

// On stocke les informations de connexion dans des constantes
const DB_HOST = 'localhost';
const DB_NAME = 'classicmodels';
const DB_USER = 'root';
const DB_PASSWORD = '';

// Si le formulaire est soumis, on récupère la recherche de l'internaute
if (array_key_exists('search-query', $_GET)) {

    $searchQuery = $_GET['search-query'];
    
    /********************************************/
    /*  Connexion à la base de données avec PDO */
    /********************************************/

    // Construction du Data Source Name
    $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;

    // Tableau d'options pour la connexion PDO
    $options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // Création de la connexion PDO (création d'un objet PDO)
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
    $pdo->exec('SET NAMES UTF8');

    // Requête SQL de recherche dans la base
    $sql = 'SELECT customerName, customerNumber
            FROM customers
            WHERE customerName LIKE ?
            ORDER BY customerName';

    $query = $pdo->prepare($sql);

    // $query->execute(['%'.$searchQuery.'%']);
    $query->execute(["%$searchQuery%"]);

    $customers = $query->fetchAll();
}

// Affichage : inclusion du template search-customer.phtml 
include 'search-customer.phtml';