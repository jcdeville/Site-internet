<?php
session_start();
require("fonction.php");
deconnexion();
include("entete.php");
?>

<body>
  <!-- header -->
  <header class="container-fluid header">
    <div class="container">
      <a href="#" class="logo">nom du site</a>
      <nav class="menu">
          <a href="inscription.php">Vous ne possedez pas encore de compte ? S'inscrire</a>
      </nav>
    </div>
  </header>
  <!-- end header -->


      <?php
      if (!isset($_POST['pseudo'],$_POST['mot_de_passe'])){
        ?>
        <div class="container-fluid " >
           <div class=" col-md-4 inscription">
              <h2>Se connecter à ...</h2>
            <form class="container" method="POST" >
              <input type="text" name="pseudo" placeholder="pseudo" require>
               <input type="password" name="mot_de_passe" placeholder="Mot de passe" require>
                <input type="submit" value="Se connecter" class="btn btn-primary pull-right" require>
            </form>
           </div>
          </div>
        <?php

      }
      else{
        $connexion = connexion();
        $requete = "SELECT id_user, mot_de_passe FROM users WHERE pseudo='".$_POST['pseudo']."'";
        $action = mysqli_query($connexion,$requete);
        $resultat = mysqli_fetch_assoc($action);
        mysqli_free_result($action);
        mysqli_close($connexion);

        if ($resultat){
          if($_POST['mot_de_passe']==$resultat['mot_de_passe']){
            $_SESSION['id_user'] = $resultat['id_user'];
            $_SESSION['pseudo'] = $_POST['pseudo'];
            ?>

            <script>
            var name='<?php echo $_SESSION['pseudo'] ?>';
            var stay=alert("Connexion réussi, Bonjour "+name)
            if (!stay)
            window.location="profil.php"
            </script>

            <?php
          }
        }
        ?>
        <script>
        var stay=alert("Echec de la connexion")
        if (!stay)
        window.location="connexion.php"
        </script>
        <?php
      }
      ?>

    </section>

  </div>

</body>
</html>
