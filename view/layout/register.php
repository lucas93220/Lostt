<?php
    session_start();
    include_once('../../controller/db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include_once "../../controller/register.inc.php";
    }
    if(isset($_SESSION["PRENOM_USER"])){
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/form.css">
    <script src="../../public/js/app.js"></script>
    <script src="../../public/js/op_panier.js"></script>
    <title>Inscription</title>
</head>
<body>
<?php include_once("../../model/nav.user.php"); ?>
    <main>
        <h2>Inscrivez-vous !</h2>
        <form class="inscription" method="post">
            <label for="nom">Nom:</label> <br>
            <input type="text" id="nom" name="NOM_USER" required> <br>

            <label for="prenom">Prénom:</label> <br>
            <input type="text" id="prenom" name="PRENOM_USER" required> <br>

            <label for="email">Email:</label> <br>
            <input type="text" id="email" name="EMAIL_USER" required> <br>

            <label for="mdp">Mot de passe:</label> <br>
            <input type="password" id="mdp" name="MDP_USER" required> <br>

            <label for="tel">Téléphone:</label> <br>
            <input type="number" id="tel" name="TEL_USER" required> <br>

            <label for="codePostal">Code Postal</label> <br>
            <input type="number" id="codePostal" name="CP_USER" minlength="5" maxlength="5" required> <br>

            <label for="ville">Ville</label> <br>
            <input type="text" id="ville" name="VILLE_USER"  required> <br>

            <label for="adresse">Adresse </label> <br>
            <input type="text" id ="adresse" name = "ADRESSE_USER" required> <br>

            <button class="button" type="submit" name="submit">Inscription</button> <br>
        </form>
        <?php
            include_once "../../controller/register.inc.php";
            ?>
    </main>

    <footer>
        <p>
            Lucas Lopez - 2024
        </p>
    </footer>
</body>
</html>