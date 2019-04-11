<?php
    //Start session
    session_start();
    include("connection.php");
    
    //Check user input
    //Define error messages
    $errors = $email = $password = "";
    $missingEmail = '<p><strong>Please enter your email address!</strong></p>';
    $missingPassword = '<p><strong>Please enter a Password!</strong></p>';
    
    //Get email
    if (empty($_POST["loginemail"])) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL);
    }
    //Get password
    if (empty($_POST["loginpassword"])) {
        $errors .= $missingPassword;
    } else {
        $password = filter_var($_POST["loginpassword"], FILTER_SANITIZE_STRING);
    }
    //If there are any errors print error
    if ($errors) {
        $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
        echo $resultMessage;
    } else {
        //No errors
        //Prepare variables for the queries
        $email = mysqli_real_escape_string($link, $email);
        $password = mysqli_real_escape_string($link, $password);
        $password = hash('sha256', $password);
        //Run query: check combination of email & passwords exists
        $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND activation = 'activated'";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo '<div class="alert alert-danger">Error running the query!</div>';
            exit;
        }
        //If email and password don't match print error
        $count = mysqli_num_rows($result);
        if ($count !== 1) {
            echo '<div class="alert alert-danger"><strong>Wrong Username or Password</strong></div>';
        } else {
            //Log the user in: set session variables
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $row["email"];
            //Check if "Remember me" checked
            if (empty($_POST["rememberme"])) {
                echo "success";
            } else {
                
            }
        }
    }
?>