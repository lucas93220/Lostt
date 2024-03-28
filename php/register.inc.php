<?php 

try{
    if(isset($_POST['submit'])){
        error_reporting(E_ALL & ~E_WARNING);
        $nom = $_POST['NOM_USER'];
        $prenom = $_POST['PRENOM_USER'];
        $email = $_POST['EMAIL_USER'];
        $password = $_POST['MDP_USER'];
        $telephone = $_POST['TEL_USER'];
        $codePostal = $_POST['CP_USER'];
        $ville      = $_POST['VILLE_USER'];
        $adresse    = $_POST['ADRESSE_USER'];

        // On se connecte à MySQL
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO('mysql:host=localhost;dbname=lostt', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',$pdo_options));
        
        // Verifie si l'utilisateur est déja inscrit
        $sql = "SELECT * FROM user WHERE EMAIL_USER = '$email' ";
        $result = $bdd->prepare($sql);
        $result->execute();

if ($result->rowCount() > 0) {
    $data = $result->fetch(PDO::FETCH_ASSOC); // Récupère la première ligne de résultat sous forme de tableau associatif

    if (password_verify($password, $data['MDP_USER'])) {
        echo "<p class=\"success\">Vous êtes déjà inscrit, <a href=\"connexion.php\" title=\"pub\">Connectez vous</a></p>";
        $_SESSION['EMAIL_USER'] = $email;   
    } else {   
        echo "<p class=\"error\">Cette adresse mail est déjà utilisée !!!</p>";
    }
}
        else
        {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (NOM_USER, PRENOM_USER, EMAIL_USER, MDP_USER, TEL_USER, CP_USER, VILLE_USER, ADRESSE_USER) VALUES ('$nom', '$prenom', '$email', '$password', '$telephone', '$codePostal', '$ville', '$adresse')";
            $req = $bdd->prepare($sql);
            $req->execute();
            echo "<p class=\"success\">Inscription effectuée :
                 <a href=\"connexion.php\" title=\"pub\">Connectez vous</a>
                 </p>";
        }
        $result->closeCursor();
    }}
    catch(Exception $e){
        die("Erreur de connexion : ".$e->getMessage());
    }


?>