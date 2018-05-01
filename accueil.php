<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['link'],$_GET['commentaire'])){
  echo "coucou";
  // Problème : des fois il y a des problèmes pour ajouter un lien ou un commentaire. Il faut regarder si les conditions sont bien choisies/remplies.
  // ajouter_article($_GET['link'],$_GET['commentaire']);
}
?>

<body>
  <div class="container">
    <h1>Page d'accueil</h1>

    <?php menu(); ?>

    <section style="border:solid; margin:10px; padding:15px;">
      <!-- Partie pour ajouté un article -->
      <h3>Ajouter un lien</h3>
      <form action="accueil.php"  method="GET">
        <p>Votre link : <input type="url" name="link" required/></p>
        <p>Votre commentaire : <input type="text" name="commentaire" required/></p>
        <p><input type="submit" value="Ajouter"></p>
      </form>
    </section>

    <!-- Partie pour visualisé tous les articles -->
    <section style="border :solid; margin:10px; padding:15px;">
      <h3>Liste des liens</h3>
      <?php
      $liste_lien ="SELECT * FROM links ORDER BY date DESC";
      $action = afficher_articles($liste_lien);
      foreach ($action as $resultat){
        ?>
        <div class="row" style="border-top : solid;">
          <article>
            <a class="nav-link active" href="<?=$resultat['link']?>"><?="Lien = ".$resultat['link']?></a><br/>
            <span><?= "Date = ".$resultat['date']?></span><br/>
            <span><?="Utilisateur = ".$resultat['id_user']?></span><br/>
            <span><?= "Commentaire de l'utilisateur = ".$resultat['comment_user']?></span><br/>
            <a href="pagelien.php?id_link=<?=$resultat['id_link']?>">Ouvrir page du lien</a>
          </arcticle>
        </div>
        <?php
      }
      ?>
    </section>

  </div>
</body>
</html>
