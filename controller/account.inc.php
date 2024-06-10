<?php

    if (isset($_SESSION['ID_USER'])) {
      $userID = $_SESSION['ID_USER'];

      $sql = "SELECT * FROM commande WHERE ID_USER = :userID ORDER BY DATE_COMMANDE DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':userID', $userID);
      $stmt->execute();
      $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($commandes) {
        foreach ($commandes as $commande) {
          echo "<p>ID Commande : " . $commande['ID_COMMANDE'] . "</p>";
          echo "<p>Date de commande : " . $commande['DATE_COMMANDE'] . "</p>";
          echo "<p>Statut de la commande : " . $commande['STATUT_COMMANDE'] . "</p>";
          echo "<p>Quantité de produits : " . $commande['QUANTITE_PRODUIT'] . "</p>";
          echo "<p>Prix total : " . $commande['PRIXTOTAL_COMMANDE'] . " €</p>";
          echo "<hr>";
        }
      } else {
        echo "Vous n'avez effectué aucune commande.";
      }
    } else {
      echo "Erreur: Utilisateur non connecté.";
    }
    ?>