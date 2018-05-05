<?php
include("entete.php");
include("fonction.php");
?>

<body>
  <div class="container">
    <h1>Page de test</h1>

    <?php
    $connexion = connexion();
    $requete = "SELECT TIMEDIFF('2009-05-18 15:45:57.005678','2009-05-18 13:40:50.005670')";
    $action = mysqli_prepare($connexion,$requete);
    $resultat = mysqli_fetch_assoc($action);

    echo $resultat;
    mysqli_close($connexion);


    ?>

  </div>

</body>
</html>
