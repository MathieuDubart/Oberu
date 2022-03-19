<?php
if (!$connection){
    //Si la connexion n'a pas été effectué
    die ("Connection impossible");
}
else {
    $requete=mysqli_query($connection,"SELECT * FROM recette LIMIT 3");
}

$recetteArrayHomepage = [];
while ($row = mysqli_fetch_assoc($requete)) {
  array_push($recetteArrayHomepage, $row);
}

echo '<div id="background_image_homepage">';
  echo '<div class="search">
          <div id="envie">Une envie ou une idée précise ?</div>
          <button type="submit" id="searchButton"><a href="http://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=search">Chercher une recette</a></button>
        </div>';

  echo '<div id="icon-scroll_recette"></div>';
echo '</div>';

echo '<div id="plats_homepage">';

echo "<div id=home_title style='color: black'><h4>~ idées de recettes ~</h4></div>";

$rangee_bool = 0;

foreach ($recetteArrayHomepage as $recette) {
  echo "<div id='plat_".$recette['id_recette']."' class='plat'>";

    if($rangee_bool == 0){
      echo "<img id='plat_img_".$recette['id_recette']."' class='plat_img img_left' src='".$recette['img_plat']."'>";
      $rangee_bool = 1;

    echo "<div id='recette_".$recette['id_recette']."' class='plats_recette'>

      <div id='nom_recette_".$recette['id_recette']."' class='plats_recetteNom'>".$recette['nom_recette']."</div>

      <div id='infos_container'>
          <div class='infos_homepage'>".$recette['temps_prep']."</div>
          <div class='infos_homepage'>".$recette['nb_personne']."</div>
          <div class='infos_homepage'>".$regimes[$recette['id_regime']-1]['nom_regime']."</div>
          <div class='infos_homepage'>".$types[$recette['id_type']-1]['nom_type']."</div>
      </div>

      <div id='recette_desc_".$recette['id_recette']."' class='plats_recetteDesc'>".$recette['desc_recette']."</div>
      <div id='link_recette'>
        <a href='?page=recette&id=".$recette['id_recette']."' class='a_recette'>recette</a>
      </div>
    </div>";
  } else if($rangee_bool == 1){

      echo "<div id='recette_".$recette['id_recette']."' class='plats_recette'>

        <div id='nom_recette_".$recette['id_recette']."' class='plats_recetteNom'>".$recette['nom_recette']."</div>

        <div id='infos_container'>
            <div class='infos_homepage'>".$recette['temps_prep']."</div>
            <div class='infos_homepage'>".$recette['nb_personne']."</div>
            <div class='infos_homepage'>".$regimes[$recette['id_regime']-1]['nom_regime']."</div>
            <div class='infos_homepage'>".$types[$recette['id_type']-1]['nom_type']."</div>
        </div>

        <div id='recette_desc_".$recette['id_recette']."' class='plats_recetteDesc'>".$recette['desc_recette']."</div>
        <div id='link_recette'>
          <a href='?page=recette&id=".$recette['id_recette']."' class='a_recette'>recette</a>
        </div>
      </div>";

      echo "<img id='plat_img_".$recette['id_recette']."' class='plat_img img_right z_index_img' src='".$recette['img_plat']."'>";
      $rangee_bool = 0;
    }

  echo "</div>"; // plat
}
echo "</div>"; // plats_homepage



?>
