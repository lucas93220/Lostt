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

            $uploadDirectory = __DIR__ . '/../uploads/';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $targetFile = $uploadDirectory . basename($image_name);

            if (move_uploaded_file($image_tmp_name, $targetFile)) {
                $image = $targetFile;

                $quantites = $_POST['quantite'];

                $quantite_totale = array_sum($quantites);

                $sql = "INSERT INTO produit (NOM_PRODUIT, PRIX_PRODUIT, IMAGE_PRODUIT, DESC_PRODUIT, ID_CATEGORIE, QUANTITE_PRODUIT_S, QUANTITE_PRODUIT_M, QUANTITE_PRODUIT_L, QUANTITE_PRODUIT_XL, QUANTITE_PRODUIT_XXL, QUANTITE_PRODUIT_U, QUANTITE_PRODUIT) 
                        VALUES (:nom, :prix, :image, :description, :categorie, :quantite_s, :quantite_m, :quantite_l, :quantite_xl, :quantite_xxl, :quantite_u, :quantite_totale)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prix', $prix);
                $stmt->bindParam(':image', $image);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':categorie', $categorie);
                $stmt->bindParam(':quantite_s', $quantites['S']);
                $stmt->bindParam(':quantite_m', $quantites['M']);
                $stmt->bindParam(':quantite_l', $quantites['L']);
                $stmt->bindParam(':quantite_xl', $quantites['XL']);
                $stmt->bindParam(':quantite_xxl', $quantites['XXL']);
                $stmt->bindParam(':quantite_u', $quantites['Unique']);
                $stmt->bindParam(':quantite_totale', $quantite_totale);

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
