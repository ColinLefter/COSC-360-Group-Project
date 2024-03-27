var replyMainPost = false;
$(document).ready( function () {

    // Loaded after currentPost. Global variables in currentPost.js are available.

    // This may be confusing. In the context of this page, '0' is the main post. So, when replying to the main post, we need the Id to be 0
    if (replyToId == '0'){
        replyMainPost = true;
        replyToId = currentPostId;
    }

    var name;
    if (replyMainPost) {
        name = currentPostUsername;
    } else {
        for (var i = 0; i < comments.length; i++) {
            if (replyToId == comments[i]['commentId']) {
                name = comments[i]['userName'];
                break;
            }
        }
    }

    // console.log(name);
    $("p.reply-to a").html(name);
    if (replyMainPost) {
        $("p.reply-to a").attr("href", "#0");
    } else {
        $("p.reply-to a").attr("href", "#" + replyToId);
    }

    // Set comment button listeners, for some reason this is the only format that actually prevents default
    $("form#comment").on("submit", function(e) {
        e.preventDefault();
        var commentContent = $("textarea#comment-text-area").val();

        if(replyMainPost) {
            addComment("NULL", commentContent); // Main post is the reply to
        } else {
            addComment(replyToId, commentContent);
        }
        
        replyMainPost = false;
    });

    $(document).on("click", "input[id='comment-discard-button']", function(e) {
        e.preventDefault();
        removeCommentBox();
    });

});

function addComment(replyId, commentContent) {

    // If the replyId is "NULL", the parent is the post
    // If the replyId is a number, the parent is a comment
    var formData = {
        postId: currentPostId,
        parentId: replyId,
        content: commentContent,
    };

    $.ajax({
        url : 'backend/addComment.php',
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
                if (data['type'] == "COMMENT_ADDED") {
                    removeCommentBox();
                    update();
                }

                console.log("Comment added sucessfully");
            
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

function removeCommentBox() {
    $("#comment-box-placeholder").empty();
}