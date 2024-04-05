<?php 
include_once("../../controller/db.php");
session_start();
if (!isset($_SESSION["PRENOM_USER"])) {
    header("Location: ../layout/connexion.php");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>

    <?php include_once("../../model/nav.admin.php"); ?>


<div class="container">
    <h1 class="">Liste des produits</h1>

    <div class="">
        <?php include_once("../../controller/update.inc.php"); ?> 
    </div>
    <a href="add_produit.php" class="btn btn-success mt-4">Ajouter un produit</a>
</div>

</body>
</html>