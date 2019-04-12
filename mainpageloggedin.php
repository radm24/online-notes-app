<?php
    session_start();
    if(!isset($_SESSION["user_id"])) {
        header("location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>My Notes</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="style.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav role="navigation" class="navbar navbar-custom navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="navbar-brand">Online Notes</a>
                <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbarCollapse" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="#">Profile</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li class="active"><a href="#">My Notes</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Logged in as <b>username</b><?php  ?></a></li>
                    <li><a href="index.php?logout=1">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Notes container -->
    <div class="container" id="notesField">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="buttons">
                    <button id="addNote" type="button" class="btn btn-lg btn-dark">Add Note</button>
                    <button id="edit" type="button" class="btn btn-lg btn-dark pull-right">Edit</button>
                    <button id="allNotes" type="button" class="btn btn-lg btn-dark">All Notes</button>
                    <button id="done" type="button" class="btn btn-lg green pull-right">Done</button>
                </div>
                <div id="notePad">
                    <textarea rows="10"></textarea>
                </div>
                <div id="notes" class="notes">
                    <!-- AJAX call to PHP file -->
                </div>
            </div>
        </div>
    </div>
       
    <!-- Footer -->
    <div class="footer">
        <div class="container">
            <p>RMCoding Copyright &copy; <?php $curdate = date("Y"); echo $curdate; ?></p>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>