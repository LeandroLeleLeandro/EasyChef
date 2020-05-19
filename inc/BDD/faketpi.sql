-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 28 avr. 2020 à 12:50
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
-- Base de données :  `faketpi`
--

-- --------------------------------------------------------

--
-- Structure de la table `animaux`
--

CREATE TABLE `animaux` (
  `idAnimal` int(11) NOT NULL,
  `typeAnimal` varchar(255) NOT NULL,
  `prenomAnimal` varchar(255) NOT NULL,
  `dateNaissanceAnimal` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii;

--
-- Déchargement des données de la table `animaux`
--

INSERT INTO `animaux` (`idAnimal`, `typeAnimal`, `prenomAnimal`, `dateNaissanceAnimal`) VALUES
(8, 'Chat', 'pizza', '2019-12-12'),
(3, 'Humain', 'Leandro', '2000-08-11'),
(5, 'Chien', 'Locky', '2017-04-16');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `idUser` int(11) NOT NULL,
  `surnameUser` varchar(255) NOT NULL,
  `pwdUser` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=ascii;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`idUser`, `surnameUser`, `pwdUser`) VALUES
(1, 'admin', 'f6fdffe48c908deb0f4c3bd36c032e72');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `animaux`
--
ALTER TABLE `animaux`
  ADD PRIMARY KEY (`idAnimal`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `animaux`
--
ALTER TABLE `animaux`
  MODIFY `idAnimal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
