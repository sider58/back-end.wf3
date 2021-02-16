<?php

// Inclusion des dépendances
include 'functions.php';

// Traitements PHP : récupérer l'email du formulaire et enregister l'email

// dump ($_POST);

// Si le formulaire a été soumis...
// if (array_key_exists ('email', $_POST)) {
if (!empty($_POST)) {

    // On récupère l'email
    $email = $_POST['email'];

    // Validation de l'email
    $email = validateEmail($email);

    // Si tout est OK (pas d'erreur)
    if($error === null) {
        addSubscriber($email);
             
        // Redirection vers la page de succès
        header('Location: success.html');
        exit;

    }
}

// Inclusion du template
include 'index.phtml';