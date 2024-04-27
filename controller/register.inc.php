<?php
try {
    if (isset($_POST['submit'])) {
        error_reporting(E_ALL & ~E_WARNING);
        $nom = $_POST['NOM_USER'];
        $prenom = $_POST['PRENOM_USER'];
        $email = $_POST['EMAIL_USER'];
        $password = $_POST['MDP_USER'];
        $confirmPassword = $_POST['CONFIRM_USER'];
        $telephone = $_POST['TEL_USER'];
        $codePostal = $_POST['CP_USER'];
        $ville = $_POST['VILLE_USER'];
        $adresse = $_POST['ADRESSE_USER'];

        if ($password !== $confirmPassword) {
            echo "<p class=\"error\">Les mots de passe ne correspondent pas.</p>";
        } else {
            $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
            if (!preg_match($passwordPattern, $password)) {
                echo "<p class=\"error\">Le mot de passe doit contenir au moins 8 caractères, dont au moins une minuscule, une majuscule, un chiffre et un caractère spécial.</p>";
            } else {
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $bdd = new PDO('mysql:host=localhost;dbname=lostt', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', $pdo_options));

                $sql = "SELECT * FROM user WHERE EMAIL_USER = :email";
                $result = $bdd->prepare($sql);
                $result->bindParam(':email', $email);
                $result->execute();

                if ($result->rowCount() > 0) {
                    $data = $result->fetch(PDO::FETCH_ASSOC);

                    if (password_verify($password, $data['MDP_USER'])) {
                        echo "<p class=\"success\">Vous êtes déjà inscrit, <a href=\"./view/connexion.php\" title=\"pub\">Connectez-vous</a></p>";
                        $_SESSION['EMAIL_USER'] = $email;
                    } else {
                        echo "<p class=\"error\">Cette adresse mail est déjà utilisée !!!</p>";
                    }
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

                    echo "<p class=\"success\">Inscription effectuée : <a href=\"view/connexion.php\" title=\"pub\">Connectez-vous</a></p>";
                }
                $result->closeCursor();
            }
        }
    }
} catch (Exception $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
