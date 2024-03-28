$(document).ready(function() {
  $('#postAnnouncementBtn').click(function() {
    var title = $('input[name="announcement-title"]').val();
    var content = $('textarea[name="announcement-content"]').val();
    
    $.ajax({
      url: 'backend/postAnnouncement.php',
      type: 'POST',
      dataType: 'json',
      data: {
        'title': title,
        'content': content
      },
      success: function(data) {
        if(data.result === "SUCCESS") {
          alert('Announcement posted successfully!');
          fetchAnnouncements(); // We also refresh the list of announcements so we can see the one we just posted in real-time!
        } else {
          alert('Failed to post announcement: ' + data.msg);
        }
      },
      error: function(xhr, status, error) {
        alert('Error posting announcement: ' + error);
      }
    });
  });
});
