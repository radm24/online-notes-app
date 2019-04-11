<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Online Notes</title>
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
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#">Help</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#loginModal" data-toggle="modal">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Jumbotron with Sign Up Button -->
    <div class="jumbotron">
        <h1>Online Notes App</h1>
        <p>Your Notes with you wherever you go.</p>
        <p>Easy to use, protects all your notes!</p>
        <button type="button" class="btn btn-lg green signup" data-target="#signupModal" data-toggle="modal">Sign Up - It's free</button>
    </div>
    
    <!-- Login form -->
    <form method="post" id="loginform">
        <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modalDialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Login:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!-- Login message from PHP file -->
                        <div id="loginmessage"></div>
                        
                        <div class="form-group">
                            <label for="loginemail" class="sr-only">Email:</label>
                            <input class="form-control" type="email" id="loginemail" name="loginemail" placeholder="Email" maxlength="50">
                        </div>   
                        <div class="form-group">
                            <label for="loginpassword" class="sr-only">Password:</label>
                            <input class="form-control" type="password" id="loginpassword" name="loginpassword" placeholder="Password" maxlength="30">
                        </div>
                        <div class="checkbox">
                            <label for="rememberme">
                                <input type="checkbox" id="rememberme" name="rememberme">
                                Remember Me
                            </label>    
                            <a class="pull-right" style="cursor: pointer" data-target="#forgotpassModal" data-toggle="modal" data-dismiss="modal">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="login" value="Login">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-default pull-left" data-target="#signupModal" data-toggle="modal" data-dismiss="modal">
                            Register
                        </button>
                    </div>
                </div>
            </div>  
        </div>
    </form>
    
    <!-- Sign up form -->
    <form method="post" id="signupform">
        <div class="modal" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modalDialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Sign up today and Start using our Online Notes App!</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!-- Sign up message from PHP file -->
                        <div id="signupmessage"></div>
                        
                        <div class="form-group">
                            <label for="username" class="sr-only">Username:</label>
                            <input class="form-control" type="text" id="username" name="username" placeholder="Username" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email:</label>
                            <input class="form-control" type="email" id="email" name="email" placeholder="Email Address" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password:</label>
                            <input class="form-control" type="password" id="password" name="password" placeholder="Choose a password" maxlength="30">
                        </div>
                        <div class="form-group">
                            <label for="confpass" class="sr-only">Confirm Password:</label>
                            <input class="form-control" type="password" id="password2" name="password2" placeholder="Confirm password" maxlength="30">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="signup" value="Sign up">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>  
        </div>
    </form>
    
    <!-- Forgot password form -->
    <form method="post" id="forgotpassform">
        <div class="modal" id="forgotpassModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modalDialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" data-dismiss="modal">&times;</button>
                        <h4 id="myModalLabel">Forgot Password? Enter your email address:</h4>
                    </div>
                    <div class="modal-body">
                        
                        <!-- Forgot password message from PHP file -->
                        <div id="forgotpassmessage"></div>
                        
                        <div class="form-group">
                            <label for="forgotpassemail" class="sr-only">Email:</label>
                            <input class="form-control" type="email" id="forgotpassemail" name="forgotpassemail" placeholder="Email" maxlength="50">
                        </div>   
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="forgotpassword" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-default pull-left" data-target="#signupModal" data-toggle="modal" data-dismiss="modal">
                            Register
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
    <script src="index.js"></script>
  </body>
</html>