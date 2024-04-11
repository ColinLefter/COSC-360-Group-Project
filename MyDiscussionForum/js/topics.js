var topic;
// This page is loaded on the right community column, since it is loaded last
$(document).ready( function () {
    
    // We are on the community page
        const urlParams = new URLSearchParams(window.location.search);
        topic = urlParams.get('t');
        
        $("h2.topics-banner").html("<strong>/" + topic + "</strong>")

});
