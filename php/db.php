<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lostt";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "La connexion à la base de données a échoué: " . $e->getMessage();
}
?>