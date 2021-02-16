<?php 

// Inclusion des dépendances
require './vendor/autoload.php';

// On stocke les informations de connexion PDO dans des constantes
const DB_HOST = 'localhost';
const DB_NAME = 'immobilier';
const DB_USER = 'root';
const DB_PASSWORD = '';

// Connexion à la base de données avec PDO

// Construction du Data Source Name
$dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST;

// Tableau d'options pour la connexion PDO
$options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

$pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
$pdo->exec('SET NAMES UTF8');

// Sélection des annonces
$sql = 'SELECT * 
        FROM logement
        INNER JOIN type ON logement.type_id = type.id_type';

// Préparation de la requête avec PDO
$query = $pdo->prepare($sql);

// Exécution de la requête
$query->execute();

// récupération des résultats
$adverts = $query->fetchAll();

// Affichage : template HTML

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Creators Shop</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/base.css">
</head>
<body>

<header>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Creators Shop</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_advert.php">Créer une annonce</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-12">
            <h1 class="my-4">Liste des annonces</h1>

            <main>
               
                <!-- Liste des annonces -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#id</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Description</th>
                            <th scope="col">Type</th>
                            <th scope="col">Adresse</th>
                            <th scope="col">Surface</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Photo</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($adverts as $advert): ?>
                            <tr>
                                <th scope="row"><?=htmlspecialchars($advert['id_logement']);?></th>
                                <td><?=htmlspecialchars($advert['titre']);?></td>
                                <td><?=htmlspecialchars(substr($advert['description'], 0, 75));?> [...]</td>
                                <td><?=htmlspecialchars($advert['label_type']);?></td>
                                <td><?=htmlspecialchars($advert['adresse']);?> <?=htmlspecialchars($advert['cp']);?> <?=htmlspecialchars($advert['ville']);?></td>
                                <td><?=htmlspecialchars($advert['surface']);?> m²</td>
                                <td><?=htmlspecialchars($advert['prix']);?> €</td>
                                <td>
                                    <img src="images/<?=htmlspecialchars($advert['photo']);?>" alt="">
                                </td>
                                <td>
                                    <a href="advert_details.php?id=<?=htmlspecialchars($advert['id_logement']);?>" class="btn btn-primary">Voir l'annonce</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </main>
        </div>

    </div>

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website 2020</p>
        </div>
    </footer>
</div>

<!-- Bootstrap core JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
        integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s"
        crossorigin="anonymous"></script>

</body>
</html>
