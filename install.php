<?php
include("config.php");
$qDb = "CREATE DATABASE IF NOT EXISTS `projet`;";
$qSelDb = "USE `projet`;";

$deletTbtUsers = "DROP TABLE IF EXISTS `users`;";

$qTbUsers = "CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB;";

$qInitTbtUsers = "INSERT INTO `users` (`pseudo`, `mot_de_passe`, `email`) VALUES
('max', 'max', 'max@free.fr'),
('bob', 'bob', 'bob@free.fr');";

$deletTbtLinks = "DROP TABLE IF EXISTS `links`;";

$qTbLinks = "CREATE TABLE IF NOT EXISTS `links` (
  `id_link` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) NOT NULL,
  `link` longtext NOT NULL,
  `id_user` int(11) NOT NULL,
  `comment_user` text NOT NULL,
  `interaction_number` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modification_date` timestamp NOT NULL,
  PRIMARY KEY (`id_link`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB;";

$qInitTbtLinks = "INSERT INTO `links` (  `link_name`,`link`, `id_user`, `comment_user`,`interaction_number`) VALUES
('moteur de recherche','https://www.google.fr/', 1, 'Je viens d\'ajouter le lien de google',0);";

$deletTbtComments = "DROP TABLE IF EXISTS `comments`;";

$qTbComments = "CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL,
  `id_link` int(11) NOT NULL,
  `content_comment` text NOT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `id_user` (`id_user`),
  KEY `id_link` (`id_link`)
) ENGINE=InnoDB;";
$qInitTbtComments = "INSERT INTO `comments` (`id_user`, `id_link`, `content_comment`) VALUES
(2, 1, 'Excellent site pour faire des recherches!');";

$deletTbtVotes = "DROP TABLE IF EXISTS `votes`;";

$qTbVotes = "CREATE TABLE IF NOT EXISTS `votes` (
  `id_vote` int(11) NOT NULL AUTO_INCREMENT,
  `id_link` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `type_vote` varchar(255) NOT NULL,
  `id_object` int(11) NOT NULL,
  `value_vote` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_vote`),
  KEY `id_user` (`id_user`),
  KEY `id_link` (`id_link`)
) ENGINE=InnoDB;";

$qInitTbtVotes = "INSERT INTO `votes` (`id_link`, `id_user`, `type_vote`, `id_object`, `value_vote`) VALUES
(1, 1, 'comments', '1', 'upvote');";

$deletTbtFavoris = "DROP TABLE IF EXISTS `favoris`;";

$qTbFavoris = "CREATE TABLE IF NOT EXISTS `favoris` (
  `id_favoris` int(11) NOT NULL AUTO_INCREMENT,
  `id_link` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_favoris`),
  KEY `id_user` (`id_user`),
  KEY `id_link` (`id_link`)
) ENGINE=InnoDB;";

echo "Connexion au serveur MySQL.</br>";
$connexion = mysqli_connect($GLOBALS['dbServ'], $GLOBALS['dbUser'], $GLOBALS['dbPass'], $GLOBALS['dbName']);
echo "Création de la table users.</br>";
mysqli_query($connexion, $deletTbtUsers);
mysqli_query($connexion, $qTbUsers);
mysqli_query($connexion, $qInitTbtUsers);
echo "Création de la table links.</br>";
mysqli_query($connexion, $deletTbtLinks);
mysqli_query($connexion, $qTbLinks);
mysqli_query($connexion, $qInitTbtLinks);
echo "Création de la table comments.</br>";
mysqli_query($connexion, $deletTbtComments);
mysqli_query($connexion, $qTbComments);
mysqli_query($connexion, $qInitTbtComments);
echo "Création de la table votes.</br>";
mysqli_query($connexion, $deletTbtVotes);
mysqli_query($connexion, $qTbVotes);
mysqli_query($connexion, $qInitTbtVotes);
echo "Création de la table favoris.</br>";
mysqli_query($connexion, $deletTbtFavoris);
mysqli_query($connexion, $qTbFavoris);
mysqli_close($connexion);
?>
