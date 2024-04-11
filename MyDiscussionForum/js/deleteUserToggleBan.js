$(document).ready(function() {

    $("button#delete-user").on("click", function (e) {
        e.preventDefault();

        if ($("h6.user-username").html() == "" || $("h6.user-username").html() == "N/A") {
            $("button#delete-user").after("<p class='login-feedback' style='text-align: center; color: red;'>No user selected.</p>");
            return;
        }

        $("button#delete-user").next().remove();

        if(confirm("Permanently delete user?") == false) {
            return;
        }
        
        var formData = {
            userName: $("h6.user-username").html()
        };

        $.ajax({
            url : 'backend/deleteUser.php',
            type : 'POST',
            data: formData,
            dataType : 'json',
            success : function (data) {
                var result = data['result'];
                if (result == "FAIL") {
                    alert("User " + $("h6.user-username").html() + " no longer exists.");
                    console.log(data['type']);
                    console.log(data['msg']);
                } else if(result == "SUCCESS") {
                    alert("User " + $("h6.user-username").html() + " successfully deleted.");
                    // $('#userLookupInput').trigger($.Event('keypress', { keyCode: 13 }));
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error : function (xhr, ajaxOptions, thrownError) {
            alert("Error deleteing user.");
            }
        })

    });

    // Toggle ban
    $("button#ban-user").on("click", function (e) {

        e.preventDefault();

        if ($("h6.user-username").html() == "" || $("h6.user-username").html() == "N/A") {
            $("button#ban-user").after("<p class='login-feedback' style='text-align: center; color: red;'>No user selected.</p>");
            return;
        }

        $("button#ban-user").next().remove();

        var formData = {
            userName: $("h6.user-username").html()
        };

        $.ajax({
            url : 'backend/toggleBan.php',
            type : 'POST',
            data: formData,
            dataType : 'json',
            success : function (data) {
                var result = data['result'];
                if (result == "FAIL") {
                    alert("User " + $("h6.user-username").html() + " no longer exists.");
                    console.log(data['type']);
                    console.log(data['msg']);
                } else if(result == "SUCCESS") {
                    alert("User " + $("h6.user-username").html() + " ban toggled.");
                    // $('#userLookupInput').trigger($.Event('keypress', { keyCode: 13 }));
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error : function (xhr, ajaxOptions, thrownError) {
            alert("Error toggling ban.");
            }
        })

    });


})