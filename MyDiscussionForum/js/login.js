$(document).ready(function () {
  $("form").submit(function (e) {
      e.preventDefault();

      // Clear previous messages
      $('.login-feedback').remove();

      let formData = {
          username: $("input[name='username']").val(),
          password: $("input[name='password']").val(),
      };

      $.ajax({
          url: 'backend/login.php',
          type: 'POST',
          data: formData,
          dataType: 'json',
          success: function (data) {
              let result = data['result'];
              if (result == "FAIL") {
                  let msg = data['msg'];
                  let type = data['type'];

                  if (type == "INVALID_PASSWORD") {
                      $('form').after("<p class='login-feedback' style='color: red; text-align: center;'>" + msg + "</p>");
                  } else {
                      console.log(type);
                      console.log(msg);
                  }
              } else if (result == "SUCCESS") {
                  console.log("Success! Logged in.");
                  window.location.href = "index.html"; // Instantly redirects to home page
              }
          },
          error: function (xhr, status, error) {
              $('form').after("<p class='login-feedback' style='text-align: center; color: red;'>Error logging into your account.</p>");
              console.log(xhr.status);
              console.log(error);
          }
      });
  });
});
