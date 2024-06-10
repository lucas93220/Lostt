<?php
session_start();

include_once('../model/db.php');
include_once('calculPanier.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';
    $product_id = $_POST['product_id'] ?? '';
    $size = $_POST['size'] ?? '';
    
    if ($action === 'delete' && $product_id && $size) {
        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['product_id'] === $product_id && $product['size'] === $size) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                exit;
            }
        }
        echo "Erreur: Produit non trouvé dans le panier.";
    } elseif ($action === 'add' && $product_id && $size) {
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

                foreach ($_SESSION['cart'] as $cart_product) {
                    if ($cart_product['product_id'] === $product_id && $cart_product['size'] === $size) {
                        $quantity_requested += $cart_product['quantite'];
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
    } elseif ($action === 'update_quantity' && $product_id && $size && isset($_POST['quantity'])) {
        $new_quantity = (int)$_POST['quantity'];

        foreach ($_SESSION['cart'] as &$cart_product) {
            if ($cart_product['product_id'] === $product_id && $cart_product['size'] === $size) {
                $cart_product['quantite'] = $new_quantity;
                break;
            }
        }

        exit;
    }
}

if (!empty($_SESSION['cart'])) {
    $panierVide = false;
    $quantiteDepasseStock = false;
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
                $quantiteDepasseStock = true;
            }
            echo "<div>";
            echo "<p>" . htmlspecialchars($cart_product['nom']) . " : " . htmlspecialchars($cart_product['prix']) . " EUR, Taille : " . htmlspecialchars($cart_product['size']) . ", Quantité : ";
            echo "<input type='number' min='1' value='" . htmlspecialchars($cart_product['quantite']) . "' onchange='changerQuantite(" . htmlspecialchars($cart_product['product_id']) . ", \"" . htmlspecialchars($cart_product['size']) . "\", this.value)'>";
            echo "<button class='deleteButton' onclick='supprimerDuPanier(" . htmlspecialchars($cart_product['product_id']) . ", \"" . htmlspecialchars($cart_product['size']) . "\")' type='button'>Supprimer</button></p>";
            echo "<hr>";
            echo "</div>";
        } else {
            echo "<p>Erreur: Format de produit invalide.</p>";
        }
    }
    echo "<p>Total : " . calculerTotalPanier() . " EUR</p>";
    if ($quantiteDepasseStock) {
        echo "<p>La quantité demandée pour un produit dépasse la quantité disponible en stock. Veuillez ajuster votre commande.</p>";
    } else {
        if (isset($_SESSION['ID_USER'])) {
            echo '<form method="post" action="../view/confirmation.php">
                    <input type="hidden" name="action" value="checkout">
                    <button class="valideButton" type="submit" ' . ($quantiteDepasseStock ? 'disabled' : '') . '>Valider la commande</button>
                  </form>';
        } else {
            echo '<a href="invite.php">Valider la commande en tant qu\'invité</a>';
        }
    }
} else {
    $panierVide = true;
    echo "<p>Votre panier est vide.</p>";
}
?>
