<?php
include_once('../model/db.php');
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $result = $conn->prepare("SELECT p.*, c.NOM_CATEGORIE FROM produit p JOIN categorie c ON p.ID_CATEGORIE = c.ID_CATEGORIE WHERE ID_PRODUIT = ?");
    $result->execute([$id]);

    if ($result->rowCount() == 1) {
        $row = $result->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
                echo "<p class=\"error\">Token CSRF invalide.</p>";
                exit;
            }

            $nom = htmlspecialchars($_POST["nom"]);
            $prix = htmlspecialchars($_POST["prix"]);
            $description = htmlspecialchars($_POST["description"]);
            $categorie = intval($_POST['categorie']);
            $quantites = array_map('intval', $_POST['quantite']);

            $quantite_total = array_sum($quantites);
            $errorMessage = '';

            try {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image_name = $_FILES['image']['name'];
                    $image_tmp_name = $_FILES['image']['tmp_name'];

                    $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    $fileType = mime_content_type($image_tmp_name);

                    if (in_array($fileType, $allowedFileTypes)) {
                        $uploadDirectory = '../../uploads/';
                        if (!is_dir($uploadDirectory)) {
                            mkdir($uploadDirectory, 0777, true);
                        }

                        $targetFile = $uploadDirectory . uniqid() . '_' . basename($image_name);

                        if (move_uploaded_file($image_tmp_name, $targetFile)) {
                            $sql = "UPDATE produit SET NOM_PRODUIT=?, PRIX_PRODUIT=?, IMAGE_PRODUIT=?, DESC_PRODUIT=?, ID_CATEGORIE=?, QUANTITE_PRODUIT_S=?, QUANTITE_PRODUIT_M=?, QUANTITE_PRODUIT_L=?, QUANTITE_PRODUIT_XL=?, QUANTITE_PRODUIT_XXL=?, QUANTITE_PRODUIT_U=? WHERE ID_PRODUIT=?";
                            $stmt = $conn->prepare($sql);
                            if ($stmt->execute([$nom, $prix, $targetFile, $description, $categorie, $quantites['S'], $quantites['M'], $quantites['L'], $quantites['XL'], $quantites['XXL'], $quantites['Unique'], $id])) {
                                $_SESSION['success_message'] = "Produit mis à jour avec succès.";
                                header("Location: update.php");
                                exit();
                            } else {
                                $errorMessage = "Erreur lors de la mise à jour du produit.";
                            }
                        } else {
                            $errorMessage = "Erreur lors de l'upload de l'image.";
                        }
                    } else {
                        $errorMessage = "Type de fichier non autorisé.";
                    }
                } else {
                    $sql = "UPDATE produit SET NOM_PRODUIT=?, PRIX_PRODUIT=?, DESC_PRODUIT=?, ID_CATEGORIE=?, QUANTITE_PRODUIT_S=?, QUANTITE_PRODUIT_M=?, QUANTITE_PRODUIT_L=?, QUANTITE_PRODUIT_XL=?, QUANTITE_PRODUIT_XXL=?, QUANTITE_PRODUIT_U=? WHERE ID_PRODUIT=?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt->execute([$nom, $prix, $description, $categorie, $quantites['S'], $quantites['M'], $quantites['L'], $quantites['XL'], $quantites['XXL'], $quantites['Unique'], $id])) {
                        $_SESSION['success_message'] = "Produit mis à jour avec succès.";
                        header("Location: update.php");
                        exit();
                    } else {
                        $errorMessage = "Erreur lors de la mise à jour du produit.";
                    }
                }
            } catch (PDOException $e) {
                $errorMessage = "Erreur PDO : " . $e->getMessage();
            }

            if ($errorMessage) {
                $_SESSION['error_message'] = $errorMessage;
                header("Location: edit_produit.php?id=$id");
                exit();
            }
        }
    } else {
        $_SESSION['error_message'] = "Aucun produit trouvé avec cet ID.";
        header("Location: update.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "ID non spécifié.";
    header("Location: update.php");
    exit();
}
