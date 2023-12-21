<?php

class InscriptionModel {
    private $base_de_donnees;

    public function __construct(Database $base_de_donnees) {
        $this->base_de_donnees = $base_de_donnees;
    }

    public function inscrire($prenom, $nom, $genre, $email, $date_naissance, $telephone, $pays, $question, $ip) {
        // Valider les données du formulaire
        $this->validerDonnees($prenom, $nom, $question, $telephone);

        // Convertir la date de naissance en objet DateTime
        $naissance = DateTime::createFromFormat('d/m/Y', $date_naissance);

        // Vérifier si l'utilisateur est mineur
        if ($this->estMineur($naissance)) {
            die("Désolé, les mineurs ne peuvent pas s'inscrire.");
        }

        // Vérifier et traiter les inscriptions multiples
        $this->verifierInscriptionMultiple($email, $ip);

        // Vérifier la longueur de la question
        if (!$this->longueurQuestionValide($question)) {
            die("La question doit comporter au moins 15 caractères.");
        }

        // Insérer ou mettre à jour les données dans la base de données
        $this->insererOuMettreAJour($prenom, $nom, $genre, $email, $date_naissance, $telephone, $pays, $question, $ip);

        echo "Inscription réussie !";
    }

    private function validerDonnees($prenom, $nom, $question, $telephone) {
        // Valider la longueur des champs
        $this->validerLongueur($prenom, 50, "Prénom");
        $this->validerLongueur($nom, 50, "Nom");
        $this->validerLongueur($question, 255, "Question");
        $this ->validerTelephone($telephone);
    }

    private function validerLongueur($valeur, $longueurMax, $nomChamp) {
        // Vérifier si la longueur dépasse la limite
        if (strlen($valeur) > $longueurMax) {
            die("$nomChamp ne peut pas dépasser $longueurMax caractères.");
        }
    }

    private function validerTelephone($telephone) {
        // Vérifier si le numéro de téléphone contient 10 chiffres
        if (!preg_match('/^\d{10}$/', $telephone)) {
            die("Le numéro de téléphone doit contenir exactement 10 chiffres.");
        }
    }

    private function estMineur(DateTime $naissance) {
        // Calculer l'âge en années
        $aujourd_hui = new DateTime();
        $age = $aujourd_hui->diff($naissance)->y;

        return $age < 18;
    }

    private function verifierInscriptionMultiple($email, $ip) {
        // Vérifier si une inscription a déjà été faite pour cette adresse IP au cours des 24 dernières heures
        $requete_verif = "SELECT COUNT(*) as count FROM gpbl 
                          WHERE email = '$email' AND IP = '$ip' AND creatAt >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        $resultat_verif = $this->base_de_donnees->query($requete_verif);

        // Vérifier si la requête s'est exécutée correctement
        if ($resultat_verif === false) {
            die("Erreur lors de l'exécution de la requête : " . $this->base_de_donnees->error);
        }

        $row = $resultat_verif->fetch_assoc();

        // Vérifier le nombre d'inscriptions dans les 24 dernières heures
        $nombre_inscriptions_24h = $row['count'];

        // Si une inscription existe déjà, afficher un message d'erreur
        if ($nombre_inscriptions_24h > 0) {
            die("Pas de deux inscriptions en moins de 24 heures.");
        }
    }

    private function longueurQuestionValide($question) {
        // Vérifier si la longueur de la question est valide
        return strlen($question) >= 15;
    }

    private function insererOuMettreAJour($prenom, $nom, $genre, $email, $date_naissance, $telephone, $pays, $question, $ip) {
        // Vérifier si l'utilisateur a déjà une inscription
        $requete_existence = "SELECT * FROM gpbl WHERE email = '$email' AND IP = '$ip'";
        $resultat_existence = $this->base_de_donnees->query($requete_existence);

        // Vérifier si la requête s'est exécutée correctement
        if ($resultat_existence === false) {
            die("Erreur lors de l'exécution de la requête : " . $this->base_de_donnees->error);
        }

        // Si l'utilisateur existe déjà, mettre à jour les données
        if ($resultat_existence->num_rows > 0) {
            $requete_mise_a_jour = "UPDATE gpbl SET prenom = '$prenom', nom = '$nom', genre = '$genre', birth = '$date_naissance', phone = '$telephone', country = '$pays', question = '$question', updateAt = NOW(), counter = counter + 1 WHERE email = '$email' AND IP = '$ip'";
            $this->base_de_donnees->query($requete_mise_a_jour);
        } else {
            // Si l'utilisateur n'existe pas, insérer une nouvelle entrée
            $requete_insertion = "INSERT INTO gpbl (prenom, nom, genre, email, birth, phone, country, question, IP, creatAt, updateAt, counter) 
                                  VALUES ('$prenom', '$nom', '$genre', '$email', '$date_naissance', '$telephone', '$pays', '$question', '$ip', NOW(), NOW(), 0)";
            $this->base_de_donnees->query($requete_insertion);
        }
    }
}
