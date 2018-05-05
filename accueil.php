<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['link'],$_GET['commentaire'])){
  ajouter_article($_GET['link'],$_GET['commentaire']);
}
?>

<body>
  <div class="container">
    <h1>Page d'accueil</h1>

    <?php menu(); ?>

    <section style="border:solid; margin:10px; padding:15px;">
      <!-- Partie pour ajouté un article -->
      <h3>Ajouter un lien</h3>
      <form action="accueil.php"  method="GET">
        <p>Votre link : <input type="url" name="link" required/></p>
        <p>Votre commentaire : <input type="text" name="commentaire" required/></p>
        <p><input type="submit" value="Ajouter"></p>
      </form>
    </section>

    <!-- Partie pour visualisé les 5 articles ayant eux le plus d'intéractions dans la journée-->
    <section style="border :solid; margin:10px; padding:15px;">
      <h3>Liste des 5 liens ayant eux le plus d'intéractions dans la journée</h3>
      <?php
      interaction_number_update();
      $liste_lien ="SELECT * FROM links ORDER BY interaction_number DESC LIMIT 5";
      $articles = selectionner_id_link($liste_lien);
      foreach ($articles as $article){
        ?>
        <div class="row" style="border-top : solid;">
          <article>
            <a class="nav-link active" href="<?=$article['link']?>"><?="Lien = ".$article['link']?></a><br/>
            <span><?= "Date = ".$article['date']?></span><br/>
            <span><?="Utilisateur = ".$article['id_user']?></span><br/>
            <span><?= "Commentaire de l'utilisateur = ".$article['comment_user']?></span><br/>

            <!-- Zone php à supprimer -->
            <?php
            $nombre_interaction = compteur_interaction($article['id_link']);
            echo "Il y a eu ".$nombre_interaction." intéractions sur cet article.</br>";
            ?>

            <a href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>
          </arcticle>
        </div>
        <?php
      }
      ?>
    </section>


    <!-- Partie pour visualisé tous les articles postés il y a 24 heures -->

    <section style="border :solid; margin:10px; padding:15px;">
      <h3>Liste des nouveautés qu’il y a eu depuis la dernière connexion de l'utilisateur pour les liens ou il avait interagi dans les dernière 24h.</h3>
      <?php

      // Il faut revoir la requête car elle ne sélectionne pas et ne classe pas les liens de la bonne manière
      // Peut être qu'il faut faire une union ou une jointure
      /*
      $liste_lien_24H ="SELECT DISTINCT id_link FROM links WHERE id_user = '".$_SESSION['id_user']."'
      UNION
      SELECT DISTINCT id_link FROM comments WHERE id_user = '".$_SESSION['id_user']."'
      UNION
      SELECT DISTINCT id_link FROM votes  WHERE id_user = '".$_SESSION['id_user']."'";


      SELECT * FROM ((
SELECT * FROM table1
WHERE ...
ORDER BY ...
LIMIT ...
) UNION (
SELECT * FROM table2
WHERE ...
ORDER BY ...
LIMIT ...
)) as t
WHERE ...
ORDER BY ...

      $liste_lien_24H = "(SELECT DISTINCT id_link FROM links WHERE id_user = '".$_SESSION['id_user']."' AND )
      UNION
      (SELECT DISTINCT id_link FROM comments WHERE id_user = '".$_SESSION['id_user']."')
      ORDER BY a LIMIT 10";

      */


      $liste_lien_24H = "SELECT * FROM links";
      $action = selectionner_id_link($liste_lien_24H);
      foreach ($action as $resultat){
        $article = article($resultat['id_link']);
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
