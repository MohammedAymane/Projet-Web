<?php
// create function to redirect to a page
function redirectIn()
{
    if ($_SESSION["loggedIn"]) {
        header("Location:index.php");
        die();
    }
}

// create function to redirect out
function redirectOut()
{
    if (!$_SESSION["loggedIn"]) {
        header("Location:login.php");
        die();
    }
}