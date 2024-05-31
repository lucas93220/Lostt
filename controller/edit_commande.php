<?php
session_start();

// if (!isset($_SESSION['ID_USER'], $_SESSION['EMAIL_USER'], $_SESSION['NOM_USER'], $_SESSION['PRENOM_USER'], $_SESSION['isAdmin']) || $_SESSION['isAdmin'] !== true) {
//     header("Location: home.php");
//     exit();
// }
include_once('../model/db.php');

// if (isset($_GET['action']) && $_GET['action'] === 'valider' && isset($_GET['commande_id'])) {
//     $commandeId = $_GET['commande_id'];

//     $sql = "UPDATE commande SET STATUT_COMMANDE = 'Validée' WHERE ID_COMMANDE = :commandeId";
//     $stmt = $conn->prepare($sql);
//     $stmt->bindParam(':commandeId', $commandeId);
//     $stmt->execute();
//     header("Location: home.php");
//     exit();
// }

if (isset($_GET['action']) && $_GET['action'] === 'annuler' && isset($_GET['commande_id'])) {
    $commandeId = $_GET['commande_id'];

    $sql = "UPDATE commande SET STATUT_COMMANDE = 'Annulée' WHERE ID_COMMANDE = :commandeId";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':commandeId', $commandeId);
    $stmt->execute();
    header("Location: home.php");
    exit();
}

$sql = "SELECT c.*, u.VILLE_USER, u.CP_USER, u.ADRESSE_USER 
        FROM commande c 
        INNER JOIN user u ON c.ID_USER = u.ID_USER 
        ORDER BY c.DATE_COMMANDE DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
