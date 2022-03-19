<?php

echo "<div id='header'>";
//Affichage du logo
  echo '<div id="logo">
  <a href="index.php"><img src="images/oberu.png"></a>
  </div>';

  echo "<div id='burger_menu'><img id='menu_img'src='images/burger_menu.svg'></div>";

  echo "<div id='navbarContainerMobile'>";
    echo "<li id='navbarMobile'>";
      echo " <ul class='linkMobile'> <a href='?page=homepage'> Accueil </a> </ul>";
      echo "<ul class='linkMobile'> <a href='?page=search'> Recherche </a> </ul>";

      if(isset($_SESSION['user_id'])) {
        echo "<ul class='linkMobile'> <a href='?page=form'> Ajouter </a> </ul>";
        echo "<ul class='linkMobile'> <a href='?page=homepage&logout=true'> Déconnexion </a></ul>";
      } else {
        echo "<ul class='linkMobile'> <a href='?page=login'> Connexion </a> </ul>";
        }
    echo "</li>";
  echo "</div>";


  //Affichage du titre

  echo "<div id='navbarContainer'>";
  echo "<li id='navbar'>";
    echo " <ul class='link'> <a href='?page=homepage'> Accueil </a> </ul>";
    echo "<ul class='link'> <a href='?page=search'> Recherche </a> </ul>";

    if(isset($_SESSION['user_id'])) {
      echo "<ul class='link'> <a href='?page=form'> Ajouter </a> </ul>";
      echo "<ul class='link'> <a href='?page=homepage&logout=true'> Déconnexion </a></ul>";
    } else {
      echo "<ul class='link'> <a href='?page=login'> Connexion </a> </ul>";
      }

  echo "</li>";
  echo "</div>";

echo "</div>";

?>
