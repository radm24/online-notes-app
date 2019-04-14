$(function() {
    //define variables
    let activeNote = 0;
    let editMode = false;
    //load notes on page load: Ajax call to loadnotes.php
    $.ajax({
        url: "loadnotes.php",
        success: (data) => {
            $("#notes").html(data);
            clickonNote();
            clickonDelete();
        },
        error: (error) => {
            $("#alertContent").text("Unable to load notes! Please try later.");
            $("#alert").fadeIn();
        }
    })
    //add a new note: Ajax call to createnote.php
    $("#addNote").click((event) => {
        $.ajax({
            url: "createnote.php",
            success: (data) => {
                if (data.trim() === "error") {
                    $("#alertContent").text("There was an issue inserting the new note in the database!");
                    $("#alert").fadeIn();
                } else {
                    //Update activeNote to the id of the new note
                    activeNote = data;
                    $("textarea").val("");
                    //Show hide elements
                    showHide(["#allNotes, #notePad"], ["#addNote, #edit, .noteheader, #done, .delete"]);
                    $("#addNote, #edit, .noteheader").css("display", "none");
                    $("#allNotes, #notePad").css("display", "block");
                    $("textarea").focus();
                }  
            },
            error: (error) => {
                $("#alertContent").text("Unable to create a note! Please try later.");
                $("#alert").fadeIn();
            }
        })
    })
    //type note: Ajax call to updatenote.php
    $("textarea").keyup(function() {
        //ajax call to update the task of id activenote
        $.ajax({
            url: "updatenote.php",
            type: "POST",
            //we need to send the current note content with its id to the php file
            data: {note: $(this).val(), id: activeNote},
            success: (data) => {
                if (data.trim() === "error") {
                    $("#alertContent").text("There was an issue updating the note in the database!");
                    $("#alert").fadeIn();
                }
            },
            error: (error) => {
                $("#alertContent").text("There was an error with the AJAX call. Unable to save changes in your note.");
                $("#alert").fadeIn();
            }
        })
    })
    //click on all notes button
    $("#allNotes").click((event) => {
        editMode = false;
        $.ajax({
            url: "loadnotes.php",
            success: (data) => {
                $("#notes").html(data);
                showHide(["#addNote, #edit, .noteheader"], ["#allNotes, #notePad"]);
                clickonNote();
                clickonDelete();
            },
            error: (error) => {
                $("#alertContent").text("Unable to load notes! Please try again later.");
                $("#alert").fadeIn();
            }
        })
    })
    //click on done after editing: load notes again
    $("#done").click(function() {
        //switch to non edit mode
        editMode = false;
        $(".noteheader").removeClass("col-sm-9 col-xs-7");
        //show hide elements
        showHide(["#edit"], [".delete, #done"]);
    })
    //click on edit: go to edit mode (show delete buttons ...)
    $("#edit").click(function() {
        //switch to edit mode
        editMode = true;
        //reduce the width of notes
        $(".noteheader").addClass("col-sm-9 col-xs-7");
        showHide([".delete, #done"], ["#edit"]);
        clickonDelete();
    })
    //click on delete in edit mode: Ajax call to deletenote.php
    
    //functions 
        //click on a note
    function clickonNote() {
        $(".noteheader").click(function() {
            if (!editMode) {
                //update activeNote variable to id of note
                activeNote = $(this).attr("id");
                //fill textarea
                $("textarea").val($(this).children(".text").text());
                //show hide elements  
                showHide(["#allNotes, #notePad"], ["#addNote, #edit, .noteheader"]);
                $("textarea").focus();
            }
        })
    }
        //click on delete
    function clickonDelete() {
        $(".delete").click(function() {
            activeNote = $(this).next().attr("id");
            //send ajax call to delete note
            $.ajax({
                url: "deletenote.php",
                type: "POST",
                data: {id: activeNote},
                success: (data) => {
                    if (data.trim() === "error") {
                        $("#alertContent").text("There was an issue deleting the note from the database!");
                        $("#alert").fadeIn();
                    } else {
                        //remove containing div
                        $(this).parent().remove();
                    }
                },
                error: (error) => {
                    $("#alertContent").text("Unable to delete note! Please try again later.");
                    $("#alert").fadeIn();
                }
            })
        })
    }
        //showHide function
    function showHide(array1, array2) {
        for (i=0; i < array1.length; i++) {
            $(array1[i]).show();
        }
        for (i=0; i < array2.length; i++) {
            $(array2[i]).hide();
        }
    } 
})

