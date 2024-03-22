var rowOffset = 0; // Add 3 everytime this is called
$(document).ready( function () {

    loadPosts(3); // load 3 initial posts

    $("div.threadview-more").on("click", function (e) {
        e.preventDefault();
        loadPosts(3);
    } );

});

function loadPosts(numPosts) {

    var formData = { // must line up in recentPosts.php
        offset: rowOffset,
        posts: numPosts,
    };

    $.ajax({
        url : 'php/recentPosts.php',
        type : 'POST',
        data : formData,
        dataType : 'json',
        success : function (data) {
            
            // Debug
            // console.log(data);
            var result = data['result'];
            if (result == "FAIL") {

                var msg = data['msg'];
                var type = data['type'];
            
                console.log(type);
                console.log(msg);

            } else if(result == "SUCCESS") {

                // Load posts
                if (data['type'] == "RECENT_POSTS") {
                    insertPosts(data['data']);
                } else if (data['type'] == "RECENT_POSTS_EMPTY") {
                    $("div.threadview-more").replaceWith("<div><p style='text-align: center; margin-top: 1em;'>End of posts.</p></div>");
                }

                console.log("Loaded more posts successfully");
            
            } else {
                console.log("Unreachable Error, debug php.");
            }
        },
        error : function (xhr, ajaxOptions, thrownError) {
        alert("Error registering account.");
        console.log("STATUS: " + xhr.status);
        console.log(thrownError);
        }
    })

    rowOffset += 3;

}

// Called in loadPosts()
function insertPosts(data) {

    // Append to recent posts container
    postsContainer = $("div.threadview");

    for(var i = 0; i < data.length; i++) {
        // Generate html
        var id = data[i]['postId'];

        // Sequentially add post data
        postsContainer.append("<div class='post-container post" + data[i]['postId'] + "'></div>");
        $("div.post" + id).append("<div class='post-header'></div>");
        $("div.post" + id).append("<div class='post-preview'>" + data[i]['postContent'] + "</div>");
        $("div.post" + id + " div.post-header").append("<div></div>");
        $("div.post" + id + " div.post-header").append("<p class='post-author post-subheader'>" + data[i]['authorName'] + "</p>");
        $("div.post" + id + " div.post-header").append("<p class='post-datetime post-subheader'> &#x2022; 17:04</p>");
        $("div.post" + id + " div.post-header div").append("<h4 class='post-title'><a class='post-title' href=''>" + data[i]['postTitle'] + "</a></h4>");

    }

}