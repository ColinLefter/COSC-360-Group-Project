var topics = new Array();
var topicCount = 0;
$(document).ready( function () {

    /* GET COMMUNITY ID */
    const urlParams = new URLSearchParams(window.location.search);
    communityId = urlParams.get('c');

    // Load communities to dropdown, passed community Id first
    loadCommunities(communityId);

    // Listener for topics
    $("input.add-topic-button").on("click", function(e) {
        e.preventDefault();

        var topic = $("input#create-post-topics").val();
        topic = topic.toLowerCase();

        // Check if the topics box has text in it
        if(topic == "") {
            return;
        }

        // Check for duplicates
        if (topics.includes(topic)) {
            $("input#create-post-topics").val("");
            return;
        }

        // If so, add the text as an element
        topics.push(topic);

        // Add html element with listener
        topicCount += 1;        
        $('div#create-post-header').after("<p class='badge topic-box' id='topic" + topicCount + "'>" + topic + " &#10060;</p>");

        // Clear
        $("input#create-post-topics").val("");

        // Create a listener for the newly created topic
        $("p#topic"+topicCount).on("click", function (e) {
            e.preventDefault();

            var clickedTopic = $(this).text();

            topics = topics.filter(item => item !== clickedTopic);
            $(this).remove();
        });

    });

    // Listener for submitting post
    $(document).on("submit", "form", function(e) {
        e.preventDefault();

        // Ajax to add post
        addPost();

    } );

});

function loadCommunities(communityId) {

    $.ajax({
        url : 'backend/createPostGetCommunities.php',
        type : 'POST',
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
                if (data['type'] == "CREATE_POST_COMMUNITIES") {
                    insertCommunities(data['data'], communityId);
                }

                console.log("Community drop down loaded sucessfully");
            
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

function insertCommunities(data, communityId) {

    dropdown = $("select#create-post-communities");

    // Load passed id first
    for (var i = 0; i < data.length; i++) {
        if (communityId == data[i]['communityId']) {
            // console.log("ID: " + data[i]['communityId'] + " Name: " + data[i]['communityName']);
            dropdown.append("<option value='" + data[i]['communityId'] + "'>" + data[i]['communityName'] + "</option>");
            break;
        }
    }

    // Load rest of the communities
    for (var i = 0; i < data.length; i++) {
        if (communityId != data[i]['communityId']) {
            // console.log("ID: " + data[i]['communityId'] + " Name: " + data[i]['communityName']);
            dropdown.append("<option value='" + data[i]['communityId'] + "'>" + data[i]['communityName'] + "</option>");
        }
    }

}

function addPost () {

    // Get information
    var cid = $("select#create-post-communities").val();
    var title = $("input#create-post-title").val();
    var content = $("textarea#create-post-content").val();

    console.log(cid);
    console.log(title);
    console.log(content);

    var formData = {
        communityId: cid,
        postTitle: title,
        postContent: content,
    };

    $.ajax({
        url : 'backend/addPost.php',
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
                if (data['type'] == "POST_ADDED") {
                    addTopics();
                    window.location.assign("index.html");
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

function addTopics() {
    
    var formData =  {
        topics: JSON.stringify(topics),
    };
    
    $.ajax({
        url : 'backend/addTopics.php',
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
                if (data['type'] == "TOPICS_ADDED") {
                    return;
                }

                console.log("Comment added sucessfully");
            
            } else {
                console.log("Unreachable Error, debug php.");
            }
        },
        error : function (xhr, ajaxOptions, thrownError) {
        alert("Error adding tags.");
        console.log("STATUS: " + xhr.status);
        console.log(thrownError);
        }
    });
}