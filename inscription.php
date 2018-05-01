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

<body>
  <div class="container">



    <h1>Page d'inscription</h1>

    <?php menu();?>

    <section style="border :solid; margin:10px; padding:15px;">

    <form action="inscription.php"  method="POST">
      <p>Votre pseudo : <input type="text" name="pseudo" placeholder="4 caractères minimum" required/></p>
      <p>Votre email : <input type="mail" name="email" required/></p>
      <p>Votre mot_de_passe : <input type="password" name="mot_de_passe" placeholder="6 caractères minimum" required/></p>
      <p><input type="submit" value="OK"></p>
    </form>

    <a href="connexion.php">Connexion</a>


    </section>

  </div>
</body>
</html>
