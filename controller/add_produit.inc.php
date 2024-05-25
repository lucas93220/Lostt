<?php
include_once('db.php');
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$nom = $prix = '';
$image = '';
$description = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "<p class=\"error\">Token CSRF invalide.</p>";
        exit;
    }

    $nom = htmlspecialchars($_POST["nom"]);
    $prix = htmlspecialchars($_POST["prix"]);
    $description = htmlspecialchars($_POST["description"]);
    $categorie = htmlspecialchars($_POST["categorie"]);

    if (empty($nom) || empty($prix) || empty($description)) {
        echo "<p class=\"error\">Les champs désignation, tarif et description sont obligatoires.</p>";
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $image_name = $_FILES['image']['name'];
            $image_tmp_name = $_FILES['image']['tmp_name'];
            $image_type = $_FILES['image']['type'];
            $image_error = $_FILES['image']['error'];

            if (!in_array($image_type, $allowedMimeTypes)) {
                echo "<p class=\"error\">Type de fichier non supporté. Seuls les fichiers JPEG, PNG et GIF sont autorisés.</p>";
                exit;
            }

            $uploadDirectory = '../../uploads/';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }

            $targetFile = $uploadDirectory . uniqid() . '_' . basename($image_name);

            if (move_uploaded_file($image_tmp_name, $targetFile)) {
                $image = $targetFile;

                $quantites = $_POST['quantite'];
                $quantite_totale = array_sum($quantites);

                $sql = "INSERT INTO produit (NOM_PRODUIT, PRIX_PRODUIT, IMAGE_PRODUIT, DESC_PRODUIT, ID_CATEGORIE, QUANTITE_PRODUIT_S, QUANTITE_PRODUIT_M, QUANTITE_PRODUIT_L, QUANTITE_PRODUIT_XL, QUANTITE_PRODUIT_XXL, QUANTITE_PRODUIT_U) 
                VALUES (:nom, :prix, :image, :description, :categorie, :quantite_s, :quantite_m, :quantite_l, :quantite_xl, :quantite_xxl, :quantite_u)";

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

                if ($stmt->execute()) {
                    header("Location: update.php");
                } else {
                    echo "<p class=\"error\">Erreur : " . $stmt->errorInfo()[2] . "</p>";
                }
            } else {
                echo "<p class=\"error\">Erreur lors de l'upload de l'image : " . $image_error . "</p>";
            }
        } else {
            echo "<p class=\"error\">Veuillez sélectionner une image.</p>";
        }
    }
}
?>
