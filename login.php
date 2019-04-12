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
                //Create two variables $authentificator1 and $authentificator2
                $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
                $authentificator2 = openssl_random_pseudo_bytes(20);
                //Store them in a cookie
                function f1($a, $b) {
                    $c = $a . "," . bin2hex($b);
                    return $c;
                }
                $cookieVal = f1($authentificator1, $authentificator2);
                setcookie("rememberme", $cookieVal, time() + 1296000);
                //Run query to store them in rememberme table
                function f2($a) {
                    $b = hash("sha256", $a);
                    return $b;
                }
                $f2authentificator2 = f2($authentificator2);
                $user_id = $_SESSION["user_id"];
                $expiration = date('Y-m-d-H:i:s', time() + 1296000);
                $sql = "INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expires) VALUES ('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";
                $result = mysqli_query($link, $sql);
                if (!$result) {
                    echo '<div class="alert alert-danger>There was en error storing data to remember you next time.</div>';
                } else {
                    echo 'success';
                }
            }
        }
    }
?>