<?php include("includes/includedFiles.php"); ?>
<h1 class="pageHeadingBig">You Might Also Like</h1>
<div id="gridViewContainer">
     <?php
          $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

          while($row = mysqli_fetch_array($albumQuery)) {
               echo "<div class='gridViewItem'>
                         <a href='album.php?id=" . $row['id'] . "'>
                             <img src='" . $row['artworkPath'] . "' class='gridViewArtwork'>
                             <div class='gridViewInfo'>
                                  " . $row['title'] . "
                             </div>
                         </a>
                    </div>";
          }
     ?>
</div>