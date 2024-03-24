$(document).ready( function () {
    $("form").submit( function (e) {
        
        e.preventDefault();

        // Delete user exists message, if exists
        $('p.user-exists').remove();

        let formData = {
            firstname: $("input[name='firstname']").val(),
            lastname: $("input[name='lastname']").val(),
            username: $("input[name='username']").val(),
            email: $("input[name='email']").val(),
            password: $("input[name='password']").val(),
          };

        $.ajax({
            url : 'backend/register.php',
            type : 'POST',
            data : formData,
            dataType : 'json',
            success : function (data) {
                let result = data['result'];
                if(result == "FAIL") {

                    let msg = data['msg'];
                    let type = data['type'];
                    if (type == "USER_EXISTS") {
                        $('form').after(msg);
                    } else {
                        // Debug
                        console.log(type);
                        console.log(msg);
                    }

                } else if(result == "SUCCESS") {
                    console.log("Success! Account added.");
                    // Instantly redirects to login page so the user can sign in with their new account. We set the session variables there.
                    window.location.href = "login.html";
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error : function (xhr, ajaxOptions, thrownError) {
            alert("Error registering account.");
            console.log(xhr.status);
            console.log(thrownError);
            }
        })
    });
});