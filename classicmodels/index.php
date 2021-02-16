<?php

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

// Préparer la requête de sélection des commandes
$sql = 'SELECT orderNumber, orderDate, shippedDate, status
        FROM orders
        ORDER BY orderDate DESC';

$query = $pdo->prepare($sql);

// Exécuter la requête
$query->execute();

// Récupérer les résultats de la requête pour les afficher dans le template HTML
$orders = $query->fetchAll();

// Affichage : inclusion du template index.phtml
include 'index.phtml';