<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['kill_article'])){
  supprimer_article($_GET['id_link']);
}
if (isset($_GET['kill_comment'])){
  supprimer_commentaire($_GET['id_comment'],$_GET['id_link']);
}
if(isset($_GET['commentaire'])){
  ajouter_commentaire($_GET['id_link'],$_GET['commentaire']);
}
if(isset($_GET['vote_lien'])){
  ajouter_vote($_GET['id_link'],'links',$_GET['id_link'],$_GET['value_vote']);
}
if(isset($_GET['vote_comment'])){
  ajouter_vote($_GET['id_link'],'comments',$_GET['id_comment'],$_GET['value_vote']);
}
?>

<body>
  <div class="container">

    <h1>Page du lien</h1>

    <?php menu();?>

    <!-- Section dédiée à l'article-->

    <section style="border:solid; margin:10px; padding:15px;">

      <!-- Afficher l'article -->

      <?php
      $article = article($_GET['id_link']);
      ?>
      <div class="row">
        <div class="col">
          <article>
            <a class="nav-link active" href="<?=$article['link']?>"><?="Lien = ".$article['link']?></a><br/>
            <span><?= "Date = ".$article['date']?></span><br/>
            <span><?="Utilisateur = ".$article['id_user']?></span><br/>
            <span><?= "Commentaire de l'utilisateur = ".$article['comment_user']?></span><br/>
            <a href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>
          </arcticle>



          <!-- Afficher les boutons pour modifier l'article si on en a les droits -->
          <?php
          if(droit($_GET['id_link'],'link')==true){
            ?>

            <form action="pagelien.php" method="GET" style="padding-bottom:15px; padding-top:15px;">
              <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
              <input type="submit" name="kill_article" value="Supprimer">
            </form>
            <form action="modifier.php" method="GET">
              <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
              <input type='hidden' name='modification' value='lien'>
              <input type="submit" name="modifier_commentaire" value="Modifier commentaire">
            </form>
            <?php
          }
          ?>
        </div>
        <div class="col">
          <?php

          // Afficher la zone de vote de l'article
          zone_de_vote($_GET['id_link'],'links',$_GET['id_link']);
          ?>
        </div>
      </div>
    </section>

    <!-- Section dédiée aux commentaires-->

    <section style="border :solid; margin:10px; padding:15px;">
      <h3>Liste des commentaires</h3>

      <?php
      $commentaires = commentaires($_GET['id_link']);
      foreach ($commentaires as $commentaire){
        ?>
        <!-- Affichage du commentaire -->
        <div class="row" style="border-top : solid;">
          <div class="col" style="margin:10px; padding:15px;">

            <article>
              <span><?= "Contenu du commentaire = ".$commentaire['content_comment']?></span><br/>
              <span><?= "Date = ".$commentaire['date']?></span><br/>
              <span><?="Utilisateur = ".pseudo_de_user($commentaire['id_user'])?></span>
            </article>



            <!-- Affichage des boutons de modification -->

            <?php
            if(droit($commentaire['id_comment'],'comment')==true){
              ?>
              <form action="pagelien.php" method="GET" style="padding-bottom:15px; padding-top:15px;">
                <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                <input type='hidden' name='id_comment' value='<?=$commentaire['id_comment']?>'>
                <input type="submit" name="kill_comment" value="Supprimer commentaire">
              </form>
              <form action="modifier.php" method="GET" >
                <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                <input type='hidden' name='modification' value='commentaire'>
                <input type='hidden' name='id_comment' value='<?=$commentaire['id_comment']?>'>
                <input type="submit" name="modifier_commentaire" value="Modifier commentaire">
              </form>

              <?php
            }
            ?>
          </div>

          <div class="col">

            <?php
            // Affiche la zone de vote pour les commentaires
            zone_de_vote($_GET['id_link'],'comments',$commentaire['id_comment']);
            ?>
          </div>
        </div>

        <?php
      }
      ?>
    </section>



    <!-- Section dédiée à l'ajout d'un commentaire-->

    <section style="border:solid; margin:10px; padding:15px;">
      <h2>Ajouter un commentaire</h2>
      <form action="pagelien.php"  method="GET">
        <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
        <p>Votre commentaire : <input type="text" name="commentaire" required/></p>
        <p><input type="submit" value="Ajouter"></p>
      </form>
    </section>


  </div>
</body>
</html>
