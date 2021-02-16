<?php 

// Inclusion des dépendances
require '../vendor/autoload.php';
require '../src/functions.php';

use App\Core\PDOFactory;
use App\Core\Database;

$path = $_SERVER['PATH_INFO'] ?? '/';

// Routing
$routes = [
    '/conducteur' => [
        'class' => 'App\\Controller\\ConducteurController',
        'method' => 'index'
    ],
    '/conducteur/edit' => [
        'class' => 'App\\Controller\\ConducteurController',
        'method' => 'edit'
    ],
    '/conducteur/delete' => [
        'class' => 'App\\Controller\\ConducteurController',
        'method' => 'delete'
    ],
    '/vehicule' => [
        'class' => 'App\\Controller\\VehiculeController',
        'method' => 'index'
    ],
    '/vehicule/edit' => [
        'class' => 'App\\Controller\\VehiculeController',
        'method' => 'edit'
    ],
    '/vehicule/delete' => [
        'class' => 'App\\Controller\\VehiculeController',
        'method' => 'delete'
    ],
    '/association' => [
        'class' => 'App\\Controller\\AssociationController',
        'method' => 'index'
    ],
    '/association/edit' => [
        'class' => 'App\\Controller\\AssociationController',
        'method' => 'edit'
    ],
    '/association/delete' => [
        'class' => 'App\\Controller\\AssociationController',
        'method' => 'delete'
    ],
    '/divers' => [
        'class' => 'App\\Controller\\DiversController',
        'method' => 'index'
    ]
];

// Si le path existe dans le tableau de routes... 
if (array_key_exists($path, $routes)) {

    // Création de l'objet Database pour l'injecter au contrôleur
    $database = new Database(PDOFactory::get());

    // Instanciation de la classe de contrôleur
    $controller = new $routes[$path]['class']($database);

    // Récupération de la méthode associée à l'action 
    $method = $routes[$path]['method'];

    // Exécution de cette méthode sur l'objet contrôleur
    call_user_func([$controller, $method]);
}
else {

    // Sinon on fait une erreur 404
    http_response_code(404);

    render('404', [
        'pageTitle' => 'Erreur 404 : page non trouvée'
    ]);
}