<?php

include "config.php";
// Create connection with mysql database using pdo surrended by try catch
try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nom` varchar(100) NOT NULL,
            `prenom` varchar(100) NOT NULL,
            `email` varchar(1000) NOT NULL,
            `telephone` varchar(100) NOT NULL UNIQUE,
            `password` varchar(1000) NOT NULL,
            `service` varchar(1000) NOT NULL,
            PRIMARY KEY (`id`),
            ) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;";
    $req = $pdo->prepare($sql);
    $req->execute();
} catch (PDOException $e) {
    return "Connection failed: " . $e->getMessage();
}