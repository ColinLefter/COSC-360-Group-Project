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
            url : 'php/register.php',
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
                    // TODO: log in, set session, etc

                    $('form').after("<p style='text-align: center;'> Success! Redirecting to home page.");
                    setTimeout(() => { location.href = "index.html"}, 2000);
                
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