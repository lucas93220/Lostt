<?php
  session_start();
  include_once("../../controller/db.php");
  if (!isset($_SESSION["PRENOM_USER"])) {
    header("Location: ../layout/connexion.php");
    exit();

  }
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="../style.css" />
  </head>
  <body>
    <?php include_once("../../model/nav.admin.php"); ?>

    <div class="sucess">
    <h1>Bienvenue <?php echo $_SESSION['PRENOM_USER']; ?>!</h1>
    <p>C'est votre espace admin.</p>
    </div>
  </body>
</html>
