<?php 
    //Start session
    session_start();
    include("connection.php");
    
    //Check user input
    //Define error messages
    $errors = $username = $email = $password = "";
    $missingUsername = '<p><strong>Please enter a username!</strong></p>';
    $missingEmail = '<p><strong>Please enter your email address!</strong></p>';
    $invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
    $missingPassword = '<p><strong>Please enter a Password!</strong></p>';
    $invalidPassword = '<p><strong>Your password should be at least 6 characters long and include one capital letter and one number!</strong></p>';
    $missingPassword2 = '<p><strong>Please confirm your password!</strong></p>';
    $differentPassword = '<p><strong>Passwords don\'t match!</strong></p>';
    
    //Get username
    if (empty($_POST["username"])) {
        $errors .= $missingUsername;
    } else {
        $username = filter_var($_POST["username"], FILTER_UNSAFE_RAW);
    }
    //Get email
    if (empty($_POST["email"])) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors .= $invalidEmail;
        }
    }
    //Get passwords
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
    $username = mysqli_real_escape_string($link, $username);
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    $password = hash('sha256', $password);
    //If username exists in the users table print error
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">Error running the query!</div>';
        exit;
    }
    $results = mysqli_num_rows($result);
    if ($results) {
        echo '<div class="alert alert-danger">That username is already registered. Do you want to log in?</div>';
        exit;
    }
    //If email exists in the users table print error
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">Error running the query!</div>';
        // echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit;
    }
    $results = mysqli_num_rows($result);
    if ($results) {
        echo '<div class="alert alert-danger">That email is already registered. Do you want to log in?</div>';
        exit;
    }
    
    //Create a unique activation code
    $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    //Insert user details and activation code in the users table
    $sql = "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password', '$activationKey')";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>';
        echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
        exit;
    }
    //Send the user an email with a link to activate.php with their email and activation code
    $subject = 'Confirm your registration';
    $message = "Please click on this link to activate your account\r\n";
    $message .= "http://localhost/radikdeveloper/online-notes-app/activate.php?email=" . urlencode($email) . "&key=$activationKey";
    
    include('sendmail.php');

    if ($mailOk) {
        echo "<div class='alert alert-success'>Thank for your registring! A confirmation email has been sent to $email. Please click on the activation link to activate your account.</div>";
    }
?>