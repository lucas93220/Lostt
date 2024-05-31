<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: ../view/connexion.php?logout=true");
exit();
?>
