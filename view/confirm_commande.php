<?php
session_start();
include_once('../controller/db.php');
include_once('../controller/calculPanier.php');

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'checkout') {
        
        $userID = $_SESSION['ID_USER'];  
        $userNom = $_SESSION['NOM_USER']; 
        $userPrenom = $_SESSION['PRENOM_USER']; 
        $userEmail = $_SESSION['EMAIL_USER']; 
        
        $prixTotal = calculerTotalPanier();

        $dateCommande = date('Y-m-d H:i:s');
        
        $statutCommande = 'En attente'; 
        
        $quantiteProduits = count($_SESSION['cart']); 

        foreach ($_SESSION['cart'] as $product) {
            $product_id = $product['product_id'];
            $size = $product['size'];
            $quantity_requested = $product['quantite'];

            $quantity_available_column = 'QUANTITE_PRODUIT_' . $size;
            $sql_check_quantity = "SELECT $quantity_available_column FROM produit WHERE ID_PRODUIT = :product_id";
            $stmt_check_quantity = $conn->prepare($sql_check_quantity);
            $stmt_check_quantity->bindParam(':product_id', $product_id);
            $stmt_check_quantity->execute();
            $result = $stmt_check_quantity->fetch(PDO::FETCH_ASSOC);
            $quantity_available = $result[$quantity_available_column];

            if ($quantity_requested > $quantity_available) {
                echo "Erreur : La quantité demandée pour le produit ID $product_id ($size) dépasse la quantité disponible en stock.";
                exit; 
            }
        }

        $sql = "INSERT INTO commande (ID_USER, DATE_COMMANDE, NOM_USER, PRENOM_USER, EMAIL_USER, STATUT_COMMANDE, QUANTITE_PRODUIT, PRIXTOTAL_COMMANDE) VALUES (:userID, :dateCommande, :userNom, :userPrenom, :userEmail, :statutCommande, :quantiteProduits, :prixTotal)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':dateCommande', $dateCommande);
        $stmt->bindParam(':userNom', $userNom);
        $stmt->bindParam(':userPrenom', $userPrenom);
        $stmt->bindParam(':userEmail', $userEmail);
        $stmt->bindParam(':statutCommande', $statutCommande);
        $stmt->bindParam(':quantiteProduits', $quantiteProduits);
        $stmt->bindParam(':prixTotal', $prixTotal);
        
        $stmt->execute();

        $total_quantity = 0;
        foreach ($_SESSION['cart'] as $product) {
            $total_quantity += $product['quantite'];
        }
        
        foreach ($_SESSION['cart'] as $product) {
            $product_id = $product['product_id'];
            $size = $product['size'];
            $quantity_requested = $product['quantite'];
        
            $quantity_column = 'QUANTITE_PRODUIT_' . $size;
            $quantity = $product['quantite'];
        
            $sql_get_current_quantity = "SELECT $quantity_column FROM produit WHERE ID_PRODUIT = :product_id";
            $stmt_get_current_quantity = $conn->prepare($sql_get_current_quantity);
            $stmt_get_current_quantity->bindParam(':product_id', $product_id);
            $stmt_get_current_quantity->execute();
            $current_quantity = $stmt_get_current_quantity->fetchColumn();
        
            $new_quantity = max(0, $current_quantity - $quantity_requested);
        
            $sql_update_quantity = "UPDATE produit SET $quantity_column = :new_quantity WHERE ID_PRODUIT = :product_id";
            $stmt_update_quantity = $conn->prepare($sql_update_quantity);
            $stmt_update_quantity->bindParam(':new_quantity', $new_quantity);
            $stmt_update_quantity->bindParam(':product_id', $product_id);
            $stmt_update_quantity->execute();
        }
        

        $sql_update_total_quantity = "UPDATE produit SET QUANTITE_PRODUIT = QUANTITE_PRODUIT - :total_quantity";
        $stmt_update_total_quantity = $conn->prepare($sql_update_total_quantity);
        $stmt_update_total_quantity->bindParam(':total_quantity', $total_quantity);
        $stmt_update_total_quantity->execute();

        unset($_SESSION['cart']);

        echo "La commande a été validée avec succès.";
    }
} else {
    echo "Erreur: Votre panier est vide.";
}
?>
