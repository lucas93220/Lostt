<?php
include_once('../controller/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once "../controller/register.inc.php";
}

if (isset($_SESSION["PRENOM_USER"])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/reset.css"/>
    <link rel="stylesheet" href="../public/css/nav.css"/>
    <link rel="stylesheet" href="../public/css/form.css"/>
    <script src="../public/js/app.js"></script>
    <script src="../public/js/op_panier.js"></script>
    <title>Inscription</title>
</head>
<body>
<?php include_once("../model/nav.php"); ?>
<main>
    <h2>Créer ton compte</h2>
    <?php
    if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
        foreach ($_SESSION['errors'] as $error) {
            echo "<p class='error'>$error</p>";

        }
        unset($_SESSION['errors']);
    }
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        echo "<p class='success'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    ?>
    <form class="inscription" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input placeholder="Nom" type="text" id="nom" name="NOM_USER" required> <br>
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
        <input placeholder="Prenom" type="text" id="prenom" name="PRENOM_USER" required> <br>
        <input placeholder="Email" type="text" id="email" name="EMAIL_USER" required> <br>
        <input placeholder="Telephone" type="text" id="tel" name="TEL_USER" required> <br>
        <input placeholder="Code postal" type="text" id="codePostal" name="CP_USER" minlength="5" maxlength="5" required> <br>
        <input placeholder="Ville" type="text" id="ville" name="VILLE_USER" required> <br>
        <input placeholder="Adresse" type="text" id="adresse" name="ADRESSE_USER" required> <br>
        <input placeholder="Mot de passe" type="password" id="mdp" name="MDP_USER" required> <br>
        <input placeholder="Confirmez votre mot de passe" type="password" id="mdp" name="CONFIRM_USER" required> <br>
        <button class="button" type="submit" name="submit">Créer</button> <br>
    </form>
</main>

<footer>
    <p>
        Lostt - 2026
    </p>
</footer>
</body>
</html>
