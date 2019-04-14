<?php
    //If the user is not logged in & rememberme cookie exists
    if (!isset($_SESSION["user_id"]) AND !empty($_COOKIE["rememberme"])) {
        //array_key_exists("user_id", $_SESSION);
            //f1: COOKIE: $a . "," . bin2hex($b)
            //f2: hash("sha256", $a)
        //Extract $authentificators 1&2 from the cookie
        list($authentificator1, $authentificator2) = explode(",", $_COOKIE["rememberme"]);
        $authentificator2 = hex2bin($authentificator2);
        $f2authentificator2 = hash("sha256", $authentificator2);
        //Look for authentificator1 in the rememberme table
        $sql = "SELECT * FROM rememberme WHERE authentificator1 = '$authentificator1'";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo '<div class="alert alert-danger">There was an error running the query.</div>';
            exit;
        }
        $count = mysqli_num_rows($result);
        if ($count !== 1) {
            echo '<div class="alert alert-danger"><strong>Remember me process failed!</strong></div>';
            exit;
        }
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        //If authentificator2 does not match print error
        if (!hash_equals($row["f2authentificator2"], $f2authentificator2)) {
            echo '<div class="alert alert-danger"><strong>hash_equals returned false.</strong></div>'; 
        } else {
            //Generate new authentificators
            //Store them in cookie and rememberme table
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
            $user_id = $row["user_id"];
            $expiration = date('Y-m-d-H:i:s', time() + 1296000);
            $sql = "INSERT INTO rememberme (authentificator1, f2authentificator2, user_id, expires) VALUES ('$authentificator1', '$f2authentificator2', '$user_id', '$expiration')";
            $result = mysqli_query($link, $sql);
            if (!$result) {
                echo '<div class="alert alert-danger>There was en error storing data to remember you next time.</div>';
            }
            //Log the user in and redirect to notes page
            $_SESSION["user_id"] = $row["user_id"];
            header("location: mynotes.php");
        } 
    }
?>
