<?php

// Inclusion des dépendances
require '../vendor/autoload.php';
require '../src/functions.php';

/*************************************/
/* REQUETE DE SELECTION DES PRODUITS */
/*************************************/
$products = getAllProducts();

/*************************************/
/* AFFICHAGE : INCLUSION DU TEMPLATE */
/*************************************/
$pageTitle = 'Welcome to my shop!';

render('index', [
    'products' => $products,
    'pageTitle' => $pageTitle
]);

