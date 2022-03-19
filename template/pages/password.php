<?php

echo "<div id='formContainerLogin'>";

  echo "<div id='formTitle'><h4>récuperation du mot de passe</h4></div><br>";

  echo "<form id='password_recup' method='POST'>";
    echo "<input type='email' class='inputStyle' id='email_recup' name='email_recup' placeholder='email' required><br>";
    echo "<input type='submit' class='inputStyle' id='formSubmit' value='envoyer'>";
  echo "</form>";
echo "</div>";

echo "<br><br>";


$mail_recup = $_POST['email_recup'];



$recup_key = md5(random_str_generator(12));

send_mail_recovery($mail_recup, $recup_key);

$recup_key = "";













// mail(
//     $mail_recup,
//     'password recovery',
//     'use the following link to change your password',
//     array|string $additional_headers = [],
//     string $additional_params = ""
// )

?>
