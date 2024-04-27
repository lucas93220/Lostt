<?php 
include_once("edit_commande.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/reset.css"/>
<link rel="stylesheet" href="../public/css/nav.css"/>
<link rel="stylesheet" href="../public/css/account.css"/>
    <script src="../public/js/app.js"></script>
                <script src="../public/js/op_panier.js"></script>
    <title>Liste des Commandes</title>
</head>
<body>
<?php include_once("../model/nav.php"); ?>
    <h1>Liste des Commandes</h1>
    <div class="sucess">

    <?php
    if ($commandes) {
        foreach ($commandes as $commande) {
          echo "<p>ID Commande : " . $commande['ID_COMMANDE'] . "</p>";
          echo "<p>Nom : " . $commande['NOM_USER'] . "</p>";
          echo "<p>Prenom : " . $commande['PRENOM_USER'] . "</p>";
          echo "<p>Date de commande : " . $commande['DATE_COMMANDE'] . "</p>";
          echo "<p>Statut de la commande : " . $commande['STATUT_COMMANDE'] . "</p>";
          echo "<p>Quantité de produits : " . $commande['QUANTITE_PRODUIT'] . "</p>";
        //   echo "<p>Adresse : " . $commande['ADRESSE_USER'] . "</p>";
        //   echo "<p>Ville : " . $commande['VILLE_USER'] . "</p>";
        //   echo "<p>Code postal : " . $commande['CP_USER'] . "</p>";
          echo "<p>Prix total : " . $commande['PRIXTOTAL_COMMANDE'] . " €</p>";
          echo "<a href='home.php?action=annuler&commande_id=" . $commande['ID_COMMANDE'] . "' class='cancelButton'>Annuler</a>";
          echo "<hr>";
        }
    } else {
        echo "<p>Aucune commande n'a été effectuée.</p>";
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
