<?php
session_start();

// Génération du jeton CSRF
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

try {
    error_reporting(E_ALL & ~E_WARNING);

    if (isset($_POST['submit'])) {
        if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die("Token CSRF invalide.");
        }

        if (isset($_POST['EMAIL_USER'], $_POST['MDP_USER'])) {
            $email = htmlspecialchars($_POST['EMAIL_USER']);
            $password = $_POST['MDP_USER'];

            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $bdd = new PDO('mysql:host=localhost;dbname=lostt', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', $pdo_options));

            $sql = "SELECT * FROM user WHERE EMAIL_USER = :email";
            $result = $bdd->prepare($sql);
            $result->bindParam(':email', $email);
            $result->execute();

            if ($result->rowCount() > 0) {
                $data = $result->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $data['MDP_USER'])) {
                    echo "<p class=\"success\">Vous êtes bien connectés !</p>";

                    $_SESSION['ID_USER'] = $data['ID_USER'];
                    $_SESSION['EMAIL_USER'] = $email;
                    $_SESSION['NOM_USER'] = $data['NOM_USER'];
                    $_SESSION['PRENOM_USER'] = $data['PRENOM_USER'];

                    if ($data['ROLE_USER'] === 'admin') {
                        $_SESSION['ROLE'] = 'admin';
                        header("Location: home.php");
                        exit();
                    } else {
                        header("Location: account.php");
                        exit();
                    }
                } else {
                    echo "<p class=\"error\">Identifiants Invalides !!!</p>";
                }
            } else {
                echo "<p class=\"error\">Utilisateur non trouvé.</p>";
            }
        }
    }
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>