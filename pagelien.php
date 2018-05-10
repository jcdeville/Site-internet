<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['kill_article'])){
  supprimer_article($_GET['id_link']);
}
if (isset($_GET['kill_comment'])){
  last_modification_date_update($_GET['id_link']);
  supprimer_commentaire($_GET['id_comment'],$_GET['id_link']);
}
if(isset($_GET['commentaire'])){
  last_modification_date_update($_GET['id_link']);
  ajouter_commentaire($_GET['id_link'],$_GET['commentaire']);
}

if(isset($_GET['vote_comment'])){
  last_modification_date_update($_GET['id_link']);
  ajouter_vote($_GET['id_link'],'comments',$_GET['id_comment'],$_GET['value_vote']);
}

if(isset($_GET['value_vote'])){
 last_modification_date_update($_GET['id_link']);
 ajouter_vote($_GET['id_link'],'links',$_GET['id_link'],$_GET['value_vote']);
 header("Location:pagelien.php?id_link=".$_GET['id_link']."");
}
if(isset($_GET['value_vote'])){
 last_modification_date_update($_GET['id_link']);
 ajouter_vote($_GET['id_link'],'comments',$_GET['id_comment'],$_GET['value_vote']);
 header("Location:pagelien.php?id_link=".$_GET['id_link']."");
}
if (isset($_GET['id_link'],$_GET['link'],$_GET['comment_user'],$_GET['modification'],$_GET['modifier'])){
  if(droit($_GET['id_link'],'link')==true){
    last_modification_date_update($_GET['id_link']);
    modifier_article($_GET['id_link'],$_GET['link'],$_GET['comment_user']);
  }
}
if(isset($_GET['id_comment'],$_GET['id_link'],$_GET['content_comment'],$_GET['modification'],$_GET['modifier'])){
  if(droit($_GET['id_comment'],'comment')==true){
    last_modification_date_update($_GET['id_link']);
    modifier_commentaire($_GET['id_comment'],$_GET['content_comment'],$_GET['id_link']);
  }
}
?>

<body>
  <!-- header -->
  <header class="container-fluid header">
    <div class="container">
      <a href="#" class="logo">nom du site</a>
      <nav class="menu">
        <a href="accueil.php">Accueil</a>
        <a href="profil.php">Profil</a>
        <a href="connexion.php?deconnexion=ok">Déconnexion</a>
      </nav>
    </div>
  </header>
  <!-- end header -->
  <section class=" corps">
    <div class="container-fluids">
      <!-- partie centrale -->

      <div class="row" style="padding-top: 10px">
        <div class="col-md-6" style="margin:auto;">
          <div class="card" style="width: auto; " >
            <?php $article=article($_GET['id_link']); ?>
            <h3 style="text-align: center"><?=$article['link_name']?></h3>
          </div>
        </div>
      </div>
    </div>


    <div class="row" style="padding-top: 10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="width: auto; " >
          <?php $pseudo=pseudo_de_user($article['id_user']);
            ?>
            <div class="container-fluid"style="padding-bottom:10px; padding-top:10px" >
              <div class="card" style="width: auto;">
                <div>
                  <a class=" titre_lien link_vote" href="pagelien.php?id_link=<?=$article['id_link']?>"><?="".$article['link_name']?></a>
                  <p class="titre_lien pseudo"><?="".$pseudo?></p>
                  <p class="titre_lien date"><?= "".$article['date']?></p>
                </div>
                <div class="card-body" style="padding-top:0px">
                  <p class="card-text">
                    <?php
                      if (isset($_GET['modification'],$_GET['modifier'])) {
                         if($_GET['modification']=='lien' && $_GET['modifier']=='Modifier'){
                        ?>
                        <form class="" action="pagelien.php" method="get">
                          <div class="">
                            <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                            <input type='hidden' name='link' value='<?=$article['link']?>'>
                            <input type='hidden' name='modification' value='lien'>
                            <textarea  class="form-control" style="padding-bottom:30px" type="text" name="comment_user" value="" required><?=$article['comment_user']?></textarea>
                          </div>
                          <div style="padding-top:10px;text-align:center">
                            <textarea class="form-control link_vote" style="padding-bottom:10px" type="url" name="link" value="" required><?="".$article['link']?></textarea>
                        <div style="padding-top:10px">
                          <input type="submit" class="btn btn-primary" name="modifier" value="Modifier">
                        </div>
                        </div>
                        </form>
                        </p>
                        <?php
                        }
                    }
                    else {?>
                      <?= "".$article['comment_user']?>
                      </p>
                      <div class="card" style="margin:auto;text-align:center">
                          <a class="nav-link link_vote"  href="<?=$article['link']?>"><?="".$article['link']?></a>
                    </div>
                    <?php
                    } ?>

                </div>


                  <?php
                  menu_vote('links','pagelien.php',$_GET['id_link'],$_GET['id_link']);
                  if(droit($_GET['id_link'],'link')==true){
                    ?>
                    <div class="card-footer">
                      <div class="row">
                        <div class="col-md-6" style="margin : auto;text-align:center">
                          <form action="pagelien.php" method="GET">
                            <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                            <input type="submit" class="btn btn-primary" name="kill_article" value="Supprimer">
                          </form>
                        </div>
                        <?php if (!isset($_GET['modification'],$_GET['modifier'])) { ?>

                        <div class="col-md-6" style="text-align:center">
                          <form action="pagelien.php" method="GET">
                            <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                            <input type='hidden' name='link' value='<?=$article['link']?>'>
                            <input type='hidden' name='modification' value='lien'>
                            <input type="submit" class="btn btn-primary" name="modifier" value="Modifier">
                          </form>
                        </div>
                      <?php } ?>
                    </div>

                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Section dédiée aux commentaires-->

      <div class="row" style="padding-top: 10px">
        <div class="col-md-6" style="margin:auto;">
          <div class="card" style="width: auto; " >
            <h3 style="text-align: center">Commentaires concernant <?=$article['link_name']?></h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Partie pour ajouté un article -->
    <div class="row" style="padding-top:10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="padding-top: 10px;width: auto;">
          <form class="form_share" action="pagelien.php"  method="GET" >
            <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>

            <div class="input-group">
              <textarea style="padding-bottom:30px" class="form-control"type="text" name="commentaire" placeholder="Commenter le lien" required></textarea>
            </div>
            <input style="width:auto;" type="submit" value="Commenter" class="input_share btn btn-primary pull-right"required>
          </form>
        </div>
      </div>
    </div>

      <?php
      $commentaires = commentaires($_GET['id_link']);
      foreach ($commentaires as $commentaire){
        ?>

        <!-- Affichage du commentaire -->


        <div class="row" style="padding-top: 10px">
          <div class="col-md-6" style="margin:auto;">
            <div class="card" style="width: auto; " >
              <div class="container-fluid"style="padding-bottom:10px; padding-top:10px" >
                <div class="card" style="width: auto;">
                  <div >
                    <a  class="titre_lien"href=""><?="".pseudo_de_user($commentaire['id_user'])?></a>
                    <p class="titre_lien date"><?= "".$commentaire['date']?></p>

                  </div>
                  <div class="card-body" style="padding-top:0px">

                    <div class="card" style="margin:auto;text-align:center">
                      <?php
                        if (isset($_GET['modification'],$_GET['modifier'])) {
                           if($_GET['modification']=='commentaire' && $_GET['modifier']=='Modifier'){
                          ?>
                          <form class="" action="pagelien.php" method="get">
                            <div class="">
                              <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                              <input type='hidden' name='id_comment' value='<?=$commentaire['id_comment']?>'>
                              <input type='hidden' name='modification' value='commentaire'>
                              <textarea  class="form-control" style="padding-bottom:30px" type="text" name="content_comment" value="" required><?=$commentaire['content_comment']?></textarea>
                            </div>
                          <div style="padding-top:10px">
                            <input type="submit" class="btn btn-primary" name="modifier" value="Modifier">
                          </div>
                          </form>
                          </p>
                          <?php
                          }
                      }
                      else {?>
                        <a> <?= "".$commentaire['content_comment']?></a>
                      <?php
                      } ?>
                  </div>
                  </div>
                  <?php menu_vote('comments','pagelien.php',$_GET['id_link'],$commentaire['id_comment']); ?>
                    <?php
                    if(droit($commentaire['id_comment'],'comment')==true){
                      ?>
                      <div class="card-footer" >
                        <div class="row">
                          <div class="col-md-6" style="text-align:center">
                            <form action="pagelien.php" method="GET" style="">
                              <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                              <input type='hidden' name='id_comment' value='<?=$commentaire['id_comment']?>'>
                              <input type="submit"class="btn btn-primary" name="kill_comment" value="Supprimer le commentaire">

                            </form>
                          </div>
                          <div class="col-md-6" style="text-align:center">

                        <form action="pagelien.php" method="GET" >
                          <input type='hidden' name='id_link' value='<?=$_GET['id_link']?>'>
                          <input type='hidden' name='modification' value='commentaire'>
                          <input type='hidden' name='id_comment' value='<?=$commentaire['id_comment']?>'>
                          <input type="submit" class="btn btn-primary" name="modifier" value="Modifier">
                        </form>
                        </div>
                        </div>


                    </div>
                      <?php
                    }
                    ?>

                </div>
              </div>
          </div>
        </div>
      </div>

            <!-- Affichage des boutons de modification -->


          <?php
      }
      ?>
    </section>

  </div>
</body>
</html>
