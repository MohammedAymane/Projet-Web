<?php

include "config.php";
// Create connection with mysql database using pdo surrended by try catch

echo "begin";
try {
  $pdo = new PDO("mysql:host=$server;dbname=$dbname", $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DROP TABLE IF EXISTS `devise`;
CREATE TABLE IF NOT EXISTS `devise` (
  `nom` enum('dollars','euro','yen','yuan') NOT NULL,
  `symbole` varchar(10) NOT NULL,
  `taux_change` float NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `devise` (`nom`, `symbole`, `taux_change`) VALUES
('dollars', '$', 0.9),
('euro', '€', 1),
('yen', '¥', 0.0076),
('yuan', '¥', 0.14);
DROP TABLE IF EXISTS `missions`;
CREATE TABLE IF NOT EXISTS `missions` (
  `Id` varchar(60) NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `devise` enum('dollars','euro','yen','yuan') NOT NULL,
  `description` varchar(200) NOT NULL,
  `etat` enum('en ours','finis','annulee','supprimee') NOT NULL,
  `solde_initial` float NOT NULL,
  `user_id` varchar(60) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FK_missions` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `missions` (`Id`, `lieu`, `debut`, `fin`, `devise`, `description`, `etat`, `solde_initial`, `user_id`) VALUES
('1', 'E', '2022-03-02', '2022-03-11', 'dollars', 'r', 'en cours', 5, '3'),
('2', 'rr', '2022-03-01', '2022-03-03', 'dollars', 't', 'finis', 9, '3'),
('23432', 't', '2022-03-02', '2022-03-11', 'dollars', 'hs', 'en cours', 9, '3'),
('mission-6236fd8382f3e9.99849820', 'tt', '2022-03-15', '2022-03-28', 'euro', 'tt', 'en cours', 9, '5'),
('mission-6236fdd0c94ed9.89201354', 'ttty', '2022-03-14', '2022-03-29', 'dollars', 're', 'en cours', 12, '5'),
('mission-6236fdee004306.36321370', 'ttty', '2022-03-14', '2022-03-29', 'dollars', 're', 'en cours', 12, '5');
DROP TABLE IF EXISTS `nomenclature`;
CREATE TABLE IF NOT EXISTS `nomenclature` (
  `id` varchar(60) NOT NULL,
  `parent` varchar(60) NOT NULL,
  `text` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_nomenclature` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `nomenclature` (`id`, `parent`, `text`) VALUES
('ajson1', '#', 'Nomenclature'),
('j1_1', 'ajson1', 'New node'),
('j1_11', 'ajson1', 'Restauration'),
('j1_12', 'j1_11', 'Petit déjeuné'),
('j1_13', 'j1_11', 'Déjeuné'),
('j1_2', 'ajson1', 'Transport'),
('j1_3', 'ajson1', 'Logement'),
('j1_4', 'j1_11', 'New node'),
('j1_7', 'j1_2', 'Bateau'),
('j1_8', 'j1_2', 'Train'),
('j1_9', 'j1_2', 'Avion');
DROP TABLE IF EXISTS `operations`;
CREATE TABLE IF NOT EXISTS `operations` (
  `id` varchar(60) NOT NULL,
  `date` date NOT NULL,
  `id_nomenclature` varchar(60) NOT NULL,
  `description` varchar(200) NOT NULL,
  `montant` float NOT NULL,
  `id_mission` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_operations` (`id_mission`),
  KEY `FK_nommenclature` (`id_nomenclature`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `operations` (`id`, `date`, `id_nomenclature`, `description`, `montant`, `id_mission`) VALUES
('1', '2022-03-02', 'j1_12', 'r', 5, '1'),
('11', '1970-01-01', 'j1_12', 'rm', -6, '1'),
('12', '2022-03-30', 'j1_13', 'bts', 7, '1'),
('op-62371737544f26.39956998', '2022-03-20', 'j1_11', 'thdt', 34, 'mission-6236fdee004306.36321370'),
('op-623721f06ae8b2.32721450', '2022-03-24', 'j1_11', 'Mission', 545, 'mission-6236fdee004306.36321370'),
('op-62372359aae320.78356983', '2022-03-25', 'j1_2', 'dhd', 12, 'mission-6236fdee004306.36321370'),
('op-62372372d4e9f6.39778654', '2022-03-30', 'j1_11', 'MAMISSION', 13, 'mission-6236fdee004306.36321370');
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `Id` varchar(60) NOT NULL,
  `role` enum('Administrateur','Employee') NOT NULL DEFAULT 'Employee',
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `service` enum('Marketing','RH','R and D','Commercial','Administration') NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `users` (`Id`, `role`, `firstName`, `lastName`, `email`, `phone`, `password`, `service`) VALUES
('user-62371b93b4edf3.94618216', 'Employee', 'KLK', 'HFKH', 'email3@gmail.com', '124567890', '$2y$10$0PEOZCZA8EtCuTejyxOhP.S5GNtAOUMfJ5mJEDlJzTIb5JmltE5Cq', 'Marketing');
COMMIT;";
  $req = $pdo->prepare($sql);
  $req->execute();
  echo "Base de donnée créée avec succès";
} catch (PDOException $e) {
  return "Connection failed: " . $e->getMessage();
}