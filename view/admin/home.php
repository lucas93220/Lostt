<?php 
include_once("edit_commande.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../public/js/app.js"></script>
                <script src="../../public/js/op_panier.js"></script>
    <title>Liste des Commandes</title>
</head>
<body>
<?php include_once("../../model/nav.admin.php"); ?>
<h1>Bienvenue <?php echo $_SESSION['PRENOM_USER']; ?>!</h1>
      <p>C'est votre espace utilisateur.</p>
    <h2>Liste des Commandes</h2>
    <?php
    if ($commandes) {
        echo "<ul>";
        foreach ($commandes as $commande) {
          echo "<p>ID Commande : " . $commande['ID_COMMANDE'] . "</p>";
          echo "<p>ID Utilisateur : " . $commande['ID_USER'] . "</p>";
          echo "<p>Nom : " . $commande['NOM_USER'] . "</p>";
          echo "<p>Prenom : " . $commande['PRENOM_USER'] . "</p>";
          echo "<p>Date de commande : " . $commande['DATE_COMMANDE'] . "</p>";
          echo "<p>Statut de la commande : " . $commande['STATUT_COMMANDE'] . "</p>";
          echo "<p>Quantité de produits : " . $commande['QUANTITE_PRODUIT'] . "</p>";
          echo "<p>Prix total : " . $commande['PRIXTOTAL_COMMANDE'] . " €</p>";
          echo "<a href='home.php?action=valider&commande_id=" . $commande['ID_COMMANDE'] . "'>Valider</a>";
          echo "<a href='home.php?action=annuler&commande_id=" . $commande['ID_COMMANDE'] . "'>Annuler</a>";
          echo "<hr>";
        }
        echo "</ul>";
    } else {
        echo "<p>Aucune commande n'a été effectuée.</p>";
    }
    ?>
</body>
</html>
