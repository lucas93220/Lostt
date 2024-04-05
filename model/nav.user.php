<?php
include_once ('../../controller/get_categorie.php');
?>
<header>
<a href="../../index.php"><img class="logo" src="./asset/logo.png" alt="logo"></a>
<nav>
    <ul class="navigation">
        <li><a id="shop-link" href="../layout/shop.php">Shop</a>
        <ul class="sous-navigation">
                <?php
                foreach ($categories as $categorie) {
                    echo "<li><a href=\"categorie.php?id={$categorie['ID_CATEGORIE']}\">{$categorie['NOM_CATEGORIE']}</a></li>";
                }
                ?>
            </ul>
        </li>
        <li><a href=".">About us</a></li>
        <?php
        if(isset($_SESSION["PRENOM_USER"])) 
        {
            echo "<li><a href=\"#\">Bienvenue " . $_SESSION["PRENOM_USER"] . " !</a></li>";
            echo "<li><a href=\"../../logout.php\">Déconnexion</a></li>";
        } else 
        {
            echo "<li><a href=\"connexion.php\">Connexion</a></li>";
            echo "<li><a href=\"register.php\">Créer un compte</a></li>";
        }
        ?>
    </ul>
</nav>
</header>