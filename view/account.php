<?php
  session_start();
  include_once("../controller/db.php");
  if(!isset($_SESSION["EMAIL_USER"])){
    header("Location: view/connexion.php");
    exit(); 
  }
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="../public/css/reset.css"/>
<link rel="stylesheet" href="../public/css/nav.css"/>
<link rel="stylesheet" href="../public/css/account.css"/>

    <script src="../public/js/app.js"></script>
    <script src="../public/js/op_panier.js"></script>
  </head>
  <body>

  <?php include_once("../model/nav.php"); ?>
  <h1>Commandes</h1>
        <div class="sucess">

      <?php

if(isset($_SESSION['ID_USER'])) {
    $userID = $_SESSION['ID_USER'];
    
    $sql = "SELECT * FROM commande WHERE ID_USER = :userID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if($commandes) {
        foreach($commandes as $commande) {
            echo "<p>ID Commande : " . $commande['ID_COMMANDE'] . "</p>";
            echo "<p>Date de commande : " . $commande['DATE_COMMANDE'] . "</p>";
            echo "<p>Statut de la commande : " . $commande['STATUT_COMMANDE'] . "</p>";
            echo "<p>Quantité de produits : " . $commande['QUANTITE_PRODUIT'] . "</p>";
            echo "<p>Prix total : " . $commande['PRIXTOTAL_COMMANDE'] . " €</p>";
            echo "<hr>";
        }
    } else {
        echo "Vous n'avez effectué aucune commande.";
    }
} else {
    echo "Erreur: Utilisateur non connecté.";
}
?>

    </div>
    <footer>
        <p>
            Lostt - 2024
        </p>
    </footer>
  </body>
</html>
