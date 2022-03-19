<?php

  // ini_set('display_errors', 1);
  // error_reporting(E_ERROR | E_WARNING | E_PARSE);

  // FORMULAIRE
  echo "<form id='login_form' method='post'>";


    echo "<div id='formContainerLogin'>";

      echo "<div id='formTitle'><h4>LOGIN</h4></div><br>";
      // echo "<div class='formDivider'> - username - </div>";
      echo "<input type='email' id='email' class='inputStyle' name='email' placeholder='email' required> <br/>";

      // echo "<div class='formDivider'> - password - </div>";
      echo "<input type='password' id='password' class='inputStyle' name='password' placeholder='password' required> <br/>";

      echo '<input type="hidden" id="hidden_action" name="action" value="login"></input>';

      // submit button
      echo "<input type='submit' id='formSubmit' class='inputStyle' value='Envoyer'> <br/>";
    echo "</form>";


    if ($login_fail == 1){
      echo 'email ou mot de passe incorrect.';
    }
    echo "<br>";
    echo "<a href='?page=password' style='color: #D86C6C'> Mot de passe oublié ?</a>";
    echo "<a href='?page=signin' style='color: #D86C6C'>creer un compte ici.</a>";

?>
