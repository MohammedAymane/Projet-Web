<?php

include "config-db.php";
// Create connection with mysql database using pdo surrended by try catch
try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `citation` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `Login` varchar(100) NOT NULL,
            `Content` varchar(1000) NOT NULL,
            `Auteur` varchar(100) NOT NULL,
            `Date_citation` date NOT NULL,
            `Date_enregistrement` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            KEY `Login` (`Login`)
            ) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;";

    $sql2 = "CREATE TABLE IF NOT EXISTS `user` (
            `username` varchar(100) NOT NULL,
            `mail` varchar(200) NOT NULL,
            `password` varchar(60) NOT NULL,
            PRIMARY KEY (`username`),
            UNIQUE KEY `mail` (`mail`)
            ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $req = $pdo->prepare($sql);
    $req->execute();
    $req = $pdo->prepare($sql2);
    $req->execute();
} catch (PDOException $e) {
    return "Connection failed: " . $e->getMessage();
}