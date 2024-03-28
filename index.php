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
  <?php include_once("./php/nav.php"); ?>
  </header>
    <div class="sucess">
       
      <h1>Bienvenue <?php echo $_SESSION['PRENOM_USER']; ?>!</h1>
      <p>C'est votre espace utilisateur.</p>
    </div>
  </body>
</html>
