<?php
class Artist {

    private $id;
    private $con;

    public function __construct($con, $id) {
        $this->id = $id;
        $this->con = $con;
    }

    public function getName() {
        $artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
        $artist = mysqli_fetch_array($artistQuery);

        return $artist['name'];
    }
        
}
?>