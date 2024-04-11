$(document).ready( function () {
    // Listener for submitting post
    $(document).on("submit", "form", function(e) {
        e.preventDefault();

        // Ajax to add post
        addCommunity();

    } );

});

function addCommunity () {

    // Get information
    var title = $("input#create-community-title").val();
    var content = $("textarea#create-community-description").val();

    console.log(title);
    console.log(content);

    var formData = {
        communityName: title,
        communityDescription: content,
    };

    $.ajax({
        url : 'backend/addCommunity.php',
        type : 'POST',
        data : formData,
        dataType : 'json',
        success : function (data) {
            
            // Debug
            // console.log(data);
            var result = data['result'];
            if (result == "FAIL") {
            
                console.log(data['type']);
                console.log(data['msg']);

            } else if(result == "SUCCESS") {

                // Load post
                if (data['type'] == "COMMUNITY_ADDED") {
                    window.location.assign("index.html");
                }
            
            } else {
                console.log("Unreachable Error, debug php.");
            }
        },
        error : function (xhr, ajaxOptions, thrownError) {
        alert("Error loading post page.");
        console.log("STATUS: " + xhr.status);
        console.log(thrownError);
        }
    })


}