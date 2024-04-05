<?php
session_start();
include_once ('db.php');

$categories = array();

$sql = "SELECT * FROM categorie";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $categories[] = $row;
    }
} else {
    echo "Erreur lors de la récupération des catégories.";
}

// $conn = null;

return $categories;
?>
