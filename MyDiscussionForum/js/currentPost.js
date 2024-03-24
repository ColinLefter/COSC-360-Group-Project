var commentRowOffset = 0; // Keep track of how many comments have been loaded, necessary for async
var comments = new Array(); // necessary for ids and name replies
var currentPostId;
$(document).ready( function () {

    // Get query from url
    const urlParams = new URLSearchParams(window.location.search);
    currentPostId = urlParams.get('p');

    loadPost(currentPostId);
});

function loadPost(postId) {

    var formData = {
        id: postId,
    };

    $.ajax({
        url : 'backend/getPost.php',
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

                // Load post
                if (data['type'] == "CURRENT_POST") {
                    insertPost(data['data']);
                    update();
                }

                console.log("Post loaded sucessfully");
            
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

// Called in loadPost()
function insertPost(data) {

    $("h2.post-large-title").remove();

    // Append to post container, threadview
    postContainer = $("div.threadview");

    for(var i = 0; i < data.length; i++) {
        // Generate html
        var id = data[i]['postId'];

        // Sequentially add post data, consider using a component
        postContainer.append("<div class='post-container-single post" + data[i]['postId'] + "'></div>");
        $("div.post" + id).append("<div class='post-header'></div>");
        $("div.post" + id).append("<div class='post-content'>" + data[i]['postContent'] + "</div>");
        $("div.post" + id + " div.post-header").append("<div></div>");
        $("div.post" + id + " div.post-header").append("<p class='post-author post-subheader'>" + data[i]['authorName'] + "</p>");
        $("div.post" + id + " div.post-header").append("<p class='post-datetime post-subheader'> &nbsp;&#x2022; 17:04</p>");
        $("div.post" + id + " div.post-header div").append("<h4 class='post-large-title-loaded'>" + data[i]['postTitle'] + "</h4>");

    }

}

// This function talks to the database and pulls all relevant comments.
// If comments have already been pulled, it only pulls any new comments added.
// Consider adding a function to check for deleted comments, and if so, remove them
function loadComments(postId) {

    // Similar to post loading
    var formData = {
        id: postId,
        offset: commentRowOffset,
    };

    $.ajax({
        url : 'backend/getComments.php',
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

                // Load comments
                if (data['type'] == "CURRENT_COMMENTS") {
                    comments = comments.concat(data['data']);
                    insertComments(data['data']);
                    commentRowOffset += data['data'].length; // Offset so we don't pull all comments every request
                }

                // console.log("Comments loaded sucessfully");
            
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

function insertComments(data) {

    // Append to post container
    postContainer = $("div.threadview");

    for(var i = 0; i < data.length; i++) {
        // Generate html
        var id = data[i]['commentId'];

        // add comments under post
        postContainer.append("<div class='post-container-single' id='" + data[i]['commentId'] + "'></div>");
        $("div#" + id).append("<div class='post-header'></div>");
        $("div#" + id).append("<div class='post-content'>" + data[i]['commentContent'] + "</div>");
        $("div#" + id + " div.post-header").append("<p class='post-author post-subheader'>" + data[i]['userName'] + "</p>");
        $("div#" + id + " div.post-header").append("<p class='post-datetime post-subheader'> &nbsp;&#x2022; 17:04 </p>");
        
        if (data[i]['parentId'] != null) {
            // get parent comment username
            var parentUsername, parentId;
            for (var j = 0; j < comments.length; j++) {
                if (comments[j]['commentId'] == data[i]['parentId']) {
                    parentUsername = comments[j]['userName'];
                    parentId = data[i]['parentId'];
                    console.log("Added!");
                    $("div#" + id + " div.post-header").append("<p class='post-datetime post-subheader'> &nbsp;&#x2022; Replying to <a href='#" + parentId + "'>" + parentUsername + "</a></p>");
                }
            }
        }
    }
}

// This loop updates our comments every 5 seconds
function update(){
    loadComments(currentPostId);

    setTimeout(update, 5000);
}