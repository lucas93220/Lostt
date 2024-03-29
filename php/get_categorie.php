<?php
include_once('./php/db.php');

$sql = "SELECT * FROM categorie";
$result = $conn->query($sql);

if ($result) {
    $rowCount = 0;
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo '<li><a href="#">' . $row['NOM_CATEGORIE'] . '</a></li>';
        $rowCount++;
    }
    
    if ($rowCount === 0) {
        echo "Aucune catégorie trouvée.";
    }
} else {
    echo "Erreur lors de la récupération des catégories.";
}

$conn = null;
?>
