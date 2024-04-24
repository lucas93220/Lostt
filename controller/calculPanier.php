
<?php
function calculerTotalPanier() {
    $total = 0;
    // Vérifier si $_SESSION['cart'] est défini et non vide
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total += $product['prix'] * $product['quantite'];
        }
    }
    return $total;
}

?>