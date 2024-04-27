<?php
session_start();
if(isset($_GET['id'])) {
    $categorie_id = $_GET['id'];

    include_once('../controller/db.php'); 

    if ($conn) {
        $sql_categorie = "SELECT NOM_CATEGORIE FROM categorie WHERE ID_CATEGORIE = :categorie_id";
        $stmt_categorie = $conn->prepare($sql_categorie);
        $stmt_categorie->bindParam(':categorie_id', $categorie_id);
        $stmt_categorie->execute();
        $row_categorie = $stmt_categorie->fetch(PDO::FETCH_ASSOC);
        $nom_categorie = $row_categorie['NOM_CATEGORIE'];
    } else {
        echo "Erreur : La connexion à la base de données a échoué.";
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/reset.css"/>
<link rel="stylesheet" href="../public/css/nav.css"/>
<link rel="stylesheet" href="../public/css/shop.css"/>
    <script src="../public/js/app.js"></script>
                <script src="../public/js/op_panier.js"></script>
    <title><?php echo $nom_categorie; ?></title>
</head>
<body>
<?php include_once("../model/nav.php"); ?>

    <h1><?php echo $nom_categorie; ?></h1>
    <main class="container">
        <?php
        if ($conn) {
            $sql_articles = "SELECT * FROM produit WHERE ID_CATEGORIE = :categorie_id";
            $stmt_articles = $conn->prepare($sql_articles);
            $stmt_articles->bindParam(':categorie_id', $categorie_id);
            $stmt_articles->execute();
            
            while ($row_article = $stmt_articles->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="article">
                <h2><a href="details_produit.php?id=<?php echo $row_article['ID_PRODUIT']; ?>"></h2>
                    <img src="<?php echo $row_article['IMAGE_PRODUIT']; ?>" alt="<?php echo $row_article['NOM_PRODUIT']; ?>">
                    <p><?php echo $row_article['NOM_PRODUIT']; ?></p>
                    <p><?php echo $row_article['PRIX_PRODUIT']; ?> EUR</p>
                    <hr>
                </div></a>
                <?php
            }
        } else {
            echo "Impossible de récupérer les articles : La connexion à la base de données a échoué.";
        }
        ?>
    </main>
</body>
</html>

<?php
} else {
    echo "Erreur: Aucune catégorie sélectionnée.";
}
?>
