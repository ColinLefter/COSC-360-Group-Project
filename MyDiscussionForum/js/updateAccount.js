$(document).ready(function() {
  $("#accountForm").submit(function(e) {
      e.preventDefault(); // Prevent the default form submission

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
