<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");
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
          <div class="card" style="width: auto; " >
            <h3 style="text-align: center">Bonjour <?php echo $_SESSION['pseudo'] ?></h3>
          </div>
        </div>
      </div>
    </div>

    <!-- liste des liens dans lesquels l'utilisateur à intéragie-->
    <div class="row" style="padding-top: 10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="width: auto; " >
          <div class="card-title">
            <h3 style="text-align: center">Liens dans lesquels vous avez intéragie</h3>
          </div>
          <?php
          $liste_lien_commenté = "SELECT DISTINCT id_link FROM comments WHERE id_user='".$_SESSION['id_user']."' ORDER BY date DESC";
          $liste_lien_voté = "SELECT DISTINCT id_link FROM votes WHERE id_user='".$_SESSION['id_user']."' GROUP BY id_link ORDER BY date DESC";
          $id_links_2 = selectionner_id_link($liste_lien_voté);
    // ajouter le fait que l'utilisateur à upvoter ou donwvoter une publi

          $id_links = selectionner_id_link($liste_lien_commenté);
          $id_links=$id_links+$id_links_2;
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
          <h3 style="text-align: center">Vos liens</h3>
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
  </section>

  </body>
</html>
