<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

// Regarde si une modification a été faite

if (isset($_GET['id_link'],$_GET['link'],$_GET['comment_user'])){
  modifier_article($_GET['id_link'],$_GET['link'],$_GET['comment_user']);
}


if (isset($_GET['id_comment'],$_GET['content_comment'],$_GET['id_link'])){
  modifier_commentaire($_GET['id_comment'],$_GET['content_comment'],$_GET['id_link']);
}

// Regarde si une modification a été faite

?>

<body>
  <div class="container">

    <h1>Page de modification</h1>
    <?php menu();

    if($_GET['modification']=='lien'){
      ?>

      <section>
        <?php
        $connexion = connexion();
        $requete = "SELECT * FROM links WHERE id_link='".$_GET['id_link']."'";
        $action = mysqli_query($connexion,$requete);
        $resultat=mysqli_fetch_assoc($action);
        ?>
        <a class="nav-link active" href="http://localhost/Tuto/pagelien.php?id_link=<?=$_GET['id_link']?>">Page lien</a>

        <form action="modifier.php"  method="GET">
          <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
          <input type='hidden' name='modification' value='lien'>
          <p>Votre link : <input type="url" name="link" value='<?=$resultat['link']?>' required/></p>
          <p>Votre commentaire : <br/><textarea name="comment_user" value=""><?=$resultat['comment_user']?></textarea></p>
          <p><input type="submit" value="Modifier"></p>
        </form>

      </section>

      <?php
    }
    else{

      ?>

      <section>
        <?php
        $connexion = connexion();
        $requete = "SELECT * FROM comments WHERE id_comment='".$_GET['id_comment']."'";
        $action = mysqli_query($connexion,$requete);
        $resultat=mysqli_fetch_assoc($action);
        ?>
        <a class="nav-link active" href="http://localhost/Tuto/pagelien.php?id_link=<?=$_GET['id_link']?>">Page lien</a>

        <form action="modifier.php"  method="GET">
          <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
          <input type='hidden' name='modification' value='commentaire'>
          <input type='hidden' name='id_comment' value='<?=$_GET['id_comment']?>'>
          <p>Votre commentaire : <br/><textarea name="content_comment" value=""><?=$resultat['content_comment']?></textarea></p>
          <p><input type="submit" value="Modifier"></p>
        </form>

      </section>

      <?php
    }
    ?>


    <!-- Permet de voir le contenu de l'article et de le modifier -->



    <!-- Permet de voir le contenu de l'article et de le modifier -->

  </div>
</body>
</html>
