<?php
session_start();
include_once ('../controller/db.php');

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM produit WHERE ID_PRODUIT = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Article supprimé avec succès.";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Erreur : " . $errorInfo[2]; 
    }
} else {
    echo "ID non spécifié.";
}

header("Location: update.php");
exit();


?>
