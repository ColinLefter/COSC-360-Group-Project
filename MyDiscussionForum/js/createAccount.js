$(document).ready(function() {
    $("form").submit(function(e) {
        e.preventDefault();

        // Remove existing messages
        $('.password-error').remove();

        let password = $("input[name='password']").val();
        let passwordCheck = $("input[name='password-check']").val();

        if (password !== passwordCheck) {
            // Highlight the password fields and display an error message
            $("input[name='password'], input[name='password-check']").addClass('is-invalid');
            $("<div class='password-error' style='color: red;'>Passwords do not match!</div>").insertAfter("input[name='password-check']");
        } else {
            // If corrected, remove the highlights and error message
            $("input[name='password'], input[name='password-check']").removeClass('is-invalid');

            // Since passwords match, proceed with the form submission (AJAX call)
            let formData = {
                firstname: $("input[name='firstname']").val(),
                lastname: $("input[name='lastname']").val(),
                username: $("input[name='username']").val(),
                email: $("input[name='email']").val(),
                password: password, // No need to send passwordCheck to the server
            };

            $.ajax({
                url: 'backend/register.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data['result'] === "FAIL") {
                        let msg = data['msg'];
                        $('form').after("<div style='color: red;'>" + msg + "</div>");
                    } else if (data['result'] === "SUCCESS") {
                        window.location.href = "login.html";
                    } else {
                        console.log("Unhandled response", data);
                    }
                },
                error: function(xhr, status, error) {
                    alert("Error registering account. Please try again.");
                }
            });
        }
    });
});
