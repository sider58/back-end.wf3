<?php 

// Inclusion des dépendances
require '../vendor/autoload.php';
require '../src/functions.php';

// Initialisations
$errors = null;
$firstname = null;
$lastname = null;
$email = null;

// Si le formulaire est soumis... 
if (!empty($_POST)) {

    // On récupère les données 
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password-confirm'];
    
    // Validation du formulaire
    $errors = validateUserForm($firstname, $lastname, $email, $password, $passwordConfirm);

    // Si il n'y a pas d'erreur... 
    if (empty($errors)) {

        // Insertion de l'utilisateur en BDD
        insertUser($firstname, $lastname, $email, $password, ROLE_USER);

        // Ajout d'un message flash de confirmation
        addFlashMessage('Votre compte a bien été créé, vous pouvez vous connecter!');
        
        // En cas de succès on redirige l'internaute vers la page d'accueil
        header('Location: login.php');
        exit;
    }
}

// Affichage du formulaire de création de compte avec la méthode render()
render('create_account', [
    'pageTitle' => 'Créez votre compte client',
    'errors' => $errors,
    'firstname' => $firstname,
    'email' => $email,
    'lastname' => $lastname
]);