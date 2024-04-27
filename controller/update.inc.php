<?php

if ($conn) {
    $result = $conn->query("SELECT * FROM produit");

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="card">';
            if (isset($row['IMAGE_PRODUIT'])) {
                echo '<img src="' . $row['IMAGE_PRODUIT'] . '" class="" alt="Image">';
            }
            echo '<div class="">';
            echo '<p>'. $row['NOM_PRODUIT'] .'</p>';
            echo '<p>'. $row['PRIX_PRODUIT'] .' EUR</p>';
            echo '<p>Stock disponible: ' . $row['QUANTITE_PRODUIT'] .'</p>';

            echo '<a href="edit_produit.php?id=' . $row['ID_PRODUIT'] . '" class="editButton">Modifier </a>';
            echo '<a href="delete_produit.php?id=' . $row['ID_PRODUIT'] . '" class="deleteButton">Supprimer</a>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<div class="">';
        echo "<p>Aucun produit trouvé.</p>";
        echo '</div>';
    }

    $conn = null;
} else {
    echo "Erreur : Impossible de se connecter à la base de données.";
}
?>
