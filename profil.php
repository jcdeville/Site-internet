<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");
if(isset($_GET['favoris'])){
  ajouter_favoris($_GET['id_link'],'links',$_GET['id_link']);
  header("Location:profil.php");
  exit;
}
?>

<body>
  <!-- header -->
  <header class="container-fluid header">
    <div class="container">
      <a href="#" class="logo">nom du site</a>
      <nav class="menu">
        <a href="accueil.php">Accueil</a>
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
          <div class="card" style="width: auto; padding-bottom: 10px" >
            <h3 class="titre">Bonjour <?php echo $_SESSION['pseudo'] ?></h3>
          </div>
        </div>
      </div>
    </div>

    <!-- liste des liens dans lesquels l'utilisateur à intéragie-->
    <div class="row" style="padding-top: 10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="width: auto; " >
          <div class="card-title">
            <h3 class="titre">Liens dans lesquels vous avez intéragie</h3>
          </div>
          <?php

          $requete = "SELECT id_link,date FROM
          (SELECT links.id_link AS id_link,comments.date AS date FROM links JOIN comments ON links.id_link = comments.id_link
            WHERE comments.id_user = '".$_SESSION['id_user']."'
            AND comments.date = (SELECT MAX(date) FROM comments WHERE id_link = links.id_link)
            UNION
            SELECT links.id_link AS id_link,votes.date AS date FROM links JOIN votes ON links.id_link = votes.id_link
            WHERE votes.id_user = '".$_SESSION['id_user']."'
            AND votes.date = (SELECT MAX(date) FROM votes WHERE id_link = links.id_link)
            UNION
            SELECT links.id_link AS id_link,favoris.date AS date FROM links JOIN favoris ON links.id_link = favoris.id_link
            WHERE favoris.id_user = '".$_SESSION['id_user']."'
            AND favoris.date = (SELECT MAX(date) FROM favoris WHERE id_link = links.id_link))
            AS list_lien
            GROUP BY id_link
            ORDER BY date DESC
            ";

            $id_links = selectionner_id_link($requete);
            foreach ($id_links as $id_link){
              $article = article($id_link['id_link']);
              $pseudo=pseudo_de_user($article['id_user']);
              ?>
              <div class="container-fluid"style="padding-bottom:10px" >
                <div class="card" style="width: auto;">
                  <div>
                    <a style="margin-top: 0px"class=" titre_lien link_vote" href="pagelien.php?id_link=<?=$article['id_link']?>"><?="".$article['link_name']?></a>
                    <p style="margin-top:3px" class="titre_lien pseudo"><?="".$pseudo?></p>
                    <p   style="margin-top:3px" class="titre_lien date"><?= "".$article['date']?></p>
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
                  menu_vote('links','accueil.php',$article['id_link'],$article['id_link']);
                  ?>
                </div>
              </div>

              <?php
            }
            ?>

          </div>
        </div>
      </div>

      <!-- liens que l'utilisateur à publié -->

      <div class="row" style="padding-top: 10px">
        <div class="col-md-6" style="margin:auto;">
          <div class="card" style="width: auto; " >
            <div class="card-title">
              <h3 class="titre">Vos liens</h3>
            </div>
            <?php
            $liste_lien_posté = "SELECT DISTINCT id_link FROM links WHERE id_user='".$_SESSION['id_user']."'  ORDER BY date DESC";
            $id_links = selectionner_id_link($liste_lien_posté);
            foreach ($id_links as $id_link){
              $article = article($id_link['id_link']);
              $pseudo=pseudo_de_user($article['id_user']);
              ?>
              <div class="container-fluid"style="padding-bottom:10px" >
                <div class="card" style="width: auto;">
                  <div>
                    <a style="margin-top: 0px"class=" titre_lien link_vote" href="pagelien.php?id_link=<?=$article['id_link']?>"><?="".$article['link_name']?></a>
                    <p style="margin-top:3px" class="titre_lien pseudo"><?="".$pseudo?></p>
                    <p   style="margin-top:3px" class="titre_lien date"><?= "".$article['date']?></p>
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
                  menu_vote('links','accueil.php',$article['id_link'],$article['id_link']);
                  ?>
                </div>
              </div>

              <?php
            }
            ?>
          </div>
        </div>
      </div>

      <!-- Lien que l'utilisateur a mis en favoris -->

      <div class="row" style="padding-top: 10px">
        <div class="col-md-6" style="margin:auto;">
          <div class="card" style="width: auto; " >
            <div class="card-title">
              <h3 class="titre">Vos favoris</h3>
            </div>
            <?php
            $liste_lien_posté = "SELECT id_link FROM favoris WHERE id_user='".$_SESSION['id_user']."'  ORDER BY date DESC";
            $id_links = selectionner_id_link($liste_lien_posté);
            foreach ($id_links as $id_link){
              $article = article($id_link['id_link']);
              $pseudo=pseudo_de_user($article['id_user']);
              ?>
              <div class="container-fluid"style="padding-bottom:10px" >
                <div class="card" style="width: auto;">
                  <div>
                    <a style="margin-top: 0px"class=" titre_lien link_vote" href="pagelien.php?id_link=<?=$article['id_link']?>"><?="".$article['link_name']?></a>
                    <p style="margin-top:3px" class="titre_lien pseudo"><?="".$pseudo?></p>
                    <p   style="margin-top:3px" class="titre_lien date"><?= "".$article['date']?></p>
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
                  menu_vote('links','accueil.php',$article['id_link'],$article['id_link']);
                  ?>
                </div>
              </div>

              <?php
            }
            ?>
          </div>
        </div>
      </div>

    </section>



  </body>
  </html>
