//AJAX call for the sign up form once the form is submitted
$("#signupform").submit(function(event) {
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    const signupdata = $(this).serializeArray();
    //send them to signup.php using AJAX
    $.ajax({
       url: "signup.php",
       type: "POST",
       data: signupdata,
       success: (data) => {
           if (data) {
                $("#signupmessage").html(data);
           }
       },
       error: (error) => {
           $("#signupmessage").html('<div class="alert alert-danger">There was an error with the AJAX call. Please try again latter.</div>')
       }
    });
        //AJAX call succesful: show error or success message
        //AJAX call fails: show AJAX call error      
});

//AJAX call for the login form once the form is submitted
$("#loginform").submit(function(event) {
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    const logindata = $(this).serializeArray();
    //send them to signup.php using AJAX
    $.ajax({
        url: "login.php",
        type: "POST",
        data: logindata,
        success: (data) => {
            if (data.trim() === "success") {
                window.location = "mainpageloggedin.php";
            } else {
                $("#loginmessage").html(data);
            }
        },
        error: (error) => {
            $("$loginmessage").html('<div class="alert alert-danger">There was an error with the AJAX call. Please try again latter.</div>')
        }
    });
        //AJAX call succesful: show error or success message
        //AJAX call fails: show AJAX call error
});

