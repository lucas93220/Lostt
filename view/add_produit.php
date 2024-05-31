<?php
session_start();
include_once("../controller/add_produit.inc.php");

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ce site est dedie a la vente de vetements">
    <title>Lostt</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../public/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../public/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../public/favicon/favicon-16x16.png">
    <link rel="manifest" href="..public/favicon/site.webmanifest">
    <link rel="stylesheet" href="../public/css/reset.css" />
    <link rel="stylesheet" href="../public/css/nav.css" />
    <link rel="stylesheet" href="../public/css/edit.css" />

    <script src="../public/js/app.js"></script>
    <script src="../public/js/op_panier.js"></script>
</head>

<body>
    <?php include_once("nav.php"); ?>

    <h1>Ajouter un produit</h1>
    <div class="container">

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="">
                <input placeholder="Nom" type="text" class="" id="nom" name="nom" value="<?php echo $nom; ?>" required>
            </div>

            <div class="">
                <select placeholder="Catégorie" id="categorie" name="categorie" required>
                    <option value="">Catégorie</option>
                    <?php
                    $result_categories = $conn->query("SELECT * FROM categorie");
                    if ($result_categories->rowCount() > 0) {
                        while ($row_category = $result_categories->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($row["ID_CATEGORIE"] == $row_category["ID_CATEGORIE"]) ? "selected" : "";
                            echo '<option value="' . $row_category['ID_CATEGORIE'] . '" ' . $selected . '>' . $row_category['NOM_CATEGORIE'] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            <div>
                <input placeholder="Prix" type="text" class="" id="prix" name="prix" value="<?php echo $prix; ?>" required>
            </div>
            <div>
                <input placeholder="Description" type="text" class="" id="description" name="description" value="<?php echo $description; ?>" required>
            </div>
            <div>
                <input type="file" class="img-produit" id="image" name="image" value="<?php echo $image; ?>" required>
            </div>
            <div>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            </div>

            <div class="form-group">
                <label for="quantite-s">Quantité disponible (S):</label>
                <input type="number" class="form-control" id="quantite-s" name="quantite[S]" value="0" min="0">
            </div>
            <div class="form-group">
                <label for="quantite-m">Quantité disponible (M):</label>
                <input type="number" class="form-control" id="quantite-m" name="quantite[M]" value="0" min="0">
            </div>
            <div class="form-group">
                <label for="quantite-l">Quantité disponible (L):</label>
                <input type="number" class="form-control" id="quantite-l" name="quantite[L]" value="0" min="0">
            </div>
            <div class="form-group">
                <label for="quantite-xl">Quantité disponible (XL):</label>
                <input type="number" class="form-control" id="quantite-xl" name="quantite[XL]" value="0" min="0">
            </div>
            <div class="form-group">
                <label for="quantite-xxl">Quantité disponible (XXL):</label>
                <input type="number" class="form-control" id="quantite-xxl" name="quantite[XXL]" value="0" min="0">
            </div>
            <div class="form-group">
                <label for="quantite-unique">Quantité disponible (Unique):</label>
                <input type="number" class="form-control" id="quantite-unique" name="quantite[Unique]" value="0" min="0">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

        <br>
        <a href="update.php">Retour à la liste des produits</a>
    </div>
</body>

</html>