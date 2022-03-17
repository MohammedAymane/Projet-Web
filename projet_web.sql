-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 16 mars 2022 à 09:46
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
-- Structure de la table `missions`
--

DROP TABLE IF EXISTS `missions`;
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

-- --------------------------------------------------------

--
-- Structure de la table `nomenclature`
--

DROP TABLE IF EXISTS `nomenclature`;
CREATE TABLE IF NOT EXISTS `nomenclature` (
  `id` int(11) NOT NULL,
  `nom` varchar(60) NOT NULL,
  `id_parent` int(11),
  PRIMARY KEY (`id`),
  KEY `FK_nomenclature` (`id_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `operations`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

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

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `role`, `firstName`, `lastName`, `email`, `phone`, `password`, `service`) VALUES
(32, 'Administrateur', 'Administrateur 1', 'Admin', 'email1@gmail.com', '0612345678', '$2y$10$.LeTRnMUSV8ChaFkziuSTeYX2kZ7xQyDM1bXssD2EdsOi0SWMOJoa', 'Administration'),
(33, 'Employee', 'Utilisateur 1', 'User', 'email2@gmail.com', '0612345678', '$2y$10$zSaDll2v0mwSAmWnE02NQ.NKCl.ycUNmugHOIwjXeznG/q/2TG/4u', 'RH');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
