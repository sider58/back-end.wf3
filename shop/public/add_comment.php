<?php 

// Inclusion des dépendances
require '../vendor/autoload.php';
require '../src/functions.php';

/**
 *  Informations sur le commentaire :
 *     - id (clé primaire) : rempli automatiquement par MySQL
 *     - content : formulaire
 *     - createdAt : fonction NOW() de SQL (directement dans la requête)
 *     - product_id (clé étrangère) : formulaire
 */ 

// Récupérer les données du formulaire
$content = strip_tags($_POST['content']);
$productId = $_POST['product-id'];
$userId = getUserId();

// Insertion du commentaire dans la table comments
insertComment($content, $productId, $userId);

// Création d'un message flash
addFlashMessage('Votre commentaire a bien été pris en compte.');

// Redirection vers la page du produit
header('Location: product.php?id=' . $productId);
exit;