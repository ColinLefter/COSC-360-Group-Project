<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

session_start();

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

// Assuming 'id' is always expected to be an integer
$postId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($postId <= 0) {
    returnData("EMPTY_INPUT_GENERAL");
    exit();
}

// Connect to the database
$connection = connectToDB();

// Prepared statement for fetching the post details
$sql = "SELECT postId, user.userName, postTitle, postContent, profilePicName, creationDate FROM post INNER JOIN user ON post.authorId=user.userId INNER JOIN userDetails ON user.userId=userDetails.userId WHERE post.postId= ?;";    
$stmt = $connection->prepare($sql);

// Bind the integer parameter
$stmt->bind_param("i", $postId);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
$postData = array();

if($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $postData[$i] = array(
            'postId' => $row['postId'],
            'authorName' => $row['userName'],
            'postTitle' => $row['postTitle'],
            'postContent' => $row['postContent'],
            'profilePicture' => $row["profilePicName"],
            'creationDateTime' => $row['creationDate'],
        );
        $i++;
    }

    // Get all topics
    $sql = "SELECT topicName FROM post INNER JOIN topic ON post.postId=topic.postId WHERE post.postId= ?;";    
    $stmt = $connection->prepare($sql);
    
    // Bind the integer parameter
    $stmt->bind_param("i", $postId);
    
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $postData[0]['topics'] = array();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $postData[0]['topics'][$i] = $row['topicName'];
            $i++;
        }
    }

    returnData("CURRENT_POST", $connection, $postData);

} else {
    returnData("CURRENT_POST_EMPTY", $connection);
}

$stmt->close();
closeDB($connection);

?>