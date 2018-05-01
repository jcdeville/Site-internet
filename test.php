<?php
include("entete.php");
include("fonction.php");
?>

<body>
  <div class="container">
    <h1>Page de connexion</h1>

    <?php

    $connexion = connexion();
    $requete = "SELECT * FROM links";
    $action = mysqli_query($connexion,$requete);


    foreach ($action as $post) {
      $titre = $post['link'];
      echo $titre;
    }


    ?>

  </div>

</body>
</html>
