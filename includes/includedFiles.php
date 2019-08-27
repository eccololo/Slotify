<?php
     //Jesli uzytkownik wchodzi na strone za pomoca requestu AJAX
     if(isset($_SERVER["HTTP_X_REQUESTED_WITH"])) {
         include("includes/config.php");
         include("includes/classes/Artist.php");
         include("includes/classes/Album.php");
         include("includes/classes/Song.php");
     } else {
         //Jesli uzytkownik wchodzi na strone za pomoca normalnego przekierowania HTTP
         include('includes/header.php');
         include('includes/footer.php');

         $url = $_SERVER['REQUEST_URI'];
         echo "<script>openPage('$url');</script>";
         exit();
     }
?>