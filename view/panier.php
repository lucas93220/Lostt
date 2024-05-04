<?php
session_start();

include_once('../controller/db.php');
include_once('../controller/calculPanier.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['product_id'], $_POST['size'])) {

    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $product_id = $_POST['product_id'];
        $size = $_POST['size'];

        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['product_id'] === $product_id && $product['size'] === $size) {
                unset($_SESSION['cart'][$key]);
                // echo "Le produit a été supprimé du panier avec succès.";
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
        $existing_product_key = null;
        foreach ($_SESSION['cart'] as $key => $cart_product) {
            if ($cart_product['product_id'] === $product_id && $cart_product['size'] === $size) {
                $existing_product_key = $key;
                break;
            }
        }

        if ($existing_product_key !== null) {
            $_SESSION['cart'][$existing_product_key]['quantite']++;
        } else {
            $quantity_column = 'QUANTITE_PRODUIT_' . $size;
            $quantity_available = $product[$quantity_column];
            $quantity_requested = 1;

            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $cart_product) {
                    if ($cart_product['product_id'] === $product_id && $cart_product['size'] === $size) {
                        $quantity_requested += $cart_product['quantite'];
                    }
                }
            }

            if ($quantity_requested > $quantity_available) {
                echo "Erreur: La quantité demandée pour le produit dépasse la quantité disponible en stock.";
                exit;
            }

            $_SESSION['cart'][] = array(
                'product_id' => $product_id,
                'size' => $size,
                'nom' => $product['NOM_PRODUIT'],
                'prix' => $product['PRIX_PRODUIT'],
                'quantite' => 1
            );
        }
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

    // echo "La quantité du produit a été mise à jour avec succès.";
    exit;
}


// ... Code précédent

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $panierVide = false; // Le panier n'est pas vide
    $quantiteDepasseStock = false; // La quantité dépasse-t-elle le stock ?
    foreach ($_SESSION['cart'] as $cart_product) {
        if (is_array($cart_product) && isset($cart_product['product_id'], $cart_product['size'], $cart_product['quantite'])) {
            $product_id = $cart_product['product_id'];
            $size = $cart_product['size'];
            $quantity_requested = $cart_product['quantite'];

            $sql = "SELECT QUANTITE_PRODUIT_" . $size . " AS quantity FROM produit WHERE ID_PRODUIT = :product_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result['quantity'] < $quantity_requested) {
                $quantiteDepasseStock = true; // La quantité dépasse le stock
            }

            echo "<div>";
            echo "<p>" . $cart_product['nom'] . " : " . $cart_product['prix'] . " EUR, Taille : " . $cart_product['size'] . ", Quantité : ";
            echo "<input type='number' min='1' value='" . $cart_product['quantite'] . "' onchange='changerQuantite(" . $cart_product['product_id'] . ", \"" . $cart_product['size'] . "\", this.value)'>";
            echo "<button class='deleteButton' onclick='supprimerDuPanier(" . $cart_product['product_id'] . ", \"" . $cart_product['size'] . "\")' type='button'>Supprimer</button></p>";
            echo "<hr>";
            echo "</div>";
        } else {
            echo "<p>Erreur: Format de produit invalide.</p>";
        }
    }

    // Afficher le bouton de validation
    echo "<p>Total : " . calculerTotalPanier() . " EUR</p>";
    if ($quantiteDepasseStock) {
        echo "<p>La quantité demandée pour un produit dépasse la quantité disponible en stock. Veuillez ajuster votre commande.</p>";
    } else {
        // Désactiver le bouton de validation si la quantité dépasse le stock
        if (isset($_SESSION['ID_USER'])) {
            echo '<form method="post" action="confirm_commande.php">
                    <input type="hidden" name="action" value="checkout">
                    <button class="valideButton" type="submit" ' . ($quantiteDepasseStock ? 'disabled' : '') . '>Valider la commande</button>
                  </form>';
        } else {
            echo '<a href="invite.php">Valider la commande en tant qu\'invité</a>';
        }
    }
} else {
    $panierVide = true; // Le panier est vide
    echo "<p>Votre panier est vide.</p>";
}

?>
