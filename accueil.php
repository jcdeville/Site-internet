<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");

if (isset($_GET['link'],$_GET['commentaire'])){
  echo $_GET['link'];
  echo $_GET['commentaire'];
  ajouter_article($_GET['link'],$_GET['commentaire']);
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
    afficher_articles($liste_lien);
    ?>
    </section>

  </div>
</body>
</html>
