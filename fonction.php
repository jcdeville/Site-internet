<?php

include('config.php');

// Permet de se connecter à la base de donnée
function connexion(){
  $connexion = mysqli_connect($GLOBALS['dbServ'],$GLOBALS['dbUser'],$GLOBALS['dbPass'],$GLOBALS['dbName']);
  return $connexion;
}

// Permet de se déconnecter
function deconnexion(){
  if(isset($_GET['deconnexion'])){
    update_date_last_user_connexion();
    session_destroy();
    session_start();
  }
}

// Renvoie à la page de de connexion si l'utilisateur ne s'est pas identifié
function testacces(){
  if(!isset($_SESSION['id_user'],$_SESSION['pseudo'])){
    header("Location:connexion.php");
    exit;
  }
}

// Vérifie que l'utilisateur est propriétaire du lien ou du commentaire
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

// Met à jour la date de connexion de l'utilisateur
function update_date_last_user_connexion(){
  if(isset($_SESSION['id_user'],$_SESSION['pseudo'])){
    $connexion = connexion();
    $requete = "UPDATE users SET date = '".date("Y-m-d H:i:s")."' WHERE id_user = '".$_SESSION['id_user']."'";
    $action = mysqli_prepare($connexion,$requete);
    mysqli_stmt_execute($action);
    mysqli_close($connexion);
  }
}
//regarde si le pseudo exite deja
function user_existant($pseudo){
  $connexion = connexion();
  $requete = "SELECT * FROM users WHERE pseudo='".$pseudo."'";
  $action = mysqli_query($connexion,$requete);
  $user = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $user['pseudo'];
}

//regarde si l'adresse mail est déjà prise
function email_existant($email){
  $connexion = connexion();
  $requete = "SELECT * FROM users WHERE email='".$email."'";
  $action = mysqli_query($connexion,$requete);
  $user = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $user['email'];
}

// Crée un compte et connecte l'utilisateur
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

// Retourne les informations d'un lien posté (un article est composé d'un lien et de son commentaire écrit pas celui qui l'a posté)
function article($id_link){
  $connexion = connexion();
  $requete = "SELECT * FROM links WHERE id_link='".$id_link."'";
  $action = mysqli_query($connexion,$requete);
  $article = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $article;
}

// Retourne un ensemble de id de lien suite à requête
function selectionner_id_link($requete){
  $connexion = connexion();
  $action = mysqli_query($connexion,$requete);
  $assoc = mysqli_fetch_all($action, MYSQLI_ASSOC);
  mysqli_free_result($action);
  mysqli_close($connexion);
  return $assoc;
}

// Ajouter un lien
function ajouter_article($link_name,$link,$commentaire){
  $connexion = connexion();
  $requete = "SELECT * FROM links WHERE link='".$link."'";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);
  $commentaire = addslashes($commentaire);
  if(!$resultat){
    $insertion = "INSERT INTO links(link_name,link,id_user,comment_user,interaction_number) VALUES  ('".$link_name."','".$link."','".$_SESSION['id_user']."','".$commentaire."',0)";
    $action = mysqli_prepare($connexion,$insertion);
    mysqli_stmt_execute($action);
  }
  mysqli_free_result($action);
  mysqli_close($connexion);
  header("Location:accueil.php");
  exit;
}

// Modifier un lien et son commentaire
function modifier_article($id_link,$link,$comment_user){
  $connexion = connexion();
  $requete = "UPDATE links SET link = '".$link."', comment_user = '".$comment_user."', date = NOW(), last_modification_date = NOW() WHERE id_link = '".$id_link."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

// Supprimer un article, son commentaire, les commentaires et les votes associés
function supprimer_article($id_link){
  $connexion = connexion();
  $supprimer = "DELETE FROM comments WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$supprimer);
  mysqli_stmt_execute($action);
  $supprimer = "DELETE FROM votes  WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$supprimer);
  mysqli_stmt_execute($action);
  $supprimer = "DELETE FROM links WHERE id_link='".$id_link."'";
  $action = mysqli_prepare($connexion,$supprimer);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:accueil.php");
  exit;
}

// Retourne le pseudo d'un utilisateur selon son id d'utilisateur
function pseudo_de_user($id_user){
  $connexion = connexion();
  $requete = "SELECT * FROM users WHERE id_user='".$id_user."'";
  $action = mysqli_query($connexion,$requete);
  $user = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $user['pseudo'];
}

// Retourne les informations d'un commentaire posté sur un lien
function commentaire($id_comment){
  $connexion = connexion();
  $requete = "SELECT * FROM comments WHERE id_comment='".$id_comment."'";
  $action = mysqli_query($connexion,$requete);
  $commentaire = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $commentaire;
}

// Retourne l'ensemble les commentaires associés à un lien
function commentaires($id_link){
  $connexion = connexion();
  $requete = "SELECT * FROM comments WHERE id_link='".$id_link."' ORDER BY date DESC";
  $action = mysqli_query($connexion,$requete);
  $assoc = mysqli_fetch_all($action, MYSQLI_ASSOC);
  mysqli_free_result($action);
  mysqli_close($connexion);
  return $assoc;
}


// Ajoute un commentaire
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

// Modifie un commentaire
function modifier_commentaire($id_comment,$content_comment,$id_link){
  $connexion = connexion();
  $requete = "UPDATE comments SET content_comment = '".$_GET['content_comment']."', date = NOW() WHERE id_comment = '".$_GET['id_comment']."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

// Supprime un commentaire et ses votes associés
function supprimer_commentaire($id_comment,$id_link){
  $connexion = connexion();
  $requete = "DELETE FROM votes  WHERE id_object = '".$id_comment."' AND type_vote = 'comments'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  $requete = "DELETE FROM comments WHERE id_comment='".$id_comment."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
  header("Location:pagelien.php?id_link=".$id_link."");
  exit;
}

// Retourne les informations d'un vote de l'utilisateur pour un commentaire en particulier
function trouver_vote_de_user($type_vote,$id_object){
  $connexion = connexion();
  $requete = "SELECT * FROM votes  WHERE type_vote='".$type_vote."' AND id_object='".$id_object."' AND id_user='".$_SESSION['id_user']."'";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);
  return $resultat;
}

// Retourne la valeur d'un vote de l'utilisteur pour un commentaire en particulier
function valeur_vote_de_user($type_vote,$id_object){
  $resultat = trouver_vote_de_user($type_vote,$id_object);
  if($resultat){
    return $resultat['value_vote'];
  }
  return NULL;
}

// Ajoute un vote à un commentaire ou le modifie si il existe déjà
function ajouter_vote($id_link,$type_vote,$id_object,$value_vote){
  $resultat = trouver_vote_de_user($type_vote,$id_object);
  if(!$resultat){
    $connexion = connexion();
    $insertion = "INSERT INTO votes (id_link,id_user,type_vote,id_object,value_vote)
    VALUES  ('".$id_link."','".$_SESSION['id_user']."','".$type_vote."','".$id_object."','".$value_vote."')";
    $action = mysqli_prepare($connexion,$insertion);
    mysqli_stmt_execute($action);
    mysqli_close($connexion);
  }
  elseif($resultat['value_vote']!=$value_vote){
    $connexion = connexion();
    $requete = "UPDATE votes  SET value_vote = '".$value_vote."', date = NOW() WHERE type_vote='".$type_vote."' AND id_object='".$id_object."' AND id_user='".$_SESSION['id_user']."'";
    $action = mysqli_prepare($connexion,$requete);
    mysqli_stmt_execute($action);
    mysqli_close($connexion);
  }
  else {
    $connexion = connexion();
    $requete = "DELETE FROM votes WHERE type_vote='".$type_vote."' AND id_object='".$id_object."' AND id_user='".$_SESSION['id_user']."'";
    $action = mysqli_prepare($connexion,$requete);
    mysqli_stmt_execute($action);
    mysqli_close($connexion);

  }
}


// regarde si l'utilisateur a mit le lien en favoris
function lien_favoris($id_link){
  $connexion = connexion();
  $requete = "SELECT * FROM favoris  WHERE id_link='".$id_link."' AND id_user='".$_SESSION['id_user']."' ";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);
  if(isset($resultat['id_favoris'])){
    return $resultat['id_link'];
  }
else {
  return NULL;
}
}
// Ajoute au favoris
function ajouter_favoris($id_link){
  $resultat=lien_favoris($id_link);
  if(!$resultat){
    $connexion = connexion();
    $insertion = "INSERT INTO favoris (id_link,id_user)
    VALUES ('".$id_link."','".$_SESSION['id_user']."')";
    $action = mysqli_prepare($connexion,$insertion);
    mysqli_stmt_execute($action);
    mysqli_close($connexion);
}
else {
  $connexion = connexion();
  $requete = "DELETE FROM favoris WHERE id_link='".$id_link."' AND id_user='".$_SESSION['id_user']."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);

}
}


// Affiche une zone de vote pour le commentaire et affiche le vote de l'utilisteur si il a déjà voté
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
        <input type="radio" name="value_vote" value="upvote" <?php if(valeur_vote_de_user('comments',$id_object)=="upvote") { echo 'checked="checked"' ; } ?>>upvote
        <input type="radio" name="value_vote" value="downvote" <?php if(valeur_vote_de_user('comments',$id_object)=="downvote") { echo 'checked="checked"' ; } ?>>downvote
        <input type="submit" name="vote_comment" value="Voter">
        <?php
      }
      if($type_vote=='links'){
        ?>
        <input type='hidden' name='id_link' value='<?=$id_link?>'>
        <input type="radio" name="value_vote" value="upvote" <?php if(valeur_vote_de_user('links',$id_object)=="upvote") { echo 'checked="checked"' ; } ?>>upvote
        <input type="radio" name="value_vote" value="downvote" <?php if(valeur_vote_de_user('links',$id_object)=="downvote") { echo 'checked="checked"' ; } ?>>downvote
        <input type="submit" name="vote_lien" value="Voter">
        <?php
      }
      ?>
    </form>

    <div style="border:solid; margin:10px; padding:15px;">
      <p>Il y a <?=compteur_vote($type_vote,$id_object,'upvote')?> votes upvotes</p>
      <p>Il y a <?=compteur_vote($type_vote,$id_object,'downvote')?> votes downvotes</p>
    </div>

  </div>
  <?php
}

// Renvoie le nombre de votes upvotes ou downvotes associés à un commentaire
function compteur_vote($type_vote,$id_object,$value_vote){
  $connexion = connexion();
  $requete = "SELECT COUNT(*) FROM votes  WHERE type_vote='".$type_vote."' AND id_object='".$id_object."' AND value_vote='".$value_vote."'";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);
  mysqli_close($connexion);
  return $resultat['COUNT(*)'];
}

// Renvoie le nombre d'intéraction qu'il a eu avec un lien (commentaires et votes) depuis le début de lajournée
function compteur_interaction($id_link){
  $nombre_interaction = 0;
  $connexion = connexion();
  $requete = "SELECT COUNT(*) FROM comments WHERE id_link='".$id_link."' AND date >= CURDATE()";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);
  mysqli_free_result($action);

  $nombre_interaction = $nombre_interaction + $resultat['COUNT(*)'];

  $requete = "SELECT COUNT(*) FROM votes  WHERE id_link='".$id_link."' AND date >= CURDATE()";
  $action = mysqli_query($connexion,$requete);
  $resultat = mysqli_fetch_assoc($action);

  $nombre_interaction = $nombre_interaction + $resultat['COUNT(*)'];

  mysqli_free_result($action);
  mysqli_close($connexion);
  return $nombre_interaction;
}

// Met à jour le nombre d'intéraction de tous les articles depuis le début de lajournée
function interaction_number_update(){
  $connexion = connexion();
  $liste_lien = "SELECT * FROM links";
  $articles = selectionner_id_link($liste_lien);
  foreach ($articles as $article){
    $nombre_interaction = compteur_interaction($article['id_link']);
    $requete = "UPDATE links SET interaction_number = '".$nombre_interaction."' WHERE id_link = '".$article['id_link']."'";
    $action = mysqli_prepare($connexion,$requete);
    mysqli_stmt_execute($action);
  }
  mysqli_close($connexion);
}

// Met à jour la date de la dernière intéraction
function last_modification_date_update($id_link){
  $connexion = connexion();
  $requete = "UPDATE links SET last_modification_date = NOW() WHERE id_link = '".$id_link."'";
  $action = mysqli_prepare($connexion,$requete);
  mysqli_stmt_execute($action);
  mysqli_close($connexion);
}

function menu_vote($type_vote,$page_web,$id_link,$id_object){?>
  <div class="card-footer zone_vote">
    <form class="form_share" action='<?=$page_web?>'  method="GET">
      <?php
      if ($type_vote=='comments') {
        ?>
        <input type='hidden' name='id_comment' value='<?=$id_object?>'>
        <input type='hidden' name='id_link' value='<?=$id_link?>'>
        <?php
        if (valeur_vote_de_user($type_vote,$id_object)=='upvote' ) {
          ?>
             <input type="submit"  class="btn btn-success" name="value_vote" value="upvote">

          <?php
            }
            else{
              ?>
              <input type="submit"  class="btn btn-outline-success" name="value_vote" value="upvote">
          <?php
            }
          echo compteur_vote($type_vote,$id_object,'upvote');

          if (valeur_vote_de_user($type_vote,$id_object)=='downvote' ) {
            ?>
               <input type="submit"  class="btn btn-danger" name="value_vote" value="downvote">
            <?php  }
              else {?>
              <input type="submit"  class="btn btn-outline-danger" name="value_vote" value="downvote">
            <?php  }
            echo compteur_vote($type_vote,$id_object,'downvote');
      }

      else{
        ?>
      <input type='hidden' name='id_link' value='<?=$id_link?>'>
      <?php
      if (valeur_vote_de_user($type_vote,$id_link)=='upvote' ) {
        ?>
           <input type="submit"  class="btn btn-success" name="value_vote" value="upvote">

        <?php
          }
          else{
            ?>
            <input type="submit"  class="btn btn-outline-success" name="value_vote" value="upvote">

        <?php
          }
        echo compteur_vote($type_vote,$id_link,'upvote');
        if (valeur_vote_de_user($type_vote,$id_link)=='downvote' ) {
          ?>
             <input type="submit"  class="btn btn-danger" name="value_vote" value="downvote">

          <?php  }
            else {?>
            <input type="submit"  class="btn btn-outline-danger" name="value_vote" value="downvote">

          <?php  }
          echo compteur_vote($type_vote,$id_link,'downvote');
    }
    if($type_vote=='links' && lien_favoris($id_link)==NULL){
      ?><input type="submit"  class="btn btn-outline-warning" name="favoris" value="favoris"><?php
    }
    else {
      ?><input type="submit"  class="btn btn-warning" name="favoris" value="favoris"><?php
    }
    ?>
  </form>
</div>
  <?php

}

?>
