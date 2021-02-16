-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 01 jan. 2021 à 06:39
-- Version du serveur :  8.0.22
-- Version de PHP : 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `immobilier`
--

-- --------------------------------------------------------

--
-- Structure de la table `logement`
--

CREATE TABLE `logement` (
  `id_logement` int NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cp` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `surface` double NOT NULL,
  `prix` double NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logement`
--

INSERT INTO `logement` (`id_logement`, `titre`, `adresse`, `ville`, `cp`, `surface`, `prix`, `photo`, `description`, `type_id`) VALUES
(1, 'appartement 4 pièces à Lyon 8ème', '46 Rue des Marguerites', 'Lyon', '69008', 93, 345000, 'image1.jpg', 'EXCLUSIVITÉ ORPI..!!. A deux pas de Monplaisir avec toutes commodités au pied d\'une copropriété des années 60, venez découvrir ce grand appartement traversant de type 4 de 93.73m² au 2ème étage avec ascenseur. Il se compose de 3 chambres dont une avec vue sur Fourvière, grand séjour, espace cuisine, salle de bain, cave. Travaux à prévoir ! Belle opportunité en résidence principale ou déficit foncier. Un garage en sus au prix de 20 000euros complète le bien. 345000 euros Honoraires à la charge du vendeur.', 1),
(2, 'appartement 1 pièce à Lyon 8ème', '74 Rue Voltaire', 'Lyon', '69008', 46, 535, 'image2.jpg', 'Studio meublé Lyon 8ème secteur Laënnec Rue Laënnec - A proximité des hôpitaux de Grange-Blanche, des commerces et des transports en commun (métro D arrêt Laënnec, tramways T2 et T5, bus) - Au 4ème étage avec ascenseur, charmant studio meublé de 22.71m² comprenant une entrée, une kitchenette équipée (réfrigérateur, plaques, vaisselle), une pièce principale avec bureau, canapé-lit, table et chaises et placard mural, et une salle de bain avec WC. Une place de parking privative dans la résidence complète ce bien. Eau froide collective. Chauffage et eau chaude individuels électriques. Double vitrage. Visite virtuelle disponible. Libre de suite !', 2),
(3, 'Appart 9m²', '63 Rue de la Marinière', 'Paris', '75015', 9, 495, 'img.jpg', '', 2),
(6, 'Appart 9m²', '63 Rue de la Marinière', 'Paris', '75015', 9, 495, 'image2.jpg', '', 2),
(7, 'Appart 9m²', '63 Rue de la Marinière', 'Paris', '75015', 9, 49550, '0274dfb85ce0bd4ce0e4aa5a7f5d93b4.jpg', '', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `logement`
--
ALTER TABLE `logement`
  ADD PRIMARY KEY (`id_logement`),
  ADD KEY `type_id` (`type_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `logement`
--
ALTER TABLE `logement`
  MODIFY `id_logement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
