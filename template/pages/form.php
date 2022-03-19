 <?php

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
// -------------------------------------- CONNEXION ----------------------------------------------


    $connection= mysqli_connect("localhost","root","", "workshopCuisine");
	  mysqli_set_charset( $connection, 'utf8');
    // Contrôle sur la connexion
    if (!$connection){
        //Si la connexion n'a pas été effectué
        die ("Connection impossible");
    }
    else {
        $requete=mysqli_query($connection,"SELECT * FROM recette ORDER BY nom_recette");
    }
  ?>

<?php

  echo "<form id='add_recipe_form' method='POST' enctype='multipart/form-data'>";


  echo "<div id='background_image_form'>";
      echo "<div id='formTitle' class='topTitle'> Vous souhaitez apporter une nouvelle recette ? </div>";
      echo "<div id='icon-scroll-form'></div>";
  echo "</div>";

  echo "<div id='formContainer'>";

    echo "<div class='formDivider'> ~ Nom de la recette ~ </div>";
    echo "<input type='text' id='newRecipeName' class='inputStyle' name='recipeNameValue' placeholder='Ex: Brochettes Yakitori' required> <br/>";

    echo "<div class='formDivider'> ~ Temps de préparation ~ </div>";
    echo "<input type='text' id='preparation_time' class='inputStyle' name='recipePrepValue' placeholder='Ex: 1h30' required> <br/>";

    echo "<div class='formDivider'> ~ Nombre de personnes ~ </div>";
    echo "<input type='text' id='nb_personne' class='inputStyle' name='recipePersValue' placeholder='Ex: 4 personnes' required> <br/>";

    echo "<div class='formDivider'> ~ Description de la recette ~ </div>";
    echo "<textarea id='newRecipeDesc' name='recipeDescArea' rows='8' cols='40' placeholder='Ex: Les brochettes yakitori sont...' required></textarea> <br/>";


// image field
    echo "<div class='formDivider'> ~ Image de la recette ~ </div>";
    echo "<input type='file' id='recipeImg' class='inputStyle' name='recipeImg' accept='image/png, image/jpg' required> <br>";


  // select by ingredient
  	$requete_ing = mysqli_query($connection, "SELECT * FROM ingredients ORDER BY nom_ingredient ASC");
  	$liste_ingredients = [];

  	while ($row = mysqli_fetch_assoc($requete_ing)) {
  		$liste_ingredients[$row['id_ingredient']]=$row["nom_ingredient"];
  	}

  	// print_r($liste_ingredients);


    echo "<div class='formDivider'> ~ Ingrédients et quantités ~ </div>";

    for ($i=1; $i<4; $i++){

      $requete_ing = $ing;

      echo "<div class='ingredientsForm'>";
         echo "<select class='inputStyle' name='ingredient[]' id='ingredient_select' required> <br/>";
         echo "<option class='inputStyle' value='' selected>Choisissez un ingrédient</option> <br/>";

         foreach($liste_ingredients as $id_ingredient => $nom_ingredient){
                echo "<option class='inputStyle' value=".$id_ingredient.">".$nom_ingredient."</option> <br/>";
         }
         echo "</select>";

        echo    "<input type='text' class='inputStyle' id='qteIng".$i."' name='qteIng[]' placeholder='quantité' required> <br>";
      echo "</div>";
      }

      echo '<div id="container">';
      echo '</div>';
    	echo '<div id="add_element" class="add_button">Ajouter un ingrédient</div>';

      // INSTRUCTION
      echo "<div class='formDivider'> ~ Instructions ~ </div>";
      echo  "<input type='text' id='instruction' class='inputStyle instructions' placeholder='instruction' class='inputStyle' name='instruction[]' required>";

      echo '<div id="container_instruction">';
      echo '</div>';

    	echo '<div id="add_element_instruction" class="add_button">Ajouter une instruction</div>';


  // ----------------------------------------- SELECT BY TYPE ---------------------------------------------

        $requete_ing = mysqli_query($connection, "SELECT * FROM type ORDER BY id_type ASC");

          echo "<div class='formDivider'> ~ Type ~ </div>";

          echo "<select name='type".$i."' id='type_select' class='inputStyle' required> <br/>";
           echo "<option value='' selected>Choisissez un type</option> <br/>";

            while ($row = mysqli_fetch_assoc($requete_ing)) {
                  echo "<option class='inputStyle' value=".$row['id_type'].">".$row["nom_type"]."</option> <br/>";
            }
          echo "</select> <br/>";

  // ----------------------------------------- SELECT BY REGIME ------------------------------------------

          $requete_ing = mysqli_query($connection, "SELECT * FROM regime ORDER BY id_regime ASC");

          echo "<div class='formDivider'> ~ Régime ~ </div>";

          echo "<select name='regime".$i."' id='regime_select' class='inputStyle' required> <br/>";
           echo "<option value='' selected>Choisissez un régime</option> <br/>";

            while ($row = mysqli_fetch_assoc($requete_ing)) {
                  echo "<option class='inputStyle' value=".$row['id_regime'].">".$row["nom_regime"]."</option> <br/>";
            }
          echo "</select> <br/>";


    // submit button
      echo "<input type='submit' id='formSubmit' class='inputStyle' value='Envoyer'> <br/>";
  echo "</div>";

    echo "</form>";

    // HIDDEN FIELD
        echo '<div id="hidden_field" style="display:none;"> ';
            echo "<div id='container_select_IDCUSTOM'>";
              echo "<select name='ingredient[]' id='ingredient_select' class='inputStyle'> <br/>";
              echo "<option value='' selected>Choisissez un ingrédient</option> <br/>";
              foreach($liste_ingredients as $id_ingredient => $nom_ingredient){
                        echo "<option class='inputStyle' value=".$id_ingredient.">".$nom_ingredient."</option> <br/>";
                  }
              echo "<input name='qteIng[]' type='text' id='qteIng".$i."' class='inputStyle' placeholder='quantité'>";
            echo '</div>';

        echo '</div>';
    // HIDDEN FIELD INSTRUCTION

    echo '<div id="hidden_field_instruction" style="display:none;">';
      echo  "<input type='text' id='instruction_IDCUSTOMINSTR' class='inputStyle instructions' name='instruction[]' placeholder='instruction'> <br/>";
    echo '</div>';


// recup
  $recipeName = strval($_POST['recipeNameValue']);
  $timePrep = strval($_POST['recipePrepValue']);
  $nbPersonne = strval($_POST['recipePersValue']);

  $recipeDesc = strval($_POST['recipeDescArea']);
  // $recipeImg = strval($_POST["recipeImgValue"]);

  $idType = strval($_POST['type'.$i]);
  $idRegime = strval($_POST['regime'.$i]);


  $ingredientArray = $_POST['ingredient'];
  $qteIngArray =  $_POST['qteIng'];
  $instructionArray =  $_POST['instruction'];

  // echo $idRegime."<br/>";

	// echo "INSERT INTO recette VALUES ('NULL' , '".$recipeName."', '$recipeDesc' , '$recipeImg' , '$nbPersonne' , '$idRegime' , '$idType' , '$timePrep')";
  // echo "<br>";


  $requeteSQL = mysqli_query($connection, "INSERT INTO recette (nom_recette, desc_recette, nb_personne, id_regime, id_type, temps_prep) VALUES ('".$recipeName."', '$recipeDesc' , '$nbPersonne' , '$idRegime' , '$idType' , '$timePrep')");

  $selectIdRecette = mysqli_query($connection, "SELECT id_recette FROM recette WHERE nom_recette = '$recipeName'");

$id_new_recette = mysqli_fetch_assoc($selectIdRecette);

// INSERT INTO liste_ingredients VALUES(NULL, $id_recette, $qteIng, $id_ingredient);
foreach ($ingredientArray as $key => $id_ingredient) {
  mysqli_query($connection, "INSERT INTO liste_ingredients
    VALUES (NULL, '$id_new_recette[id_recette]', '$qteIngArray[$key]', '$ingredientArray[$key]')");
}

foreach ($instructionArray as $key => $desc_instruction) {
  $id_instruction = $key + 1;
  mysqli_query($connection, "INSERT INTO instructions VALUES (NULL, '$instructionArray[$key]', '$id_instruction', '$id_new_recette[id_recette]')");
}

// upload image in directory
$tmpName = $_FILES['recipeImg']['tmp_name'];
$name = $_FILES['recipeImg']['name'];
$size = $_FILES['recipeImg']['size'];
$error = $_FILES['recipeImg']['error'];
$extension = explode('/', $_FILES['recipeImg']['type']);
$img_path = "/images/".$id_new_recette['id_recette'].".".$extension[1];
$img_path_query = "/workshopCuisine/images/".$id_new_recette['id_recette'].".".$extension[1];

mysqli_query($connection, "UPDATE recette SET img_plat = '$img_path_query' WHERE id_recette = '$id_new_recette[id_recette]'");

// move_uploaded_file($tmpName, dirname(__FILE__)."/../../images".$id_recette);

// while ($row = mysqli_fetch_assoc($requete_ing)){
//   echo "<pre>";
//   print_r($row);
//   echo "</pre>";
// }

  // echo "je suis l'id de la recette entrée : ";
  // // echo "<pre>";
  // // print_r($selectIdRecette);
  // // echo "</pre>";
  // echo "<br>";
  // echo "SELECT id_recette FROM recette WHERE nom_recette = '$recipeName'";
  // echo "<br>";

  // echo "INSERT INTO liste_ingredients VALUES (NULL, '$selectIdRecette', '$qteIng1', '$ingredient1');";
  // echo "<br>";
  // echo "INSERT INTO liste_ingredients VALUES (NULL, '$selectIdRecette', '$qteIng2', '$ingredient2');";
  // echo "<br>";
  // echo "INSERT INTO liste_ingredients VALUES (NULL, '$selectIdRecette', '$qteIng3', '$ingredient3');";
  // echo "<br>";

  // $requeteSqlListeIng = mysqli_query($connection, "INSERT INTO liste_ingredients VALUES (NULL, '$selectIdRecette', '$qteIng1', '$ingredient1');");
  // $requeteSqlListeIng = mysqli_query($connection, "INSERT INTO liste_ingredients VALUES (NULL, '$selectIdRecette', '$qteIng2', '$ingredient2');");
  // $requeteSqlListeIng = mysqli_query($connection, "INSERT INTO liste_ingredients VALUES (NULL, '$selectIdRecette', '$qteIng3', '$ingredient3');");


  ?>
