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
                    <?= "".$article['comment_user']?>
                  </p>

                  <div class="card" style="margin:auto;text-align:center">
                    <a class="nav-link link_vote"  href="<?=$article['link']?>"><?="".$article['link']?></a>
                </div>
                </div>

                <?php
                if(isset($_GET['value_vote'])){
                 last_modification_date_update($_GET['id_link']);
                 ajouter_vote($_GET['id_link'],'links',$_GET['id_link'],$_GET['value_vote']);
                 header("Location:pagelien.php?id_link=".$_GET['id_link']."");
               }
                 ?>
                  <?php
                  menu_vote('pagelien.php',$_GET['id_link']);
                  if(droit($_GET['id_link'],'link')==true){
                    ?>
                    <form action="pagelien.php" method="GET">
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

            <div class="row" style="padding-top: 10px">
              <div class="col-md-6" style="margin:auto;">
                <div class="card" style="width: auto; " >
                    <h3 style="text-align: center">Commentaires concernant <?=$article['link_name']?></h3>
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
                  <div class="card-body" style="padding-top:0px">
                    <p class="card-text">
                      <a href=""><?="".pseudo_de_user($commentaire['id_user'])?></a>
                    </p>
                    <div class="card" style="margin:auto;text-align:center">
                      <a> <?= "".$commentaire['content_comment']?></a>
                  </div>
                  </div>
                </div>
              </div>



              <a href=""><?="".pseudo_de_user($commentaire['id_user'])?></a>
              <span><?= "Contenu du commentaire = ".$commentaire['content_comment']?></span><br/>
              <span><?= "Date = ".$commentaire['date']?></span><br/>
          </div>
        </div>

        </div>

        <div class="row" style="border-top : solid;">
          <div class="col" style="margin:10px; padding:15px;">

            <article>

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

  </div>
</body>
</html>
