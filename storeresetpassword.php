<!-- This file receives: user_id, generated key to reset password, password1 and password2 -->
<!-- This file then resets password for user_id if all checks are correct -->
<?php
    session_start();
    include("connection.php");
    //If user_id or reset key is missing print error message
    if (!isset($_POST["user_id"]) || !isset($_POST["key"])) {
        echo '<div class="alert alert-danger>There was an error. Please click on the link your received by email.</div>';
        exit;
    }
    //Store them in two variables
    $user_id = $_POST["user_id"];
    $key = $_POST["key"];
    $time = time() - 86400;
    //Prepare variables for query
    $user_id = mysqli_real_escape_string($link, $user_id);
    $key = mysqli_real_escape_string($link, $key);
    //Run query: check combination of user_id & key exists and less than 24h old
    $sql = "SELECT user_id FROM forgotpassword WHERE user_id = '$user_id' AND rkey = '$key' AND time > '$time' AND status = 'pending'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">Error running the query!</div>';
        exit;
    }
    //If combination does not exist show an error message
    $count = mysqli_num_rows($result);
    if ($count !== 1) {
        echo '<div class="alert alert-danger">Unable to reset password!</div>';
        exit;
    }
    
    //Define error messages
    $errors = $password = "";
    $missingPassword = '<p><strong>Please enter a Password</strong></p>';
    $invalidPassword = '<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
    $missingPassword2 = '<p><strong>Please confirm your Password!</strong></p>';
    $differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
    //Get passwords 1&2
    if (empty($_POST["password"])) {
        $errors .= $missingPassword;
    } else if (!(strlen($_POST["password"]) >= 6 AND preg_match("/[A-Z]/", $_POST["password"]) AND preg_match("/[0-9]/", $_POST["password"]))) {
        $errors .= $invalidPassword;
    } else {
        $password = filter_var($_POST["password"], FILTER_UNSAFE_RAW);
        if (empty($_POST["password2"])) {
            $errors .= $missingPassword2;
        } else {
            $password2 = filter_var($_POST["password2"], FILTER_UNSAFE_RAW);
            if ($password !== $password2) {
                $errors .= $differentPassword;
            }
        }
    }
    //If there are any errors print error
    if ($errors) {
        $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
        echo $resultMessage;
        exit;
    }
    //No errors
    //Prepare variables for the queries
    $password = mysqli_real_escape_string($link, $password);
    $password = hash("sha256", $password);
    $user_id = mysqli_real_escape_string($link, $user_id);
    //Run query: update users password in the users table
    $sql = "UPDATE users SET password = '$password' WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">There was an error storing the new password in the database!</div>';
        exit;
    }
    //Set the key status to "used" in the forgotpassword table to prevent the key from being used multiple times
    $sql = "UPDATE forgotpassword SET status = 'used' WHERE user_id = '$user_id' AND rkey = '$key'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">Error running the query!</div>';
    } else {
        echo '<div class="alert alert-success">Your password has been updated successfully!&nbsp;<a href="index.php">Login</a></div>';
    }
?>
