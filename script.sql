-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 07 mai 2025 à 20:56
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `data_molène`
--

-- --------------------------------------------------------

--
-- Structure de la table `data`
--

CREATE TABLE `data` (
  `id_data` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `date_prise` varchar(50) NOT NULL,
  `date_ajout` varchar(50) NOT NULL,
  `chemin` varchar(255) NOT NULL,
  `id_type` int(11) NOT NULL,
  `id_niveau` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `data`
--

INSERT INTO `data` (`id_data`, `nom`, `date_prise`, `date_ajout`, `chemin`, `id_type`, `id_niveau`, `id_utilisateur`) VALUES
(77, 'Molène 1', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1A/Molène 1.mp4', 1, 1, 1),
(78, 'Molène 2', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1A/Molène 2.mp4', 1, 1, 1),
(79, 'Molène 3', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1A/Molène 3.mp4', 1, 1, 1),
(82, 'Perception 1', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1B/Perception 1.jpg', 3, 1, 1),
(83, 'Perception 2', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1B/Perception 2.jpg', 3, 1, 1),
(84, 'Perception 3', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1B/Perception 3.jpg', 3, 1, 1),
(85, 'Perception 6', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1B/Perception 6.jpg', 3, 1, 1),
(86, 'Perception 7', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 1/Données niveau 1B/Perception 7.jpg', 3, 1, 1),
(87, 'Croquis préparatoires Molène_traits de côte', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/Croquis préparatoires Molène_traits de côte.jpg', 3, 2, 1),
(88, 'IMG_20240924_174750', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20240924_174750.jpg', 3, 2, 1),
(89, 'IMG_20240924_174919', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20240924_174919.jpg', 3, 2, 1),
(90, 'IMG_20240924_175007', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20240924_175007.jpg', 3, 2, 1),
(91, 'IMG_20240924_180442', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20240924_180442.jpg', 3, 2, 1),
(92, 'IMG_20240925_174047', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20240925_174047.jpg', 3, 2, 1),
(93, 'IMG_20241121_144500', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20241121_144500.jpg', 3, 2, 1),
(94, 'IMG_20241121_144728', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20241121_144728.jpg', 3, 2, 1),
(95, 'IMG_20241121_144750', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20241121_144750.jpg', 3, 2, 1),
(96, 'IMG_20241121_144808', 'pas info', '2025-04-03', 'uploads/Données qualitatives 16_01_25/Données niveau 2/IMG_20241121_144808.jpg', 3, 2, 1),
(97, 'Encre_Fanny Lefort_1', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Encre_Fanny Lefort_1.jpg', 3, 3, 19),
(98, 'Encre_Fanny Lefort_2', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Encre_Fanny Lefort_2.jpg', 3, 3, 19),
(99, 'encre_algue_fanny', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Encre_Fanny Lefort_3.jpg', 3, 3, 19),
(100, 'Erosion_Isabelle Elizéon_1', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Erosion_Isabelle Elizéon_1.jpg', 3, 3, 1),
(101, 'Erosion_Isabelle Elizéon_2', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Erosion_Isabelle Elizéon_2.jpg', 3, 3, 1),
(102, 'Erosion_Isabelle Elizéon_3', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Erosion_Isabelle Elizéon_3.jpg', 3, 3, 1),
(103, 'Fusain_Fanny Lefort_1', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Fusain_Fanny Lefort_1.jpg', 3, 3, 19),
(104, 'Fusain_Fanny Lefort_2', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Fusain_Fanny Lefort_2.jpg', 3, 3, 19),
(105, 'Fusain_Fanny Lefort_3', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Fusain_Fanny Lefort_3.jpg', 3, 3, 19),
(106, 'Strates_Isabelle Elizéon_1', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Strates_Isabelle Elizéon_1.jpg', 3, 3, 1),
(107, 'Strates_Isabelle Elizéon_2', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 3/Strates_Isabelle Elizéon_2.jpg', 3, 3, 1),
(108, 'CR Résidence-terrain Molène_sept', '2024-09', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 4/CR Résidence-terrain Molène_sept. 24.pdf', 4, 4, 1),
(109, 'MOLENE vFinale_Isabelle', 'pas info', '2025-14-03', 'uploads/Données qualitatives 16_01_25/Données niveau 4/MOLENE vFinale_Isabelle.mp4', 1, 4, 1),
(111, 'Molène 8', '2025-04-28', '2025-04-28', 'uploads/Molène 8.mp4', 1, 1, 13),
(112, '0001', '2025-04-28', '2025-04-28', 'uploads/00001.mp4', 1, 1, 13);

-- --------------------------------------------------------

--
-- Structure de la table `data_polygons`
--

CREATE TABLE `data_polygons` (
  `id` int(11) NOT NULL,
  `data_id` int(11) NOT NULL,
  `h3_zone` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`h3_zone`)),
  `chemin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `data_projet`
--

CREATE TABLE `data_projet` (
  `id_data` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fonction`
--

CREATE TABLE `fonction` (
  `id_fonction` int(11) NOT NULL,
  `fk_fonction` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fonction`
--

INSERT INTO `fonction` (`id_fonction`, `fk_fonction`) VALUES
(1, 'Particulier'),
(2, 'Scientifique'),
(3, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

CREATE TABLE `niveau` (
  `id_niveau` int(11) NOT NULL,
  `fk_niveau` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `niveau`
--

INSERT INTO `niveau` (`id_niveau`, `fk_niveau`) VALUES
(1, 'Niveau 1'),
(2, 'Niveau 2'),
(3, 'Niveau 3'),
(4, 'Niveau 4'),
(5, 'Niveau 5');

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id_projet` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `est_prive` tinyint(1) DEFAULT 1,
  `id_createur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id_projet`, `nom`, `est_prive`, `id_createur`) VALUES
(1, 'Molène', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id_type` int(11) NOT NULL,
  `fk_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id_type`, `fk_type`) VALUES
(1, 'Video'),
(2, 'Audio'),
(3, 'Photo'),
(4, 'document');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `MDP` varchar(255) NOT NULL,
  `id_fonction` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `Nom`, `Prenom`, `Mail`, `MDP`, `id_fonction`) VALUES
(1, 'Elizeon', 'Isabelle', 'isabelle.elizeon@protonmail.com', 'YGDEYçu@feozofhz7/89665', 2),
(13, 'Sido', 'Flore', 'floresido@gmail.com', '$2y$10$sRNlP/Mjdan.ZIuNwv1j4.RozkUuQbfYi760rQkxCU8Ea69Hk0Dby', 2),
(19, 'Leffort', 'Fanny', 'Fanny_leffort@gmail.com', '$2y$10$y0IHsM8Sbw6Xio.khK10Ve3bFG7LYoJ.dyLYZK4M/p2iN5BZAiWBS', 3),
(29, 'Admin', 'Démo', 'admin_demo@gmail.com', '$2y$10$QPfkHjlT9ue2eJnGXQQMP.qvDTuC778AXKC29OJtrXdYDFNnOA9Z2', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur_projet`
--

CREATE TABLE `utilisateur_projet` (
  `id_utilisateur` int(11) NOT NULL,
  `id_projet` int(11) NOT NULL,
  `role` enum('admin','membre') NOT NULL DEFAULT 'membre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur_projet`
--

INSERT INTO `utilisateur_projet` (`id_utilisateur`, `id_projet`, `role`) VALUES
(1, 1, 'admin'),
(13, 1, ''),
(29, 1, '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id_data`),
  ADD KEY `data_type_FK` (`id_type`),
  ADD KEY `data_Niveau0_FK` (`id_niveau`),
  ADD KEY `data_utilisateur1_FK` (`id_utilisateur`);

--
-- Index pour la table `data_polygons`
--
ALTER TABLE `data_polygons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_id` (`data_id`);

--
-- Index pour la table `data_projet`
--
ALTER TABLE `data_projet`
  ADD PRIMARY KEY (`id_data`,`id_projet`),
  ADD KEY `id_projet` (`id_projet`);

--
-- Index pour la table `fonction`
--
ALTER TABLE `fonction`
  ADD PRIMARY KEY (`id_fonction`);

--
-- Index pour la table `niveau`
--
ALTER TABLE `niveau`
  ADD PRIMARY KEY (`id_niveau`);

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id_projet`),
  ADD KEY `id_createur` (`id_createur`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD KEY `utilisateur_Fonction_FK` (`id_fonction`);

--
-- Index pour la table `utilisateur_projet`
--
ALTER TABLE `utilisateur_projet`
  ADD PRIMARY KEY (`id_utilisateur`,`id_projet`),
  ADD KEY `id_projet` (`id_projet`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `data`
--
ALTER TABLE `data`
  MODIFY `id_data` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT pour la table `data_polygons`
--
ALTER TABLE `data_polygons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT pour la table `fonction`
--
ALTER TABLE `fonction`
  MODIFY `id_fonction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `niveau`
--
ALTER TABLE `niveau`
  MODIFY `id_niveau` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id_projet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_Niveau0_FK` FOREIGN KEY (`id_niveau`) REFERENCES `niveau` (`id_niveau`),
  ADD CONSTRAINT `data_type_FK` FOREIGN KEY (`id_type`) REFERENCES `type` (`id_type`),
  ADD CONSTRAINT `data_utilisateur1_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `data_polygons`
--
ALTER TABLE `data_polygons`
  ADD CONSTRAINT `data_polygons_ibfk_1` FOREIGN KEY (`data_id`) REFERENCES `data` (`id_data`) ON DELETE CASCADE;

--
-- Contraintes pour la table `data_projet`
--
ALTER TABLE `data_projet`
  ADD CONSTRAINT `data_projet_ibfk_1` FOREIGN KEY (`id_data`) REFERENCES `data` (`id_data`) ON DELETE CASCADE,
  ADD CONSTRAINT `data_projet_ibfk_2` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`) ON DELETE CASCADE;

--
-- Contraintes pour la table `projet`
--
ALTER TABLE `projet`
  ADD CONSTRAINT `projet_ibfk_1` FOREIGN KEY (`id_createur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE;

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_Fonction_FK` FOREIGN KEY (`id_fonction`) REFERENCES `fonction` (`id_fonction`);

--
-- Contraintes pour la table `utilisateur_projet`
--
ALTER TABLE `utilisateur_projet`
  ADD CONSTRAINT `utilisateur_projet_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`) ON DELETE CASCADE,
  ADD CONSTRAINT `utilisateur_projet_ibfk_2` FOREIGN KEY (`id_projet`) REFERENCES `projet` (`id_projet`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
