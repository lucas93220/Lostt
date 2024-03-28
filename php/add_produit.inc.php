<?php
    include_once('./php/db.php');

$nom = $prix = '';
$image = '';
$description = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $prix = htmlspecialchars($_POST["prix"]);
    $description = htmlspecialchars($_POST["description"]);


    // Validation des champs
    if (empty($nom) || empty($prix) || empty($description)) {
        echo "Les champs désignation et tarif sont obligatoires.";
    } else {
        // Upload de l'image
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_type = $_FILES['image']['type'];

            // Déplacement du fichier téléchargé vers un emplacement temporaire sur le serveur
            $upload_directory = 'uploads/';
            $target_file = $upload_directory . basename($image_name);
            if (move_uploaded_file($image_tmp_name, $target_file)) {
                $image = $target_file;
            } else {
                echo "Erreur lors de l'upload de l'image.";
            }
        }

        // Insertion des données dans la base de données
        $sql = "INSERT INTO produit (NOM_PRODUIT, PRIX_PRODUIT, IMAGE_PRODUIT, DESC_PRODUIT) VALUES ('$nom', '$prix', '$image', '$description')";
        $result = $conn->query($sql);
        if ($result === false) {
            $errorInfo = $conn->errorInfo();
            echo "Erreur : " . $errorInfo[2]; // Affiche le message d'erreur
        } else {
            echo "Article ajouté avec succès.";
        }
        

        $conn = null;
    }
}
?>