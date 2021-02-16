<?php

// Déclaration des variables "tva", "price", "number" définissant "tva", "prix" et "nombre" 
$tva = 0.206;
$price = 150;
$number = 10;

// Calcul du prix hors taxe et du prix toute taxes confondues pour les 10 articles
$ht = $price * $number;
$ttc = $ht * (1+$tva);

// Inclusion du fichier .phtml
include 'trois.phtml';



