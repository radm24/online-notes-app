<?php
    //The user is re-directed to this file after clicking the activation link
    //Signup link contains two GET parameters: email and activation link
    session_start();
    include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Account Activation</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <style>
            h1 {
                color: purple;
            }
            .contactForm {
                border: 1px solid #7c7376;
                margin-top: 50px;
                border-radius: 15px;
            }
            .contactForm a{
                display: inline-block;
                margin-bottom: 20px;
                margin-top: -8px;
                line-height: 1.15;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 contactForm">
                    <h1>Account Activation</h1>
                    
    <?php
        //If email or activation key is missing show an error
        if (!isset($_GET["email"]) || !isset($_GET["key"])) {
            echo '<div class="alert alert-danger>There was an error. Please click on the activation link your received by email.</div>';
            exit;
        }
        //Store them in two variables
        $email = $_GET["email"];
        $key = $_GET["key"];
        //Prepare variables for query
        $email = mysqli_real_escape_string($link, $email);
        $key = mysqli_real_escape_string($link, $key);
        //Run query: set activation field to "activated" for the provided email
        $sql = "UPDATE users SET activation = 'activated' WHERE (email = '$email' AND activation = '$key') LIMIT 1";
        //If query is successful, show success message and invite user to login
        $result = mysqli_query($link, $sql);
        if (mysqli_affected_rows($link) == 1) {
            echo '<div class="alert alert-success">Your account has been activated.</div>';
            echo '<a href="index.php" type="button" class="btn-lg btn-success">Log in</a>';
        } else {
            //else show error message
            echo '<div class="alert alert-danger">Your account could not be activated. Please try again later.</div>';
        }       
    ?>
                    
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
        