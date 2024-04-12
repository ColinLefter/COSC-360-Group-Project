$(document).ready(function() {
  $("#accountForm").submit(function(e) {
      e.preventDefault(); // Prevent the default form submission

      // Clear previous messages and remove error highlights
      $("#responseMessage").text("");
      $("input").removeClass('is-invalid');

      // Validate required fields are not empty
      var fields = {
          firstName: $("input[name='firstName']").val().trim(),
          lastName: $("input[name='lastName']").val().trim(),
          username: $("input[name='username']").val().trim(),
          email: $("input[name='email']").val().trim()
      };

      var isValid = true;
      // Loop through fields and check for emptiness
      for (var key in fields) {
          if (fields[key] === "") {
              $("input[name='" + key + "']").addClass('is-invalid'); // Add error class
              isValid = false;
          }
      }

      if (!isValid) {
          $("#responseMessage").text("Please fill out all required fields.");
          return; // Stop the function if validation fails
      }

      $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: $(this).serialize(), // Serialize the form data
          dataType: 'json', // Expecting JSON response
          success: function(response) {
              // Display response message
              $("#responseMessage").text(response.msg);
          },
          error: function(xhr, status, error) {
              console.log(xhr.responseText);
              $("#responseMessage").text("An error occurred. Please try again.");
          }        
      });
  });
});