<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Model\AssociationModel;
use App\Model\ConducteurModel;
use App\Model\VehiculeModel;

class DiversController extends AbstractController
{

    public function index()
    {
        $associationModel = new AssociationModel($this->database);
        $conducteurModel = new ConducteurModel($this->database);
        $vehiculeModel = new VehiculeModel($this->database);

        // Rendu du template
        render('divers', [
            'countVehicules' => $vehiculeModel->count(),
            'countConducteurs' => $conducteurModel->count(),
            'countAssociations' => $associationModel->count(),
            'vehiculesSansConducteur' => $vehiculeModel->getVehiculesSansConducteur(),
            'conducteursSansVehicule' => $conducteurModel->getConducteursSansVehicules(),
            'vehiculesDePhilippePandre' => $vehiculeModel->getVehiculesByConducteur('Philippe', 'Pandre'),
            'conducteursEtLeursVehicules' => $conducteurModel->getAllWithVehicules(),
            'conducteursEtTousLesVehicules' => $conducteurModel->getAllWithAllVehicules(),
            'everything' =>$conducteurModel->getAllConducteursAndAllVehicules()
        ]);
    }
}