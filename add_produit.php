<?php include_once("./php/add_produit.inc.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un produit</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-4">Ajouter un produit</h1>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="">
                <label for="nom">Nom du produit</label>
                <input type="text" class="" id="nom" name="nom" value="<?php echo $nom; ?>" required>
            </div>
            <div class="">
                <label for="tarif">Tarif (en €):</label>
                <input type="text" class="" id="prix" name="prix" value="<?php echo $prix; ?>" required>
            </div>
            <div class="">
                <label for="tarif">Description:</label>
                <input type="text" class="" id="description" name="description" value="<?php echo $description; ?>" required>
            </div>
            <div class="">
                <label for="image">Image du produit:</label>
                <input type="file" class="" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

        <br>
        <a href="update.php">Retour à la liste des produits</a>
    </div>
</body>

</html>
