<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["name"]);
unset($_SESSION["loggedIn"]);
header("Location:login.php");
?>
