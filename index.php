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
                         <div class="content">
                              <span class="albumLink">
                                   <img src="assets/images/placeholders/square-image-orange.jpg" alt=""
                                   class="albumArtwork">
                              </span>
                              <div class="trackInfo">
                                   <span class="trackName">
                                        <span>The Bicycle on the Moon</span>
                                   </span>
                                   <span class="artistName">
                                        <span>Mateusz Hyla</span>
                                   </span>
                              </div>  
                         </div>
                    </div>
                    <div id="nowPlayingCenter">
                         <div class="content playerControls">
                              <div class="buttons">
                                   <button class="controlButton shuffle" title="Shuffle button">
                                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                                   </button>
                                   <button class="controlButton previous" title="Previous button">
                                        <img src="assets/images/icons/previous.png" alt="Previous">
                                   </button>
                                   <button class="controlButton play" title="Play button">
                                        <img src="assets/images/icons/play.png" alt="Play">
                                   </button>
                                   <button class="controlButton pause" title="Pause button" style="display: none;">
                                        <img src="assets/images/icons/pause.png" alt="Pause">
                                   </button>
                                   <button class="controlButton next" title="Next button">
                                        <img src="assets/images/icons/next.png" alt="Next">
                                   </button>
                                   <button class="controlButton repeat" title="Repeat button">
                                        <img src="assets/images/icons/repeat.png" alt="Repeat">
                                   </button>
                              </div>
                              <div id="playbackBar">
                                   <span class="progressTime current">0.00</span>

                                   <div class="progressBar">
                                        <div class="progressBarBg">
                                             <div class="progress">

                                             </div>
                                        </div>
                                   </div>
                                   
                                   <span class="progressTime remaining">0.00</span>
                              </div>
                         </div>
                    </div>
                    <div id="nowPlayingRight">
                         
                    </div>
               </div>
         </div>
     </body>
</html>    