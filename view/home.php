<?php
include_once("../controller/edit_commande.php");
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

    <title>Liste des Commandes</title>
</head>

<body>
    <?php include_once("nav.php"); ?>
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
                echo "<p>Adresse : " . $commande['ADRESSE_USER'] . "</p>";
                echo "<p>Ville : " . $commande['VILLE_USER'] . "</p>";
                echo "<p>Code postal : " . $commande['CP_USER'] . "</p>";
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
    <script src="../public/js/app.js"></script>
    <script src="../public/js/op_panier.js"></script>
</body>

</html>