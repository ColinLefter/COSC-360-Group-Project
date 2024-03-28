var communityId = 0;
var communityName;
var communityDesc;
// This page is loaded on the right community column, since it is loaded last
$(document).ready( function () {
    
    // We are on the community page
    if (window.location.pathname.endsWith("community.html")) {
        const urlParams = new URLSearchParams(window.location.search);
        communityId = urlParams.get('c');
        getCommunityInfo(communityId, 0);
    } else {
        // We are on the post page
        console.log(currentPostId);
        getCommunityInfo(currentPostId, 1);
    }

});

function getCommunityInfo(currentId, isPostId = 0) {

        var formData = {
            id: currentId,
            ispost: isPostId, // Returns communityId 
        };
    
        $.ajax({
            url : 'backend/getCommunityInfo.php',
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
                    if (data['type'] == "COMMUNITY_INFO") {

                        communityName = data['data'][0]['communityName'];
                        communityDesc = data['data'][0]['communityDesc'];
                        if(isPostId == 0) { // we are on the community page
                            $("h2.community-banner").html("<strong>/" + communityName + "</strong>")
                        } else {
                            communityId = data['data'][0]['communityId'];
                        }
                        // Update column
                        $("h5.community-name").html("<a href='community.html?c=" + communityId + "'><strong>/" + communityName + "</strong>");
                        $("p.community-description").html(communityDesc);


                    }
    
                    console.log("Community info loaded sucessfully");
                
                } else {
                    console.log("Unreachable Error, debug php.");
                }
            },
            error : function (xhr, ajaxOptions, thrownError) {
            alert("Error loading post page.");
            console.log("STATUS: " + xhr.status);
            console.log(thrownError);
            }
        });

}