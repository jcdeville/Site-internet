<?php
include("entete.php");
?>

<body>
  <div class="container">
    <h1>Page de connexion</h1>

    <form method="POST">
      <input type="text" id="pseudo" name="pseudo" >
      <span id="pseudo_manquant"></span><br/>
      <input type="submit" value="Connexion" id="bouton_connexion">
    </form>
    <script>
    var pseudo = document.getElementById('pseudo');
    var pseudo_manquant = document.getElementById('pseudo_manquant');
    var validation = document.getElementById('bouton_connexion');
    validation.addEventListener('click',f_valid);

    function f_valid(e){
      if(!pseudo.validity.valueMessage){
        alert('pas de valeur');
      }

    }
    </script>

  </div>



</body>
</html>
