<?php
setcookie("username", "", time() - 3600, "/admin/");
header("location: login.php");
?>
