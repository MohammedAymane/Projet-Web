<?php

include "init.php";

//function to add a citation to the database
function addCitation($pdo, $auteur, $citation, $date, $login)
{
    $sql =
        "INSERT INTO citation(`Login`,`Content`,`Auteur`,`Date_citation`) VALUES (?,?,?,?)";
    $req = $pdo->prepare($sql);
    $nbResult = $req->execute([$login, $citation, $auteur, $date]);
}

//create function to read citations from database
function readCitations($pdo)
{
    $sql = "SELECT * FROM citation";
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->fetchAll();
    return $result;
}

//create function to get content of citation by login
function getCitationByLogin($pdo, $Id)
{
    $sql = "SELECT * FROM citation WHERE Id=?";
    $req = $pdo->prepare($sql);
    $req->execute([$Id]);
    $result = $req->fetchAll();
    return $result;
}

//create function to get citations of past 5 days
function getCitationsByDate($pdo)
{
    $sql =
        "SELECT * FROM citation WHERE Date_enregistrement > DATE_SUB(NOW(), INTERVAL 5 DAY)";
    $req = $pdo->prepare($sql);
    $req->execute();
    $result = $req->fetchAll();
    return $result;
}

//create function to add user to database
function addUser($pdo, $username, $password, $mail)
{
    $sql = "INSERT INTO user(`username`,`password`,`mail`) VALUES (?,?,?)";
    $req = $pdo->prepare($sql);
    $nbResult = $req->execute([$username, $password, $mail]);
}

//create a function to check if a user exists by username and password
function checkUser($pdo, $username, $password)
{
    $sql = "SELECT * FROM user WHERE username=?";
    $req = $pdo->prepare($sql);
    $req->execute([$username]);
    $result = $req->fetchAll();
    if (sizeOf($result) != 0) return password_verify($password, $result[0]["password"]);
    return false;
}