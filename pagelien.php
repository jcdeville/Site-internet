<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['kill'])){
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

    <section style="border:solid; margin:10px; padding:15px;">
      <?php


      // Afficher l'article
      afficher_un_article($_GET['id_link']);

      // Afficher les boutons pour modifier l'article si on en a les droits
      if(droit($_GET['id_link'],'lien')==true){
        ?>
        <form action="pagelien.php" method="GET">
          <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
          <input type="submit" name="kill" value="Supprimer">
        </form>
        <a class="nav-link active" href="modifier.php?id_link=<?=$_GET['id_link']?>&modification=lien">Modifier</a>
        <?php
      }

      // Afficher la zone de vote de l'article
      zone_de_vote($_GET['id_link'],'links',$_GET['id_link']);
      ?>

    </section>





    <section style="border:solid; margin:10px; padding:15px;">
      <?php
      // Affiche à la fois les commentaires, les boutons pour les modifiers si on en a les droits et la zone de vote du commentaire
      afficher_commentaires($_GET['id_link']);
      ?>
    </section>




    <!!-- Affiche les boutons pour ajouter un nouvel article -->
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
