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
  					  <div class="card-title">
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
                 <input style="padding-bottom:30px"class="input_share form-control" type="text" name="commentaire" placeholder="Commenter le lien" required>
                 <input style="width:auto;" type="submit" value="Partager" class="btn btn-primary pull-right"required>
              </form>
            </div>
        </div>
      </div>



    <!-- Partie pour visualisé les 5 articles ayant eux le plus d'intéractions dans la journée-->
    <div class="row" style="padding-top: 10px">
      <div class="col-md-6" style="margin:auto;">
        <div class="card" style="width: auto; " >
            <div class="card-title">
                <h3 style="text-align: center">Liste des 5 liens ayant eux le plus d'intéractions dans la journée</h3>
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
                  <p class="card-text">
                    <?= "".$article['comment_user']?>
                  </p>
         		  		<p class="card-text lien">
                    <a class="nav-link active" href="<?=$article['link']?>"><?="Lien = ".$article['link']?></a><br/>
                  </p>
         				  <div class="card-footer">
         				  	<img src="https://www.stickers-shopping.fr/prestashop/img/p/1564-1626-large.jpg" style="width:20px;height:20px;">
         				    <a href="">Upvote</a>

                    <?php
                    echo compteur_vote('links',$article['id_link'],'positif');
                     ?>
         				    <img src="http://www.stickers-shopping.fr/prestashop/img/p/1567-1629-large.jpg" style="width:20px;height:20px;">
         				    <a href="">Downvote</a>
                    <?php echo compteur_vote('links',$article['id_link'],'négatif') ?>
                    <a href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>

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

    <section style="border :solid; margin:10px; padding:15px;">
      <h3>Liste des nouveautés qu’il y a eu depuis la dernière connexion de l'utilisateur pour les liens ou il avait interagi dans les dernière 24h.</h3>
      <?php

      // Il faut revoir la requête car elle ne sélectionne pas et ne classe pas les liens de la bonne manière
      // Peut être qu'il faut faire une union ou une jointure
      /*
      $liste_lien_24H ="SELECT DISTINCT id_link FROM links WHERE id_user = '".$_SESSION['id_user']."'
      UNION
      SELECT DISTINCT id_link FROM comments WHERE id_user = '".$_SESSION['id_user']."'
      UNION
      SELECT DISTINCT id_link FROM votes  WHERE id_user = '".$_SESSION['id_user']."'";


      SELECT * FROM ((
SELECT * FROM table1
WHERE ...
ORDER BY ...
LIMIT ...
) UNION (
SELECT * FROM table2
WHERE ...
ORDER BY ...
LIMIT ...
)) as t
WHERE ...
ORDER BY ...

      $liste_lien_24H = "(SELECT DISTINCT id_link FROM links WHERE id_user = '".$_SESSION['id_user']."' AND )
      UNION
      (SELECT DISTINCT id_link FROM comments WHERE id_user = '".$_SESSION['id_user']."')
      ORDER BY a LIMIT 10";

      */


      $liste_lien_24H = "SELECT * FROM links";
      $action = selectionner_id_link($liste_lien_24H);
      foreach ($action as $resultat){
        $article = article($resultat['id_link']);
        ?>
        <div class="row" style="border-top : solid;">
          <article>
            <a class="nav-link active" href="<?=$article['link']?>"><?="Lien = ".$article['link']?></a><br/>
            <span><?= "Date = ".$article['date']?></span><br/>
            <span><?="Utilisateur = ".$article['id_user']?></span><br/>
            <span><?= "Commentaire de l'utilisateur = ".$article['comment_user']?></span><br/>
            <a href="pagelien.php?id_link=<?=$article['id_link']?>">Ouvrir page du lien</a>
          </arcticle>
        </div>
        <?php
      }
      ?>
    </section>

  </div>
</body>
</html>
