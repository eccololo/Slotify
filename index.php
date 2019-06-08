<?php
     include("includes/config.php");

     //session_destroy(); //LOGOUT

     if(isset($_SESSION['userLoggedIn'])) {
          $userLoggedIn = $_SESSION['userLoggedIn'];
     } else {
          header("Location: register.php");
     }
?>

<html>
     <head>
          <title></title>
          <link rel="stylesheet" href="assets/css/style.css">
     </head>
     <body>
         <div id="nowPlayingBarContainer">
               <div id="nowPlayingBar">
                    <div id="nowPlayingLeft">

                    </div>
                    <div id="nowPlayingCenter">
                         <div class="content playerControls">
                              <div class="buttons">
                                   <button>hello</button>
                              </div>
                         </div>
                    </div>
                    <div id="nowPlayingRight">
                         
                    </div>
               </div>
         </div>
     </body>
</html>    