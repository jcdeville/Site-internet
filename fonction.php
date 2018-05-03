<?php

include('config.php');

function connexion(){
  $connexion = mysqli_connect($GLOBALS['dbServ'],$GLOBALS['dbUser'],"",$GLOBALS['dbName']);
  return $connexion;
}

function deconnexion(){
  if(isset($_GET['deconnexion'])){
    update_date_last_user_connexion();
    session_destroy();
    session_start();
  }
}

function testacces(){
  if(!isset($_SESSION['id_user'],$_SESSION['pseudo'])){
    header("Location:connexion.php");
    exit;
  }
}

function droit($id_object,$type_object){
  $connexion = connexion();
  if($type_object=='link'){
    $requete = "SELECT * FROM links WHERE id_link='".$id_object."'";
  }
  elseif($type_object=='comment'){
    $requete = "SELECT * FROM comments WHERE id_comment='".$id_object."'";
  }
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  $id_user = $resultat['id_user'];
  mysqli_free_result($action);
  mysqli_close($connexion);
  if($_SESSION['id_user']==$id_user){
    return true;
  }
  return false;
}

function update_date_last_user_connexion(){
  if(isset($_SESSION['id_user'],$_SESSION['pseudo'])){
    $connexion = connexion();
    $requete = "UPDATE users SET date = '".date("Y-m-d H:i:s")."' WHERE id_user = '".$_SESSION['id_user']."'";
    $action = mysqli_prepare($connexion,$requete);
    mysqli_stmt_execute($action);
    mysqli_close($connexion);
  }
}

function menu(){
  ?>
  <nav style="border-bottom: solid;">
    <a href="accueil.php">Accueil</a>
    <a href="profil.php">Profil</a>
    <a href="connexion.php?deconnexion=ok">Deconnexion</a>
  </nav>
  <?php
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


function article($id_link){
  $connexion = connexion();
  $requete = "SELECT * FROM links WHERE id_link='".$id_link."' ORDER BY date DESC";
  $action = mysqli_query($connexion,$requete);
  $article = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $article;
}


function afficher_articles($requete){
  $connexion = connexion();
  $articles = mysqli_query($connexion,$requete);
  mysqli_close($connexion);
  return $articles;
}

function ajouter_article($link,$commentaire){
  $connexion = connexion();
  $requete = "SELECT * FROM links WHERE link='".$link."'";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);
  $commentaire = addslashes($commentaire);
  if(!$resultat){
    $insertion = "INSERT INTO links(link,id_user,comment_user) VALUES  ('".$link."','".$_SESSION['id_user']."','".$commentaire."')";
    $action = mysqli_prepare($connexion,$insertion);
    mysqli_stmt_execute($action);
  }
  mysqli_free_result($action);
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

function supprimer_article($id_link){
  $connexion = connexion();
  $supprimer = "DELETE FROM comments WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$supprimer);
  mysqli_stmt_execute($action);
  $supprimer = "DELETE FROM vote WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$supprimer);
  mysqli_stmt_execute($action);
  $supprimer = "DELETE FROM links WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$supprimer);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:accueil.php");
  exit;
}


function commentaire($id_comment){
  $connexion = connexion();
  $requete = "SELECT * FROM comments WHERE id_comment='".$id_comment."'";
  $action = mysqli_query($connexion,$requete);
  $commentaire = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $commentaire;
}

function pseudo_de_user($id_user){
  $connexion = connexion();
  $requete = "SELECT * FROM users WHERE id_user='".$id_user."'";
  $action = mysqli_query($connexion,$requete);
  $user = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $user['pseudo'];
}



function commentaires($id_link){
  $connexion = connexion();
  $requete = "SELECT * FROM comments WHERE id_link='".$id_link."' ORDER BY date DESC";
  $commentaires = mysqli_query($connexion,$requete);
  mysqli_close($connexion);
  return $commentaires;
}



function ajouter_commentaire($id_link,$commentaire){
  $connexion = connexion();
  $commentaire = addslashes($commentaire);
  $insertion = "INSERT INTO comments(id_user,id_link,content_comment)
  VALUES  ('".$_SESSION['id_user']."','".$id_link."','".$commentaire."')";
  $action = mysqli_query($connexion,$insertion);
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

function supprimer_commentaire($id_comment,$id_link){
  $connexion = connexion();
  $requete = "DELETE FROM comments WHERE id_comment='".$id_comment."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

// J'ai rajouté et je suis en train de rendre au plus propre tout ce qui est sur le vote

function trouver_vote_de_user($type_vote,$id_object){
  $connexion = connexion();
  $requete = "SELECT * FROM vote WHERE type_vote='".$type_vote."' AND id_object='".$id_object."' AND id_user='".$_SESSION['id_user']."'";
  $action = mysqli_query($connexion,$requete);
  $resultat=mysqli_fetch_assoc($action);
  return $resultat;
}

function valeur_vote_de_user($type_vote,$id_object){
  $resultat = trouver_vote_de_user($type_vote,$id_object);
  if($resultat){
    return $resultat['value_vote'];
  }
  return NULL;
}

function ajouter_vote($id_link,$type_vote,$id_object,$value_vote){
  $resultat = trouver_vote_de_user($type_vote,$id_object);
  if(!$resultat){
    $connexion = connexion();
    $insertion = "INSERT INTO vote(id_link,id_user,type_vote,id_object,value_vote)
    VALUES  ('".$id_link."','".$_SESSION['id_user']."','".$type_vote."','".$id_object."','".$value_vote."')";
    $action = mysqli_query($connexion,$insertion);
    mysqli_close($connexion);
  }
  elseif($resultat['$value_vote']!=$value_vote){
    $connexion = connexion();
    $requete = "UPDATE vote SET value_vote = '".$value_vote."' WHERE type_vote='".$type_vote."' AND id_object='".$id_object."' AND id_user='".$_SESSION['id_user']."'";
    $action = mysqli_prepare($connexion,$requete);
    mysqli_stmt_execute($action);
    mysqli_close($connexion);
  }
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

function zone_de_vote($id_link,$type_vote,$id_object){
  ?>
  <div style="border:solid; margin:10px; padding:15px;">
    <p>Zone de vote</p>

    <form action="pagelien.php" method="GET">
      <?php
      if($type_vote=='comments'){
        ?>
        <input type='hidden' name='id_link' value='<?=$id_link?>'>
        <input type='hidden' name='id_comment' value='<?=$id_object?>'>
        <input type="radio" name="value_vote" value="Positif" <?php if(valeur_vote_de_user('comments',$id_object)=="Positif") { echo 'checked="checked"' ; } ?>>Positif
        <input type="radio" name="value_vote" value="Négatif" <?php if(valeur_vote_de_user('comments',$id_object)=="Négatif") { echo 'checked="checked"' ; } ?>>Négatif
        <input type="submit" name="vote_comment" value="Voter">
        <?php
      }
      if($type_vote=='links'){
        ?>
        <input type='hidden' name='id_link' value='<?=$id_link?>'>
        <input type="radio" name="value_vote" value="Positif" <?php if(valeur_vote_de_user('links',$id_object)=="Positif") { echo 'checked="checked"' ; } ?>>Positif
        <input type="radio" name="value_vote" value="Négatif" <?php if(valeur_vote_de_user('links',$id_object)=="Négatif") { echo 'checked="checked"' ; } ?>>Négatif
        <input type="submit" name="vote_lien" value="Voter">
        <?php
      }
      ?>
    </form>

    <div style="border:solid; margin:10px; padding:15px;">
      <p>Il y a <?=compteur_vote($type_vote,$id_object,'Positif')?> votes positifs</P>
        <p>Il y a <?=compteur_vote($type_vote,$id_object,'Négatif')?> votes négatifs</P>
        </div>
      </div>
      <?php
    }


    function compteur_vote($type_vote,$id_object,$value_vote){
      $connexion = connexion();
      $requete = "SELECT COUNT(*) FROM vote WHERE type_vote='".$type_vote."' AND id_object='".$id_object."' AND value_vote='".$value_vote."'";
      $action = mysqli_query($connexion,$requete);
      $resultat = mysqli_fetch_assoc($action);
      mysqli_close($connexion);
      return $resultat['COUNT(*)'];
    }


    ?>
