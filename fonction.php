<?php

function connexion(){
  $connexion = mysqli_connect("localhost","root","","projet_web");
  return $connexion;
}

function deconnexion(){
  if(isset($_SESSION['id_user']) || isset($_SESSION['pseudo'])){
    session_destroy();
  }
}

function testacces(){
  if(!isset($_SESSION['id_user']) || !isset($_SESSION['pseudo'])){
    header("Location:connexion.php");
    exit;
  }
}

function inscription($pseudo,$mot_de_passe,$email){
  $connexion=connexion();
  $insertion = "INSERT INTO users(pseudo,mot_de_passe,email) VALUES  ('".$pseudo."','".$mot_de_passe."','".$email."')";
  $action=mysqli_query($connexion,$insertion);

  // Se connnecte directement
  $selection = "SELECT * FROM users WHERE pseudo='".$pseudo."'";
  $action = mysqli_query($connexion,$selection);
  $resultat=mysqli_fetch_assoc($action);
  session_start();
  $_SESSION['id_user'] = $resultat['id_user'];
  $_SESSION['pseudo'] = $resultat['pseudo'];
  mysqli_close($connexion);
  ?>

  <script>
  var stay=alert("Inscription réussie")
  if (!stay)
    window.location="accueil.php"
  </script>

  <?php
}

function menu(){
  ?>
  <nav>
  <a href="accueil.php">Accueil</a>
  <a href="profil.php">Profil</a>
  <a c href="connexion.php?deconnexion=ok">Deconnexion</a>
  </nav>
  <?php
}


function afficher_articles_user($id_user){
  $connexion = connexion();
  $requete = "SELECT * FROM links WHERE id_user='".$id_user."'";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  while($resultat){
    afficher_un_article($resultat['id_link']);
    ?>
    <a  href="pagelien.php?id_link=<?=$resultat['id_link']?>">Ouvrir page du lien</a>
    <?php
    $resultat=mysqli_fetch_assoc($action);
  }
  mysqli_free_result($action);
  mysqli_close($connexion);
}




function afficher_un_article($id_link){
  $connexion = connexion();
  $requete = "SELECT * FROM links WHERE id_link='".$id_link."'";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  if($resultat){
    ?>
    <div class="row" style="border-bottom : solid; border-top : solid;">
      <article>
        <h2><a class="nav-link active" href="<?=$resultat['link']?>"> <?="Lien = ".$resultat['link']?></a></h2>
        <br/>
        <br/>
        <span><?= "Date = ".$resultat['date']?></span>
        <br/>
        <br/>
        <span><?="Utilisateur = ".$resultat['id_user']?></span>
        <br/>
        <br/>
        <span><?= "Commentaire de l'utilisateur = ".$resultat['comment_user']?></span>
      </arcticle>
    </div>
    <?php
  }
  mysqli_free_result($action);
  mysqli_close($connexion);
}


function afficher_articles(){
  $connexion = connexion();
  $requete = "SELECT * FROM links ORDER BY date DESC";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  while($resultat){
    afficher_un_article($resultat['id_link']);
    ?>
    <a  href="pagelien.php?id_link=<?=$resultat['id_link']?>">Ouvrir page du lien</a>
    <?php
    $resultat=mysqli_fetch_assoc($action);
  }
  mysqli_free_result($action);
  mysqli_close($connexion);
}


function supprimer_article($id_link){
  $connexion = connexion();
  $supprimer = "DELETE FROM comments WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$supprimer);
  mysqli_stmt_execute($action);

  $requete = "DELETE FROM links WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:accueil.php");
  exit;
}

function modifier_article($id_link,$link,$comment_user){
  $connexion = connexion();
  $requete = "UPDATE links SET link = '".$link."', comment_user = '".$comment_user."' WHERE id_link = '".$id_link."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

function droit_article($id_link){
  $connexion = connexion();
  $requete = "SELECT * FROM links WHERE id_link='".$id_link."'";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  $id_user = $resultat['id_user'];
  mysqli_free_result($action);
  mysqli_close($connexion);
  return $id_user;
}

function ajouter_lien($link,$commentaire){
  $connexion=connexion();
  $requete = "SELECT * FROM links WHERE link='".$link."'";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);

  if(!$resultat){
    $insertion = "INSERT INTO links(link,nb_up,nb_down,date,id_user,comment_user) VALUES  ('".$link."',0,0,'".date("Y-m-d H:i:s")."','".$_SESSION['id_user']."','".$commentaire."')";
    $action=mysqli_query($connexion,$insertion);
  }
  else{
    ?>

    <script>
    var stay=alert("Lien déjà existant!")
    if (!stay)
    window.location="accueil.php"
    </script>

    <?php
  }
  mysqli_close($connexion);
}



function ajouter_commentaire($id_user,$id_link,$commentaire){
  $connexion=connexion();
  $insertion = "INSERT INTO comments(nb_up,nb_down,date,id_user,id_link,content_comment) VALUES  (0,0,'".date("Y-m-d H:i:s")."','".$_SESSION['id_user']."','".$id_link."','".$commentaire."')";
  $action=mysqli_query($connexion,$insertion);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}


function afficher_un_commentaire($id_comment){
  $connexion = connexion();
  $requete = "SELECT * FROM comments WHERE id_comment='".$id_comment."'";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);

  // Récupère le pseudo de l'utilisateur ayant posté le commentaire
  $requete = "SELECT * FROM users WHERE id_user='".$resultat['id_user']."'";
  $action = mysqli_query($connexion,$requete);
  $user = mysqli_fetch_assoc($action);

  if($resultat){
    ?>
    <div class="row" style="border-bottom : solid; border-top : solid;">
      <article>
        <span><?=$resultat['content_comment']?></span>
        <br/>
        <span><?= "Date = ".$resultat['date']?></span>
        <br/>
        <span><?="Utilisateur = ".$user['pseudo']?></span>
      </arcticle>
    </div>
    <?php
  }
  mysqli_free_result($action);
  mysqli_close($connexion);
}

function afficher_commentaires(){
  $connexion = connexion();
  $requete = "SELECT * FROM comments ORDER BY date DESC";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  while($resultat){
    afficher_un_commentaire($resultat['id_comment']);
    // Dans le cas où l'utilisateur est propriétaire du commentaire
    if($_SESSION['id_user']==droit_commentaire($resultat['id_comment'])){
      echo "Je suis modifiable";
      ?>

      <form action="pagelien.php" method="GET">
        <input type='hidden' name='id_link' value='<?=$resultat['id_link']?>'>
        <input type='hidden' name='id_comment' value='<?=$resultat['id_comment']?>'>
        <input type="submit" name="kill_comment" value="Supprimer commentaire">
      </form>
      <a class="nav-link active" href="modifier.php?id_link=<?=$resultat['id_link']?>&modification='commentaire'&id_comment=<?=$resultat['id_comment']?>">Modifier</a>

      <?php
    }
    $resultat=mysqli_fetch_assoc($action);
  }
  mysqli_free_result($action);
  mysqli_close($connexion);
}

function droit_commentaire($id_comment){
  $connexion = connexion();
  $requete = "SELECT * FROM comments WHERE id_comment='".$id_comment."'";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  $id_user = $resultat['id_user'];
  mysqli_free_result($action);
  mysqli_close($connexion);
  return $id_user;
}



function supprimer_commentaire($id_comment,$id_link){
  $connexion = connexion();
  $requete = "DELETE FROM comments WHERE id_comment='".$id_comment."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

function modifier_commentaire($id_comment,$content_comment,$id_link){
  $connexion = connexion();
  $requete = "UPDATE comments SET content_comment = '".$_GET['content_comment']."' WHERE id_comment = '".$_GET['id_comment']."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

?>
