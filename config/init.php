<?php

include "config.php";
// Create connection with mysql database using pdo surrended by try catch
try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
    `Id` int(11) NOT NULL AUTO_INCREMENT,
    `role` enum('Administrateur','Employee') NOT NULL DEFAULT 'Employee',
    `firstName` varchar(60) NOT NULL,
    `lastName` varchar(60) NOT NULL,
    `email` varchar(100) NOT NULL,
    `phone` varchar(20) NOT NULL,
    `password` varchar(60) NOT NULL,
    `service` varchar(100) NOT NULL,
    PRIMARY KEY (`Id`),
    UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;";
    $req = $pdo->prepare($sql);
    $req->execute();
} catch (PDOException $e) {
    return "Connection failed: " . $e->getMessage();
}