<?php
session_start();
include_once("../model/db.php");
if (!isset($_SESSION["EMAIL_USER"])) {
  header("Location: connexion.php");
  exit();
}
?>
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
  <link rel="stylesheet" href="../public/css/account.css" />
</head>

<body>

  <?php include_once("nav.php"); ?>
  <h1>Commandes</h1>
  <div class="sucess">

    <?php include_once('../controller/account.inc.php'); ?>

  </div>
  <footer>
    <p>
      Lostt - 2024
    </p>
  </footer>
  <script src="../public/js/app.js"></script>
  <script src="../public/js/op_panier.js"></script>
</body>

</html>