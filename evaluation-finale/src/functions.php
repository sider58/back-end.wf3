<?php

// Inclusion du fichier de configuration
require '../config.php';

/**
 * Envoi en sortie le rendu d'un fichier de template
 */
function render(string $template, array $values = [], string $baseTemplate = 'base')
{
    // Extraction des variables
    extract($values);

    // Récupération du message flash le cas échéant
    $flashMessages = (new \App\Service\Flashbag())->fetchAllFlashMessages();

    // Inclusion du template de base
    include '../templates/'.$baseTemplate.'.phtml';
}