<?php
    include_once("./php/db.php");
    if(isset($_SESSION["PRENOM_USER"])){
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/form.css">
    <title>Connexion</title>
</head>
<body>
    <header>
        <a href="./index.html"><img class="logo" src="./asset/logo.png" alt="logo"></a>
        <nav>
            <ul class="navigation">
                <li><a href=".">Shop</a></li>
                <li><a href=".">About us</a></li>
                <li><a href="connexion.php">Connexion</a></li>
                <li><a href="register.php">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <main>
            <h2>Connectez-vous</h2> 
            <?php
            include_once "./php/log.inc.php";
            ?>       
            <form class="connexion" action="" method="post">
            <label for="email">Email:</label> <br>
            <input type="text" id="email" name="EMAIL_USER" required>
            <br>
            <label for="password">Mot de passe:</label> <br>
            <input type="password" id="password" name="MDP_USER" required> <br>
            <p class="pswForget"><a href=".">Mot de passe oublie ?</a></p>
            <br>
            <button  class="button" type="submit">Connexion</button>
        </form>

        

        <p>Vous n'avez pas de compte? <a href="./register.php">Inscrivez-vous ici</a></p>
        
    </main>

    <footer>
        <p>
            Lostt - 2024
        </p>
    </footer>
</body>
</html>