<?php 
session_start();
include_once("../../controller/add_produit.inc.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../public/js/app.js" defer></script>

</head>

    <?php include_once("../../model/nav.admin.php"); ?>
<body>
    <div class="container">
        <h1 class="mt-4">Ajouter un produit</h1>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="">
                <label for="nom">Nom du produit</label>
                <input type="text" class="" id="nom" name="nom" value="<?php echo $nom; ?>" required>
            </div>

            <div class="">
    <label for="categorie">Catégorie :</label>
    <select class="" id="categorie" name="categorie" required>
        <option value="">Sélectionnez une catégorie</option>
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

            <div class="">
                <label for="tarif">Tarif (en €):</label>
                <input type="text" class="" id="prix" name="prix" value="<?php echo $prix; ?>" required>
            </div>
            <div class="">
                <label for="description">Description:</label>
                <input type="text" class="" id="description" name="description" value="<?php echo $description; ?>" required>
            </div>
            <div class="">
                <label for="image">Image du produit:</label>
                <input type="file" class="" id="image" name="image" value="<?php echo $image; ?>" required>
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
