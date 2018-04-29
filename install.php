<?php
include("config.php");

$qDb = "CREATE DATABASE IF NOT EXISTS `projet_web`;";

$qSelDb = "USE `projet_web`;";

$qTbUsers = "CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
  ) ENGINE=InnoDB;";

$qTbLinks = "CREATE TABLE IF NOT EXISTS `links` (
    `id_link` int(11) NOT NULL AUTO_INCREMENT,
    `link` longtext NOT NULL,
    `nb_up` int(11) NOT NULL,
    `nb_down` int(11) NOT NULL,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `id_user` int(11) NOT NULL,
    PRIMARY KEY (`id_link`),
    FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`)
    ) ENGINE=InnoDB;";

$qTbComments = "CREATE TABLE IF NOT EXISTS `comments` (
      `id_comment` int(11) NOT NULL AUTO_INCREMENT,
      `link` longtext NOT NULL,
      `nb_up` int(11) NOT NULL,
      `nb_down` int(11) NOT NULL,
      `date` timestamp NOT NULL,
      `id_user` int(11) NOT NULL,
      `id_link` int(11) NOT NULL,
      PRIMARY KEY (`id_comment`),
      FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`),
      FOREIGN KEY (`id_link`) REFERENCES `links`(`id_link`)
      ) ENGINE=InnoDB;";




echo "Connexion au serveur MySQL.";
$a=mysqli_connect($GLOBALS['dbServ'], $GLOBALS['dbUser'], $GLOBALS['dbPass'], $GLOBALS['dbName']);
mysqli_query($a, $qTbUsers);
mysqli_query($a, $qTbLinks);
mysqli_query($a, $qTbComments);


mysqli_close($a);
?>
