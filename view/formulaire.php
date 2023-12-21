<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
</head>
<body>
    <h2>Formulaire d'Inscription</h2>
    <form action="../controller/InscriptionController.php" method="post">
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required><br>

        <label for="nom">Nom :</label>
        <input type="text" name="nom" required><br>

        <label>Genre :</label>
        <input type="radio" name="genre" value="homme" required> Homme
        <input type="radio" name="genre" value="femme" required> Femme<br>

        <label for="email">Email :</label>
        <input type="email" name="email" required><br>

        <label for="date_naissance">Date de naissance :</label>
        <input type="date" id="date_naissance" name="date_naissance" required pattern="\d{1,2}/\d{1,2}/\d{4}" title="Veuillez entrer une date au format jj/mm/aaaa">

        <label for="telephone">Téléphone :</label>
        <input type="tel" name="telephone" required><br>

        <label for="pays">Pays :</label>
        <input type="text" name="pays" required><br>

        <label for="question">Question à poser :</label>
        <textarea name="question" required></textarea><br>

        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
