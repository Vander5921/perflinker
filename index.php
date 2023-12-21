<?php

// index.php (point d'entrée)

require_once 'model/Database.php';
require_once 'model/InscriptionModel.php';
require_once 'controller/InscriptionController.php';

$database = new Database("localhost", "nom_utilisateur","", "perflinker");
$model = new InscriptionModel($database);
$controller = new InscriptionController($model);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'inscrire':
            $controller->traiterFormulaire($_POST);
            break;
        default:
            // Gérer d'autres actions si nécessaire
    }
} else {
    $controller->afficherFormulaire();
}

$database->close();
