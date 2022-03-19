<?php

ini_set('display_errors', 1);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

  echo "<div id=formTitle style='color: black'><h1>SIGN IN</h1></div><br>";

  // FORMULAIRE
  echo "<form id='signin_form' method='post'>";

    echo "<div id='formContainer'>";

      // echo "<input type='text' id='prenom' class='inputStyle' name='prenom' placeholder='prénom' required> <br/>";

      // echo "<input type='text' id='nom' class='inputStyle' name='nom' placeholder='nom' required> <br/>";

      echo "<input type='email' id='email' class='inputStyle' name='email' placeholder='email' required> <br/>";

      // echo "<div class='formDivider'> - username - </div>";
      echo "<input type='text' id='username' class='inputStyle' name='username' placeholder='username' required> <br/>";

      // echo "<div class='formDivider'> - password - </div>";
      echo "<input type='password' id='password' class='inputStyle' name='password' placeholder='password' required> <br/>";

      echo "<input type='password' id='passwordCheck' class='inputStyle' name='passwordCheck' placeholder='password' required> <br/>";

      // submit button
      echo "<input type='submit' id='formSubmit' class='inputStyle' value='Envoyer'> <br/>";
    echo "</form>";


    $email = $_POST["email"];

    $username = $_POST["username"];

    $raw_password = $_POST["password"];

    $password = $_POST["passwordCheck"];

    $crypted_password = md5($password);

    if(isset($email)){
      $email_query = mysqli_query($connection, "SELECT * FROM users WHERE mail_user = '$email'");
      $row = mysqli_fetch_assoc($email_query);

      if ($row['mail_user'] == $email) {
        echo "Impossible de créer un compte: adresse mail déjà utilisée.</br>";
        echo "<br><a href='?page=login' style='color: #D86C6C'>se connecter ici.</a>";
      } else{
        $insert_query = mysqli_query($connection, "INSERT INTO users (name_user, mail_user, password_user) VALUES ('$username','$email','$crypted_password')");
        echo "votre compte a bien été créé !";
      }
    } else{

    }
?>
