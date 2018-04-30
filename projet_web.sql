-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 30 avr. 2018 à 18:14
-- Version du serveur :  5.7.21
-- Version de PHP :  5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_web`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_link` int(11) NOT NULL,
  `content_comment` text NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `id_user` (`id_user`),
  KEY `id_link` (`id_link`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id_comment`, `date`, `id_user`, `id_link`, `content_comment`) VALUES
(40, '2018-04-30 08:08:52', 1, 56, 'lala'),
(48, '2018-04-30 09:14:31', 2, 56, 'Je viens de poster le lien de you tube'),
(49, '2018-04-30 14:51:00', 2, 56, 'Test si Ã§a marche');

-- --------------------------------------------------------

--
-- Structure de la table `links`
--

DROP TABLE IF EXISTS `links`;
CREATE TABLE IF NOT EXISTS `links` (
  `id_link` int(11) NOT NULL AUTO_INCREMENT,
  `link` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `comment_user` text NOT NULL,
  PRIMARY KEY (`id_link`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `links`
--

INSERT INTO `links` (`id_link`, `link`, `date`, `id_user`, `comment_user`) VALUES
(56, 'https://www.youtube.com/', '2018-04-30 07:41:01', 1, 'Test il est'),
(58, 'http://www.filmzenstream.com/une-vie-entre-deux-oceanss/', '2018-04-30 15:33:08', 1, 'IdÃ©e numÃ©ro 3');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `mot_de_passe`, `email`) VALUES
(1, 'jc', 'lala', 'jc@free.fr'),
(2, 'damien', 'lili', 'damien@free.fr'),
(3, 'alexis', 'popo', 'alexis@free.fr');

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `id_vote` int(11) NOT NULL AUTO_INCREMENT,
  `id_link` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type_vote` varchar(255) NOT NULL,
  `id_object` int(11) NOT NULL,
  `value_vote` varchar(255) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id_vote`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vote`
--

INSERT INTO `vote` (`id_vote`, `id_link`, `id_user`, `type_vote`, `id_object`, `value_vote`, `date`) VALUES
(14, 56, 2, 'links', 56, 'NÃ©gatif', '2018-04-30'),
(15, 56, 2, 'comments', 48, 'Positif', '2018-04-30'),
(16, 56, 2, 'comments', 40, 'Positif', '2018-04-30'),
(17, 56, 1, 'links', 56, 'Positif', '2018-04-30'),
(18, 56, 1, 'comments', 40, 'Positif', '2018-04-30');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_link`) REFERENCES `links` (`id_link`);

--
-- Contraintes pour la table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `links_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
