<?php 
include_once("../controller/db.php");
session_start();
if (!isset($_SESSION["PRENOM_USER"])) {
    header("Location: ../connexion.php");
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
<link rel="stylesheet" href="../public/css/update.css"/>


    <script src="../public/js/app.js"></script>
                <script src="../public/js/op_panier.js"></script>
    <title>Liste des Produits</title>
</head>
<body>

    <?php include_once("../model/nav.php"); ?>
    <h1>Liste des produits</h1>
<main>
<a href="add_produit.php" class="addButton">Ajouter un produit</a>
<div class="container">

        <?php include_once("../controller/update.inc.php"); ?> 
</div>
</main>
<footer>
        <p>
            Lostt - 2024
        </p>
    </footer>
</body>
</html>