// To be included in myAccount.php

$(document).ready( function () {


    // Get profile picture directory
    $.ajax({
        url : 'backend/getProfilePicture.php',
        type : 'POST',
        dataType : 'json',
        success : function (data) {
            
            // Debug
            console.log(data);
            var result = data['result'];
            if (result == "FAIL") {
            
                console.log(data['type']);
                console.log(data['msg']);

            } else if(result == "SUCCESS") {

                // Load posts
                if (data['type'] == "PROFILE_PICTURE") {
                    $(".profile-picture-large img").attr("src", "res/img/" + data['data'][0]['profilepicture']);
                }

                console.log("Profile picture retrieved successfully");
            
            } else {
                console.log("Unreachable Error, debug php.");
            }
        },
        error : function (xhr, ajaxOptions, thrownError) {
        alert("Error loading recent posts.");
        console.log("STATUS: " + xhr.status);
        console.log(thrownError);
        }
    })

    // Upload image
    $(".profile-picture-large img").on("click", function() {
        // console.log("CLICKED");
        $("input#profilePictureFile").click();
    })

    $("input#profilePictureFile").on("change", function () {

        var fileInput = $(this)[0];

        if (fileInput.files && fileInput.files.length > 0) {
            var profilePicture = fileInput.files[0];
            console.log("File found: ", profilePicture.name);
        } else {
            console.log("error! File not found");
            return;
        }

        // Necessary for files
        var formData = new FormData();

        formData.append('profilepicture', profilePicture);

        // Pass image to backend with ajax
        $.ajax({
            url : 'backend/uploadProfilePicture.php',
            type : 'POST',
            data : formData,
            contentType: false,
            processData: false,
            dataType : 'json',
            success : function (data) {
                
                // Debug
                console.log(data);
                var result = data['result'];
                if (result == "FAIL") {
    
                    var msg = data['msg'];
                    var type = data['type'];
                
                    console.log(type);
                    console.log(msg);
    
                } else if(result == "SUCCESS") {
    
                    // Load posts
                    if (data['type'] == "PROFILE_PICTURE_UPLOADED") {
                        $(".profile-picture-large img").attr("src", "res/img/" + profilePicture.name);
                    }
    
                    console.log("Profile picture uploaded successfully");
                
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error : function (xhr, ajaxOptions, thrownError) {
            alert("Error loading recent posts.");
            console.log("STATUS: " + xhr.status);
            console.log(thrownError);
            }
        });

    })

});