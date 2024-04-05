<?php
include_once('db.php');

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

            // Assurez-vous que le répertoire "uploads" existe et a les bonnes permissions
            $uploadDirectory = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Crée le répertoire s'il n'existe pas
            }

            // Utilisez un chemin absolu pour le répertoire "uploads"
            $targetFile = $uploadDirectory . basename($image_name);

            // Déplacez le fichier téléchargé vers le répertoire "uploads"
            if (move_uploaded_file($image_tmp_name, $targetFile)) {
                // Le fichier a été téléchargé avec succès, vous pouvez l'utiliser dans votre base de données
                $image = $targetFile;

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
            } else {
                echo "Erreur lors de l'upload de l'image : " . $_FILES['image']['error'];
            }
        } else {
            echo "Veuillez sélectionner une image.";
        }
    }
}
?>
