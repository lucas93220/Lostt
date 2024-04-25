<?php
session_start();

include_once('../../controller/db.php');
include_once('../../controller/calculPanier.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['product_id'], $_POST['size'])) {
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $product_id = $_POST['product_id'];
        $size = $_POST['size'];

        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['product_id'] === $product_id && $product['size'] === $size) {
                unset($_SESSION['cart'][$key]);
                echo "Le produit a été supprimé du panier avec succès.";
                exit;
            }
        }
        echo "Erreur: Produit non trouvé dans le panier.";
    } else {
        echo "Erreur: Le panier est vide.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'add' && isset($_POST['product_id'], $_POST['size'])) {
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];

    $sql = "SELECT * FROM produit WHERE ID_PRODUIT = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($product)) {
        $product_already_in_cart = false;
        foreach ($_SESSION['cart'] as &$cart_product) {
            if ($cart_product['product_id'] === $product_id && $cart_product['size'] === $size) {
                $cart_product['quantite'] += 1; // Augmenter la quantité du produit dans le panier
                $product_already_in_cart = true;
                break;
            }
        }
        if (!$product_already_in_cart) {
            $_SESSION['cart'][] = array(
                'product_id' => $product_id,
                'size' => $size,
                'nom' => $product['NOM_PRODUIT'],
                'prix' => $product['PRIX_PRODUIT'],
                'quantite' => 1
            );
        }

        // Mettre à jour la quantité du produit dans la base de données
        $sql_update_quantity = "UPDATE produit SET QUANTITE_PRODUIT = QUANTITE_PRODUIT + 1 WHERE ID_PRODUIT = :product_id";
        $stmt_update_quantity = $conn->prepare($sql_update_quantity);
        $stmt_update_quantity->bindParam(':product_id', $product_id);
        $stmt_update_quantity->execute();

        echo "Le produit a été ajouté au panier avec succès.";
    } else {
        echo "Erreur: Produit non trouvé dans la base de données.";
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'update_quantity' && isset($_POST['product_id'], $_POST['size'], $_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];
    $new_quantity = $_POST['quantity'];

    foreach ($_SESSION['cart'] as &$cart_product) {
        if ($cart_product['product_id'] === $product_id && $cart_product['size'] === $size) {
            $cart_product['quantite'] = $new_quantity;
            break;
        }
    }

    echo "La quantité du produit a été mise à jour avec succès.";
    exit;
}

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $panierVide = true;
    foreach ($_SESSION['cart'] as $product) {
        if (is_array($product) && isset($product['product_id'], $product['size'], $product['nom'], $product['prix'])) {
            $panierVide = false;
            $quantity = isset($product['quantite']) ? $product['quantite'] : 1;
            echo "<div>";
            echo "<p>Nom du produit: " . $product['nom'] . ", Prix unitaire: " . $product['prix'] . " €, Taille: " . $product['size'] . ", Quantité: <input type='number' min='1' value='" . $product['quantite'] . "' onchange='changerQuantite(" . $product['product_id'] . ", \"" . $product['size'] . "\", this.value)'> <button onclick='supprimerDuPanier(" . $product['product_id'] . ", \"" . $product['size'] . "\")' type='button'>Supprimer</button></p>";
            echo "</div>";
        } else {
            echo "<p>Erreur: Format de produit invalide.</p>";
        }
    }
    if ($panierVide) {
        echo "<p>Votre panier est vide.</p>";
    } else {
        echo "<p>Total du panier : " . calculerTotalPanier() . " €</p>";
        if(isset($_SESSION['ID_USER'])) {
            echo '<form method="post" action="confirm_commande.php">
                <input type="hidden" name="action" value="checkout">
                <button type="submit">Valider la commande</button>
              </form>';

        } else {
            echo '<a href="invite.php">Valider la commande en tant qu\'invité</a>';
        }
    }
} else {
    echo "<p>Votre panier est vide.</p>";
}
?>
