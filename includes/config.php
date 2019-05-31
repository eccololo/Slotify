<?php
    //Wlacza output buffer ktory ulatwia przesylanie danych na serwer.
    ob_start();
    session_start();

    //Ustawiamy domyslny timezone tak zebysmy mieli poprawne daty i czas w bazie danych wstawiany
    $timezone = date_default_timezone_set("Europe/Warsaw");

    $con = mysqli_connect("localhost", "root", "root", "slotify");
    if(mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
    }
?>