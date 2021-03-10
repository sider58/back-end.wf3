-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 10 mars 2021 à 02:53
-- Version du serveur :  8.0.22
-- Version de PHP : 8.0.1

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
  `titre` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ville` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cp` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `surface` double NOT NULL,
  `prix` double NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `logement`
--

INSERT INTO `logement` (`id_logement`, `titre`, `adresse`, `ville`, `cp`, `surface`, `prix`, `photo`, `description`, `type_id`) VALUES
(1, 'appartement 1 pièce à Lyon 8ème', '74 Rue Voltaire', 'Lyon', '69008', 46, 535, 'image2.jpg', 'Studio meublé Lyon 8ème secteur Laënnec Rue Laënnec - A proximité des hôpitaux de Grange-Blanche, des commerces et des transports en commun (métro D arrêt Laënnec, tramways T2 et T5, bus) - Au 4ème étage avec ascenseur, charmant studio meublé de 22.71m² comprenant une entrée, une kitchenette équipée (réfrigérateur, plaques, vaisselle), une pièce principale avec bureau, canapé-lit, table et chaises et placard mural, et une salle de bain avec WC. Une place de parking privative dans la résidence complète ce bien. Eau froide collective. Chauffage et eau chaude individuels électriques. Double vitrage. Visite virtuelle disponible. Libre de suite !', 2),
(2, 'Appart 9m²', '63 Rue de la Marinière', 'Paris', '75015', 9, 495, 'img.jpg', '\'COUP DE COEUR\' - Proximité Place de Breteuil. A quelques pas des stations de Métro Sèvres-Lecourbe &amp; Ségur. Au 3ème étage avec ascenseur d\'un Bel Immeuble Pierre de Taille, nous vous proposons ce superbe appartement familial ayant conservé tout son cachet Haussmannien. Composé d\'une Entrée, un Double Living plein SUD de 40 m2 ouvrant sur petits balconnets, Parquet en Point de Hongrie, Moulures, Cheminée. Cet appartement bénéficie de 3 Chambres spacieuses, une cuisine aménagée et équipée, une Salle de Bains, une Salle de douche, wc indépendant. Une cave vient compléter le Bien. Copropriété de 17 Lots dont 13 Lots principaux d\'Habitation. Charges : 591/ Mois Chauffage inclus. Quote-part moyenne charges annuelles : 7 100  Honoraires d\'Agence Inclus à la charge du Vendeur. Mandat N° 18. Honoraires inclus de 3.46% TTC à la charge de l\'acquéreur. Prix hors honoraires 1 357 000 . Dans une copropriété de 17 lots. Quote-part moyenne du budget prévisionnel 7 000 /an. Aucune procédure n\'est en cours.', 2),
(3, 'Appartement haussmannien à Paris 16', '34 Rue des Flatteurs', 'Paris', '75016', 235, 2300000, '9a35ea831e29e3f94c93ff9d55296e24.jpg', 'Nous vous conseillons de demander à visiter dans un premier temps ce bien en visio conférence ! Notre conseiller reste disponible. WELMO, la 1ère agence immobilière en ligne, vous présente : XVIème - HAUSSMANNIEN - LUMINEUX - SUR COUR - CALME - ETAGE ÉLEVÉ - CHARME DE L\'ANCIEN - TRÈS BON ÉTAT Vous souhaitez visiter ce bien ? Planifiez directement une visite sur le site WELMO avec la référence : Mof_-D6OkY WELMO vous présente ce bel appartement de 47,38m2 Carrez avec une CAVE. Ce bien se compose d\'une entrée donnant sur une pièce de vie avec cuisine ouverte aménagée de 26m2, une salle à manger/bureau de 11,4m2, une chambre avec rangements intégrés de 10,7m2, une salle d\'eau et WC séparés. En complément de ce bien, une CAVE. Le bien est idéalement situé; proche de toutes commodités, des écoles et des transports (à 5 min de la Gare de Boulainvilliers et du métro \"Ranelagh\"). Nombre de lots : 26 Charges prévisionnelles annuelles : 1680 € WELMO, commission de 1,9% à la charge de l\'acquéreur incluse dans le prix de vente affiché', 1);

-- --------------------------------------------------------

--
-- Structure de la table `type`
--

CREATE TABLE `type` (
  `id_type` int NOT NULL,
  `label_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type`
--

INSERT INTO `type` (`id_type`, `label_id`) VALUES
(1, 'vente'),
(2, 'location');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `logement`
--
ALTER TABLE `logement`
  ADD PRIMARY KEY (`id_logement`),
  ADD KEY `Type` (`type_id`);

--
-- Index pour la table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id_type`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `logement`
--
ALTER TABLE `logement`
  MODIFY `id_logement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `type`
--
ALTER TABLE `type`
  MODIFY `id_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `logement`
--
ALTER TABLE `logement`
  ADD CONSTRAINT `Type` FOREIGN KEY (`type_id`) REFERENCES `type` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
