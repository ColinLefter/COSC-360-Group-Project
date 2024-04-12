$('#userLookupInput').on('keypress', function(e) {
  if (e.which == 13) { // Enter key pressed
    let username = $(this).val(); // Get the username from the input box
    console.log("Username to lookup: ", username);

    $.ajax({
      url: 'backend/userLookup.php',
      type: 'POST',
      dataType: 'json',
      data: { 'username': username },
      success: function(data) {
        if (data.result === "SUCCESS") {
          $('.user-username').text(data.userData.username);
          $('.user-email').text(data.userData.email);
          $('.user-account-age').text(data.userData.accountAge);
          // Use .html() to parse HTML content
          $('.user-is-banned').html(data.userData.isBanned == 0 ? `<span class="badge bg-success">Account active</span>` : `<span class="badge bg-danger">Account banned</span>`);
        } else {
          $('.user-username').text("N/A");
          $('.user-email').text("N/A");
          $('.user-account-age').text("N/A");
          // Set default message using .html() for HTML content
          $('.user-is-banned').html(`<span class="badge">N/A</span>`);
          console.log('Failed to fetch user data:', data.msg ? data.msg : 'Unknown error');
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching user data:', error);
      }
    });
  }
});
