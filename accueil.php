<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");
?>

<body>
  <div class="container">
    <h1>Page d'accueil</h1>

    <?php menu(); ?>

    <section>

      <!-- Partie pour ajouté un article -->

      <h3>Ajouter un lien</h3>


      <form action="accueil.php"  method="GET">
        <p>Votre link : <input type="url" name="link" required/></p>
        <p>Votre commentaire : <input type="text" name="commentaire" required/></p>
        <p><input type="submit" value="Ajouter"></p>
      </form>

      <?php
      if (isset($_GET['link'],$_GET['commentaire'])){
        ajouter_lien($_GET['link'],$_GET['commentaire']);
      }
      ?>

    <!-- Partie pour ajouté un article -->

    <!-- Partie pour visualisé tous les articles -->

    <h3>Liste des liens</h3>
    <?php afficher_articles();?>

    <!-- Partie pour visualisé tous les articles -->


    </section>
  </div>
</body>
</html>
