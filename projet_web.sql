-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 21 mars 2022 à 11:36
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_web`
--

-- --------------------------------------------------------

--
-- Structure de la table `devise`
--

DROP TABLE IF EXISTS `devise`;
CREATE TABLE IF NOT EXISTS `devise` (
  `nom` enum('dollars','euro','yen','yuan') NOT NULL,
  `symbole` varchar(10) NOT NULL,
  `taux_change` float NOT NULL,
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `devise`
--

INSERT INTO `devise` (`nom`, `symbole`, `taux_change`) VALUES
('dollars', '$', 0.9),
('euro', '€', 1),
('yen', '¥', 0.0076),
('yuan', '¥', 0.14);

-- --------------------------------------------------------

--
-- Structure de la table `missions`
--

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

--
-- Déchargement des données de la table `missions`
--

INSERT INTO `missions` (`Id`, `lieu`, `debut`, `fin`, `devise`, `description`, `etat`, `solde_initial`, `user_id`) VALUES
('1', 'E', '2022-03-02', '2022-03-11', 'dollars', 'r', 'en cours', 5, '3'),
('2', 'rr', '2022-03-01', '2022-03-03', 'dollars', 't', 'finis', 9, '3'),
('23432', 't', '2022-03-02', '2022-03-11', 'dollars', 'hs', 'en cours', 9, '3'),
('mission-6236fd8382f3e9.99849820', 'tt', '2022-03-15', '2022-03-28', 'euro', 'tt', 'en cours', 9, '5'),
('mission-6236fdd0c94ed9.89201354', 'ttty', '2022-03-14', '2022-03-29', 'dollars', 're', 'en cours', 12, '5'),
('mission-6236fdee004306.36321370', 'ttty', '2022-03-14', '2022-03-29', 'dollars', 're', 'en cours', 12, '5');

-- --------------------------------------------------------

--
-- Structure de la table `nomenclature`
--

DROP TABLE IF EXISTS `nomenclature`;
CREATE TABLE IF NOT EXISTS `nomenclature` (
  `id` varchar(60) NOT NULL,
  `parent` varchar(60) NOT NULL,
  `text` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_nomenclature` (`parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `nomenclature`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `operations`
--

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

--
-- Déchargement des données de la table `operations`
--

INSERT INTO `operations` (`id`, `date`, `id_nomenclature`, `description`, `montant`, `id_mission`) VALUES
('1', '2022-03-02', 'j1_12', 'r', 5, '1'),
('11', '1970-01-01', 'j1_12', 'rm', -6, '1'),
('12', '2022-03-30', 'j1_13', 'bts', 7, '1'),
('op-62371737544f26.39956998', '2022-03-20', 'j1_11', 'thdt', 34, 'mission-6236fdee004306.36321370'),
('op-623721f06ae8b2.32721450', '2022-03-24', 'j1_11', 'Mission', 545, 'mission-6236fdee004306.36321370'),
('op-62372359aae320.78356983', '2022-03-25', 'j1_2', 'dhd', 12, 'mission-6236fdee004306.36321370'),
('op-62372372d4e9f6.39778654', '2022-03-30', 'j1_11', 'MAMISSION', 13, 'mission-6236fdee004306.36321370');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

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

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `role`, `firstName`, `lastName`, `email`, `phone`, `password`, `service`) VALUES
('2', 'Employee', 'Wenjie', 'FU', 'email@gmail.com', '+33752741076', '$2y$10$VhyCtDnawUZNHRSeBfBLDO2xUjqyCN7RbZGRC95sRNhFlmTeUXt5e', 'RH'),
('3', 'Employee', 'hortense', 'SO', 'mail@gmail.com', '08654', '$2y$10$KqFxFVqyxRGEvtVl5hNR/ucd2W0I8P3qbl3GUtLrPbIv6Glarcxga', 'RH'),
('5', 'Administrateur', 't', 't', 'b@mail.com', 't', '$2y$10$yyyfPZ8s5CrdWFsbx0mLxu0gSSqDSm9HCPOXesfv7lTxgGj0w5j5G', 'RH'),
('user-62371afeced575.21660764', 'Employee', 'O', 'Aymane', 'email1@gmail.com', '1234567890', '$2y$10$QFhWpa7gU8.OoF1xdRYTEeMXFAGQIEE./Kn7kwwsfjmfwiV7zp3te', 'RH'),
('user-62371b93b4edf3.94618216', 'Employee', 'KLK', 'HFKH', 'email3@gmail.com', '124567890', '$2y$10$0PEOZCZA8EtCuTejyxOhP.S5GNtAOUMfJ5mJEDlJzTIb5JmltE5Cq', 'Marketing'),
('user-62371f0bb44029.35694466', 'Employee', 'GHJ', 'jhkuk', 'G@gmail.com', '9847358934', '$2y$10$vzTOCPGVLqGwO8Q9i13.XOH6TNmutAfQQiG5H2y9VawnowaQSQEpS', 'Commercial'),
('user-62371fa015ff77.14753092', 'Employee', 'krerg', 'grkh', 'GH@GG.COM', '87876', '$2y$10$JvR7jsh47n9BOwWU5TLQXuqc.mox93WUh5O4foCinXMFSbOhBBKAy', 'R and D');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
