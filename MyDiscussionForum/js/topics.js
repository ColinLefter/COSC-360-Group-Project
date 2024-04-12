var topic;
$(document).ready( function () {
    
    // We are on the topics page
    const urlParams = new URLSearchParams(window.location.search);
    topic = urlParams.get('t');
    
    $("h2.topics-banner").html("<strong>/" + topic + "</strong>")

    var formData = {
        topic: topic
    };

    $.ajax({
        url: 'backend/logTopicActivity.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            if(data.result === "SUCCESS") {
                // do nothing
            }
        },
        error: function(xhr, status, error) {
            console.error('Error logging topics', error);
        }
        });

});
