<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
    <header>
        <h1>Utilisation de l'instructeur IF</h1>
    </header>

<?php

// Déclaration des variables "tva", "price", "number" définissant "tva", "prix" et "nombre" 
$prix_table = 150;  
$prix_armoire = 50;
$Nombre = 10;

// Prix total des armoires hors taxe
$armoire_total_ht = $prix_armoire * $Nombre;
// Prix total des tables hors taxe
$table_total_ht = $prix_table * $Nombre;

// Affichage du prix total des armoires ( balise '<br/>' pour revenir à la ligne )
echo "Le prix total pour les 10 armoires est de $armoire_total_ht <br/>";

// Affichage du prix total des tables ( balise '<br/>' pour revenir à la ligne )
echo "Le prix total pour les 10 tables est de $table_total_ht <br/>";


// Si le prix de l'armoire et supérieur au prix de la table
if($prix_table > $prix_armoire) {

    // Alors affiche ce message
    echo "Le prix de l'armoire ($prix_armoire) est inférieur au prix de la table ($prix_table)";

}

// Sinon si le prix de l'armoire est inférieur au prix de la table
else {
    
    if($prix_armoire < $prix_table) {

        echo "Le prix de la table ($prix_table) est supérieur au prix de l'armoire ($prix_armoire)";
    
    }
}

?>

</body>
</html>

