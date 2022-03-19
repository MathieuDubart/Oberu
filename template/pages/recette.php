<?php
// ----------------------------------- REQUETE RECUP RECETTE --------------------------------------
// Contrôle sur la connexion

$id_recette = $_GET["id"];

if (!$connection){
    //Si la connexion n'a pas été effectué
    die ("Connection impossible");
}
else {
    $requete=mysqli_query($connection,"SELECT * FROM recette WHERE id_recette = $id_recette");
}

$recetteArray = [];
while ($row = mysqli_fetch_assoc($requete)) {
  array_push($recetteArray, $row);
}


$requete_ing = mysqli_query($connection, "SELECT id_liste, id_recette, qte_ingredient, ingredients.id_ingredient, nom_ingredient, img_ingredient
  FROM liste_ingredients
  JOIN ingredients
  ON liste_ingredients.id_ingredient = ingredients.id_ingredient
  WHERE liste_ingredients.id_recette = $id_recette;");
$liste_ingredients = [];
while ($row = mysqli_fetch_assoc($requete_ing)) {
  // $liste_ingredients[$row['id_ingredient']]=$row["nom_ingredient"];
  array_push($liste_ingredients, $row);

}

$requete_instruction = mysqli_query($connection, "SELECT * FROM instructions WHERE id_recette = $id_recette");
$arrayInstruction = [];
while ($row = mysqli_fetch_assoc($requete_instruction)) {
  array_push($arrayInstruction, $row);
}
// ----------------------------------- DOM --------------------------------------
echo "<section id='header_recette'>";

  echo "<div id='header_img'>";
    echo "<img src='".$recetteArray[0]['img_plat']."' alt='image recette'>";

    echo "<div id='header_recette_container'>";
      echo "<div id='recette_container'>";
        echo "<div id='titre_recette'>";
          echo "<h1>".$recetteArray[0]['nom_recette']."</h1>";
        echo "</div>";

        echo "<div id='infos_container_recette'>";
          echo "<div class='infos'>".$recetteArray[0]['temps_prep']."</div>";
          echo "<div class='infos'>".$recetteArray[0]['nb_personne']."</div>";
          echo "<div class='infos'>".$regimes[$recetteArray[0]['id_regime']-1]['nom_regime']."</div>";
          echo "<div class='infos'>".$types[$recetteArray[0]['id_type']-1]['nom_type']."</div>";
        echo "</div>";

        echo "<div id='desc_recette'>";
          echo "<p>".$recetteArray[0]['desc_recette']."</p>";
        echo "</div>";
      echo "</div>";
    echo "</div>";
    echo '<div id="icon-scroll_recette"></div>';
  echo "</div>";

echo "</section>";

echo "<section id='ingredient_section'>";
  echo "<h1>-Ingrédients-</h1>";

  echo "<div id='ingredient_container'>";

    echo "<div id='mosaique_container_ing'>";

      for ($j = 0; $j < count($liste_ingredients); $j++) {
        echo "<div id='mosaique_ingredient'".$j." class='mosaique_class_ing'>";
          echo "<img src=".$liste_ingredients[$j]['img_ingredient']."> ";
          echo "<br><div> ".$liste_ingredients[$j]['nom_ingredient']."</div>";
          echo "<div> ".$liste_ingredients[$j]['qte_ingredient']."</div>";
        echo "</div>";
      }

    echo "</div>";

  echo "</section>";


echo "<section id='preparation_section'>";
  echo "<h1>-Préparation-</h1>";

  echo "<div id='instructions_container'>";

  echo '<div class="swiper mySwiper">
      <div class="swiper-wrapper">';
        foreach ($arrayInstruction as $instruction) {
          echo '<div class="swiper-slide">';
            echo "<div class='content_swiper'>";
              echo '<div class="etape">';
                echo "ETAPE ".$instruction['ordre'];
              echo "</div>";
              echo '<div class="instr">';
                echo "<p>".$instruction['desc_instruction']."</p>";
              echo "</div>";
            echo "</div>";
          echo '</div>';
        }
      echo '</div>
      <div class="swiper-pagination"></div>
    </div>';


  echo "</section>";


echo "</div>";

?>
