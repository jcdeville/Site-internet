<?php
require("fonction.php");
include("entete.php");
?>

<body>

  <!-- header -->
  <header class="container-fluid header">
    <div class="container">
      <a href="accueil.php" class="logo">share it</a>
      <nav class="menu">
        <a href="connexion.php">Vous avez déja un compte ? Se connecter</a>
      </nav>
    </div>
  </header>
<!-- end header -->
  <?php
  // Inscrit la personne si les renseignements sont donnés
  if (isset($_POST['pseudo'],$_POST['email'],$_POST['mot_de_passe'],$_POST['confirmation_mot_de_passe'])){
    if(strlen($_POST['pseudo']) >= 4 && strlen($_POST['mot_de_passe']) >= 6 && $_POST['mot_de_passe']==$_POST['confirmation_mot_de_passe'] && $_POST['pseudo']==user_existant($_POST['pseudo']) && $_POST['email']==email_existant($_POST['email'])){
      inscription($_POST['pseudo'],$_POST['mot_de_passe'],$_POST['email']);
    }
    else{
      ?>
      <div class="container">
        <div class="col-md-5 pb_inscription">
          <div class="alert alert-danger " role="alert" style="text-align:center">
            <?php
            if($_POST['mot_de_passe']!=$_POST['confirmation_mot_de_passe']){?>
              Veuillez renseigner le même mot de passe;    <?php
            }
            elseif($_POST['pseudo']==user_existant($_POST['pseudo'])){?>
              Le pseudo est deja pris<?php
            }
            elseif($_POST['email']==email_existant($_POST['email'])){?>
              Vous possédez déjà un compte<?php
            }
            else{
              ?>Veuillez correctement renseigner vos informations<?php
            } ?>
          </div>
        </div>
      </div>
      <?php
    }
  }
  ?>

  <div class="container-fluid " >
    <div class=" col-md-4 inscription">
      <h2>Bienvenue !</h2>
      <form class="container" action="inscription.php"  method="POST" style="padding-left:0px">
        <!-- <input type="text" name="nom" placeholder="Nom">
        <input type="text" name="prénom" placeholder="Prénom"> -->
        <input class="input_co" type="text" name="pseudo" placeholder="Nom d'utilisateur (4 caractères minimum)"required>
        <input class="input_co" type="email" name="email" placeholder="Adresse mail" required>
        <input class="input_co" type="password" name="mot_de_passe" placeholder="Mot de passe (6 caractères minimum)"required>
        <input class="input_co" type="password" name="confirmation_mot_de_passe" placeholder="Confirmation du mot de passe" required>
        <input type="submit" value="S'inscrire" class=" input_co btn btn-primary pull-right"required>
      </form>
    </div>
  </div>
</body>
</html>
