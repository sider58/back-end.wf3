<?php

if (!array_key_exists('customerNumber', $_GET) || !isset($_GET['customerNumber'])){
    echo 'Problème de transmission du numéro client.';
    exit;
}

// On stocke les informations de connexion dans des constantes
const DB_HOST = 'localhost';
const DB_NAME = 'classicmodels';
const DB_USER = 'root';
const DB_PASSWORD = '';

$customerNumber = $_GET['customerNumber'];

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

// Requête SQL de sélection du client
$sql = 'SELECT customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, postalCode, country  
        FROM customers
        WHERE customerNumber = ?';

$query = $pdo->prepare($sql);
$query->execute([$customerNumber]);

$customer = $query->fetch();

// Liste des commandes
$sql = 'SELECT orderNumber, orderDate
        FROM orders
        WHERE customerNumber = ?
        ORDER BY orderDate DESC';

$query = $pdo->prepare($sql);
$query->execute([$customerNumber]);
    
$orders = $query->fetchAll();

// Affichage
include 'customer-details.phtml';