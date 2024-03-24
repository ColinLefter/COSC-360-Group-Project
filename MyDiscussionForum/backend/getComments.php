<?php

/* For use on post.html through currentPost.html component */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate post
validateMethodPost();

$postId = $_POST['id'];
$rowOffset = $_POST['offset'];

if (!isset($postId) || !isset($rowOffset)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// Sanitize
$postId = mysqli_real_escape_string($connection, $postId);

    $sql = "SELECT postId, commentId, parentId, user.userName, commentContent FROM comment INNER JOIN user ON comment.userId=user.userId WHERE postId='".$postId."' LIMIT 1000 OFFSET ".$rowOffset.";";    
//  echo $sql;
$results = mysqli_query($connection, $sql);
$commentData = array();

if(mysqli_num_rows($results) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($results)) {
        $commentData[$i] = array();
        $commentData[$i]['postId'] = $row['postId'];
        $commentData[$i]['commentId'] = $row['commentId'];
        $commentData[$i]['parentId'] = $row['parentId'];
        $commentData[$i]['userName'] = $row['userName'];
        $commentData[$i]['commentContent'] = $row['commentContent'];
        $i++;
    }

    returnData("CURRENT_COMMENTS", $connection, $commentData);

} else {
    returnData("CURRENT_COMMENTS_EMPTY", $connection);
}

?>