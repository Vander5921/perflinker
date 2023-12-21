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
        if (!preg_match('/^[a-zA-Z0-9]{10}$/', $telephone)) {
            die("Le numéro de téléphone doit contenir exactement 10 chiffres.");
        }
    }

    private function estMineur(DateTime $naissance) {
        // Calculer l'âge en années
        $aujourd_hui = new DateTime();
        $age = $aujourd_hui->diff($naissance)->y;

        return $age < 18;
    }
    //Utilisation de prepare pour protection injections SQL
    private function verifierInscriptionMultiple($email, $ip) {
        $requete_verif = "SELECT COUNT(*) as count FROM gpbl WHERE email = ? AND IP = ? AND creatAt >= DATE_SUB(NOW(), INTERVAL 24 HOUR)";
        $stmt_verif = $this->base_de_donnees->prepare($requete_verif);
        $stmt_verif->bind_param("ss", $email, $ip);
        $stmt_verif->execute();
        $resultat_verif = $stmt_verif->get_result();
    
        if ($resultat_verif === false) {
            die("Erreur lors de l'exécution de la requête : " . $stmt_verif->error);
        }
    
        $row = $resultat_verif->fetch_assoc();
        $nombre_inscriptions_24h = $row['count'];
    
        if ($nombre_inscriptions_24h > 0) {
            die("Pas de deux inscriptions en moins de 24 heures.");
        }
    }

    private function longueurQuestionValide($question) {
        // Vérifier si la longueur de la question est valide
        return strlen($question) >= 15;
    }

    //Utilisation de prepare pour protection injections SQL
    private function insererOuMettreAJour($prenom, $nom, $genre, $email, $date_naissance, $telephone, $pays, $question, $ip) {
        $requete_existence = "SELECT * FROM gpbl WHERE email = ? AND IP = ?";
        $stmt_existence = $this->base_de_donnees->prepare($requete_existence);
        $stmt_existence->bind_param("ss", $email, $ip);
        $stmt_existence->execute();
        $resultat_existence = $stmt_existence->get_result();
    
        if ($resultat_existence === false) {
            die("Erreur lors de l'exécution de la requête : " . $stmt_existence->error);
        }
    
        if ($resultat_existence->num_rows > 0) {
            $requete_mise_a_jour = "UPDATE gpbl SET prenom = ?, nom = ?, genre = ?, birth = ?, phone = ?, country = ?, question = ?, updateAt = NOW(), counter = counter + 1 WHERE email = ? AND IP = ?";
            $stmt_mise_a_jour = $this->base_de_donnees->prepare($requete_mise_a_jour);
            $stmt_mise_a_jour->bind_param("sssssssss", $prenom, $nom, $genre, $date_naissance, $telephone, $pays, $question, $email, $ip);
            $stmt_mise_a_jour->execute();
        } else {
            $requete_insertion = "INSERT INTO gpbl (prenom, nom, genre, email, birth, phone, country, question, IP, creatAt, updateAt, counter) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), 0)";
            $stmt_insertion = $this->base_de_donnees->prepare($requete_insertion);
            $stmt_insertion->bind_param("ssssssssss", $prenom, $nom, $genre, $email, $date_naissance, $telephone, $pays, $question, $ip);
            $stmt_insertion->execute();
        }
    }
}
