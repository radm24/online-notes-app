<?php
    //Start session
    session_start();
    //Connect to the database
    include("connection.php");
    //Check user inputs
    //Define error messages
    $errors = $email = "";
    $missingEmail = '<p>Please enter your email address!</p>';
    $invalidEmail = '>p>Please enter a valid email!</p>';
    //Get email
    //Store errors in errors variable
    if (empty($_POST["forgotpassemail"])) {
        $errors .= $missingEmail;
    } else {
        $email = filter_var($_POST["forgotpassemail"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($_POST["forgotpassemail"], FILTER_VALIDATE_EMAIL)) {
            $errors .= $invalidEmail;
        }
    }
    //If there are any errors print error message
    if ($errors) {
        $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
        echo $resultMessage;
        exit;
    }
    //No errors
    //Prepare variables for the query
    $email = mysqli_real_escape_string($link, $email);
    //Run query to check if the email exists in the users table
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">Error running the query!</div>';
        exit;
    }
    $count = mysqli_num_rows($result);
    //If the email does not exist print error message
    if ($count !== 1) {
        echo '<div class="alert alert-danger">The email is not registered!</div>';
        exit;
    }
    //Else
    //Get the user_id
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $user_id = $row["user_id"];
    //Create a unique activation code
    $key = bin2hex(openssl_random_pseudo_bytes(16));
    //Insert user details and activation code in the forgotpassword table
    $time = time();
    $status = "pending";
    $sql = "INSERT INTO forgotpassword (user_id, rkey, time, status) VALUES ('$user_id', '$key', '$time', '$status')";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>';
        exit;
    }
    //Send email with link to resetpassword.php with the user id and activation code
    $message = "Please click on this link to reset your password:\r\n";
    $message .= "http://localhost/radikdeveloper/online-notes-app/resetpassword.php?user_id=$user_id&key=$key";
    $mailOk = mail($email, "Reset your password", $message, 'From:' . 'rmcoding@gmail.com');
    //If email sent successfully print success message
    if ($mailOk) {
        echo "<div class='alert alert-success'>An email has been sent to $email. Please click on the link to reset your password.</div>";
    }
?>

