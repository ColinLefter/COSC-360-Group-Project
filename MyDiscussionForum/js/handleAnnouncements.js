$(document).ready(function () {
  fetchAnnouncements();

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
          console.log('Announcement posted successfully!');
          fetchAnnouncements(); // We also refresh the list of announcements so we can see the one we just posted in real-time!
        } else {
          console.log('Failed to post announcement: ' + data.msg);
        }
      },
      error: function(xhr, status, error) {
        alert('Error posting announcement: ' + error);
      }
    });
  });

  function fetchAnnouncements() {
    $.ajax({
      url: 'backend/fetchAnnouncements.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        if(data.result === "SUCCESS") {
          var announcementsHtml = '';
          data.announcements.forEach(function(announcement) {
            announcementsHtml += `
              <div class="card my-2">
                <div class="announcement">
                  <h6>${announcement.title}
                    <span class="bullet-point"></span> 
                    ${announcement.date}
                    <span class="bullet-point"></span> 
                    ${announcement.author}
                  </h6>
                  <p class="mb-0">${announcement.content}</p>
                </div>
              </div>
            `;
          });
          $('.announcements, .announcements-container').html(announcementsHtml); // This works for both dashboards as we target both containers
        } else {
          console.error('Failed to fetch announcements:', data.msg);
        }
      },
      error: function(xhr, status, error) {
        console.error('Error fetching announcements:', error);
      }
    });
  }
});
