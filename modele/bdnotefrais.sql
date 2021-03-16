-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 16 mars 2021 à 19:12
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
-- Base de données :  `bdnotefrais`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `iuser` varchar(30) NOT NULL,
  `ipassword` varchar(30) NOT NULL,
  `inom` varchar(50) NOT NULL,
  `igroupe` varchar(20) NOT NULL,
  `imail` varchar(50) NOT NULL,
  `itelephone` varchar(10) NOT NULL,
  `istatut` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`iuser`, `ipassword`, `inom`, `igroupe`, `imail`, `itelephone`, `istatut`) VALUES
('thierry.bogusz', 'th', 'thierry.bogusz', '@android', 'mail@mail.fr', '065544332', 'I'),
('agnes.bourgeois', 'ag', 'agnes.bourgeois', '@android', 'maila@mail.fr', '0644886655', 'S'),
('test', 'test', 'Test', '@android', 'test@maoil', '0633443322', 'I');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iuser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
