
 <?php

  // Contrôle sur la connexion
  if (!$connection){
      //Si la connexion n'a pas été effectué
      die ("Connexion impossible");
  }
  else {
      $requete=mysqli_query($connection,"SELECT * FROM recette ORDER BY nom_recette ASC");
  }

  $typeArray = [];
  $regimeArray = [];

  $requeteType=mysqli_query($connection,"SELECT * FROM type");
  while ($row = mysqli_fetch_assoc($requeteType)) {
    $typeArray[$row['id_type']] = $row["nom_type"];
  }

  $requeteRegime=mysqli_query($connection,"SELECT * FROM regime");
  while ($row = mysqli_fetch_assoc($requeteRegime)) {
    $regimeArray[$row['id_regime']] = $row["nom_regime"];
  }
    // --------------------------------------- RECHERCHE NOM --------------------------------------- //
      echo "<form id='testRecherche' method='POST'>";

        echo "<div id='background_image'>";
          echo "<div id='searchBar'>";
            echo "<input type='text' id='text_search' name='text_search' placeholder='Rechercher une recette 🍜'>";
          echo "</div>";

          echo "<div id='rechercheAvancee'>";
            echo "Recherche avancée";
            echo "<div id='icon-scroll'></div>";
          echo "</diV>";
        echo "</div>";

    // --------------------------------------- RECHERCHE TYPE REGIME --------------------------------------- //


        echo "<div id='regimeForm'>";
          echo "<div id='regimeFormTitle'>";
            echo "- Régime -";
          echo "</div>";

          echo "<div id='regimeFormButtons'>";
            echo  "<input type='radio' id='tout_regime' class='inputStyleRadio' name='regime' value='tout_regime' checked> <label for='tout_regime'>Tous</label>";
            foreach ($regimeArray as $id_regime => $nom_regime) {
              echo "<input type='radio' id='$nom_regime' class='inputStyleRadio' name='regime' value='$id_regime'> <label for='$nom_regime'>$nom_regime</label>";
            }
          echo "</div>";
        echo "</div>";

        echo "<div id='typeForm'>";
          echo "<div id='typeFormTitle'>";
            echo "- Type -";
          echo "</div>";

          echo "<div id='typeFormButtons'>";
            echo  "<input type='radio' id='tout_type' class='inputStyleRadio' name='type' value='tout_type' checked> <label for='tout_type'>Tous</label>";
            foreach ($typeArray as $id_type => $nom_type) {
              echo "<input type='radio' id='$nom_type' class='inputStyleRadio' name='type' value='$id_type'> <label for='$nom_type'>$nom_type</label>";
            }
          echo "</div>";
        echo "</div>";

      // --------------------------------------- RECHERCHE INGREDIENTS --------------------------------------- //

      echo "<div id='selectIngredient'>";
        echo "<div id='ingredientFormTitle'>";
          echo "- Ingredients -";
        echo "</div>";

        echo "<div id='ingredientFormButtons'>";
          $requete_ing = mysqli_query($connection, "SELECT * FROM ingredients ORDER BY nom_ingredient ASC");
        	$liste_ingredients = [];

        	while ($row = mysqli_fetch_assoc($requete_ing)) {
        		$liste_ingredients[$row['id_ingredient']]=$row["nom_ingredient"];
        	}
          for ($i=1; $i<4; $i++){

            $requete_ing = $ing;
              echo "<select class='inputStyle' name='ingredient".$i."' id='ingredient_select'>";
               echo "<option value='-1' selected>Choisissez un ingrédient</option>";

               foreach($liste_ingredients as $id_ingredient => $nom_ingredient){
                      echo "<option value=".$id_ingredient.">".$nom_ingredient."</option>";
                }
              echo "</select>";
            }
          echo "</div>";
        echo "</div>";

      echo "<div id='submitContainer'>";
        echo "<input id='findMyRecetteSubmit' type='submit' value='Trouver ma recette'>";
      echo "</div>";

      echo "<div id='divider'>";
        echo "<div id='dividerTrait'></div>";
      echo "</div>";
  // ------------------ QUERY REGIME TYPE -----------------------

      $regimeId = $_POST['regime'];
      $typeId = $_POST['type'];

      $regime_type_array = [];



      if ($regimeId == "tout_regime" && $typeId == "tout_type") {
       $requete_trois = mysqli_query($connection, "SELECT * FROM recette");
      } else if ($regimeId == "tout_regime") {
       $requete_trois = mysqli_query($connection, "SELECT * FROM recette WHERE id_type = $typeId");
      } else if ($typeId == "tout_type") {
       $requete_trois = mysqli_query($connection, "SELECT * FROM recette WHERE id_regime = $regimeId");
      } else {
       $requete_trois = mysqli_query($connection, "SELECT * FROM recette WHERE id_regime = $regimeId AND id_type = $typeId");
      }

      while ($row = mysqli_fetch_assoc($requete_trois)) {
        array_push($regime_type_array, $row["id_recette"]);
      }

  // ------------------ QUERY SEARCH -----------------------

      $querystring = $_POST["text_search"];

      if (!isset($querystring)) {
        $requete_quatre = mysqli_query($connection, "SELECT * FROM recette");
      } else {
        $requete_quatre = mysqli_query($connection, "SELECT * FROM recette WHERE nom_recette LIKE '%{$querystring}%'");
      }

      $rowcount = mysqli_num_rows($requete_quatre);
      $search_array = [];

        while ($row = mysqli_fetch_assoc($requete_quatre)) {
            array_push($search_array, $row["id_recette"]);
        }

        // echo '<pre>';
        // print_r($search);
        // echo '</pre>';


  // ------------------ QUERY INGREDIENTS -----------------------

      $arrayIngredients = [];

      if ($_POST['ingredient1'] != '-1') {
        array_push($arrayIngredients, $_POST['ingredient1']);
      }
      if ($_POST['ingredient2'] != '-1' ) {
        array_push($arrayIngredients, $_POST['ingredient2']);
      }
      if ($_POST['ingredient3'] != '-1') {
        array_push($arrayIngredients, $_POST['ingredient3']);
      }

      $subQuery = '';

      foreach ($arrayIngredients as $key => $id_ing) {
        $subQuery = $subQuery . "(SELECT COUNT(*) FROM liste_ingredients WHERE liste_ingredients.id_recette = recette.id_recette AND liste_ingredients.id_ingredient = ".$id_ing.") AS nb_ing_".$key.",";
      }

      $finalSubQuery = substr($subQuery, 0, -1);

      $requete_ing = mysqli_query($connection, "SELECT id_recette,
        $finalSubQuery
        FROM recette;
      ");

      $array_query_ing = [];
      $counter = 0;

      while ($row = mysqli_fetch_assoc($requete_ing)){

          array_push($array_query_ing, $row);

          $final_array_ing = [];

          foreach ($array_query_ing as $recette) {
            $bool = true;
            foreach ($recette as $key => $value) {
              if ($key != 'id_recette'){
                if($value == 0){
                  $bool = false;
                }
              }
            }
            if($bool == true){
              array_push($final_array_ing, $recette['id_recette']);
            }
          }
       }

      $intersect_result = [];


      if (count($arrayIngredients) == 0) {
        $intersect_result = array_intersect($search_array, $regime_type_array);
      } else {
        $intersect_result = array_intersect($search_array, $final_array_ing, $regime_type_array);
      }

      if (count($intersect_result) > 1) {
        echo "<div id='search_results_number'> Nombre de résultats: ".count($intersect_result)." recettes trouvées 🍜</div>";
      } else {
        echo "<div id='search_results_number'> Nombre de résultat: ".count($intersect_result)." recette trouvée 🍜</div>";
      }


    echo "</form>";

    // ------------------ FIN FORMULAIRE SEARCH ------------------

    if(count($intersect_result) != 0) {
        $secondSubQuery = 'SELECT * FROM recette WHERE';
        $tableauRecettes = [];

      foreach ($intersect_result as $recette) {
          $secondSubQuery = $secondSubQuery ." id_recette = '".$recette."' OR";
      }

      $secondSubQuery = substr($secondSubQuery, 0, -2);

      $requete_affichage = mysqli_query($connection, $secondSubQuery);

      $nb_resultats = mysqli_num_rows($requete_affichage);

      if ($nb_resultats == 1) {
        $tableauRecettes = mysqli_fetch_assoc($requete_affichage);
      } else {
        while ($row = mysqli_fetch_assoc($requete_affichage)) {
            array_push($tableauRecettes, $row);
          }
      }
    }


    // echo "<pre>";
    // print_r($tableauRecettes);
    // echo "</pre>";


    mysqli_close($connection);

    // ---------------------------------------------------- MOSAIQUES RESULTAtS -------------------------------------- //

    echo "<div id='mosaique_container'>";

    if ($nb_resultats == 0) {
      echo "<div id='no_results_button'> <a href='http://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=form'> Ajouter une recette </a> </div>";
    } else if ($nb_resultats == 1) {
      echo "<div class='mosaique_class'> <a href='http://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=recette&id=".$tableauRecettes['id_recette']."'>";
        echo "<img src='".$tableauRecettes['img_plat']."'>";
        echo "<div class='recipeTitle'>";
          echo $tableauRecettes['nom_recette'];
        echo "</div>";
        echo "<div class='recipeTags'>";
          echo "<div class='recipeSoloTag'>";
            echo $regimes[$tableauRecettes['id_regime']-1]['nom_regime'];
          echo "</div>";
          echo "<div class='recipeSoloTag'>";
            echo $tableauRecettes['temps_prep'];
          echo "</div>";
          echo "<div class='recipeSoloTag'>";
            echo $tableauRecettes['nb_personne'];
          echo "</div>";
        echo "</div>";
      echo "</a> </div>";
    } else {
      foreach ($tableauRecettes as $lastRecettes) {
          echo "<div class='mosaique_class'> <a href='http://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=recette&id=".$lastRecettes['id_recette']."'> ";
            echo "<img src='".$lastRecettes['img_plat']."'>";
            echo "<div class='recipeTitle'>";
              echo $lastRecettes['nom_recette'];
            echo "</div>";
            echo "<div class='recipeTags'>";
              echo "<div class='recipeSoloTag'>";
                echo $regimes[$lastRecettes['id_regime']-1]['nom_regime'];
              echo "</div>";
              echo "<div class='recipeSoloTag'>";
                echo $lastRecettes['temps_prep'];
              echo "</div>";
              echo "<div class='recipeSoloTag'>";
                echo $lastRecettes['nb_personne'];
              echo "</div>";
            echo "</div>";
          echo "</a> </div>";
      }
    }
    echo "</div>";

?>
