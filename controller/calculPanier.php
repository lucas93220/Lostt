
<?php
function calculerTotalPanier()
{
    $total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            $total += $product['prix'] * $product['quantite'];
        }
    }
    return $total;
}

?>