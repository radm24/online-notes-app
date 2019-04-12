<!-- This file receives user_id and key generated to create the new password -->
<!-- This file displays form to input new password -->

<?php
    session_start();
    include("connection.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Password Reset</title>
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
            .contactForm form:last-child {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-offset-1 col-sm-10 contactForm">
                    <h1>Enter new Password</h1>
                    
                    <!-- Reset password message from PHP file -->
                    <div id="resetpasswordmessage"></div>
                    
    <?php
        //If user_id or reset key is missing print error message
        if (!isset($_GET["user_id"]) || !isset($_GET["key"])) {
            echo '<div class="alert alert-danger>There was an error. Please click on the link your received by email.</div>';
            exit;
        }
        //Store them in two variables
        $user_id = $_GET["user_id"];
        $key = $_GET["key"];
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
        //Print reset password form with hidden user_id and key fields
        echo 
        "<form method='post' id='passwordresetform'>
            <input type='hidden' name='key' value=$key>
            <input type='hidden' name='user_id' value=$user_id>
            <div class='form-group'>
                <label for='password'>Enter your new Password</label>
                <input class='form-control' id='password' name='password' type='password' placeholder='Enter Password'>
            </div>
            <div class='form-group'>
                <label for='password2'>Confirm your new Password</label>
                <input class='form-control' id='password2' name='password2' type='password' placeholder='Confirm Password'>
            </div>
            <input class='btn btn-lg btn-success' type='submit' name='resetpassword' value='Reset Password'>
        </form>";   
    ?>
                    
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <!-- Script for Ajax call to storeresetpassword.php which processes form data -->
        <script>
            //Once the form is submitted
            $("#passwordresetform").submit((event) => {
                //Prevent default php processing
                event.preventDefault();
                //Collect user inputs
                const datatopost = $(event.target).serializeArray();
                $.ajax({
                    url: "storeresetpassword.php",
                    type: "POST",
                    data: datatopost,
                    success: (data) => {
                        $("#resetpasswordmessage").html(data);
                    },
                    error: (error) => {
                        $("#resetpasswordmessage").html('<div class="alert alert-danger">There was an error with the AJAX call. Please try again latter.</div>');
                    }                    
                })
            })
        </script>
    </body>
</html>
