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
  ajouter_commentaire($_SESSION['id_user'],$_GET['id_link'],$_GET['commentaire']);
}

?>

<body>
  <div class="container">

    <h1>Page du lien</h1>

    <?php menu();?>
    <section>

      <!-- Afficher l'article souhaité -->
      <?php
      afficher_un_article($_GET['id_link']);
      // Afficher l'article souhaité

      afficher_commentaires();

      // Gérer l'article
      if($_SESSION['id_user']==droit_article($_GET['id_link'])){
        ?>

        <form action="pagelien.php" method="GET">
          <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
          <input type="submit" name="kill" value="Supprimer">
        </form>
        <a class="nav-link active" href="modifier.php?id_link=<?=$_GET['id_link']?>&modification=lien">Modifier</a>
        <?php
        // Gérer l'article
      }



      ?>

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
