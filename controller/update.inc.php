<?php

if ($conn) {
    $result = $conn->query("SELECT * FROM produit");

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="">';
            echo '<div class="">';
            if (isset($row['IMAGE_PRODUIT'])) {
                echo '<img src="' . $row['IMAGE_PRODUIT'] . '" class="" alt="Image">';
            }
            echo '<div class="">';
            echo '<h5 class="">' . $row['NOM_PRODUIT'] . '</h5>';
            echo '<p class="">Tarif : ' . $row['PRIX_PRODUIT'] . ' €</p>';
            echo '<p class="">Description : ' . $row['DESC_PRODUIT'] . '</p>';
            echo '<a href="../admin/edit_produit.php?id=' . $row['ID_PRODUIT'] . '" class="btn btn-primary btn-sm m-1 btn-margin">Modifier</a>';
            echo '<a href="../admin/delete_produit.php?id=' . $row['ID_PRODUIT'] . '" class="btn btn-danger btn-sm m-1 btn-margin">Supprimer</a>';
            echo '</div>';
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
