<?php
    //Connect to the database
    $link = mysqli_connect("localhost", "root", "root", "scotchbox");
    if (mysqli_connect_error()) {
        die("ERROR: Unable to connect" . mysqli_connect_error());
        echo "<script>window.alert('Hello!');</script>";
    }
?>

