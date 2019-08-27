<?php
    $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

    $resultArray = array();
    while($row = mysqli_fetch_array($songQuery)) {
          array_push($resultArray, $row['id']);
    }

    $jsonArray = json_encode($resultArray);
?>
<script>
     $(document).ready(function() {
          var newPlaylist = <?php echo $jsonArray; ?>;
          audioElement = new Audio();
          setTrack(newPlaylist[0], newPlaylist, false);

          //Na samym poczatku przy ladowaniu sie strony volume bar jest na 100%.
          updateVolumeProgressBar(audioElement.audio);

          //Zapobiegamy przypadkowemu zaznaczeniu przez myszke elementow playing bara.
          $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
               e.preventDefault();
          });

          //Ewenty dzieki ktorym mozemy kliknac na progress bar piosenki i przesunac ja w lewo lub w prawo
          $("#playbackBar .progressBar").mousedown(function() {
               mouseDown = true;
          });

          $("#playbackBar .progressBar").mousemove(function(e) {
               if(mouseDown) {
                    timeFromOffset(e, this);
               }
          });

          $("#playbackBar .progressBar").mouseup(function(e) {
                    timeFromOffset(e, this);
          });
          // -- Koniec -- //

          //Ewenty dzieki ktorym mozemy kliknac na progress bar glosnosci i przesunac ja w lewo lub w prawo
          $(".volumeBar .progressBar").mousedown(function() {
               mouseDown = true;
          });

          $(".volumeBar .progressBar").mousemove(function(e) {
               if(mouseDown) {
                    var percentage = e.offsetX / $(this).width();
                    if(percentage >= 0 && percentage <= 1) {
                         audioElement.audio.volume = percentage;
                    }
               }
          });

          $(".volumeBar .progressBar").mouseup(function(e) {
                    var percentage = e.offsetX / $(this).width();
                    if(percentage >= 0 && percentage <= 1) {
                         audioElement.audio.volume = percentage;
                    }
          });
          // -- Koniec -- //

          $(document).mouseup(function() {
               mouseDown = false;
          });
     });

     //Funkcja ktora pomaga nam obliczyc ile musimy updatowac progress baru i jak ustawic duration piosenki 
     //kiedy klikniemy na progress bar.
     function timeFromOffset(mouse, progressBar) {
          var percentage = mouse.offsetX / $(progressBar).width() * 100;
          var seconds = audioElement.audio.duration * (percentage / 100);
          audioElement.setTime(seconds);
     }

     //Kiedy nacisniemy button wstecz daje nam previous song
     function prevSong() {
          //Jesli jestesmy na pierwszej piosence z listy lub jesli piosenka juz gra jakis czas
          //to wracamy na start piosenki.
          if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
               audioElement.setTime(0);
          } else {
               currentIndex--;
               setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
          }
     }

     //Funkcja ktora daje nam nastepna piosenke po wcisnieciu przycisku.
     function nextSong() {

          //Jesli zapetlamy piosenke
          if(repeat == true) {
               audioElement.setTime(0);
               playSong();
               return;
          }

          //Jesli doszlismy do ostatniej piosenki
          if(currentIndex == currentPlaylist.length - 1) {
               currentIndex = 0;
          } else {
               currentIndex++;
          }

          var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
          setTrack(trackToPlay, currentPlaylist, true);
     }

     function setRepeat() {
          repeat = !repeat;
          var imageName = repeat ? "repeat-active.png" : "repeat.png";
          $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName); 
     }

     function setMute() {
          audioElement.audio.muted = !audioElement.audio.muted;
          var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
          $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName); 
     }

     function setShuffle() {
          shuffle = !shuffle;
          //Zmien ikonke shuffle po kliknieciu w nia
          var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
          $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName); 

          if(shuffle == true) {
               //pomieszaj playliste
               shuffleArray(shufflePlaylist);
               currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
          } else {
               //Wracamy do normalnej playlisty, shuffle zostal wylaczony
               currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
          }
     }

     function shuffleArray(a) {
          var j, x, i;
          for(i = a.length; i; i--) {
               j = Math.floor(Math.random() * i);
               x = a[i - 1];
               a[i - 1] = a[j];
               a[j] = x;
          }
     }

     function setTrack(trackId, newPlaylist, play) {

          if(newPlaylist != currentPlaylist) {
               currentPlaylist = newPlaylist;
               //Tworzymy kopie newPLaylist za pomoca funkcji slice.
               shufflePlaylist = currentPlaylist.slice();
               shuffleArray(shufflePlaylist);
          }

          if(shuffle == true) {
               currentIndex = shufflePlaylist.indexOf(trackId);
          } else {
               currentIndex = currentPlaylist.indexOf(trackId);
          }
          
          pauseSong();

          $.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {
               
               var track = JSON.parse(data);
               
               $(".trackName span").text(track.title); 

               $.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist}, function(data) {
                    var artist = JSON.parse(data);

                    $(".artistName span").text(artist.name); 
               });

               $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album}, function(data) {
                    var album = JSON.parse(data);
                    $(".albumLink img").attr("src", album.artworkPath);
               });

               audioElement.setTrack(track);
               //audioElement.play();
               playSong();
               
          });
          if(play) {
               audioElement.play();
          }
     }

     function playSong() {

          //Jesli zaczelismy sluchac nowej piosenki i jestesmy na jej poczatku updatujemy plays w db
          if(audioElement.audio.currentTime == 0) {
               $.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentlyPlaying.id});
          } 

          $(".controlButton.play").hide();
          $(".controlButton.pause").show();
          audioElement.play();
     }

     function pauseSong() {
          $(".controlButton.play").show();
          $(".controlButton.pause").hide();
          audioElement.pause();
     }
</script>
<div id="nowPlayingBarContainer">
               <div id="nowPlayingBar">
                    <div id="nowPlayingLeft">
                         <div class="content">
                              <span class="albumLink">
                                   <img src="" alt=""
                                        class="albumArtwork">
                              </span>
                              <div class="trackInfo">
                                   <span class="trackName">
                                        <span></span>
                                   </span>
                                   <span class="artistName">
                                        <span></span>
                                   </span>
                              </div>
                         </div>
                    </div>
                    <div id="nowPlayingCenter">
                         <div class="content playerControls">
                              <div class="buttons">
                                   <button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle();">
                                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                                   </button>
                                   <button class="controlButton previous" title="Previous button" onclick="prevSong();">
                                        <img src="assets/images/icons/previous.png" alt="Previous">
                                   </button>
                                   <button class="controlButton play" title="Play button" onclick="playSong();">
                                        <img src="assets/images/icons/play.png" alt="Play">
                                   </button>
                                   <button class="controlButton pause" title="Pause button" style="display: none;" 
                                   onclick="pauseSong();">
                                        <img src="assets/images/icons/pause.png" alt="Pause">
                                   </button>
                                   <button class="controlButton next" title="Next button" onclick="nextSong();">
                                        <img src="assets/images/icons/next.png" alt="Next">
                                   </button>
                                   <button class="controlButton repeat" title="Repeat button" onclick="setRepeat();">
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
                         <div class="volumeBar">
                              <button class="controlButton volume" title="Volume button" onclick="setMute();">
                                   <img src="assets/images/icons/volume.png" alt="Volume">
                              </button>
                              <div class="progressBar">
                                   <div class="progressBarBg">
                                        <div class="progress">

                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>