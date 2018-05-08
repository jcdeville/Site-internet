<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['link'],$_GET['commentaire'])){
  ajouter_article($_GET['link'],$_GET['commentaire']);
}
?>

<body>
  <!-- header -->
  <header class="container-fluid header">
    <div class="container">
      <a href="#" class="logo">nom du site</a>
      <nav class="menu">
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
            <h3 style="text-align: center">Quoi de neuf ?</h3>
          </div>
        </div>
      </div>
    </div>


    <!-- Partie pour ajouté un article -->
    <div class="row" style="padding-top:10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="padding-top: 10px;width: auto;">
          <form class="form_share" action="accueil.php"  method="GET" >
            <input  class="input_share form-control" type="url" name="link" placeholder="Partager un lien">
            <div class="input-group">
              <textarea style="padding-bottom:30px" class="form-control"type="text" name="commentaire" placeholder="Commenter le lien" required></textarea>
            </div>
            <input style="width:auto;" type="submit" value="Partager" class="input_share btn btn-primary pull-right"required>
          </form>
        </div>
      </div>
    </div>



    <!-- Partie pour visualisé les 5 articles ayant eux le plus d'intéractions dans la journée-->
    <div class="row" style="padding-top: 10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="width: auto; " >
          <div class="card-title">
            <h3 style="text-align: center">Tendances</h3>
          </div>
          <?php
          interaction_number_update();
          $liste_lien ="SELECT * FROM links ORDER BY interaction_number DESC LIMIT 5";
          $articles = selectionner_id_link($liste_lien);
          foreach ($articles as $article){
            $pseudo=pseudo_de_user($article['id_user']);
            ?>
            <div class="container-fluid"style="padding-bottom:10px" >
              <div class="card" style="width: auto;">
                <div>
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
                 header("Location:accueil.php");
               }
                 ?>


                <div class="card-footer">
                  <form class="form_share" action="accueil.php"  method="GET">
                    <img src="https://www.stickers-shopping.fr/prestashop/img/p/1564-1626-large.jpg" style="width:20px;height:20px;">
                    <input type='hidden' name='id_link' value="<?=$article['id_link']?>">
                    <?php
                    if (!trouver_vote_de_user('links',$article['id_link'])) {
                      ?>
                     <input type="submit"  class="btn btn-outline-success" name="value_vote" value="upvote">
                  <?php  }
                    elseif(valeur_vote_de_user('links',$article['id_link'])=='upvote') {?>
                    <input type="submit"  class="btn btn-success" name="value_vote" value="upvote">
                  <?php  }?>

                    <?php
                    echo compteur_vote('links',$article['id_link'],'upvote');
                    ?>
                  </form>



                  <img src="http://www.stickers-shopping.fr/prestashop/img/p/1567-1629-large.jpg" style="width:20px;height:20px;">
                  <a class="link_vote" href="">Downvote</a>
                  <?php echo compteur_vote('links',$article['id_link'],'downvote') ?>
                  <a class="link_vote" href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>

                </div>
              </div>
            </div>

            <?php
          }
          ?>

        </div>
      </div>
    </div>




    <!-- Partie pour visualisé tous les articles postés il y a 24 heures -->



    <div class="row" style="padding-top: 10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="width: auto; " >
          <div class="card-title">
            <h3 style="text-align: center">Nouveautés</h3>
          </div>
          <?php
          $requete = "SELECT DISTINCT links.id_link FROM links JOIN comments ON links.id_link = comments.id_link
          WHERE comments.id_user = '".$_SESSION['id_user']."'
          AND comments.date >= DATE_SUB(NOW(),INTERVAL 24 HOUR)
          AND links.last_modification_date >= (SELECT date FROM users WHERE id_user = '".$_SESSION['id_user']."')
          UNION
          SELECT DISTINCT links.id_link FROM links JOIN votes ON links.id_link = votes.id_link
          WHERE votes.id_user = '".$_SESSION['id_user']."'
          AND votes.date >= DATE_SUB(NOW(),INTERVAL 24 HOUR)
          AND links.last_modification_date >= (SELECT date FROM users WHERE id_user = '".$_SESSION['id_user']."')";
          $action = selectionner_id_link($requete);
          foreach ($action as $resultat){
            $article = article($resultat['id_link']);
            $pseudo = pseudo_de_user($article['id_user']);
            ?>
            <div class="container-fluid"style="padding-bottom:10px" >
              <div class="card" style="width: auto;">
                <div>
                  <p class="titre_lien pseudo"><?="".$pseudo?></p>
                  <p class="titre_lien date"><?= "".$article['date']?></p>
                </div>
                <div class="card-body" style="padding-top:0px">
                  <p class="card-text">
                    <?= "".$article['comment_user']?>
                  </p>

                  <div class="card" style="margin:auto;text-align:center">
                    <a class="nav-link link_vote"  href="<?=$article['link']?>"><?="".$article['link']?></a><br/>
                  </div>
                </div>


                <div class="card-footer">
                  <img src="https://www.stickers-shopping.fr/prestashop/img/p/1564-1626-large.jpg" style="width:20px;height:20px;">
                  <a class="link_vote" href="">Upvote</a>

                  <?php
                  echo compteur_vote('links',$article['id_link'],'upvote');
                  ?>
                  <img src="http://www.stickers-shopping.fr/prestashop/img/p/1567-1629-large.jpg" style="width:20px;height:20px;">
                  <a class="link_vote" href="">Downvote</a>
                  <?php echo compteur_vote('links',$article['id_link'],'downvote') ?>
                  <a class="link_vote" href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>

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
</body>
</html>
