<?php

/* For use on post.html through currentPost.html */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate post
validateMethodPost();

$postId = $_POST['id'];

if (!isset($postId)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// Sanitize
$postId = mysqli_real_escape_string($connection, $postId);

$sql = "SELECT postId, user.userName, postTitle, postContent FROM post INNER JOIN user ON post.authorId=user.userId WHERE post.postId=".$postId.";";    
$results = mysqli_query($connection, $sql);
$postData = array();

if(mysqli_num_rows($results) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($results)) {
        $postData[$i] = array();
        $postData[$i]['postId'] = $row['postId'];
        $postData[$i]['authorName'] = $row['userName'];
        $postData[$i]['postTitle'] = $row['postTitle'];
        $postData[$i]['postContent'] = $row['postContent'];
        $i++;
    }

    returnData("CURRENT_POST", $connection, $postData);

} else {
    returnData("CURRENT_POST_EMPTY", $connection);
}

?>