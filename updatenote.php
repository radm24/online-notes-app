<?php
    session_start();
    include("connection.php");
    //get the id of the note sent through Ajax
    $note_id = $_POST['id'];
    $note_id = intval($note_id);
    //get the content of the note
    $note_content = $_POST['note'];
    //get the time 
    $time = time();
    //run a query to update the note
    $sql = "UPDATE notes SET note = '$note_content', time = '$time' WHERE id = '$note_id'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "error";
    }
?>

