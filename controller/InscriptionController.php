<?php

require_once  'C:\wamp64\www\perflinker\model\Database.php'; //chemins relatifs ne marche plus, à améliorer
require_once  'C:\wamp64\www\perflinker\model\InscriptionModel.php';

 

class InscriptionController {
    private $model;

    public function __construct(InscriptionModel $model) {
        $this->model = $model;
    }

    public function afficherFormulaire() {
        // Affiche le formulaire
        include '../view/formulaire.php';
    }

    public function traiterFormulaire(array $donneesFormulaire) {
        // Traite les données du formulaire
        $this->model->inscrire(
            $donneesFormulaire['prenom'],
            $donneesFormulaire['nom'],
            $donneesFormulaire['genre'],
            $donneesFormulaire['email'],
            $donneesFormulaire['date_naissance'],
            $donneesFormulaire['telephone'],
            $donneesFormulaire['pays'],
            $donneesFormulaire['question'],
            $_SERVER['REMOTE_ADDR'] // Adresse IP du client
        );
    }
}

// Configuration de la base de données
$serveur = 'localhost';
$utilisateur = 'root';  
$mot_de_passe = ''; // Mot de passe de la base de données, aucun pour cet exercice
$base_de_donnees = 'perflinker'; // Nom de la base de données

// Création d'une instance de la classe Database
$database = new Database($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Création d'une instance de la classe InscriptionModel
$inscriptionModel = new InscriptionModel($database);

// Création d'une instance de la classe InscriptionController
$inscriptionController = new InscriptionController($inscriptionModel);

// Traitement du formulaire si des données sont soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inscriptionController->traiterFormulaire($_POST);
} else {
    $inscriptionController->afficherFormulaire();
}

// Fermeture de la connexion à la base de données
$database->close();
