<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

$postId = $_POST['id'] ?? null;
$rowOffset = intval($_POST['offset'] ?? 0); // Default offset to 0 if not set

if (empty($postId)) {
    returnData("EMPTY_INPUT_GENERAL");
    exit;
}

// Connect to the database
$connection = connectToDB();

// Prepared statement for fetching comments
$sql = "SELECT postId, commentId, parentId, user.userName, commentContent, profilePicName, creationDate FROM comment INNER JOIN user ON comment.userId=user.userId INNER JOIN userDetails ON user.userId=userDetails.userId WHERE postId= ? LIMIT 1000 OFFSET ?;";
$stmt = $connection->prepare($sql);

// Bind parameters. The "si" string means we are binding one string and one integer
$stmt->bind_param("si", $postId, $rowOffset);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
$commentData = array();

if ($result->num_rows > 0) {
    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $commentData[$i] = array(
            'postId' => $row['postId'],
            'commentId' => $row['commentId'],
            'parentId' => $row['parentId'],
            'userName' => $row['userName'],
            'commentContent' => $row['commentContent'],
            'profilePicture' => $row['profilePicName'],
            'creationDateTime' => $row['creationDate'],
        );
        $i++;
    }

    returnData("CURRENT_COMMENTS", $connection, $commentData);

} else {
    returnData("CURRENT_COMMENTS_EMPTY", $connection);
}

$stmt->close();
closeDB($connection);

?>