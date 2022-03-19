<?php

    // ini_set('display_errors', 1);
    // error_reporting(E_ERROR | E_WARNING | E_PARSE);

	session_start();

	$login_fail = 0;

	$connection= mysqli_connect("localhost","root","", "workshopCuisine");
    mysqli_set_charset( $connection, 'utf8');

    if(isset($_GET['logout'])){
      if ($_GET['logout'] == "true"){
        session_destroy();
        $_SESSION = [];
      }
    }else {

      if (isset($_POST['action'])) {
         if($_POST['action'] == 'login') {
           $email = $_POST['email'];
           $password = $_POST['password'];

           $crypted_password = md5($password);

           if (isset($email)) {
             echo "SELECT * FROM users WHERE mail_user = '$email' and password_user = '$crypted_password'";
             $login_query = mysqli_query($connection, "SELECT * FROM users WHERE mail_user = '$email' and password_user = '$crypted_password'");
             $row = mysqli_fetch_assoc($login_query);

				print_r( $login_query);

             if ($row['mail_user'] == $email and $row['password_user'] == $crypted_password) {

                $_SESSION['user_id'] = $row['id_user'];
                $_SESSION['username'] = $row['name_user'];
        			  $url = $_SERVER['SCRIPT_URI'];
        				header("Location: $url");
        				exit();

             } else{
               $login_fail = 1;
             }
           }
         }
      }
    }


    $pagesArray = [
      "homepage",
      "recette",
      "search",
      "form",
      "login",
      "signin",
			"password"
    ];

// recuperation tous les recettes dans un tableau
    $requete_recettes = mysqli_query($connection, "SELECT * FROM recette;");
    $recettes = [];
    while ($row = mysqli_fetch_assoc($requete_recettes)) {
      // $liste_ingredients[$row['id_ingredient']]=$row["nom_ingredient"];
      array_push($recettes, $row);
    }

// recuperation tous les ingrédients dans un tableau
    $requete_ing = mysqli_query($connection, "SELECT * FROM ingredients;");
    $ingredients = [];
    while ($row = mysqli_fetch_assoc($requete_ing)) {
      // $liste_ingredients[$row['id_ingredient']]=$row["nom_ingredient"];
      array_push($ingredients, $row);
    }

// recuperation tous les types dans un tableau
    $requete_types = mysqli_query($connection, "SELECT * FROM type;");
    $types = [];
    while ($row = mysqli_fetch_assoc($requete_types)) {
      // $liste_ingredients[$row['id_ingredient']]=$row["nom_ingredient"];
      array_push($types, $row);
    }

// recuperation tous les regimes dans un tableau
    $requete_regimes = mysqli_query($connection, "SELECT * FROM regime;");
    $regimes = [];
    while ($row = mysqli_fetch_assoc($requete_regimes)) {
      // $liste_ingredients[$row['id_ingredient']]=$row["nom_ingredient"];
      array_push($regimes, $row);
    }


function random_str_generator ($len_of_gen_str){
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$var_size = strlen($chars);

	for( $x = 0; $x < $len_of_gen_str; $x++ ) {
		$random_str= $random_str.$chars[ rand( 0, $var_size - 1 ) ];
	}

	return $random_str;
}




	function send_mail_recovery($to, $key){
		//$to      = 'arnaud.richert.pro@gmail.com';
		$subject = 'Password Recovery';
		$message = "
		<html>
		 <head>
			<title>recovery key - mot de passe oublié</title>
		 </head>
		 <body>
			<p> Pour changer votre mot de passe, cliquez sur le lien suivant ou copiez-collez le dans votre navigateur: <p>
			<a href='https://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=password&recovery_key=".$key."'> https://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=password&recovery_key=".$key."</a>
		 </body>
		</html>";

		// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
     $headers[] = 'MIME-Version: 1.0';
     $headers[] = 'Content-type: text/html; charset=iso-8859-1';

     // En-têtes additionnels
     $headers[] = 'To: '.$mail_user;
     $headers[] = 'From: Password Recovery <passwordrecovery@noreply.com>';

		 mail($to, $subject, $message, implode("\r\n", $headers));


		// echo mail($to, $subject, $message, $headers);
	}

		// <a href='http://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=password&recovery_key='.$key.'> http://kbcterv.cluster029.hosting.ovh.net/workshopCuisine/?page=password&recovery_key='.$key.'</a>

?>
