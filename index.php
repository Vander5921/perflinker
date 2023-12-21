<?php

require_once  'C:\wamp64\www\perflinker\model\Database.php';  //Souci avec les chemins relatifs, à ameliorer
require_once  'C:\wamp64\www\perflinker\model\InscriptionModel.php';
require_once 'C:\wamp64\www\perflinker\controller\InscriptionController.php';

$database = new Database("localhost", "nom_utilisateur","", "perflinker");
$model = new InscriptionModel($database);
$controller = new InscriptionController($model);

// Rediriger vers le formulaire d'inscription
header('Location: controller/InscriptionController.php');

$database->close();
?>
