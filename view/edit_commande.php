<?php
session_start();

// if (!isset($_SESSION['ID_USER'], $_SESSION['EMAIL_USER'], $_SESSION['NOM_USER'], $_SESSION['PRENOM_USER'], $_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
//     header("Location: ../login.php");
//     exit();
// }
include_once('../controller/db.php');

if (isset($_GET['action']) && $_GET['action'] === 'valider' && isset($_GET['commande_id'])) {
    $commandeId = $_GET['commande_id'];

    $sql = "UPDATE commande SET STATUT_COMMANDE = 'Validée' WHERE ID_COMMANDE = :commandeId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':commandeId', $commandeId);
    $stmt->execute();
    header("Location: home.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'annuler' && isset($_GET['commande_id'])) {
    $commandeId = $_GET['commande_id'];

    $sql = "UPDATE commande SET STATUT_COMMANDE = 'Annulée' WHERE ID_COMMANDE = :commandeId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':commandeId', $commandeId);
    $stmt->execute();
    header("Location: home.php"); 
    exit();
}

$sql = "SELECT * FROM commande";
$stmt = $conn->prepare($sql);
$stmt->execute();
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
