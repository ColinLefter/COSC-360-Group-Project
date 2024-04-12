$(document).ready(function () {
  
    $.ajax({
    url: 'backend/getTopics.php',
    type: 'POST',
    dataType: 'json',
    success: function(data) {
        if(data.result === "SUCCESS") {
            console.log(data['data']);
            for (var i = 0; i < Math.min(4, data['data'].length); i++) { // 4 posts at most
                $("div.loaded-topics").append("<a href='topics.html?t=" + data['data'][i]['topicName'] + "'><button class='button-base community-button'>" + data['data'][i]['topicName'] + "</button></a>");
            }
        }
    },
    error: function(xhr, status, error) {
        console.error('Error fetching announcements:', error);
    }
    });
  });
  