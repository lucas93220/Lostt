<?php
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

try {
    if (isset($_POST['submit'])) {
        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            $_SESSION['errors'][] = "Token CSRF invalide.";
            header("Location: register.php");
            exit;
        }
        error_reporting(E_ALL & ~E_WARNING);

        $nom = htmlspecialchars($_POST['NOM_USER']);
        $prenom = htmlspecialchars($_POST['PRENOM_USER']);
        $email = htmlspecialchars($_POST['EMAIL_USER']);
        $password = $_POST['MDP_USER'];
        $confirmPassword = $_POST['CONFIRM_USER'];
        $telephone = htmlspecialchars($_POST['TEL_USER']);
        $codePostal = htmlspecialchars($_POST['CP_USER']);
        $ville = htmlspecialchars($_POST['VILLE_USER']);
        $adresse = htmlspecialchars($_POST['ADRESSE_USER']);

        $_SESSION['errors'] = [];
        $_SESSION['success'] = "";

        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=localhost;dbname=lostt', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', $pdo_options));

        $sql = "SELECT * FROM user WHERE EMAIL_USER = :email";
        $result = $bdd->prepare($sql);
        $result->bindParam(':email', $email);
        $result->execute();

        if ($result->rowCount() > 0) {
            $_SESSION['errors'][] = "Cette adresse mail est déjà utilisée !!!";
        } else {
            if ($password !== $confirmPassword) {
                $_SESSION['errors'][] = "Les mots de passe ne correspondent pas.";
            } else {
                $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
                if (!preg_match($passwordPattern, $password)) {
                    $_SESSION['errors'][] = "Le mot de passe doit contenir au moins 8 caractères, dont au moins une minuscule, une majuscule, un chiffre et un caractère spécial.";
                } else {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    $sql = "INSERT INTO user (NOM_USER, PRENOM_USER, EMAIL_USER, MDP_USER, TEL_USER, CP_USER, VILLE_USER, ADRESSE_USER) VALUES (:nom, :prenom, :email, :password, :telephone, :codePostal, :ville, :adresse)";
                    $req = $bdd->prepare($sql);
                    $req->bindParam(':nom', $nom);
                    $req->bindParam(':prenom', $prenom);
                    $req->bindParam(':email', $email);
                    $req->bindParam(':password', $passwordHash);
                    $req->bindParam(':telephone', $telephone);
                    $req->bindParam(':codePostal', $codePostal);
                    $req->bindParam(':ville', $ville);
                    $req->bindParam(':adresse', $adresse);
                    $req->execute();

                    $_SESSION['success'] = "Inscription effectuée : <a href=\"view/connexion.php\" title=\"pub\">Connectez-vous</a>";
                }
            }
        }
        $result->closeCursor();
    }
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
