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

        foreach ($_SESSION['cart'] as $product) {
            $product_id = $product['product_id'];
            $size = $product['size'];
            $quantity_requested = $product['quantite'];
        
            $quantity_column = 'QUANTITE_PRODUIT_' . $size;
            
            $sql_update_quantity = "UPDATE produit SET $quantity_column = $quantity_column - :quantity WHERE ID_PRODUIT = :product_id";
            $stmt_update_quantity = $conn->prepare($sql_update_quantity);
            $stmt_update_quantity->bindParam(':quantity', $quantity_requested);
            $stmt_update_quantity->bindParam(':product_id', $product_id);
            $stmt_update_quantity->execute();
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
        
        unset($_SESSION['cart']);

        echo "La commande a été validée avec succès.";
    }
} else {
    echo "Erreur: Votre panier est vide.";
}

?>
