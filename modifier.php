<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['id_link'],$_GET['link'],$_GET['comment_user'])){
  if(droit($_GET['id_link'],'link')==true){
    last_modification_date_update($_GET['id_link']);
    modifier_article($_GET['id_link'],$_GET['link'],$_GET['comment_user']);
  }
  else{
    header("Location:pagelien.php?id_link=".$_GET['id_link']."");
    exit;
  }
}
if(isset($_GET['id_comment'],$_GET['id_link'],$_GET['content_comment'])){
  if(droit($_GET['id_comment'],'comment')==true){
    last_modification_date_update($_GET['id_link']);
    modifier_commentaire($_GET['id_comment'],$_GET['content_comment'],$_GET['id_link']);
  }
  else{
    header("Location:pagelien.php?id_link=".$_GET['id_link']."");
    exit;
  }
}
?>

<body>
  <div class="container">

    <h1>Page de modification</h1>
    <?php menu();

    if($_GET['modification']=='lien'){
      ?>

      <!-- Dans le cas où la modification porte sur le lien -->

      <section style="border:solid; margin:10px; padding:15px;">
        <?php
        $connexion = connexion();
        $requete = "SELECT * FROM links WHERE id_link='".$_GET['id_link']."'";
        $action = mysqli_query($connexion,$requete);
        $resultat=mysqli_fetch_assoc($action);
        ?>

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

      <!-- Dans le cas où la modification porte sur un commentaire -->


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


  </div>
</body>
</html>
