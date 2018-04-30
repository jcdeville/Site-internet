<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");
?>

<body>

  <div class="container">
    <h1>Page de profil</h1>

    <?php menu();?>

    <section style="border:solid; margin:10px; padding:15px;">
      <?php
      echo "Vous êtes connecté sur la page profil de : ".$_SESSION['pseudo']."<br/><br/>";
      echo "Votre id_user est : ".$_SESSION['id_user'];
      ?>
    </section>

    <section style="border:solid; margin:10px; padding:15px;">
      <h2>Liste des liens commentés</h2>
      <?php
      $liste_lien_commenté = "SELECT DISTINCT id_link FROM comments WHERE id_user='".$_SESSION['id_user']."' ORDER BY date DESC";
      afficher_articles($liste_lien_commenté);
      ?>
    </section>

    <section style="border:solid; margin:10px; padding:15px;">
      <h2>Liste des liens postés</h2>
      <?php
      $liste_lien_posté = "SELECT * FROM links WHERE id_user='".$_SESSION['id_user']."'";
      afficher_articles($liste_lien_posté);
      ?>
    </section>

    <section style="border:solid; margin:10px; padding:15px;">
      <h2>Liste des liens où on a émis un vote</h2>
      <?php
      $liste_lien_voté = "SELECT DISTINCT * FROM vote WHERE id_user='".$_SESSION['id_user']."' GROUP BY id_user";
      afficher_articles($liste_lien_voté);
      ?>
    </section>

  </div>

</body>
</html>
