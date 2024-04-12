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

    // This is for the recennt activity
    $.ajax({
        url: 'backend/getRecentActivity.php',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if(data.result === "SUCCESS") {
                for (var i = 0; i < Math.min(4, data['data'].length); i++) { // 4 posts at most
                    if(data['data'][i]['isCommunity'] == '0') {
                        $("div.recent-activities").append("<a href='topics.html?t=" + data['data'][i]['name'] + "'><button class='button-base community-button'>topic&nbsp;&#x2022;&nbsp;" + data['data'][i]['name'] + "</button></a>");
                    } else {
                        $("div.recent-activities").append("<a href='community.html?c=" + data['data'][i]['cid'] + "'><button class='button-base community-button'>community&nbsp;&#x2022;&nbsp;" + data['data'][i]['name'] + "</button></a>");

                    }
                }
            } else {
                $("div.recent").append("<p style='margin-left: 0.5em; margin-right: 0.5em;'>Recent activity will appear here. Must be logged in.</p>");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching announcements:', error);
        }
        });

});