-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 05 juin 2020 à 09:16
-- Version du serveur :  5.7.17
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `easychef`
--

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE `ingredient` (
  `idIngredient` int(11) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ingredient`
--

INSERT INTO `ingredient` (`idIngredient`, `idRecipe`, `name`, `quantity`, `unity`) VALUES
(1, 1, 'Banane', 12, ''),
(2, 1, 'Beurre', 160, 'grammes'),
(3, 1, 'Oeufs', 4, ''),
(4, 1, 'Sucre', 200, ''),
(5, 1, 'Farine', 250, 'grammes'),
(6, 1, 'Levure chimique', 1, 'sachet'),
(7, 1, 'Sucre vanillé', 1, 'grammes'),
(9, 7, 'Oeufs', 3, ''),
(10, 7, 'Farine', 100, 'grammes'),
(11, 7, 'Levure', 1, 'sachet'),
(12, 7, 'Lait', 10, 'cl'),
(13, 7, 'Huile', 10, 'cl'),
(14, 7, 'Gruyère râpé', 100, 'grammes'),
(15, 7, 'Tomates séchée', 150, 'grammes'),
(16, 7, 'Poulet rôti', 150, 'grammes'),
(17, 7, 'oignons', 1, ''),
(18, 7, 'poivre', 1, 'pincée'),
(19, 7, 'sel', 1, 'pincée');

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE `picture` (
  `idPicture` int(11) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `picture`
--

INSERT INTO `picture` (`idPicture`, `idRecipe`, `path`) VALUES
(1, 1, 'pictureN1.jpg'),
(3, 7, 'pictureN7.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `rate`
--

CREATE TABLE `rate` (
  `idRate` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idRecipe` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rate`
--

INSERT INTO `rate` (`idRate`, `idUser`, `idRecipe`, `rating`, `description`, `date`) VALUES
(2, 7, 1, 4, 'Un très bon cake', '2020-05-26 09:12:56'),
(3, 8, 1, 5, 'La description de la perfection', '2020-05-26 09:21:00'),
(8, 6, 7, 1, 'Update', '2020-06-04 23:03:31'),
(10, 6, 7, 5, 'deuxieme msg', '2020-06-04 23:00:56'),
(11, 6, 7, 3, 'troisième msg', '2020-06-04 23:02:57');

-- --------------------------------------------------------

--
-- Structure de la table `recipe`
--

CREATE TABLE `recipe` (
  `idRecipe` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `timeRequired` int(11) NOT NULL,
  `isValid` tinyint(1) NOT NULL DEFAULT '0',
  `lastChangeDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recipe`
--

INSERT INTO `recipe` (`idRecipe`, `idUser`, `title`, `description`, `timeRequired`, `isValid`, `lastChangeDate`) VALUES
(1, 6, 'Gâteau à la banane', '1) Écraser les bananes avec une fourchette dans une assiette et les laisser de côté.\r\n2) Bien mélanger les oeufs avec le sucre.\r\n3) Rajouter la farine, le beurre, la levure et le sucre vanillé.\r\n4) Incorporer la purée de bananes à la préparation.\r\nPour finir\r\nMettre au four pendant 35 minutes sur (thermostat 3-4).', 45, 0, '2020-06-04 14:42:41'),
(7, 9, 'Cake tomates séchées et poulet rôti', '1) Préchauffer le four à 180°C (thermostat 6).\r\n2) Faire revenir l&#39;oignon émincé à feu doux.\r\n3) Dans un récipient, mélanger farine et levure.\r\n4) Creuser un puits et ajouter les oeufs, le lait et l&#39;huile.\r\n5) Saler, poivrer.\r\n6) Bien mélanger pour obtenir une pâte lisse.\r\n7) Ajouter le gruyère râpé, mélanger.\r\n8) Couper les tomates séchées et le poulet rôti en petits morceaux et les ajouter au mélange.\r\n9) Quand l&#39;oignon a bien fondu, l&#39;incorporer au mélange.\r\n10) Huiler un moule à cake et y verser le mélange\r\n11) Enfourner pendant 40 minutes.', 55, 1, '2020-06-03 10:28:02'),
(20, 6, 'tracteur scott', 'caca', 3, 0, '2020-06-04 23:45:27');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`idUser`, `pseudo`, `email`, `password`, `admin`) VALUES
(6, 'admin', 'admin@admin.admin', 'dd94709528bb1c83d08f3088d4043f4742891f4f', 1),
(7, 'Leandro', 'leandro.rsstti@gmail.com', '5fb9558e1f5db0205710e789125923e1fbd37200', 0),
(8, 'David', 'david@gmail.com', '340892a69186ab0467490a4a60c14b9a21b60044', 0),
(9, 'Tracteur', 'tracteur@gmail.com', '3ee9863a42737f6d778130ecf4367486e265abcc', 0),
(10, 'Test', 'test@gmail.com', 'a010b72dac9727ba7e60c4fda46694262df561a2', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`idIngredient`),
  ADD KEY `idRecipe` (`idRecipe`);

--
-- Index pour la table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`idPicture`),
  ADD KEY `idRecipe` (`idRecipe`);

--
-- Index pour la table `rate`
--
ALTER TABLE `rate`
  ADD PRIMARY KEY (`idRate`),
  ADD KEY `idUser` (`idUser`,`idRecipe`),
  ADD KEY `idRecipe` (`idRecipe`);

--
-- Index pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD PRIMARY KEY (`idRecipe`),
  ADD KEY `idUser` (`idUser`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `idIngredient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `picture`
--
ALTER TABLE `picture`
  MODIFY `idPicture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `rate`
--
ALTER TABLE `rate`
  MODIFY `idRate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `recipe`
--
ALTER TABLE `recipe`
  MODIFY `idRecipe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `ingredient_ibfk_1` FOREIGN KEY (`idRecipe`) REFERENCES `recipe` (`idRecipe`);

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `picture_ibfk_1` FOREIGN KEY (`idRecipe`) REFERENCES `recipe` (`idRecipe`);

--
-- Contraintes pour la table `rate`
--
ALTER TABLE `rate`
  ADD CONSTRAINT `rate_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`),
  ADD CONSTRAINT `rate_ibfk_2` FOREIGN KEY (`idRecipe`) REFERENCES `recipe` (`idRecipe`);

--
-- Contraintes pour la table `recipe`
--
ALTER TABLE `recipe`
  ADD CONSTRAINT `recipe_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
