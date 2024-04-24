<?php
session_start();

try {
    error_reporting(E_ALL & ~E_WARNING);
    $email = $_POST['EMAIL_USER'];
    $password = $_POST['MDP_USER'];
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $bdd = new PDO('mysql:host=localhost;dbname=lostt', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', $pdo_options));

    $sql = "SELECT * FROM user WHERE EMAIL_USER = '$email' ";
    $result = $bdd->prepare($sql);
    $result->execute();

    if (isset($_POST['EMAIL_USER']) && isset($_POST['MDP_USER'])) {
        $data = $result->fetch(PDO::FETCH_ASSOC);

        if ($result->rowCount() > 0 && password_verify($password, $data['MDP_USER'])) {
            echo "<p class=\"success\">Vous êtes bien connectés !</p>";
    
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['ID_USER'] = $data['ID_USER']; // Stocker l'ID_USER
            $_SESSION['EMAIL_USER'] = $email; // Stocker l'email de l'utilisateur
            $_SESSION['NOM_USER'] = $data['NOM_USER']; // Assurez-vous de définir NOM_USER correctement
            $_SESSION['PRENOM_USER'] = $data['PRENOM_USER'];
    
            // Redirection en fonction du rôle de l'utilisateur
            if ($data['ROLE_USER'] === 'admin') {
                $_SESSION["isAdmin"] = true;
                header("Location: ../admin/home.php");
            } else {
                $_SESSION["isAdmin"] = false;
                header("Location: ../layout/account.php");
            }
        } else {
            echo "<p class=\"error\">Identifiants Invalides !!!</p>";
        }
    }
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

?>
