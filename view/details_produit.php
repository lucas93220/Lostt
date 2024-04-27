<?php
    include_once("../controller/details.inc.php");
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/reset.css"/>
    <link rel="stylesheet" href="../public/css/nav.css"/>
    <link rel="stylesheet" href="../public/css/produit.css"/>
    <title><?php echo $row_produit['NOM_PRODUIT']; ?></title>
    <script src="../public/js/app.js"></script>
    <script src="../public/js/op_panier.js"></script>
</head>
<body>
    <?php include_once("../model/nav.php"); ?>
    <main>
    <img class="img-produit" src="<?php echo $row_produit['IMAGE_PRODUIT']; ?>" alt="<?php echo $row_produit['NOM_PRODUIT']; ?>">
    <aside>
    <h2><?php echo $row_produit['NOM_PRODUIT']; ?></h2>
    <p><?php echo $row_produit['PRIX_PRODUIT']; ?> EUR</p>
    <p><?php echo $row_produit['DESC_PRODUIT']; ?></p>
    <h3>Tailles:</h3>
    <div class="tailles-buttons">
        <?php foreach ($tailles_disponibles as $taille_produit) : ?>
            <?php foreach ($taille_produit as $key => $value) : ?>
                <?php if (strpos($key, 'QUANTITE_PRODUIT_') !== false && $value > 0) : ?>
                    <?php
                        $taille = str_replace('QUANTITE_PRODUIT_', '', $key);
                    ?>
                    <form onsubmit="addToCart(event, <?php echo $produit_id; ?>, '<?php echo $row_produit['NOM_PRODUIT']; ?>', <?php echo $row_produit['PRIX_PRODUIT']; ?>, '<?php echo $taille; ?>')">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="product_id" value="<?php echo $produit_id; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $row_produit['NOM_PRODUIT']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $row_produit['PRIX_PRODUIT']; ?>">
                        <input type="hidden" name="size" value="<?php echo $taille; ?>">
                        <button type="submit"><?php echo $taille; ?></button>
                    </form>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
    </aside>
    </main>
    <footer>
        <p>
            Lostt - 2024
        </p>
    </footer>
</body>
</html>
