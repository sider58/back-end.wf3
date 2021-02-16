<?php

/** 
 * Récupère et retourne dans un tableau les emails des abonnés
 */
function getAllSubscribers()
{
    // Ouverture du fichier
        $file = fopen('subscribers.csv', 'a+');

        // Création du tableau vide pour stocker les emails des abonnés
        $emails = [];

        // Lecture du fichier ligne par ligne
        while ($row = fgetcsv($file)) {
            $emails[] = $row[0]; // $row : ['jenny.dablock@outlook.ass']
        }

        // Fermeture du fichier
        fclose($file);

        return $emails;
}

/**
 * Détérmine si une adresse email est déjà présente  dans le fichier d'abonnés
 */
function emailExists(string $email)
{
    $emails = getAllSubscribers();
    
    // Vérification de l'existence de l'email
    return in_array($email, $emails); {
    
}

/**
 * Ajoute un abonné à la liste des emails
 */
function addSubscriber(string $email)
{
    // Ouvrir le fichier dans lequel on veut enregister l'email (fopen())
    $file = fopen('subscribers.csv', 'a');

    // Ecrire l'adresse email dans le fichier (fputcsv())
    fputcsv($file, [$email]);

    // Fermer le fichier (fclose())
    fclose($file);

}

/**
 * Fais la validation de l'email
 * En cas d'erreur elle retourne le message d'erreur
 */
function validateEmail(string $email)
{
    if (!empty($_POST)) {

        if(!isset($_POST['email']) || empty($_POST['email'])) {

            $error = "Merci d'indiquer une adresse e-mail";
        
        }
    
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error ="Ce n'est pas une adresse e-mail valide";
        
        }

        if (emailExists($email)) {
        $error = "Cette adresse email existe déjà dans notre base.";

        }
    }
}