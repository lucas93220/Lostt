<?php
include_once('db.php');

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $result = $conn->prepare("SELECT p.*, c.NOM_CATEGORIE FROM produit p JOIN categorie c ON p.ID_CATEGORIE = c.ID_CATEGORIE WHERE ID_PRODUIT = ?");
    $result->execute([$id]);

    if ($result->rowCount() == 1) {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = $_POST["nom"];
            $prix = $_POST["prix"];
            $description = $_POST["description"];
            $categorie = $_POST['categorie'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_name = $_FILES['image']['name'];
                $image_tmp_name = $_FILES['image']['tmp_name'];

                // Assurez-vous que le répertoire "uploads" existe
                $uploadDirectory = __DIR__ . '/../uploads/';
                if (!is_dir($uploadDirectory)) {
                    mkdir($uploadDirectory, 0777, true); // Crée le répertoire s'il n'existe pas
                }

                // Générez un nom de fichier unique pour éviter les conflits
                $targetFile = $uploadDirectory . uniqid() . '_' . basename($image_name);

                if (move_uploaded_file($image_tmp_name, $targetFile)) {
                    $sql = "UPDATE produit SET NOM_PRODUIT=?, PRIX_PRODUIT=?, IMAGE_PRODUIT=?, DESC_PRODUIT=? WHERE ID_PRODUIT=?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute([$nom, $prix, $targetFile, $description, $id])) {
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
                $sql = "UPDATE produit SET NOM_PRODUIT=?, PRIX_PRODUIT=?, DESC_PRODUIT=?, ID_CATEGORIE=? WHERE ID_PRODUIT=?";
                $stmt = $conn->prepare($sql);
                if ($stmt->execute([$nom, $prix, $description, $categorie, $id])) {
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
