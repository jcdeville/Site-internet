<?php
session_start();
require("fonction.php");
testacces();
include("entete.php");
?>

<body>

  <div class="container">
    <h1>Page de profil</h1>

    <?php
    menu();
    echo "Vous êtes connecté sur la page profil de : ".$_SESSION['pseudo'];
    echo "<br/><br/>";
    echo "Votre id_user est : ".$_SESSION['id_user'];
    echo "<br/><br/>";
    ?>


    <h2>Liste des liens postés</h2>

    <?php
    afficher_articles_user($_SESSION['id_user']);
    ?>

  </div>

</body>
</html>
