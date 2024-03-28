<?php
  session_start();
  include_once("../php/db.php");
  if(!isset($_SESSION["EMAIL_USER"])){
    header("Location: connexion.php");
    exit(); 
  }
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="../style.css" />
  </head>
  <body>

  <header>
        <a href="./index.html"><img class="logo" src="./asset/logo.png" alt="logo"></a>
        <nav>
            <ul class="navigation">
                <li><a href=".">Shop</a></li>
                <li><a href=".">About us</a></li>
                <li><a href=".">Modifier</a></li>
                <li><a href="../logout.php">Deconnexion</a></li>
            </ul>
        </nav>
    </header>
    <div class="sucess">
    <h1>Bienvenue <?php echo $_SESSION['PRENOM_USER']; ?>!</h1>
    <p>C'est votre espace admin.</p>
    </div>
  </body>
</html>
