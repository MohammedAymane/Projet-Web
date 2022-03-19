-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Mar 19, 2022 at 09:26 AM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projet_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `missions`
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

-- --------------------------------------------------------

--
-- Table structure for table `nomenclature`
--

CREATE TABLE `nomenclature` (
  `id` varchar(60) NOT NULL,
  `parent` varchar(60) NOT NULL,
  `text` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nomenclature`
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
-- Table structure for table `operations`
--

CREATE TABLE `operations` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `id_nomenclature` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `montant` float NOT NULL,
  `id_mission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `role`, `firstName`, `lastName`, `email`, `phone`, `password`, `service`) VALUES
(2, 'Employee', 'Wenjie', 'FU', 'email@gmail.com', '+33752741076', '$2y$10$VhyCtDnawUZNHRSeBfBLDO2xUjqyCN7RbZGRC95sRNhFlmTeUXt5e', 'RH');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_missions` (`user_id`);

--
-- Indexes for table `nomenclature`
--
ALTER TABLE `nomenclature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_nomenclature` (`parent`);

--
-- Indexes for table `operations`
--
ALTER TABLE `operations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_operations` (`id_mission`),
  ADD KEY `FK_nommenclature` (`id_nomenclature`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operations`
--
ALTER TABLE `operations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
