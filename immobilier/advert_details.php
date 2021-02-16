<?php 

// Inclusion des dépendances
require './vendor/autoload.php';

// Validation de l'id dans l'URL
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo 'Identifiant invalide.';
    exit;
}

// On récupère l'id dans une variable
$idLogement = $_GET['id']; 

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

// Sélection de l'annonce
$sql = 'SELECT * 
        FROM logement
        INNER JOIN type ON logement.type_id = type.id_type
        WHERE id_logement = ?';

$query = $pdo->prepare($sql);
$query->execute([$idLogement]);

$advert = $query->fetch();

// Vérifier si le logement existe (si l'id existe dans la BDD)
if (!$advert) {
    echo "Ce logement n'existe plus.";
    exit;
}

// Affichage

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
                <!-- Détails de l'annonce -->
                <article>
                    <h2><?=htmlspecialchars($advert['titre']);?></h2>
                    <span class="badge badge-secondary"><?=htmlspecialchars($advert['label_type']);?></span>
                    <ul>
                        <li><?=htmlspecialchars($advert['prix']);?> €</li>
                        <li><?=htmlspecialchars($advert['surface']);?> m²</li>
                    </ul>
                    <img src="images/<?=htmlspecialchars($advert['photo']);?>" alt="">
                    <p><?=htmlspecialchars($advert['description']);?></p>
                    <p><?=htmlspecialchars($advert['adresse']);?> <?=htmlspecialchars($advert['cp']);?> <?=htmlspecialchars($advert['ville']);?></p>
                </article>
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
