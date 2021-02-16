<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\VehiculeModel;
use App\Service\Flashbag;

class VehiculeController extends AbstractController {

    public function index()
    {
        // Initialisation du tableau de'erreurs
        $errors = [];

        // Instanciation de la classe de modèle
        $vehiculeModel = new VehiculeModel($this->database);

        // Si le formulaire d'ajout est soumis, on traite ses données
        if (!empty($_POST)) {

            $marque = trim($_POST['marque']);
            $modele = trim($_POST['modele']);
            $couleur = trim($_POST['couleur']);
            $immatriculation = trim($_POST['immatriculation']);

            // Validation des champs du formulaire
            if (!$marque) {
                $errors[] = 'Le champ marque est obligatoire.';
            }

            if (!$modele) {
                $errors[] = 'Le champ modele est obligatoire.';
            }

            if (!$couleur) {
                $errors[] = 'Le champ couleur est obligatoire.';
            }

            if (!$immatriculation) {
                $errors[] = 'Le champ immatriculation est obligatoire.';
            }

            if ($vehiculeModel->exists($immatriculation)) {
                $errors[] = 'Ce vehicule existe déjà.';
            }

            // S'il n'y a pas d'erreur on enregistre les données en BDD
            if (empty($errors)) {

                // Insertion du conducteur
                $vehiculeModel->insert($_POST['marque'], $_POST['modele'], $_POST['couleur'], $_POST['immatriculation']);

                // Message flash et redirection
                (new Flashbag())->addFlashMessage('Véhicule ajouté.');
                header('Location: /vehicule');
                exit;
            }
        }

        // Rendu du template
        render('vehicule', [
            'errors' => $errors,
            'vehicules' => $vehiculeModel->getAll()
        ]);
    }


    public function edit()
    {
        // Validation du paramètre id_vehicule de l'URL
        if (!array_key_exists('id_vehicule', $_GET) || !isset($_GET['id_vehicule']) || !ctype_digit($_GET['id_vehicule'])) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Initialisation du tableau de'erreurs
        $errors = [];

        // Instanciation de la classe de modèle
        $vehiculeModel = new VehiculeModel($this->database);

        // Sélection de l'entité Conducteur que l'on souhaite modifier
        $vehicule = $vehiculeModel->getOne($_GET['id_vehicule']);

        // On vérifie si l'id transmis dans l'URL est bien un id qui existe dans la table vehicule
        if (!$vehicule) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Si le formulaire d'ajout est soumis, on traite ses données
        if (!empty($_POST)) {

            $marque = trim($_POST['marque']);
            $modele = trim($_POST['modele']);
            $couleur = trim($_POST['couleur']);
            $immatriculation = trim($_POST['immatriculation']);

            // Validation des champs du formulaire
            if (!$marque) {
                $errors[] = 'Le champ marque est obligatoire.';
            }

            if (!$modele) {
                $errors[] = 'Le champ modele est obligatoire.';
            }

            if (!$couleur) {
                $errors[] = 'Le champ couleur est obligatoire.';
            }

            if (!$immatriculation) {
                $errors[] = 'Le champ immatriculation est obligatoire.';
            }

            if ($vehiculeModel->exists($immatriculation, $vehicule['id_vehicule'])) {
                $errors[] = 'Ce vehicule existe déjà.';
            }

            // S'il n'y a pas d'erreur on enregistre les données en BDD
            if (empty($errors)) {

                // Insertion du vehicule
                $vehiculeModel->update($_POST['marque'], $_POST['modele'], $_POST['couleur'], $_POST['immatriculation'], $_GET['id_vehicule']);

                // Message flash et redirection
                (new Flashbag())->addFlashMessage('Véhicule modifié.');
                header('Location: /vehicule');
                exit;
            }
        }

        // Rendu du template
        render('vehicule_edit', [
            'errors' => $errors,
            'vehicule' => $vehicule
        ]);
    }


    public function delete()
    {
        // Validation du paramètre id_vehicule de l'URL
        if (!array_key_exists('id_vehicule', $_GET) || !isset($_GET['id_vehicule']) || !ctype_digit($_GET['id_vehicule'])) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Instanciation de la classe de modèle
        $vehiculeModel = new VehiculeModel($this->database);

        // Insertion du vehicule
        $vehiculeModel->delete($_GET['id_vehicule']);

        // Message flash et redirection
        (new Flashbag())->addFlashMessage('Véhicule supprimé.');
        header('Location: /vehicule');
        exit;
    }
}




