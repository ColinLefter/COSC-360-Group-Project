$(document).ready( function () {
  $("form").submit( function (e) {
      
      e.preventDefault();

      // Clear previous messages
      $('.login-feedback').remove();

      let formData = {
          username: $("input[name='username']").val(),
          password: $("input[name='password']").val(),
        };

      $.ajax({
          url : 'php/login.php',
          type : 'POST',
          data : formData,
          dataType : 'json',
          success : function (data) {
            // Check whether the data was added successfully
            let result = data['result'];
            if (result == "FAIL") {

            let msg = data['msg'];
            $('form').after("<p class='login-feedback' style='text-align: center; color: red;'>" + msg + "</p>");

            } else if (result == "SUCCESS") {
                $('form').after("<p class='login-feedback' style='text-align: center;'>Success! Redirecting...</p>");
                setTimeout(() => { location.href = "index.html" }, 2000);
            }

          },
          error: function(xhr, status, error) {
            $('form').after("<p class='login-feedback' style='text-align: center; color: red;'>Error logging into your account.</p>");
            console.log(xhr.status);
            console.log(error);
          }
      })
  });
});