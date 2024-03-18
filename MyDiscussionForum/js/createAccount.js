$(document).ready( function () {
    $("form").submit( function (e) {
        
        e.preventDefault();

        // Delete user exists message, if exists
        $('p.user-exists').remove();

        var formData = {
            firstname: $("input[name='firstname']").val(),
            lastname: $("input[name='lastname']").val(),
            username: $("input[name='username']").val(),
            email: $("input[name='email']").val(),
            password: $("input[name='password']").val(),
          };

        $.ajax({
            url : '../php/register.php',
            type : 'POST',
            data : formData,
            dataType : 'json',
            success : function (data) {
                
                // Check whether the data was added successfully
                var result = data['result'];
                if(result == "FAIL") {

                    var msg = data['msg'];
                    var type = data['type'];
                    if(type == "DATABASE_CONNECT_ERROR") {
                        console.log(msg);
                    } else if (type == "USER_EXISTS") {
                        $('form').after(msg);
                    }

                } else if(result == "SUCCESS") {

                    console.log("Success! Account added.");
                    // TODO: log in, set session, etc

                    $('form').after("<p style='text-align: center;'> Success! Redirecting...");
                    setTimeout(() => { location.href = "../index.html"}, 2000);
                
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error : function () {
            alert("Error registering account.");
            }
        })
    });
});