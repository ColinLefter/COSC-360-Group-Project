var rowOffset = 0; // Add 3 everytime this is called
$(document).ready( function () {

    // Get query from url
    const urlParams = new URLSearchParams(window.location.search);
    query = urlParams.get('q'); // q for query

    // add spaces back to query
    $("h2.threadview-category").html("<strong>Results for: </strong><span style='font-weight: 400; font-style: italic;'>" + query.replaceAll("+", " ") + "</span>");

    loadQueriedPosts(3, query, 'none'); // load 3 initial posts

    $("div.threadview-more").on("click", function (e) {
        e.preventDefault();
        loadQueriedPosts(3, query, 'none');
    } );

});

function loadQueriedPosts(numPosts, searchQuery, searchTopic) {

    var formData = { // must line up in recentPosts.php
        offset: rowOffset,
        posts: numPosts,
        query: searchQuery,
        topic: 'none',
    };

    $.ajax({
        url : 'backend/searchPosts.php',
        type : 'POST',
        data : formData,
        dataType : 'json',
        success : function (data) {
            
            // Debug
            // console.log(data);
            var result = data['result'];
            if (result == "FAIL") {
            
                // log error client-side
                console.log(data['type']);
                console.log(data['msg']);

            } else if(result == "SUCCESS") {

                // Load queried posts
                if (data['type'] == "QUERIED_POSTS") {
                    insertPosts(data['data']);
                    rowOffset += 3;
                } else if (data['type'] == "QUERIED_POSTS_EMPTY") {
                    if (rowOffset == 0) {
                        $("div.threadview-more").replaceWith("<div><p style='text-align: center; margin-top: 1em;'>No results.</p></div>");
                    } else {
                        $("div.threadview-more").replaceWith("<div><p style='text-align: center; margin-top: 1em;'>End of posts.</p></div>");
                    }    
                }

                console.log("Loaded more posts successfully");
            
            } else {
                console.log("Unreachable Error, debug php.");
            }
        },
        error : function (xhr, ajaxOptions, thrownError) {
        alert("Error loading recent posts.");
        console.log("STATUS: " + xhr.status);
        console.log(thrownError);
        }
    })
}

// Called in loadPosts()
function insertPosts(data) {

    // Append to recent posts container
    postsContainer = $("div.threadview");

    for(var i = 0; i < data.length; i++) {
        // Generate html
        var id = data[i]['postId'];

        // Sequentially add post data, consider using a component
        postsContainer.append("<div class='post-container post" + data[i]['postId'] + "'></div>");
        $("div.post" + id).append("<div class='post-header'></div>");
        $("div.post" + id).append("<div class='post-preview'>" + data[i]['postContent'] + "</div>");
        $("div.post" + id + " div.post-header").append("<div></div>");
        $("div.post" + id + " div.post-header").append("<p class='post-author post-subheader'>" + data[i]['authorName'] + "</p>");
        $("div.post" + id + " div.post-header").append("<p class='post-datetime post-subheader'> &nbsp;&#x2022;&nbsp;" + parseDateTime(data[i]['creationDateTime']) + "</p>");
        $("div.post" + id + " div.post-header div").append("<h4 class='post-title'><a class='post-title' href='post.html?p=" + data[i]['postId'] + "'>" + data[i]['postTitle'] + "</a></h4>");

    }

}

// Returns string for use in post and comments
function parseDateTime(creationDateTime) {

    var t = creationDateTime.split(/[- :]/);

    // Convert to milliseconds
    var d = Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]);

    // Offset by 7 hours to convert from UTC to MST, consider doing this automatically
    var timeAgo;
    if ((Date.now()-7*60*60*1000) - d > 86400000) {
        // More than 24 hours ago
        timeAgo = ((Date.now()-7*60*60*1000) - d)/1000/60/60/24;
        return Math.floor(timeAgo) + " day(s) ago";
    } else if ((Date.now()-7*60*60*1000) - d > 3600000) {
        timeAgo = ((Date.now()-7*60*60*1000) - d)/1000/60/60;
        return Math.floor(timeAgo) + " hour(s) ago";
    } else {
        timeAgo = ((Date.now()-7*60*60*1000) - d)/1000/60;
        return Math.floor(timeAgo) + " minute(s) ago";
    }

}