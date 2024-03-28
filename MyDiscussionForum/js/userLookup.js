$(document).ready(function() {
  // Other functions...

  $('#userLookupInput').on('keypress', function(e) {
    if(e.which == 13) { // Enter key pressed
      let username = $(this).val(); // Get the username from the input box
      console.log("Username to lookup: ", username);
      
      $.ajax({
        url: 'backend/userLookup.php',
        type: 'POST',
        dataType: 'json',
        data: { 'username': username },
        success: function(data) {
          if(data.result === "SUCCESS") {
            $('.user-username').text(data.userData.username);
            $('.user-email').text(data.userData.email);
            $('.user-account-age').text(data.userData.accountAge);
            // let communitiesHtml = '';
            // data.userData.communities.forEach(function(community) {
            //   communitiesHtml += `<span class="badge">${community}</span> `;
            // });
            let communitiesHtml = `<span class="badge">Sports</span> <span class="badge">Entertainment</span>`;
            $('.user-communities').html(communitiesHtml);
          } else {
            $('.user-username').text("N/A");
            $('.user-email').text("N/A");
            $('.user-account-age').text("N/A");
            let communitiesHtml = `<span class="badge">N/A</span>`;
            $('.user-communities').html(communitiesHtml);
            console.log('Failed to fetch user data:', data.msg ? data.msg : 'Unknown error');
          }
        },
        error: function(xhr, status, error) {
          console.error('Error fetching user data:', error);
        }
      });
    }
  });
});
