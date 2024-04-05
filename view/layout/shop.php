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
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>

  <?php include_once("../../model/nav.user.php"); ?>

  </body>
</html>