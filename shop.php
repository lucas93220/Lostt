<?php
  session_start();
  include_once("./php/db.php");
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

  <header>
        <a href="./index.html"><img class="logo" src="./asset/logo.png" alt="logo"></a>
        <?php include_once("./php/nav.php"); ?>
    </header>

  </body>
</html>