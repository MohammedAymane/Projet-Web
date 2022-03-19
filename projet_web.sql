-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : sam. 19 mars 2022 à 10:51
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.21

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

CREATE TABLE `missions` (
  `Id` int(11) NOT NULL,
  `lieu` varchar(100) NOT NULL,
  `debut` date NOT NULL,
  `fin` date NOT NULL,
  `devise` enum('dollars','euro','yen','yuan') NOT NULL,
  `description` varchar(200) NOT NULL,
  `etat` enum('enCours','finis','annulee','supprimee') NOT NULL,
  `solde_initial` float NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `missions`
--

INSERT INTO `missions` (`Id`, `lieu`, `debut`, `fin`, `devise`, `description`, `etat`, `solde_initial`, `user_id`) VALUES
(1, 'E', '2022-03-02', '2022-03-11', 'dollars', 'r', 'enCours', 5, 3);

-- --------------------------------------------------------

--
-- Structure de la table `nomenclature`
--

CREATE TABLE `nomenclature` (
  `id` varchar(60) NOT NULL,
  `parent` varchar(60) NOT NULL,
  `text` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `nomenclature`
--

INSERT INTO `nomenclature` (`id`, `parent`, `text`) VALUES
('ajson1', '#', 'Nomenclature'),
('j1_11', 'ajson1', 'Restauration'),
('j1_12', 'j1_11', 'Petit déjeuné'),
('j1_13', 'j1_11', 'Déjeuné'),
('j1_2', 'ajson1', 'Transport'),
('j1_3', 'ajson1', 'Logement'),
('j1_7', 'j1_2', 'Bateau'),
('j1_8', 'j1_2', 'Train'),
('j1_9', 'j1_2', 'Avion');

-- --------------------------------------------------------

--
-- Structure de la table `operations`
--

CREATE TABLE `operations` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_nomenclature` varchar(200) NOT NULL,
  `description` varchar(200) NOT NULL,
  `montant` float NOT NULL,
  `id_mission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `operations`
--

INSERT INTO `operations` (`id`, `date`, `id_nomenclature`, `description`, `montant`, `id_mission`) VALUES
(1, '2022-03-02', 'j1_12', 'r', 5, 1),
(2, '2022-03-02', 'j1_12', 'rr', 4, 1),
(3, '2022-04-22', 'j1_12', 'rrtt', 9, 1),
(4, '2022-04-22', 'j1_12', 'rrtt', 9, 1),
(5, '2022-04-22', 'j1_12', 'tyuy', 9, 1),
(6, '2022-04-22', 'j1_12', 'tyuy', 9, 1),
(7, '1970-01-01', 'j1_12', 'aa', 9, 1),
(8, '1970-01-01', 'j1_12', 'aa', 9, 1),
(9, '1970-01-01', 'j1_12', 'azety', 9, 1),
(10, '1970-01-01', 'j1_12', 'azety', 9, 1),
(11, '1970-01-01', 'j1_12', 'rm', -6, 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `role` enum('Administrateur','Employee') NOT NULL DEFAULT 'Employee',
  `firstName` varchar(60) NOT NULL,
  `lastName` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `service` enum('Marketing','RH','R&D','Commercial','Administration') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`Id`, `role`, `firstName`, `lastName`, `email`, `phone`, `password`, `service`) VALUES
(2, 'Employee', 'Wenjie', 'FU', 'email@gmail.com', '+33752741076', '$2y$10$VhyCtDnawUZNHRSeBfBLDO2xUjqyCN7RbZGRC95sRNhFlmTeUXt5e', 'RH'),
(3, 'Employee', 'hortense', 'SO', 'mail@gmail.com', '08654', '$2y$10$KqFxFVqyxRGEvtVl5hNR/ucd2W0I8P3qbl3GUtLrPbIv6Glarcxga', 'RH');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_missions` (`user_id`);

--
-- Index pour la table `nomenclature`
--
ALTER TABLE `nomenclature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nomenclature` (`parent`);

--
-- Index pour la table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_operations` (`id_mission`),
  ADD KEY `FK_nommenclature` (`id_nomenclature`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `missions`
--
ALTER TABLE `missions`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
