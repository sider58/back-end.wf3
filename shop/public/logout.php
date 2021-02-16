<?php 

// Inclusion des dépendances
require '../vendor/autoload.php';
require '../src/functions.php';

// Déconnexion utilisateur
logout();

// Redirection vers la page d'accueil avec un message flash
addFlashMessage('Au revoir !');
header('Location: index.php');
exit;