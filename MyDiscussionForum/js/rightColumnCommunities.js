$(document).ready(function () {
  
    console.log("HERE");
    $.ajax({
    url: 'backend/createPostGetCommunities.php',
    type: 'POST',
    dataType: 'json',
    success: function(data) {
        if(data.result === "SUCCESS") {
            console.log(data.length);
            for (var i = 0; i < 4; i++) { // 4 posts at most
                $("div.loaded").append("<a href='community.html?c=" + data['data'][i]['communityId'] + "'><button class='button-base community-button'>" + data['data'][i]['communityName'] + "</button></a>");
            }
        }
    },
    error: function(xhr, status, error) {
        console.error('Error fetching announcements:', error);
    }
    });
  });
  