<?php
session_start();
// create function to redirect to a page
function redirectIn()
{
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"]) {
        header("Location:index.php");
        die();
    }
}

// create function to redirect out
function redirectOut()
{
    if (!isset($_SESSION["loggedIn"]) || !$_SESSION["loggedIn"]) {
        header("Location:login.php");
        die();
    }
}

function redirectNoneAdmin()
{
    if (!isset($_SESSION["role"]) || $_SESSION["role"] != "Administrateur") {
        header("Location:listeMissions.php");
        die();
    }
}