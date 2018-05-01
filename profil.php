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

    <!-- Informations profil -->

    <section style="border:solid; margin:10px; padding:15px;">
      <?php
      echo "Vous êtes connecté sur la page profil de : ".$_SESSION['pseudo']."<br/><br/>";
      echo "Votre id_user est : ".$_SESSION['id_user'];
      ?>
    </section>


    <!-- Partie pour visualisé tous les articles commentés -->
    <section style="border :solid; margin:10px; padding:15px;">
      <h2>Liste des liens commentés</h2>
      <?php
      $liste_lien_commenté = "SELECT DISTINCT id_link FROM comments WHERE id_user='".$_SESSION['id_user']."' ORDER BY date DESC";
      $id_links = afficher_articles($liste_lien_commenté);
      foreach ($id_links as $id_link){
        $article = article($id_link['id_link']);
        ?>
        <div class="row" style="border-top : solid;">
          <article>
            <a class="nav-link active" href="<?=$article['link']?>"><?="Lien = ".$article['link']?></a><br/>
            <span><?= "Date = ".$article['date']?></span><br/>
            <span><?="Utilisateur = ".$article['id_user']?></span><br/>
            <span><?= "Commentaire de l'utilisateur = ".$article['comment_user']?></span><br/>
            <a href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>
          </arcticle>
        </div>
        <?php
      }
      ?>
    </section>


    <!-- Partie pour visualisé tous les articles postés -->
    <section style="border :solid; margin:10px; padding:15px;">
      <h2>Liste des liens postés</h2>
      <?php
      $liste_lien_posté = "SELECT * FROM links WHERE id_user='".$_SESSION['id_user']."'  ORDER BY date DESC";
      $id_links = afficher_articles($liste_lien_posté);
      foreach ($id_links as $id_link){
        $article = article($id_link['id_link']);
        ?>
        <div class="row" style="border-top : solid;">
          <article>
            <a class="nav-link active" href="<?=$article['link']?>"><?="Lien = ".$article['link']?></a><br/>
            <span><?= "Date = ".$article['date']?></span><br/>
            <span><?="Utilisateur = ".$article['id_user']?></span><br/>
            <span><?= "Commentaire de l'utilisateur = ".$article['comment_user']?></span><br/>
            <a href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>
          </arcticle>
        </div>
        <?php
      }
      ?>
    </section>

    <!-- Partie pour visualisé tous les articles votés -->
    <section style="border :solid; margin:10px; padding:15px;">
      <h2>Liste des liens votés</h2>
      <?php
      $liste_lien_voté = "SELECT DISTINCT * FROM vote WHERE id_user='".$_SESSION['id_user']."' GROUP BY id_link ORDER BY date DESC";
      $id_links = afficher_articles($liste_lien_voté);
      foreach ($id_links as $id_link){
        $article = article($id_link['id_link']);
        ?>
        <div class="row" style="border-top : solid;">
          <article>
            <a class="nav-link active" href="<?=$article['link']?>"><?="Lien = ".$article['link']?></a><br/>
            <span><?= "Date = ".$article['date']?></span><br/>
            <span><?="Utilisateur = ".$article['id_user']?></span><br/>
            <span><?= "Commentaire de l'utilisateur = ".$article['comment_user']?></span><br/>
            <a href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>
          </arcticle>
        </div>
        <?php
      }
      ?>
    </section>


  </div>

</body>
</html>
