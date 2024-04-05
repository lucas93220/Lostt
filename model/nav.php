<header>
<a href="./index.php"><img class="logo" src="./asset/logo.png" alt="logo"></a>
<nav>
    <ul class="navigation">
        <li><a id="shop-link" href="shop.php">Shop</a>
        <ul class="sous-navigation">
                <?php
                foreach ($categories as $categorie) {
                    echo "<li><a href=\"categorie.php?id={$categorie['ID_CATEGORIE']}\">{$categorie['NOM_CATEGORIE']}</a></li>";
                }
                ?>
            </ul>
        </li>
        <?php if(isset($_SESSION["PRENOM_USER"])) : ?>
            <?php if(isset ($_SESSION["isAdmin"]) && $_SESSION["isAdmin"] === true) : ?>
                <li><a href="#">Bienvenue <?php echo $_SESSION["PRENOM_USER"]; ?></a></li>
                <li><a href="../admin/update.php">Modifier</a></li>
            <?php else: ?>
                <li><a href=".">About us</a></li>
                <li><a href="#">Bienvenue <?php echo $_SESSION["PRENOM_USER"]; ?></a></li>
            <?php endif; ?>
            <li><a href="logout.php">Déconnexion</a></li>
        <?php else : ?>
            <li><a href="connexion.php">Connexion</a></li>
            <li><a href="register.php">Créer un compte</a></li>
        <?php endif; ?>
    
    </ul>
</nav>

<nav id="category-nav" style="display: none;">
    <ul class="category-navigation">
        <?php include_once('C:\xampp\htdocs\classroom_php_2223\Projet Pro\controller\get_categorie.php'); ?>
    </ul>
    <script src="./js/app.js"></script>
</nav>
</header>