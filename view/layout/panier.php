<?php
session_start();

// Incluez votre fichier de connexion à la base de données ici
include_once('../../controller/db.php');

// Fonction pour calculer le coût total du panier
function calculerTotalPanier() {
    $total = 0;
    foreach ($_SESSION['cart'] as $product) {
        $total += $product['prix'];
    }
    return $total;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'], $_POST['product_id'], $_POST['size'])) {
    $action = $_POST['action'];
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];

    // Ajoutez la logique pour récupérer les informations sur le produit depuis votre base de données
    $sql = "SELECT * FROM produit WHERE ID_PRODUIT = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($action === 'add' && !empty($product_id) && !empty($size) && $product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        $_SESSION['cart'][] = array(
            'product_id' => $product_id,
            'size' => $size,
            'nom' => $product['NOM_PRODUIT'],
            'prix' => $product['PRIX_PRODUIT']
        );
        echo "Le produit a été ajouté au panier avec succès.";
    } else {
        echo "Erreur: Données du produit manquantes ou invalides.";
    }
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<h2>Contenu du panier :</h2>";
    foreach ($_SESSION['cart'] as $product) {
        if (is_array($product) && isset($product['product_id'], $product['size'])) {
            echo "<p>Nom du produit: " . $product['nom'] . ", Prix: " . $product['prix'] . " €, Taille: " . $product['size'] . "</p>";
        } else {
            echo "<p>Erreur: Format de produit invalide.</p>";
        }
    }
    echo "<p>Total du panier : " . calculerTotalPanier() . " €</p>";
} else {
    echo "<p>Votre panier est vide.</p>";
}
?>
