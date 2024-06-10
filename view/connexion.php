<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ce site est dedie a la vente de vetements">
    <title>Lostt</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/favicon/favicon-16x16.png">
    <link rel="manifest" href="../public/favicon/site.webmanifest">
    <link rel="stylesheet" href="../public/css/reset.css" />
    <link rel="stylesheet" href="../public/css/nav.css" />
    <link rel="stylesheet" href="../public/css/form.css" />
    <title>Connexion</title>
</head>

<body>
    <?php include_once("nav.php"); ?>
    <main class="connexion">
        <h2>Connexion</h2>
        <?php
include_once('../controller/log.inc.php');
        ?>
        <form class="connexion" action="" method="post">
            <input placeholder="Email" type="text" id="email" name="EMAIL_USER" required>
            <br>
            <input placeholder="Mot de passe" type="password" id="password" name="MDP_USER" required>
            <p class="pswForget"><a href=".">Mot de passe oublié ?</a></p>
            <br>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <button class="button" type="submit" name="submit">Connexion</button>
        </form>
        <p>Vous n'avez pas de compte? <a href="register.php">Inscrivez-vous ici</a></p>
    </main>

    <footer>
        <p>
            Lostt - 2024
        </p>
    </footer>

    <script src="../public/js/app.js"></script>
    <script src="../public/js/op_panier.js"></script>
</body>

</html>