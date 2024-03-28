$(document).ready(function () {
  fetchAnnouncements();

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
          $('.announcements').html(announcementsHtml);
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
