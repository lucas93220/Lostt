<?php
session_start();
include_once('../controller/db.php');
include_once('../controller/calculPanier.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];

    $guestUserId = 4;

    $sql_check_user = "SELECT * FROM user WHERE ID_USER = :guestUserId";
    $stmt_check_user = $conn->prepare($sql_check_user);
    $stmt_check_user->bindParam(':guestUserId', $guestUserId);
    $stmt_check_user->execute();
    $user_exists = $stmt_check_user->fetch();

    if (!$user_exists) {
        $sql_insert_user = "INSERT INTO user (ID_USER, ROLE_USER) VALUES (:guestUserId, 'guest')";
        $stmt_insert_user = $conn->prepare($sql_insert_user);
        $stmt_insert_user->bindParam(':guestUserId', $guestUserId);
        $stmt_insert_user->execute();
    }

    $sql_insert_commande = "INSERT INTO commande (ID_USER, NOM_USER, PRENOM_USER, EMAIL_USER, STATUT_COMMANDE, QUANTITE_PRODUIT, PRIXTOTAL_COMMANDE) VALUES (:guestUserId, :nom, :prenom, :email, 'En attente', :quantiteProduits, :prixTotal)";
    $stmt_insert_commande = $conn->prepare($sql_insert_commande);
    $quantiteProduits = count($_SESSION['cart']); 
    $prixTotal = calculerTotalPanier();
    $stmt_insert_commande->bindParam(':guestUserId', $guestUserId);
    $stmt_insert_commande->bindParam(':nom', $nom);
    $stmt_insert_commande->bindParam(':prenom', $prenom);
    $stmt_insert_commande->bindParam(':email', $email);
    $stmt_insert_commande->bindParam(':quantiteProduits', $quantiteProduits);
    $stmt_insert_commande->bindParam(':prixTotal', $prixTotal);
    $stmt_insert_commande->execute();

    unset($_SESSION['cart']);

    echo "<script>alert('Votre commande a été passée avec succès !');</script>";
    header("Location: shop.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../public/js/app.js"></script>
    <script src="../public/js/op_panier.js"></script>
    <title>Commande en tant qu'invité</title>
</head>
<body>
<?php include_once("../model/nav.php"); ?>

<h2>Commande en tant qu'invité</h2>
<?php
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $panierVide = true;
    foreach ($_SESSION['cart'] as $product) {
        if (is_array($product) && isset($product['product_id'], $product['size'], $product['nom'], $product['prix'])) {
            $panierVide = false;
            $quantity = isset($product['quantite']) ? $product['quantite'] : 1;
            echo "<div>";
            echo "<p>Nom du produit: " . $product['nom'] . ", Prix unitaire: " . $product['prix'] . " €, Taille: " . $product['size'] . ", Quantité: <input type='number' min='1' value='" . $quantity . "' onchange='changerQuantite(" . $product['product_id'] . ", \"" . $product['size'] . "\", this.value)'> <button onclick='supprimerDuPanier(" . $product['product_id'] . ", \"" . $product['size'] . "\")' type='button'>Supprimer</button></p>";
            echo "</div>";
        } else {
            echo "<p>Erreur: Format de produit invalide.</p>";
        }
    }

    if ($panierVide) {
        echo "<p>Votre panier est vide.</p>";
    } else {
        echo "<p>Total du panier : " . calculerTotalPanier() . " €</p>";
    }
} else {
    echo "<p>Votre panier est vide.</p>";
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required>
    <label for="prenom">Prenom:</label>
    <input type="text" id="prenom" name="prenom" required>
    <label for="email">Adresse e-mail:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit">Valider la commande en tant qu'invité</button>
</form>

</body>
</html>
