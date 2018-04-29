<?php
session_start();
require("fonction.php");
if(isset($_GET['deconnexion'])){
  session_destroy();
  session_start();
}
include("entete.php");
?>

<body>
  <div class="container">
    <h1>Page de connexion</h1>

    <?php menu();

    if (!isset($_POST['pseudo'],$_POST['mot_de_passe'])){
      ?>
      <form method="POST">
        <input type="text" name="pseudo" placeholder="Nom" required/>
        <input type="password" name="mot_de_passe" placeholder="Mot de passe" required/>
        <input type="submit" name="validate" value="Connexion"/>
      </form>
      <a class="nav-link active" href="profil.php">Voir profil</a>
      <a class="nav-link active" href="inscription.php">S'inscrire</a>
      <?php

    }
    else{
      $connexion = connexion();
      $requete = "SELECT id_user, mot_de_passe FROM users WHERE pseudo='".$_POST['pseudo']."'";
      $action = mysqli_query($connexion,$requete);
      $resultat = mysqli_fetch_assoc($action);

      if ($resultat){
        if($_POST['mot_de_passe']==$resultat['mot_de_passe']){
          $_SESSION['id_user'] = $resultat['id_user'];
          $_SESSION['pseudo'] = $_POST['pseudo'];

          ?>

          <script>
          var stay=alert("Connexion réussi")
          if (!stay)
          window.location="profil.php"
          </script>

          <?php
        }
        else{
          ?>

          <script>
          var stay=alert("Echec de la connexion")
          if (!stay)
          window.location="connexion.php"
          </script>

          <?php
        }
      }
      mysqli_free_result($action);
      mysqli_close($connexion);
    }

  ?>

</div>

</body>
</html>
