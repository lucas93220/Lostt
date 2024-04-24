<?php
    include_once("../../controller/db.php");
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
    <!-- <link rel="stylesheet" href="../../public/css/nav.css"> -->
    <link rel="stylesheet" href="../../public/css/reset.css">
    <script src="../../public/js/app.js"></script>
                <script src="../../public/js/op_panier.js"></script>
    <title>Connexion</title>
</head>
<body>
<?php include_once("../../model/nav.user.php"); ?>
    <main>
            <h2>Connectez-vous</h2> 
            <?php
            include_once "../../controller/log.inc.php";
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