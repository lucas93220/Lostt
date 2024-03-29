<?php
include_once('./php/db.php');

$nom = $prix = '';
$image = '';
$description = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prix = htmlspecialchars($_POST["prix"]);
    $description = htmlspecialchars($_POST["description"]);
    $categorie = $_POST["categorie"];

    if (empty($nom) || empty($prix) || empty($description)) {
        echo "Les champs désignation, tarif et description sont obligatoires.";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_type = $_FILES['image']['type'];

            $upload_directory = 'uploads/';
            $target_file = $upload_directory . basename($image_name);
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                $image = $target_file;
            } else {
                echo "Erreur lors de l'upload de l'image.";
            }
        }

        $sql = "INSERT INTO produit (NOM_PRODUIT, PRIX_PRODUIT, IMAGE_PRODUIT, DESC_PRODUIT, ID_CATEGORIE) 
                VALUES (:nom, :prix, :image, :description, :categorie)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':categorie', $categorie);

        if ($stmt->execute()) {
            echo "Article ajouté avec succès.";
        } else {
            echo "Erreur : " . $stmt->errorInfo()[2];
        }
    }
}
?>
