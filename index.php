<!DOCTYPE html>
<?php
require 'include/init.php';
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oberu</title>
    <link rel="shortcut icon" type="image/jpg" href="images/oberu.png"/>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/responsive.css">
    <link rel="stylesheet" href="style/search_style.css">
    <link rel="stylesheet" href="style/form_style.css">
    <link rel="stylesheet" href="style/recette_style.css">
    <link rel="stylesheet" href="style/homepage_responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

	<script  src="https://code.jquery.com/jquery-3.6.0.min.js"  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="  crossorigin="anonymous"></script>
  </head>
  <body>
    <!--                    HEADER                     -->

    <div id="header">
      <?php
        require"template/structure/header.php";
      ?>
    </div>

    <!--                    CONTENT                    -->

    <div id="content">
    <?php
      require"template/structure/content.php";
    ?>
    </div>

    <!--                    FOOTER                     -->

    <div id="footer">
    <?php
      require"template/structure/footer.php";
    ?>
    </div>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="script/script.js"></script>

  </body>
</html>
