<?php
session_start();

include_once('../../controller/db.php');

function calculerTotalPanier() {
    $total = 0;
    foreach ($_SESSION['cart'] as $product) {
        $total += $product['prix'] * $product['quantite'];
    }
    return $total;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['product_id'], $_POST['size'])) {
        // Supprimer le produit du panier
        $product_id = $_POST['product_id'];
        $size = $_POST['size'];

        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['product_id'] === $product_id && $product['size'] === $size) {
                unset($_SESSION['cart'][$key]);
                echo "Le produit a été supprimé du panier avec succès.";
                exit; // Arrêter l'exécution après la suppression
            }
        }
        echo "Erreur: Produit non trouvé dans le panier.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'], $_POST['product_id'], $_POST['size'])) {
    $action = $_POST['action'];
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];

    $sql = "SELECT * FROM produit WHERE ID_PRODUIT = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($action === 'add' && !empty($product_id) && !empty($size) && $product) {
        $product_already_in_cart = false;
        foreach ($_SESSION['cart'] as &$cart_product) {
            if ($cart_product['product_id'] === $product_id && $cart_product['size'] === $size) {
                // Le produit est déjà dans le panier, augmenter la quantité
                $cart_product['quantite'] = isset($cart_product['quantite']) ? $cart_product['quantite'] + 1 : 1;
                $product_already_in_cart = true;
                break;
            }
        }
        if (!$product_already_in_cart) {
            // Le produit n'est pas encore dans le panier, l'ajouter
            $_SESSION['cart'][] = array(
                'product_id' => $product_id,
                'size' => $size,
                'nom' => $product['NOM_PRODUIT'],
                'prix' => $product['PRIX_PRODUIT'],
                'quantite' => 1
            );
        }
        echo "Le produit a été ajouté au panier avec succès.";
    } else {
        echo "Erreur: Données du produit manquantes ou invalides.";
    }
}


if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $panierVide = true; // Variable pour suivre si le panier est vide ou non
    echo "<h2>Contenu du panier :</h2>";
    foreach ($_SESSION['cart'] as $product) {
        if (is_array($product) && isset($product['product_id'], $product['size'], $product['nom'], $product['prix'])) {
            $panierVide = false; // Si un produit est trouvé, le panier n'est pas vide
            $quantity = isset($product['quantite']) ? $product['quantite'] : 1; // Utilisation d'une valeur par défaut de 1 si 'quantite' n'est pas défini
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
        echo '<form method="post">
                <input type="hidden" name="action" value="checkout">
                <button type="submit">Valider la commande</button>
              </form>';
    }
} else {
    echo "<p>Votre panier est vide.</p>";
}

?>
