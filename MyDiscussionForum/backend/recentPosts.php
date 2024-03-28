<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

$rowOffset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0; // Default to 0 if not set
$numPosts = isset($_POST['posts']) ? (int)$_POST['posts'] : 10; // Default to 10 posts if not set

// Check if the communityId is set
$communityId = isset($_POST['cid']) ? (int)$_POST['cid'] : null;

if ($rowOffset < 0 || $numPosts <= 0) {
    returnData("INVALID_INPUT");
    exit;
}

// Connect to the database
$connection = connectToDB();

// Since prepared statements do not support binding LIMIT and OFFSET directly, these must be integers
if ($communityId == null) {
    $sql = "SELECT postId, user.userName, postTitle, postContent FROM post INNER JOIN user ON post.authorId=user.userId ORDER BY creationDate DESC LIMIT ? OFFSET ?;";
    $stmt = $connection->prepare($sql);
    // Bind parameters. The "ii" string means we are binding two integers
    $stmt->bind_param("ii", $numPosts, $rowOffset);
} else {
    $sql = "SELECT postId, user.userName, postTitle, postContent FROM post INNER JOIN user ON post.authorId=user.userId WHERE communityId=? ORDER BY creationDate DESC LIMIT ? OFFSET ?;";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iii", $communityId, $numPosts, $rowOffset);
}


// Execute the query
$stmt->execute();
$result = $stmt->get_result();
$postData = array();

if ($result -> num_rows > 0) {
    $i = 0;
    while ($row = $result -> fetch_assoc()) {
        $postData[$i] = array(
            'postId' => $row['postId'],
            'authorName' => $row['userName'],
            'postTitle' => $row['postTitle'],
            'postContent' => $row['postContent'],
        );
        $i++;
    }

    returnData("RECENT_POSTS", $connection, $postData);

} else {
    returnData("RECENT_POSTS_EMPTY", $connection);
}

$stmt->close();
closeDB($connection);

?>