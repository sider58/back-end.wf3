<?php

/**
 * Traduit un mot en anglais/français
 * @param string $word Le mot à traduire
 * @param string $direction Le sens de tradution ('toFrench' ou 'toEnglish')
 * @return string Le mot traduit ou false
 */
function translate(string $word, string $direction): string
{
    // On définit le dictionnaire
    $dictionary = [
        'chat'   => 'cat',
        'chien'  => 'dog',
        'singe'  => 'monkey',
        'mer'    => 'sea',
        'soleil' => 'sun'
    ];

    // On initialise le résultat (par défaut on n'a pas trouvé le mot)
    $result = false;

    // Traduction du mot en -> fr ou fr -> en.
    switch($direction) {

        case 'toEnglish':
            /*
             * Le mot spécifié est en anglais, on veut traduire vers le français.
             *
             * Il s'agit donc d'un indice dans le dictionnaire.
             * Est-ce que ce mot existe en tant qu'indice dans le dictionnaire ?
             */
            if(array_key_exists($word, $dictionary) == true) {

                // Oui, récupération de la valeur, de la traduction en français.
                $result = $dictionary[$word];
            }

            break;

        case 'toFrench':
            /*
             * Le mot spécifié est en français, on veut traduire vers l'anglais.
             *
             * Il s'agit donc d'une valeur dans le dictionnaire.
             * Est-ce que ce mot existe en tant que valeur dans le dictionnaire ?
             */
            if(in_array($word, $dictionary) == true) {

                // Oui, récupération de l'indice, de la traduction en anglais.
                $result = array_search($word, $dictionary);
            }
            break;
    }

    // On retourne le résultat pour le récupérer en dehors de la fonction
    return $result;
}


// Initialisation du résultat de la traduction (message affiché à l'internaute)
$message = null;

// Si des données ont été transmises dans le formulaire, la variable super globale $_POST ne sera pas vide
if(!empty($_GET)) {

    // Une direction a été spécifiée, récupération de la valeur.
    $direction = $_GET['direction'];

    // Récupération du mot spécifié dans l'URL.
    $word = strtolower($_GET['word']);

    // Appel de la fonction translate()
    $result = translate($word, $direction);

    // Si on a un résultat...
    if($result){
        $message = "Le mot '$word' se traduit par '$result'.";
    }

    // Sinon ça veut dire qu'on N'a PAS trouvé le mot dans le dictionnaire
    else {
        $message = "Le mot '$word' n'existe pas dans le dictionnaire.";
    }
}


// Inclusion du template affichant la variable $result.
include 'translator.phtml';