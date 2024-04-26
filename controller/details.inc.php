<?php
session_start();
include_once('db.php');

if(isset($_GET['id'])) {
    $produit_id = $_GET['id'];

    if ($conn) {
        $sql_produit = "SELECT * FROM produit WHERE ID_PRODUIT = :produit_id";
        $stmt_produit = $conn->prepare($sql_produit);
        $stmt_produit->bindParam(':produit_id', $produit_id);
        $stmt_produit->execute();
        
        if ($row_produit = $stmt_produit->fetch(PDO::FETCH_ASSOC)) {
            
            $sql_tailles = "SELECT * FROM produit WHERE ID_PRODUIT = :produit_id AND (QUANTITE_PRODUIT_S > 0 OR QUANTITE_PRODUIT_M > 0 OR QUANTITE_PRODUIT_L > 0 OR QUANTITE_PRODUIT_XL > 0 OR QUANTITE_PRODUIT_XXL > 0 OR QUANTITE_PRODUIT_U > 0)";
            $stmt_tailles = $conn->prepare($sql_tailles);
            $stmt_tailles->bindParam(':produit_id', $produit_id);
            $stmt_tailles->execute();
            $tailles_disponibles = $stmt_tailles->fetchAll(PDO::FETCH_ASSOC);
            
            include_once('details_produit.php');
        } else {
            echo "Aucun produit trouvé avec cet identifiant.";
        }
    } else {
        echo "Erreur: La connexion à la base de données a échoué.";
    }
} else {
    echo "Erreur: Aucun identifiant de produit spécifié.";
}
?>
