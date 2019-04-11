<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Profile</title>
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
                    <li class="active"><a href="#">Profile</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact us</a></li>
                    <li><a href="#">My Notes</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">Logged in as <b>username</b><?php  ?></a></li>
                    <li><a href="#loginModal">Log out</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Notes container -->
    <div class="container" id="profileField">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h2>General Account Settings:</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered">
                        <tr data-target="#updateusernameModal" data-toggle="modal">
                            <td>Username</td>
                            <td>value</td>
                        </tr>
                        <tr data-target="#updateemailModal" data-toggle="modal">
                            <td>Email</td>
                            <td>value</td>
                        </tr>
                        <tr data-target="#updatepasswordModal" data-toggle="modal">
                            <td>Password</td>
                            <td>hidden</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Update username form -->
    <form method="post" id="updateusernameform">
        <div class="modal" id="updateusernameModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modalDialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Edit Username:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!-- Login message from PHP file -->
                        <div id="updateusernamemessage"></div>
                        
                        <div class="form-group">
                            <label for="updateusername">Username:</label>
                            <input class="form-control" type="text" id="username" name="username" value="Username value" maxlength="30">
                        </div>   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="updateusername" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>  
        </div>
    </form>
    
    <!-- Update email form -->
    <form method="post" id="updateemailform">
        <div class="modal" id="updateemailModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modalDialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Enter new email:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!-- Login message from PHP file -->
                        <div id="updateemailmessage"></div>
                        
                        <div class="form-group">
                            <label for="updateemail">Email:</label>
                            <input class="form-control" type="email" id="email" name="email" value="Email value" maxlength="50">
                        </div>   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="updateemail" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>  
        </div>
    </form>
    
    <!-- Update password form -->
    <form method="post" id="updatepasswordform">
        <div class="modal" id="updatepasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modalDialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Enter current and New password:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!-- Login message from PHP file -->
                        <div id="updatepasswordmessage"></div>
                        
                        <div class="form-group">
                            <label for="currentpassword" class="sr-only">Your Current Password:</label>
                            <input class="form-control" type="password" id="currentpassword" name="currentpassword" placeholder="Your current password" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="currentpassword" class="sr-only">Choose a Password:</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Choose a password" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="currentpassword" class="sr-only">Confirm Password:</label>
                            <input class="form-control" type="password" id="password2" name="password2" placeholder="Confirm password" maxlength="30">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="updatepassword" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>  
        </div>
    </form>
    
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
