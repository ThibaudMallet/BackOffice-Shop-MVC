<?php
// POINT D'ENTRÉE UNIQUE :
// FrontController

// inclusion des dépendances via Composer
// autoload.php permet de charger d'un coup toutes les dépendances installées avec composer
// mais aussi d'activer le chargement automatique des classes (convention PSR-4)
require_once '../vendor/autoload.php';

session_start();
/* ------------
--- ROUTAGE ---
-------------*/


// création de l'objet router
// Cet objet va gérer les routes pour nous, et surtout il va
$router = new AltoRouter();

// le répertoire (après le nom de domaine) dans lequel on travaille est celui-ci
// Mais on pourrait travailler sans sous-répertoire
// Si il y a un sous-répertoire
if (array_key_exists('BASE_URI', $_SERVER)) {
    // Alors on définit le basePath d'AltoRouter
    $this->router->setBasePath($_SERVER['BASE_URI']);
    // ainsi, nos routes correspondront à l'URL, après la suite de sous-répertoire
} else { // sinon
    // On donne une valeur par défaut à $_SERVER['BASE_URI'] car c'est utilisé dans le CoreController
    $_SERVER['BASE_URI'] = '/';
}

// On doit déclarer toutes les "routes" à AltoRouter,
// afin qu'il puisse nous donner LA "route" correspondante à l'URL courante
// On appelle cela "mapper" les routes
// 1. méthode HTTP : GET ou POST (pour résumer)
// 2. La route : la portion d'URL après le basePath
// 3. Target/Cible : informations contenant
//      - le nom de la méthode à utiliser pour répondre à cette route
//      - le nom du controller contenant la méthode
// 4. Le nom de la route : pour identifier la route, on va suivre une convention
//      - "NomDuController-NomDeLaMéthode"
//      - ainsi pour la route /, méthode "home" du MainController => "main-home"


/* HOME */ 
$router->map(
    'GET',
    '/',
    [
        'method' => 'home',
        'controller' => '\App\Controllers\MainController' // On indique le FQCN de la classe
    ],
    'main-home'
);


/* CATEGORY */
// Affichage de la liste des catégories
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-list'
);

// Affichage du formulaire pour modification d'une categorie
$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add'
);

// Route pour la soumission du formulaire
// On garde la meme route, mais avec une methode post
$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'insert',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-insert'
);

// Modification d'une categrory
// Affichage du formulaire
$router->map(
    'GET',
    '/category/[i:id]',
    [
        "method" => "edit",
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-edit'
);

// Soummission du formulaire
$router->map(
    'POST',
    '/category/[i:id]',
    [
        "method" => "update",
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-update'
);


// Suppression d'une category
$router->map(
    'GET',
    '/category/[i:id]/delete', 
    [
        "method" => "delete",
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-delete'
);

// Définition des home_order pour la page home
$router->map(
    'GET',
    '/category/home-order', 
    [
        "method" => "manageHome",
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-managehome'
);

$router->map(
    'POST',
    '/category/home-order', 
    [
        "method" => "saveHome",
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-savehome'
);


/* PRODUCT */
// Affichage de la liste des produits
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

// Affichage du formulaire pour modification d'un produit
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);

// ASoumission du fomrulaire 
$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'save',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-insert'
);


// Modification d'un produit
// Affichage du formulaire
$router->map(
    'GET',
    '/product/[i:id]',
    [
        "method" => "edit",
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-edit'
);

// Soummission du formulaire
$router->map(
    'POST',
    '/product/[i:id]',
    [
        "method" => "save",
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-update'
);

// Suppression d'une category
$router->map(
    'GET',
    '/product/[i:id]/delete', 
    [
        "method" => "delete",
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-delete'
);

$router->map(
    'GET',
    '/login', 
    [
        "method" => "login",
        'controller' => '\App\Controllers\UserAppController'
    ],
    'login'
);

$router->map(
    'POST',
    '/login', 
    [
        "method" => "connecting",
        'controller' => '\App\Controllers\UserAppController'
    ],
    'connection'
);

$router->map(
    'GET',
    '/logout', 
    [
        "method" => "logout",
        'controller' => '\App\Controllers\UserAppController'
    ],
    'logout'
);

$router->map(
    'GET',
    '/user-list', 
    [
        "method" => "list",
        'controller' => '\App\Controllers\UserAppController'
    ],
    'user-list'
);

$router->map(
    'GET',
    '/user-add', 
    [
        "method" => "add",
        'controller' => '\App\Controllers\UserAppController'
    ],
    'user-add'
);

$router->map(
    'POST',
    '/user-add', 
    [
        "method" => "insert",
        'controller' => '\App\Controllers\UserAppController'
    ],
    'user-insert'
);



/* -------------
--- DISPATCH ---
--------------*/

// On demande à AltoRouter de trouver une route qui correspond à l'URL courante
$match = $router->match();

// Ensuite, pour dispatcher le code dans la bonne méthode, du bon Controller
// On délègue à une librairie externe : https://packagist.org/packages/benoclock/alto-dispatcher
// 1er argument : la variable $match retournée par AltoRouter
// 2e argument : le "target" (controller & méthode) pour afficher la page 404
$dispatcher = new Dispatcher($match, '\App\Controllers\ErrorController::err404');

// On passe des variable au constructeur de nos controllers
$dispatcher->setControllersArguments($match['name'], $router);

// Une fois le "dispatcher" configuré, on lance le dispatch qui va exécuter la méthode du controller
$dispatcher->dispatch();