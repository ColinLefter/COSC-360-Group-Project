<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

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
$sql = "SELECT postId, user.userName, postTitle, postContent FROM post INNER JOIN user ON post.authorId=user.userId WHERE post.postId= ?;";    
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
        );
        $i++;
    }

    returnData("CURRENT_POST", $connection, $postData);

} else {
    returnData("CURRENT_POST_EMPTY", $connection);
}

$stmt->close();
closeDB($connection);

?>