<?php
include_once('./php/db.php'); 

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $result = $conn->query("SELECT p.*, c.NOM_CATEGORIE FROM produit p JOIN categorie c ON p.ID_CATEGORIE = c.ID_CATEGORIE WHERE ID_PRODUIT = $id");

    if ($result->rowCount() == 1) {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = $_POST["nom"];
            $prix = $_POST["prix"];
            $description = $_POST["description"];
            $categorie = $_POST['categorie'];

            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_name = $_FILES['image']['name'];
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_type = $_FILES['image']['type'];

                $upload_directory = 'uploads/';
                $target_file = $upload_directory . basename($image_name);
                if (move_uploaded_file($image_tmp_name, $target_file)) {
                    $sql = "UPDATE produit SET NOM_PRODUIT='$nom', PRIX_PRODUIT='$prix', IMAGE_PRODUIT='$target_file', DESC_PRODUIT='$description' WHERE ID_PRODUIT=$id";

                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute()) {
                        echo "Produit mis à jour avec succès.";
                        header("Location: update.php");
                        exit();
                    } else {
                        echo "Erreur lors de la mise à jour du produit.";
                    }
                } else {
                    echo "Erreur lors de l'upload de l'image.";
                }
            } else {
                $sql = "UPDATE produit SET NOM_PRODUIT='$nom', PRIX_PRODUIT='$prix', DESC_PRODUIT='$description', ID_CATEGORIE='$categorie' WHERE ID_PRODUIT=$id";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute()) {
                    echo "Produit mis à jour avec succès.";
                    header("Location: update.php");
                    exit();
                } else {
                    echo "Erreur lors de la mise à jour du produit.";
                }
            }
        }
    } else {
        echo "Aucun produit trouvé avec cet ID.";
    }

} else {
    echo "ID non spécifié.";
}
?>
