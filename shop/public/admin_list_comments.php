<?php

// Inclusion des dépendances
require '../vendor/autoload.php';
require '../src/functions.php';

$comments = getAllComments(false);

render('admin_add_product', [
    'pageTitle' => 'Gestion des commentaires',
    'comments' => $comments
], 'base_admin');