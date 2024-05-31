<?php

if ($conn) {
    $sql = "SELECT *, (QUANTITE_PRODUIT_S + QUANTITE_PRODUIT_M + QUANTITE_PRODUIT_L + QUANTITE_PRODUIT_XL + QUANTITE_PRODUIT_XXL + QUANTITE_PRODUIT_U) AS STOCK FROM produit";
    $result = $conn->query($sql);

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="card">';
            if (isset($row['IMAGE_PRODUIT'])) {
                $imagePath = htmlspecialchars($row['IMAGE_PRODUIT']);
                echo '<img src="' . $imagePath . '" class="" alt="Image">';
            }
            echo '<div class="">';
            echo '<p>' . htmlspecialchars($row['NOM_PRODUIT']) . '</p>';
            echo '<p>' . htmlspecialchars($row['PRIX_PRODUIT']) . ' EUR</p>';
            echo '<p>Stock disponible: ' . htmlspecialchars($row['STOCK']) . '</p>';

            $editUrl = htmlspecialchars('edit_produit.php?id=' . $row['ID_PRODUIT']);
            $deleteUrl = htmlspecialchars('delete_produit.php?id=' . $row['ID_PRODUIT']);
            echo '<a href="' . $editUrl . '" class="editButton">Modifier </a>';
            echo '<a href="' . $deleteUrl . '" class="deleteButton">Supprimer</a>';
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
