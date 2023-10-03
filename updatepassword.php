<?php
    //start session
    session_start();
    //connect to the database
    include("connection.php");
    //get user id
    $user_id = $_SESSION["user_id"];    
    //define errors
    $errors = $currentPassword = $password = $password2 = "";
    $missingCurrentPassword = '<p><strong>Please enter your Current Password!</strong></p>';
    $wrongPassword = '<p><strong>You entered wrong Password!</strong></p>';
    $missingPassword = '<p><strong>Please enter a new Password!</strong></p>';
    $invalidPassword = '<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
    $samePassword = '<p><strong>The new Password must be different from the current!</strong></p>';
    $missingPassword2 = '<p><strong>Please confirm your Password!</strong></p>';
    $differentPasswords = '<p><strong>Passwords don\'t match!</strong></p>';
    //get passwords sent through AJAX
    if (empty($_POST["currentpassword"])) {
        $errors .= $missingCurrentPassword;
    } else {
        $currentPasswordTest = filter_var($_POST["currentpassword"], FILTER_UNSAFE_RAW);
        $currentPassword = mysqli_real_escape_string($link, $currentPasswordTest);
        $currentPassword = hash("sha256", $currentPassword);
        //check if given password is correct
        $sql = "SELECT * FROM users WHERE user_id = '$user_id' AND password = '$currentPassword'";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo '<div class="alert alert-danger">Unable to check your password! Please try again later.</div>';
            exit;
        }
        $count = mysqli_num_rows($result);
        if ($count !== 1) {
            $errors .= $wrongPassword;
        }
    }
    if (empty($_POST["password"])) {
        $errors .= $missingPassword;
    } else if (!(strlen($_POST["password"]) >= 6 AND preg_match("/[A-Z]/", $_POST["password"]) AND preg_match("/[0-9]/", $_POST["password"]))) {
        $errors .= $invalidPassword;
    } else {
        $password = filter_var($_POST["password"], FILTER_UNSAFE_RAW);
        if ($password == $currentPasswordTest) {
            $errors .= $samePassword;
        }
        if (empty($_POST["password2"])) {
            $errors .= $missingPassword2;
        } else {
            $password2 = filter_var($_POST["password2"], FILTER_UNSAFE_RAW);
            if ($password !== $password2) {
                $errors .= $differentPasswords;
            }
        }
    }
    //if there are any errors print error message
    if ($errors) {
        echo '<div class="alert alert-danger">' . $errors . '</div>';
        exit;
    }
    //no errors
    //prepare variable for the query
    $password = mysqli_real_escape_string($link, $password);
    $password = hash("sha256", $password);
    //run query and update password
    $sql = "UPDATE users SET password = '$password' WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">The password could not be updated! Please try again later.</div>';
    } else {
        echo "success";
    }
?>

