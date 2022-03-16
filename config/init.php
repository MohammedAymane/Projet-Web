<?php

include "config.php";
// Create connection with mysql database using pdo surrended by try catch

echo "begin";
try {
    $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "DROP TABLE IF EXISTS `missions`;
CREATE TABLE IF NOT EXISTS `missions` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `lieu` varchar(100) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `devise` enum('dollars','euro','yen','yuan') NOT NULL,
  `description` varchar(200) NOT NULL,
  `etat` enum('enCours','finis','annulee','supprimee') NOT NULL,
  `solde_initial` float NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_missions` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
DROP TABLE IF EXISTS `nomenclature`;
CREATE TABLE IF NOT EXISTS `nomenclature` (
  `id` varchar(60) NOT NULL,
  `parent` varchar(60) NOT NULL,
  `text` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_nomenclature` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
DROP TABLE IF EXISTS `operations`;
CREATE TABLE IF NOT EXISTS `operations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `id_nomenclature` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `montant` float NOT NULL,
  `id_mission` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_operations` (`id_mission`),
  KEY `FK_nommenclature` (`id_nomenclature`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `role` enum('Administrateur','Employee') NOT NULL DEFAULT 'Employee',
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `service` enum('Marketing','RH','R&D','Commercial','Administration') NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
";
    $req = $pdo->prepare($sql);
    $req->execute();
    echo "Base de donnée créée avec succès";
} catch (PDOException $e) {
    return "Connection failed: " . $e->getMessage();
}