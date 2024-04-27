<?php
session_start();
include_once ('../controller/db.php');

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM produit WHERE ID_PRODUIT=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Article supprimé avec succès.";
    } else {
        $errorInfo = $conn->errorInfo();
        echo "Erreur : " . $errorInfo[2]; 
    }

} else {
    echo "ID non spécifié.";
}

header("Location: update.php");
exit();

?>
