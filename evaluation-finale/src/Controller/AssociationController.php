<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\AssociationModel;
use App\Model\ConducteurModel;
use App\Model\VehiculeModel;
use App\Service\Flashbag;

class AssociationController extends AbstractController {

    public function index()
    {
        // Initialisation du tableau de'erreurs
        $errors = [];

        // Instanciation de la classe de modèle
        $associationModel = new AssociationModel($this->database);
        $conducteurModel = new ConducteurModel($this->database);
        $vehiculeModel = new VehiculeModel($this->database);

        // Si le formulaire d'ajout est soumis, on traite ses données
        if (!empty($_POST)) {

            $idConducteur = (int) $_POST['id_conducteur'];
            $idVehicule = (int) $_POST['id_vehicule'];

            // Validation des champs du formulaire
            if (!$idConducteur) {
                $errors[] = 'Le champ conducteur est obligatoire.';
            }

            if (!$idVehicule) {
                $errors[] = 'Le champ vehicule est obligatoire.';
            }

            if ($associationModel->exists($idConducteur, $idVehicule)) {
                $errors[] = 'Cette association existe déjà.';
            }

            // S'il n'y a pas d'erreur on enregistre les données en BDD
            if (empty($errors)) {

                // Insertion du association
                $associationModel->insert($_POST['id_conducteur'], $_POST['id_vehicule']);

                // Message flash et redirection
                (new Flashbag())->addFlashMessage('Association ajouté.');
                header('Location: /association');
                exit;
            }
        }

        // Rendu du template
        render('association', [
            'errors' => $errors,
            'associations' => $associationModel->getAll(),
            'conducteurs' => $conducteurModel->getAll(),
            'vehicules' => $vehiculeModel->getAll(),
        ]);
    }


    public function edit()
    {
        // Validation du paramètre id_association de l'URL
        if (!array_key_exists('id_association', $_GET) || !isset($_GET['id_association']) || !ctype_digit($_GET['id_association'])) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Initialisation du tableau de'erreurs
        $errors = [];

        // Instanciation de la classe de modèle
        $associationModel = new AssociationModel($this->database);
        $conducteurModel = new ConducteurModel($this->database);
        $vehiculeModel = new VehiculeModel($this->database);

        // Sélection de l'entité Association que l'on souhaite modifier
        $association = $associationModel->getOne($_GET['id_association']);

        // On vérifie si l'id transmis dans l'URL est bien un id qui existe dans la table association
        if (!$association) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Si le formulaire d'ajout est soumis, on traite ses données
        if (!empty($_POST)) {

            $idConducteur = (int) $_POST['id_conducteur'];
            $idVehicule = (int) $_POST['id_vehicule'];

            // Validation des champs du formulaire
            if (!$idConducteur) {
                $errors[] = 'Le champ conducteur est obligatoire.';
            }

            if (!$idVehicule) {
                $errors[] = 'Le champ vehicule est obligatoire.';
            }

            if ($associationModel->exists($_POST['id_conducteur'], $_POST['id_vehicule'], $association['id_association'])) {
                $errors[] = 'Cette association existe déjà.';
            }

            // S'il n'y a pas d'erreur on enregistre les données en BDD
            if (empty($errors)) {

                // Insertion du association
                $associationModel->update($_POST['id_conducteur'], $_POST['id_vehicule'], $_GET['id_association']);

                // Message flash et redirection
                (new Flashbag())->addFlashMessage('Association modifié.');
                header('Location: /association');
                exit;
            }
        }

        // Rendu du template
        render('association_edit', [
            'errors' => $errors,
            'association' => $association,
            'conducteurs' => $conducteurModel->getAll(),
            'vehicules' => $vehiculeModel->getAll(),
        ]);
    }


    public function delete()
    {
        // Validation du paramètre id_association de l'URL
        if (!array_key_exists('id_association', $_GET) || !isset($_GET['id_association']) || !ctype_digit($_GET['id_association'])) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Instanciation de la classe de modèle
        $associationModel = new AssociationModel($this->database);

        // Insertion du association
        $associationModel->delete($_GET['id_association']);

        // Message flash et redirection
        (new Flashbag())->addFlashMessage('Association supprimée.');
        header('Location: /association');
        exit;
    }
}




