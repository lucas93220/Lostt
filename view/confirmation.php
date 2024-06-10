<?php 
session_start(); 
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ce site est dedie a la vente de vetements">
    <title>Confirmation</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/favicon/favicon-16x16.png">
    <link rel="manifest" href="../public/favicon/site.webmanifest">
    <link rel="stylesheet" href="../public/css/reset.css" />
    <link rel="stylesheet" href="../public/css/nav.css" />
    <link rel="stylesheet" href="../public/css/confirmation.css" />


</head>
<body>
    <?php include_once("nav.php"); ?>
    <main>
        <?php include_once("../controller/confirm_commande.php"); ?>
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