<?php

$get = $_GET;

$error404 = true;


if(!isset($get["page"])){
    // echo "<div id='homePage'>";
    require "template/pages/homepage.php";
    $error404 = false;
    // echo "</div>";
}else{
    foreach($pagesArray as $key => $page){
        if($page == $get["page"]){
            if ( $page == 'recette' and !isset($get['id'])){
              $error404 = true;
            }else{
              require dirname (__FILE__)."/../pages/".$page.".php";
              $error404 = false;
            }
            // require "template/pages/".$page.".php/";
            // echo dirname (__FILE__);
        }
    }
}

//Affichage de la page error404
if($error404 == true){
    require dirname (__FILE__)."/../pages/"."error404.php";
}

?>
