<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="radio"] {
            margin-right: 6px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
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

        <label for="date_naissance">Date de Naissance (JJ/MM/AAAA) :</label>
        <input type="text" name="date_naissance" required><br>

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
