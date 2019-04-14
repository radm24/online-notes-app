//AJAX call to updateusername.php
$("#updateusernameform").submit((event) => {
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    const datatopost = $(event.target).serializeArray();
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updateusername.php",
        type: "POST",
        data: datatopost,
        success: (data) => {
            if (data.trim() === "success") {
                $("#updateusernamemessage").html('<div class="alert alert-success">Your username has been successfully changed!</div>');
                setTimeout(() => {
                    location.reload();
                }, 2000);
            } else {
                $("#updateusernamemessage").html(data);   
            }
        },
        error: (error) => {
            $("#updateusernamemessage").html('<div class="alert alert-danger">Unable to change username! Please try again later.</div>');
        }
    })
})

//AJAX call to updateemail.php
$("#updateemailform").submit((event) => {
    //prevent default php processing
    event.preventDefault();
    //collect user input
    const datatopost = $(event.target).serializeArray();
    $.ajax({
        url: "updateemail.php",
        type: "POST",
        data: datatopost,
        success: (data) => {
            $("#updateemailmessage").html(data);
        },
        error: (error) => {
            $("#updateemailmessage").html('<div class="alert alert-danger">Unable to update email address! Please try again later.</div>');
        }
    })
})

//AJAX call to updatepassword.php
$("#updatepasswordform").submit((event) => {
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    const datatopost = $(event.target).serializeArray();
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: datatopost,
        success: (data) => {
            if (data.trim() === "success") {
                $("#updatepasswordmessage").html('<div class="alert alert-success">Your password has been successfully changed!</div>');
            } else {
                $("#updatepasswordmessage").html(data);
            }
        },
        error: (error) => {
            $("#updatepasswordmessage").html('<div class="alert alert-danger">Unable to change password! Please try again later.</div>');
        }
    })
})