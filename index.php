<?php include("includes/header.php"); ?>
<h1 class="pageHeadingBig">You Might Also Like</h1>
<div id="gridViewContainer">
     <?php
          $albumQuery = mysqli_query($con, "SELECT * FROM albums");

          while($row = mysqli_fetch_array($albumQuery)) {
               echo $row["title"];
          }
     ?>
</div>
<?php include("includes/footer.php"); ?>

             