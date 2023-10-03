<?php
    //start session
    session_start();
    //connect to the database
    include("connection.php");
    //get user id and current email
    $user_id = $_SESSION["user_id"];
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    $count = mysqli_num_rows($result);
    if ($count == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $current_email = $row["email"];
    } else {
        echo "There was an error retrieving the email from the database!";
    }
    //define errors
    $errors = $email = "";
    $missingEmail = '<p><strong>Please enter a new email address!</strong></p>';
    $invalidEmail = '<p><strong>Please enter a valid email address!</strong></p>';
    $sameEmail = '<p><strong>You entered current email address!</strong></p>';
    //get email address
    if (empty($_POST["email"])) {
        $errors .= $missingEmail;
    } else {
        $new_email = filter_var($_POST["email"]);
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $errors .= $invalidEmail;
        } else if ($new_email == $current_email) {
            $errors .= $sameEmail;
        } else {
            //check if new email exists
            $sql = "SELECT * FROM users WHERE email = '$new_email'";
            $result = mysqli_query($link, $sql);
            if (!$result) {
                echo '<div class="alert alert-danger">Unable to update email address! Please try again later.</div>';
                exit;
            }
            $count = mysqli_num_rows($result);
            if ($count) {
                echo '<div class="alert alert-danger"><strong>The provided email is registered! Please choose another one!</strong></div>';
                exit;
            }
        }
    }
    //if there are any errors print error message
    if ($errors) {
        echo '<div class="alert alert-danger">' . $errors . '</div>';
        exit;
    }
    //create a unique activation code
    $activationKey = bin2hex(openssl_random_pseudo_bytes(16));
    //Insert new activation code in the users table
    $sql = "UPDATE users SET activation2 = '$activationKey' WHERE user_id = '$user_id'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">There was an error inserting ther user details in the database.</div>';
    } else {
        //send mail with the link to activatenewemail.php with the current email, new email and activation code
        $message = "Please click on this link to change your email address:\r\n";
        $message .= "http://localhost/radikdeveloper/online-notes-app/activatenewemail.php?email=" . urlencode($current_email) . "&newemail=" . urlencode($new_email) . "&key=$activationKey";
        $mailOk = mail($new_email, "Email Update for you on Online Notes App", $message, "From:" . "rmcoding@gmail.com");
        if ($mailOk) {
            echo "<div class='alert alert-success'>An email has been sent to $new_email. Please click on the link to change your email address.</div>";
        }
    }
?>

