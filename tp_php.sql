-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 16 août 2024 à 18:18
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tp_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `nom`, `prenom`, `email`, `password`, `role`) VALUES
(4, 'SYLVA', 'Antoine', 'sylvaantoine21@gmail.com', '$2y$10$ttFUd4v.igRSbw75WzVr7ekilZwsbimzDGGz3J2G1SNLQZSlJsbFS', 'admin'),
(9, 'Sow', 'Aldiey', 'ouze24@gmail.com', '$2y$10$AYYOtVsUMkhsH3lBu6G0w.Z3U91CYH18ogn1EsP9wFeQXYWeL7.5i', 'user'),
(12, 'Luffy', 'Muguiwara', 'lucy@gmail.com', '$2y$10$pQ10bSMSDtwupNWyOZGW9ekUqzkZSl7mxlE8gaiUpDnjje0b820..', 'user'),
(18, 'jefe', 'ninho', 'skdis@gmail.com', '$2y$10$CCsneoC8rCW1.lTs.4lqAOZIkrGiv1GYQU07IvOMK2qzenkgzgyqu', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `archivage`
--

CREATE TABLE `archivage` (
  `id` int(10) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date_naiss` date DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `niveau` varchar(10) DEFAULT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `date_archive` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `archivage`
--

INSERT INTO `archivage` (`id`, `nom`, `prenom`, `email`, `date_naiss`, `tel`, `niveau`, `matricule`, `date_archive`) VALUES
(18, 'Sow', 'Aldiey', 'sowaldiey@gmail.com', '2005-05-11', '', 'M2', 'ETU2E820CAE', '2024-08-14 15:26:27'),
(19, 'ez;ekflfe', 'dfdgfd', 'dfdgfd@gmail.com', '2001-05-20', '78-245-41-45', 'L2', 'ETU8E440C9F', '2024-08-14 15:36:47'),
(20, 'ez;ekflfe', 'hklhihu', 'hklhihu@gmail.com', '2000-01-21', '75-854-75-69', 'L2', 'ETU6690079B', '2024-08-14 15:38:59'),
(21, 'Gefe', 'Khalifa', 'sdstyzq@exemple.com', '2003-05-27', '785421066', 'L1', 'ETU146C9776', '2024-08-16 12:55:23'),
(22, 'Moreau', 'Léa', 'lea.moreau@example.com', '1998-12-03', '0612349876', 'L2', 'A007', '2024-08-16 12:55:51'),
(23, 'Lefebvre', 'Marie', 'marie.lefebvre@example.com', '1999-09-20', '0687654321', 'L2', 'A002', '2024-08-16 12:59:52');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(10) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(20) NOT NULL,
  `date_naiss` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `niveau` varchar(5) DEFAULT NULL,
  `matricule` varchar(30) NOT NULL,
  `archive` int(5) DEFAULT 0,
  `date_archiv` datetime DEFAULT NULL,
  `math` float DEFAULT NULL,
  `physic` float DEFAULT NULL,
  `informatique` float DEFAULT NULL,
  `chimie` float DEFAULT NULL,
  `moyenne` float DEFAULT NULL,
  `admission` enum('en_cour','admis','recale') NOT NULL DEFAULT 'en_cour'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `date_naiss`, `email`, `tel`, `niveau`, `matricule`, `archive`, `date_archiv`, `math`, `physic`, `informatique`, `chimie`, `moyenne`, `admission`) VALUES
(1, 'Dup', 'Jeanot', '1998-05-12', 'jean.dupont@example.com', '0612345678', 'L1', 'A001', 0, '2024-08-16 15:56:17', 12, 11, 5, 20, 12, 'admis'),
(3, 'Mercier', 'Pierre', '2000-03-08', 'pierre.mercier@example.com', '0612348765', 'L3', 'A003', 1, '2024-08-16 01:11:07', 0, 0, 0, 0, 0, 'en_cour'),
(4, 'Girard', 'Sophie', '2001-11-25', 'sophie.girard@example.com', '0687653412', 'M1', 'A004', 1, '2024-08-16 14:59:58', 0, 0, 0, 0, 0, 'en_cour'),
(5, 'Rousseau', 'Julien', '1997-06-30', 'julien.rousseau@example.com', '0612345987', 'M2', 'A005', 0, '2024-08-15 00:00:00', 14.4, 10.08, 8, 12, 11.12, 'admis'),
(6, 'Leroy', 'Camille', '2002-04-18', 'camille.leroy@example.com', '0687654098', 'L1', 'A006', 0, '2024-08-15 00:00:00', 12, 15, 14, 4, 11.25, 'admis'),
(8, 'Fournier', 'Maxime', '2000-09-15', 'maxime.fournier@example.com', '0687650123', 'L3', 'A008', 0, '2024-08-15 00:00:00', 14.25, 12.75, 11, 3, 10.25, 'admis'),
(9, 'Dupuis', 'Chloé', '2001-05-27', 'chloe.dupuis@example.com', '0612347890', 'M1', 'A009', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(10, 'Leclercq', 'Théo', '1999-11-10', 'theo.leclercq@example.com', '0687650987', 'M2', 'A010', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(11, 'Dubois', 'Manon', '2002-02-22', 'manon.dubois@example.com', '0612349012', 'L1', 'A011', 0, '2024-08-15 00:00:00', 12.22, 9.08, 9.3, 3, 8.4, 'recale'),
(12, 'Mercier', 'Léo', '1998-08-01', 'leo.mercier@example.com', '0687650456', 'L2', 'A012', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(13, 'Lefevre', 'Emma', '2000-03-15', 'emma.lefevre@example.com', '0612349678', 'L3', 'A013', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(14, 'Girard', 'Lucas', '2001-09-28', 'lucas.girard@example.com', '0687650234', 'M1', 'A014', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(15, 'Rousseau', 'Jade', '1997-04-05', 'jade.rousseau@example.com', '0612349456', 'M2', 'A015', 0, '2024-08-15 00:00:00', 9, 12, 8, 9, 9.5, 'recale'),
(16, 'Leroy', 'Mathis', '2002-07-12', 'mathis.leroy@example.com', '0687650789', 'L1', 'A016', 0, '2024-08-15 00:00:00', 14, 2, 9, 9, 8.5, 'recale'),
(17, 'Moreau', 'Lucie', '1998-10-19', 'lucie.moreau@example.com', '0612349234', 'L2', 'A017', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(18, 'Fournier', 'Ethan', '2000-06-02', 'ethan.fournier@example.com', '0687650567', 'L3', 'A018', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(19, 'Dupuis', 'Léa', '2001-01-14', 'lea.dupuis@example.com', '0612349789', 'M1', 'A019', 0, '2024-08-15 00:00:00', 5, 11, 14.28, 12.6, 10.72, 'admis'),
(20, 'Leclercq', 'Hugo', '1999-07-26', 'hugo.leclercq@example.com', '0687650345', 'M2', 'A020', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(21, 'Dubois', 'Léna', '2002-11-09', 'lena.dubois@example.com', '0612349012', 'L1', 'A021', 0, '2024-08-15 00:00:00', 14, 13, 17, 9, 13.25, 'admis'),
(22, 'Mercier', 'Noa', '1998-03-23', 'noa.mercier@example.com', '0687650456', 'L2', 'A022', 0, '2024-08-15 00:00:00', 3, 11.25, 10, 12.247, 9.12425, 'recale'),
(23, 'Lefevre', 'Mia', '2000-10-07', 'mia.lefevre@example.com', '0612349678', 'L3', 'A023', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(24, 'Girard', 'Léo', '2001-04-14', 'leo.girard@example.com', '0687650234', 'M1', 'A024', 0, '2024-08-15 00:00:00', 0, 0, 0, 0, 0, 'en_cour'),
(29, 'Monkey', 'Luffy', '2001-09-24', 'monkey@gmail.com', '70-125-42-66', 'M2', 'ETU1704CB72', 0, NULL, 18, 14, 14.5, 10, 14.125, 'admis'),
(30, 'sylva', 'mouhamed', '2006-11-13', 'louis.sylva@gmail.com', '77-605-89-18', 'M1', 'ETUC6A89885', 0, NULL, 16, 2, 0, 1, 4.75, 'recale'),
(32, 'ka', 'thier', '2000-12-10', 'ka@gmail.com', '778942163', 'L1', 'ETU71921802', 0, NULL, NULL, NULL, NULL, NULL, NULL, 'en_cour');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `archivage`
--
ALTER TABLE `archivage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `matricule` (`matricule`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `archivage`
--
ALTER TABLE `archivage`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
