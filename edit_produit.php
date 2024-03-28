<?php
include_once ('./php/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une produit</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Modifier un produit</h1>
    <?php
include_once ('./php/edit_produit.inc.php');
?>
    <form method="post" action="<?php echo isset($id) ? htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $id) : htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <div class="">
            <label for="design">Nom :</label>
            <input type="text" class="" id="nom" name="nom" value="<?php echo isset($row["NOM_PRODUIT"]) ? $row["NOM_PRODUIT"] : ''; ?>" required>
        </div>
        <div class="">
            <label for="tarif">Prix (en €) :</label>
            <input type="text" class="" id="prix" name="prix" value="<?php echo isset($row["PRIX_PRODUIT"]) ? $row["PRIX_PRODUIT"] : ''; ?>" required>
        </div>
        <div class="">
            <label for="description">Description :</label>
            <input type="text" class="" id="description" name="description" value="<?php echo isset($row["DESC_PRODUIT"]) ? $row["DESC_PRODUIT"] : ''; ?>" required>
        </div>
        <div class="">
            <label for="image">Image :</label>
            <?php if (isset($row['IMAGE_PRODUIT'])): ?>
                <img src="<?php echo $row['IMAGE_PRODUIT']; ?>" alt="Image" class="img">
            <?php endif; ?>
            <input type="file" class="" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary" name="<?php echo isset($_GET["action"]) && $_GET["action"] == "add" ? "add_produit" : (isset($_GET["action"]) && $_GET["action"] == "delete" ? "delete_produit" : "edit_produit"); ?>">
            <?php echo isset($_GET["action"]) && $_GET["action"] == "add" ? "Ajouter" : (isset($_GET["action"]) && $_GET["action"] == "delete" ? "Supprimer" : "Modifier"); ?>
        </button>
    </form>

    <br>
    <a href="update.php">Retour à la liste des produits</a>
</div>
</body>
</html>
