<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: ./view/layout/connexion.php?logout=true");
exit();
?>
