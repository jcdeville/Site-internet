<?php
require("fonction.php");
include("entete.php");

// Inscrit la personne si les renseignements sont donnés
if (isset($_POST['pseudo'],$_POST['email'],$_POST['mot_de_passe'])){
  if(strlen($_POST['pseudo']) >= 4 && strlen($_POST['mot_de_passe']) >= 6){
    inscription($_POST['pseudo'],$_POST['mot_de_passe'],$_POST['email']);
  }
  else{
    echo "Veuillez respecter les conditions d'inscription";
  }
}
?>
<!-- header -->
<header class="container-fluid header">
  <div class="container">
    <a href="#" class="logo">nom du site</a>
    <nav class="menu">
       <a href="connexion.php">Vous avez déja un compte ? Se connecter</a>
    </nav>
  </div>
</header>
<!-- end header -->
<body>
  <div class="container-fluid " >
     <div class=" col-md-4 inscription">
        <h2>Bienvenue !</h2>
      <form class="container" action="inscription.php"  method="POST" >
          <!-- <input type="text" name="nom" placeholder="Nom">
          <input type="text" name="prénom" placeholder="Prénom"> -->
          <input class="input_co" type="text" name="pseudo" placeholder="Nom d'utilisateur (4 caractères minimum)"required>
          <input class="input_co" type="email" name="email" placeholder="Adresse mail" >
          <input class="input_co" type="password" name="mot_de_passe" placeholder="Mot de passe (6 caractères minimum)"required>
          <!-- <input type="password" name="mdp_verif" placeholder="Confirmation du mot de passe"> -->
          <input type="submit" value="S'inscrire" class=" input_co btn btn-primary pull-right"required>
      </form>
     </div>
    </div>
</body>
</html>
