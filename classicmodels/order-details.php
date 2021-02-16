<?php

/********************************************/
/* Récupérer le numéro de commande de l'URL */
/********************************************/

// Si le numéro de commande n'est pas défini...
if (!isset($_GET['orderNumber']) || !ctype_digit($_GET['orderNumber'])) {
    echo 'Erreur : Numéro de commande manquant ou incorrect.';
    exit;
}

$orderNumber = $_GET['orderNumber'];

/********************************************/
/*  Connexion à la base de données avec PDO */
/********************************************/

// On stocke les informations de connexion dans des constantes
const DB_HOST = 'localhost';
const DB_NAME = 'classicmodels';
const DB_USER = 'root';
const DB_PASSWORD = '';

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

/********************************************/
/*  Récupération des informations client    */
/********************************************/

// Préparation de la requête SQL
$sql = 'SELECT customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, postalCode, country  
        FROM orders
        INNER JOIN customers 
        ON orders.customerNumber = customers.customerNumber
        WHERE orderNumber = ?';

$query = $pdo->prepare($sql);

// Exécution 
$query->execute([$orderNumber]);

// Récupération du résultat
$customer = $query->fetch();

// dump($customer);

/********************************************/
/*  Récupération du détail de la commande   */
/********************************************/
$sql = 'SELECT productName, 
               priceEach, 
               quantityOrdered,
               priceEach * quantityOrdered AS subtotal
        FROM orderdetails
        INNER JOIN products 
        ON products.productCode = orderdetails.productCode
        WHERE orderNumber = ?';

$query = $pdo->prepare($sql);

$query->execute([$orderNumber]);

$orderdetails = $query->fetchAll();

/********************************************/
/*  Calcul et récupération du prix total    */
/********************************************/
$sql = 'SELECT SUM(priceEach * quantityOrdered) AS total
        FROM orderdetails
        WHERE orderNumber = ?';

$query = $pdo->prepare($sql);

$query->execute([$orderNumber]);

$total = $query->fetchColumn();

/********************************************/
/*  Affichage : inclusion du template       */
/********************************************/
include 'order-details.phtml';