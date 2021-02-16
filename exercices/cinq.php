<!doctype html>
<html>  
    <head>
        <meta charset="utf-8">
    </head>
<body>
    <header>
        <title>Exercice 5</title>
    </header>
<?php

    echo "<h1>Utilisation de l'instructeur FOR et WHILE </h1>";
    
    $nombre = 3;
    $nombreuh = 0;

    for($i=0; $i<=$nombre; $i++) 
    {
        $nombreuh = $nombreuh + $i;
    }
    
    echo "La somme des entiers de 1 à $nombre est égale à : $nombreuh </br>";

    $nombre1 = 4;
    $nombreuuuh = 0;

    while($i<=$nombre1) {
        $nombreuuuh = $nombreuuuh + $i;
        $i++;
    }

    echo "La somme des entiers de 1 à $nombre1 est égale à : $nombreuuuh";
?>