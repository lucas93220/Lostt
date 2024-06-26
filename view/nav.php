<?php
include_once('../controller/get_categorie.php');
?>

<header>
    <a href="."><img class="logo" src="../public/asset/LOSTT.PNG" alt="LOSTT"></a>
    <nav>
        <ul class="navigation">
            <li>
                <a id="shop-link" href="shop.php">Shop</a>
                <ul class="sous-navigation">
                    <?php
                    foreach ($categories as $categorie) {
                        echo "<li><a href=\"categorie.php?id={$categorie['ID_CATEGORIE']}\">{$categorie['NOM_CATEGORIE']}</a></li>";
                    }
                    ?>
                </ul>
            </li>
            <li><a href="">About us</a></li>
            <?php
            if (isset($_SESSION["PRENOM_USER"])) {
                echo "<li><a href=\"account.php\">" . $_SESSION["PRENOM_USER"] . "</a></li>";
                echo "<li><a href=\"../controller/logout.php\">Déconnexion</a></li>";

                if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] === 'admin') {
                    include_once('nav.test.php');
                }
            } else {
                echo "<li><a href=\"connexion.php\">Connexion</a></li>";
                echo "<li><a href=\"register.php\">Créer un compte</a></li>";
            }
            ?>
            <li>
                <a id="panier-link" href="../controller/panier.php" class="active">Panier</a>
                <div id="panier-content" class="panier-content"></div>
            </li>
        </ul>
    </nav>
</header>