<?php
session_start();
include_once('../model/db.php');
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
  <link rel="stylesheet" href="../public/css/index.css" />
  <script src="../public/js/app.js"></script>
  <script src="../public/js/op_panier.js"></script>

</head>

<body>

  <?php include_once "nav.php"; ?>
  <main>
    <img src="../public/asset/clothes.JPG" alt="">

    <h2>Actualités</h2>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusantium omnis repellat libero vel in harum ipsam magnam repudiandae, corrupti dignissimos earum, placeat inventore recusandae ea temporibus? Atque illo veniam illum. Non sed quaerat fugiat repellat suscipit, quisquam doloremque. Fugit nesciunt veniam accusantium repudiandae aperiam culpa eum vitae in voluptas odio?</p>
  </main>

  <footer>
    <p>
      Lostt - 2024
    </p>
  </footer>

</body>

</html>