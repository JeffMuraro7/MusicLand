-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 17 Novembre 2015 à 10:12
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `music_land`
--
CREATE DATABASE IF NOT EXISTS `music_land` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `music_land`;

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `IdAlbum` bigint(20) NOT NULL AUTO_INCREMENT,
  `NomAlbum` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `NomArtiste` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `DateParution` date DEFAULT NULL,
  `Pochette` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `IdStyle` bigint(20) NOT NULL,
  PRIMARY KEY (`IdAlbum`),
  KEY `FK_ALBUM_IdStyle` (`IdStyle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `deposer`
--

DROP TABLE IF EXISTS `deposer`;
CREATE TABLE IF NOT EXISTS `deposer` (
  `IdUser` bigint(20) NOT NULL AUTO_INCREMENT,
  `IdMusique` bigint(20) NOT NULL,
  PRIMARY KEY (`IdUser`,`IdMusique`),
  KEY `FK_DEPOSER_IdMusique` (`IdMusique`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `musique`
--

DROP TABLE IF EXISTS `musique`;
CREATE TABLE IF NOT EXISTS `musique` (
  `IdMusique` bigint(20) NOT NULL AUTO_INCREMENT,
  `Titre` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `Piste` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `IdAlbum` bigint(20) NOT NULL,
  PRIMARY KEY (`IdMusique`),
  KEY `FK_MUSIQUE_IdAlbum` (`IdAlbum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `style`
--

DROP TABLE IF EXISTS `style`;
CREATE TABLE IF NOT EXISTS `style` (
  `IdStyle` bigint(20) NOT NULL AUTO_INCREMENT,
  `Style` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`IdStyle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `IdUser` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `Pseudo` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `MDP` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `Email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `Statut` int(11) DEFAULT NULL,
  PRIMARY KEY (`IdUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `FK_ALBUM_IdStyle` FOREIGN KEY (`IdStyle`) REFERENCES `style` (`IdStyle`);

--
-- Contraintes pour la table `deposer`
--
ALTER TABLE `deposer`
  ADD CONSTRAINT `FK_DEPOSER_IdMusique` FOREIGN KEY (`IdMusique`) REFERENCES `musique` (`IdMusique`),
  ADD CONSTRAINT `FK_DEPOSER_IdUser` FOREIGN KEY (`IdUser`) REFERENCES `user` (`IdUser`);

--
-- Contraintes pour la table `musique`
--
ALTER TABLE `musique`
  ADD CONSTRAINT `FK_MUSIQUE_IdAlbum` FOREIGN KEY (`IdAlbum`) REFERENCES `album` (`IdAlbum`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
GRANT USAGE ON *.* TO 'musicLand'@'127.0.0.1' IDENTIFIED BY PASSWORD '*29584A00D0A4A1D95E278B1F32FBB6324A5BE1D2';

GRANT SELECT, INSERT, UPDATE, DELETE ON `music\_land`.* TO 'musicLand'@'127.0.0.1';
