<?php
    //start session and connect to the database
    session_start();
    include("connection.php");
    //get user id
    $user_id = $_SESSION["user_id"];
    //get current username from the database
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    if ($result = mysqli_query($link, $sql)) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $current_username = $row["username"];
    } else {
        echo '<div class="alert alert-danger><strong>There was an issue running query to the database!</strong></div>';
    }
    //declare errors
    $errors = $username = "";
    $missingUsername = '<p><strong>Please enter your new username!</strong></p>';
    $sameUsername = '<p><strong>Please enter a new username!</strong></p>';
    //get username sent through AJAX
    if (empty($_POST["username"])) {
        $errors .= $missingUsername;
    } else {
        $username = filter_var($_POST["username"], FILTER_UNSAFE_RAW);
        if ($username == $current_username) {
            $errors .= $sameUsername;
        }
    }
    if ($errors) {
        echo '<div class="alert alert-danger">' . $errors . '</div>';
        exit;
    }
    //prepare variable for query
    $username = mysqli_real_escape_string($link, $username);
    //run query and update username
    $sql = "UPDATE users SET username = '$username' WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo "success";
    } else {
        echo '<div class="alert alert-danger">There was an error storing the new username in the database!</div>';
    }
?>

