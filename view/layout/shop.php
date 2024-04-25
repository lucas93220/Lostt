<?php
session_start();
include_once("../../controller/db.php");
if(!isset($_SESSION["EMAIL_USER"])){
  header("Location: connexion.php");
  exit(); 
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="../../public/css/reset.css"/>
  <link rel="stylesheet" href="../../public/css/nav.css"/>

  <script src="../../public/js/app.js"></script>
  <script src="../../public/js/op_panier.js"></script>
</head>
<body>

<?php include_once("../../model/nav.user.php"); ?>
<h2>Shop</h2>
<div class="articles">
  <?php
  if ($conn) {
    $sql_articles = "SELECT * FROM produit";
    $stmt_articles = $conn->prepare($sql_articles);
    $stmt_articles->execute();
    
    while ($row_article = $stmt_articles->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="article">
        <h2><a href="details_produit.php?id=<?php echo $row_article['ID_PRODUIT']; ?>"><?php echo $row_article['NOM_PRODUIT']; ?></h2>
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
