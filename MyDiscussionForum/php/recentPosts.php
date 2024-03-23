<?php

/* For use on the home page */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate post
validateMethodPost();

$rowOffset = $_POST['offset'];
$numPosts = $_POST['posts'];

if (!isset($rowOffset) || !isset($numPosts)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// Sanitize
$rowOffset = mysqli_real_escape_string($connection, $rowOffset);
$numPosts = mysqli_real_escape_string($connection, $numPosts);

$sql = "SELECT postId, authorName, postTitle, postContent FROM post ORDER BY creationDate DESC LIMIT ".$numPosts." OFFSET ".$rowOffset.";";    
//  echo $sql;
$results = mysqli_query($connection, $sql);
$postData = array();

if(mysqli_num_rows($results) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($results)) {
        $postData[$i] = array();
        $postData[$i]['postId'] = $row['postId'];
        $postData[$i]['authorName'] = $row['authorName'];
        $postData[$i]['postTitle'] = $row['postTitle'];
        $postData[$i]['postContent'] = $row['postContent'];
        $i++;
    }

    returnData("RECENT_POSTS", $connection, $postData);

} else {
    returnData("RECENT_POSTS_EMPTY", $connection);
}

?>