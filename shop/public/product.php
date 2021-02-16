<?php

/******************************
 * Inclusion des dépendances
 *****************************/
require '../vendor/autoload.php';
require '../src/functions.php';

/**********************************************************
 * Récupération et validation de l'id du produit à afficher
 **********************************************************/

 // Si problème avec l'id du produit -> message d'erreur + exit;
 if (!isset($_GET['id'])) {
     echo 'Error : no valid product id';
     exit;
 }

// $productId = (int) $_GET['id'];
$productId = intval($_GET['id']);

/**********************************
 * Requête de sélection du produit
 *********************************/
$product = getProductById($productId);

/************************************************************
 * Requête de sélection des commentaires associés au produit
 ************************************************************/
$comments = getCommentsByProductId($productId);

// Affichage : inclusion du fichier de template
$pageTitle = $product['name'];

render('product', [
    'product' => $product,
    'pageTitle' => $pageTitle,
    'comments' => $comments
]);