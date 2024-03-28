<?php
session_start();
?>

<nav>
    <ul class="navigation">
        <li><a href=".">Shop</a></li>
        <li><a href=".">About us</a></li>
        <?php
        if(isset($_SESSION["PRENOM_USER"])) 
        {
            echo "<li><a href=\"#\">Bienvenue " . $_SESSION["PRENOM_USER"] . " !</a></li>";
            echo "<li><a href=\"logout.php\">Déconnexion</a></li>";
        } else 
        {
            echo "<li><a href=\"connexion.php\">Connexion</a></li>";
            echo "<li><a href=\"register.php\">Créer un compte</a></li>";
        }
        ?>
    </ul>
</nav>
