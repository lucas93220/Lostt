<?php
if(isset($_GET['id'])) {
    $categorie_id = $_GET['id'];

    include_once('../../controller/db.php'); 

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
    <title><?php echo $nom_categorie; ?></title>
</head>
<body>
<?php include_once("../../model/nav.user.php"); ?>

    <h2><?php echo $nom_categorie; ?></h2>
    <div class="articles">
        <?php
        if ($conn) {
            $sql_articles = "SELECT * FROM produit WHERE ID_CATEGORIE = :categorie_id";
            $stmt_articles = $conn->prepare($sql_articles);
            $stmt_articles->bindParam(':categorie_id', $categorie_id);
            $stmt_articles->execute();
            
            while ($row_article = $stmt_articles->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="article">
                    <h2><?php echo $row_article['NOM_PRODUIT']; ?></h2>
                    <img src="<?php echo $row_article['IMAGE_PRODUIT']; ?>" alt="<?php echo $row_article['NOM_PRODUIT']; ?>">
                    <p>Prix: <?php echo $row_article['PRIX_PRODUIT']; ?> €</p>
                    <p>Description: <?php echo $row_article['DESC_PRODUIT']; ?></p>
                </div>
                <?php
            }
        } else {
            echo "Impossible de récupérer les articles : La connexion à la base de données a échoué.";
        }
        ?>
    </div>
</body>
</html>

<?php
} else {
    echo "Erreur: Aucune catégorie sélectionnée.";
}
?>
