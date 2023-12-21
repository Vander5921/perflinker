<?php

class Database {
    private $connexion;

    public function __construct($serveur, $utilisateur, $mot_de_passe, $base_de_donnees) {
        $this->connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

        if ($this->connexion->connect_error) {
            die("Échec de la connexion à la base de données : " . $this->connexion->connect_error);
        }
    }

    public function query($requete) {
        $resultat = $this->connexion->query($requete);

        if (!$resultat) {
            die("Erreur SQL : " . $this->connexion->error);
        }
    
        return $resultat;
    }

    public function close() {
        $this->connexion->close();
    }
}
