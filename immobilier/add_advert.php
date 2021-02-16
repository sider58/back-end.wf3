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


/**
 * TRAITEMENT DES DONNEES DU FORMULAIRE
 */
if (!empty($_POST)) {

    // dump($_FILES);
    // exit;

    // Validation des données
    $errors = [];

    if (!$_POST['titre']) {
        $errors[] = 'Le champ titre est obligatoire.';
    }

    if (strlen($_POST['titre']) > 255) {
        $errors[] = 'Le champ titre doit faire au maximum 255 caractères.';
    }

    if (!$_POST['adresse']) {
        $errors[] = 'Le champ adresse est obligatoire.';
    }

    if (!$_POST['ville']) {
        $errors[] = 'Le champ ville est obligatoire.';
    }

    if (!$_POST['cp']) {
        $errors[] = 'Le champ Code postal est obligatoire.';
    }

    if (!ctype_digit($_POST['cp']) || strlen($_POST['cp']) != 5) {
        $errors[] = 'Le champ Code postal est incorrect.';
    }

    if (!$_POST['surface']) {
        $errors[] = 'Le champ surface est obligatoire.';
    }

    if (!ctype_digit($_POST['surface']) || $_POST['surface'] < 0) {
        $errors[] = 'Le champ surface est incorrect.';
    }

    if (!$_POST['prix']) {
        $errors[] = 'Le champ prix est obligatoire.';
    }

    if (!ctype_digit($_POST['prix']) || $_POST['prix'] < 0) {
        $errors[] = 'Le champ prix est incorrect.';
    }

    // Si il ya un fichier image uploadé => validation (vérifier le type de fichier + vérifier la taille)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] != UPLOAD_ERR_NO_FILE) {

        // Test du type MIME (type de fichier)
        $allowedMimeTypes = ['image/png', 'image/jpeg', 'image/gif'];
        $mimetype = mime_content_type($_FILES['photo']['tmp_name']);

        if (!in_array($mimetype, $allowedMimeTypes)) {
            $errors[] = 'Type de fichier incorrect (gif, jpg ou png autorisés)';
        }

        // Test du poids du fichier
        $maxFileSize = 1024 * 1024;
        $filesize = filesize($_FILES['photo']['tmp_name']);

        if ($filesize > $maxFileSize) {
            $errors[] = 'Le fichier dépasse le poids autorisé (1 Mo)';
        }
    }

    // Si tout est ok, aucune erreur, on lance l'insertion
    if (empty($errors)) {

        $filename = '';

        // @TODO Si tout est ok, si pas d'erreurs et qu'un fichier image est uploadé
        // => alors déplacer le fichier temporaire vers le répertoire de destination (images/)        
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] != UPLOAD_ERR_NO_FILE) {

            // Si le dossier de destination n'existe pas... 
            if (!file_exists('images')) {
                mkdir('images');
            }

            // Générer un nom de fichier unique 
            $filename = md5(uniqid(rand(), true));
            
            // Récupérer l'extension du fichier uploadé
            $extension = pathinfo($_FILES['photo']['name'])['extension'];
            $filename .= '.' . $extension;

            // Déplacer le fichier temporaire vers sa destination finale
            move_uploaded_file($_FILES['photo']['tmp_name'], 'images/' . $filename);
        }

        // Insertion des données dans la base
        $sql = 'INSERT INTO logement (titre, adresse, ville, cp, surface, prix, photo, description, type_id)
                VALUES (?,?,?,?,?,?,?,?,?)';

        $query = $pdo->prepare($sql);

        $query->execute([
            $_POST['titre'],
            $_POST['adresse'],
            $_POST['ville'],
            $_POST['cp'],
            $_POST['surface'],
            $_POST['prix'],
            $filename,
            $_POST['description'],
            $_POST['type_id']
        ]);        

        // Redirection vers l'index.php
        header('Location: index.php');
        exit;
    }
}

// Sélection des types d'annonces
$sql = 'SELECT * 
        FROM type
        ORDER BY label_type';

// Préparation de la requête avec PDO
$query = $pdo->prepare($sql);

// Exécution de la requête
$query->execute();

// récupération des résultats
$types = $query->fetchAll();

// Affichage

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Immobilier</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />

    <link rel="stylesheet" href="css/base.css">
</head>
<body>

<header>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Immobilier</a>
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
            <h1 class="my-4">Création d'une nouvelle annonce</h1>

            <main>

                <?php if (isset($errors) && !empty($errors)): ?>
                    <?php foreach ($errors as $error):?>
                        <p class="alert alert-danger"><?=$error;?></p>
                    <?php endforeach; ?>
                <?php endif; ?>

               <form action="add_advert.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="titre">Titre de l'annonce</label>
                        <input required type="text" class="form-control" id="titre" name="titre" value="<?=$_POST['titre']??'';?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea rows="5" class="form-control" id="description" name="description"><?=$_POST['description']??'';?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input required type="text" class="form-control" id="adresse" name="adresse" value="<?=$_POST['adresse']??'';?>">
                    </div>
                    <div class="form-group">
                        <label for="cp">Code postal</label>
                        <input required pattern="[0-9]{5}" type="text" class="form-control" id="cp" name="cp" value="<?=$_POST['cp']??'';?>">
                    </div>
                    <div class="form-group">
                        <label for="ville">Ville</label>
                        <input required type="text" class="form-control" id="ville" name="ville" value="<?=$_POST['ville']??'';?>">
                    </div>
                    <div class="form-group">
                        <label for="surface">Surface</label>
                        <input required type="number" min="0" class="form-control" id="surface" name="surface" value="<?=$_POST['surface']??'';?>">
                    </div>
                    <div class="form-group">
                        <label for="prix">Prix</label>
                        <input required type="number" min="0" class="form-control" id="prix" name="prix" value="<?=$_POST['prix']??'';?>">
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <div class="form-group">
                        <label for="type_id">Type d'annonce</label>
                        <select required class="form-control" id="type_id" name="type_id">
                            <?php foreach ($types as $type): ?>
                                <?php 
                                    $selected = '';
                                    if (isset($_POST['type_id']) && $_POST['type_id'] == $type['id_type']) {
                                        $selected = 'selected';
                                    }
                                ?>
                                <option <?=$selected;?> value="<?=$type['id_type'];?>"><?=$type['label_type'];?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Enregistrer</button>
               </form>
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
