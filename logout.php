<?php

// OUGGADI Mohammed Aymane

session_start();
unset($_SESSION["loggedIn"]);
unset($_SESSION["token"]);
unset($_SESSION["id"]);
unset($_SESSION["firstname"]);
unset($_SESSION["lastname"]);
unset($_SESSION["role"]);

header("Location:login.php");