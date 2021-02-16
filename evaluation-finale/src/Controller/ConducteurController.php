<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\ConducteurModel;
use App\Service\Flashbag;

class ConducteurController extends AbstractController {

    public function index()
    {
        // Initialisation du tableau de'erreurs
        $errors = [];

        // Instanciation de la classe de modèle
        $conducteurModel = new ConducteurModel($this->database);

        // Si le formulaire d'ajout est soumis, on traite ses données
        if (!empty($_POST)) {

            $prenom = trim($_POST['prenom']);
            $nom = trim($_POST['nom']);

            // Validation des champs du formulaire
            if (!$prenom) {
                $errors[] = 'Le champ prénom est obligatoire.';
            }

            if (!$nom) {
                $errors[] = 'Le champ nom est obligatoire.';
            }

            if ($conducteurModel->exists($prenom, $nom)) {
                $errors[] = 'Ce conducteur existe déjà.';
            }

            // S'il n'y a pas d'erreur on enregistre les données en BDD
            if (empty($errors)) {

                // Insertion du conducteur
                $conducteurModel->insert($prenom, $nom);

                // Message flash et redirection
                (new Flashbag())->addFlashMessage('Conducteur ajouté.');
                header('Location: /conducteur');
                exit;
            }
        }

        // Rendu du template
        render('conducteur', [
            'errors' => $errors,
            'conducteurs' => $conducteurModel->getAll()
        ]);
    }


    public function edit()
    {
        // Validation du paramètre id_conducteur de l'URL
        if (!array_key_exists('id_conducteur', $_GET) || !isset($_GET['id_conducteur']) || !ctype_digit($_GET['id_conducteur'])) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Initialisation du tableau de'erreurs
        $errors = [];

        // Instanciation de la classe de modèle
        $conducteurModel = new ConducteurModel($this->database);

        // Sélection de l'entité Conducteur que l'on souhaite modifier
        $conducteur = $conducteurModel->getOne($_GET['id_conducteur']);

        // On vérifie si l'id transmis dans l'URL est bien un id qui existe dans la table conducteur
        if (!$conducteur) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Si le formulaire d'ajout est soumis, on traite ses données
        if (!empty($_POST)) {

            $prenom = trim($_POST['prenom']);
            $nom = trim($_POST['nom']);

            // Validation des champs du formulaire
            if (!$prenom) {
                $errors[] = 'Le champ prénom est obligatoire.';
            }

            if (!$nom) {
                $errors[] = 'Le champ nom est obligatoire.';
            }

            if ($conducteurModel->exists($prenom, $nom, $conducteur['id_conducteur'])) {
                $errors[] = 'Ce conducteur existe déjà.';
            }

            // S'il n'y a pas d'erreur on enregistre les données en BDD
            if (empty($errors)) {

                // Insertion du conducteur
                $conducteurModel->update($_POST['prenom'], $_POST['nom'], $_GET['id_conducteur']);

                // Message flash et redirection
                (new Flashbag())->addFlashMessage('Conducteur modifié.');
                header('Location: /conducteur');
                exit;
            }
        }

        // Rendu du template
        render('conducteur_edit', [
            'errors' => $errors,
            'conducteur' => $conducteur
        ]);
    }


    public function delete()
    {
        // Validation du paramètre id_conducteur de l'URL
        if (!array_key_exists('id_conducteur', $_GET) || !isset($_GET['id_conducteur']) || !ctype_digit($_GET['id_conducteur'])) {
            http_response_code(404);
            echo 'Page introuvable';
            exit;
        }

        // Instanciation de la classe de modèle
        $conducteurModel = new ConducteurModel($this->database);

        // Insertion du conducteur
        $conducteurModel->delete($_GET['id_conducteur']);

        // Message flash et redirection
        (new Flashbag())->addFlashMessage('Conducteur supprimé.');
        header('Location: /conducteur');
        exit;
    }
}




