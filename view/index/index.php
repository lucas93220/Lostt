<?php
  session_start();
  include_once ('./controller/db.php');
?>
<!DOCTYPE html>
<html>
  <head>
  <link rel="stylesheet" href="../../public/css/reset.css"/>
<link rel="stylesheet" href="../../public/css/nav.css"/>
    <script src="../../public/js/app.js" defer></script>

  </head>
  <body>

  <?php if(isset($_SESSION["EMAIL_USER"])) {
    if($_SESSION["ROLE_USER"] === "admin") {
        include_once("../../model/nav.admin.php");
    } else {
        include_once("../../model/nav.user.php");
    }
} else {
    include_once("../../model/nav.user.php");
}?>


  </body>
</html>
