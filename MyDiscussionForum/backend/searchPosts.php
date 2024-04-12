<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

session_start();

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

$rowOffset = $_POST['offset'];
$numPosts = $_POST['posts'];
$query = $_POST['query'];
$topic = $_POST['topic'];

if (!isset($rowOffset) || !isset($numPosts) || !isset($query) || !isset($topic)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// Sanitize
$rowOffset = mysqli_real_escape_string($connection, $rowOffset);
$numPosts = mysqli_real_escape_string($connection, $numPosts);
$query = mysqli_real_escape_string($connection, $query);
$topic = mysqli_real_escape_string($connection, $topic);

// Get statement for query, or prepared statement for topic query

$values = explode(' ',$query);
$sql = "SELECT postId, user.userName, postTitle, postContent, creationDate, 
    MATCH (postTitle) AGAINST ('".$query."' IN BOOLEAN MODE) AS titleRel,
    MATCH (postContent) AGAINST ('".$query."' IN BOOLEAN MODE) AS contentRel
    FROM post INNER JOIN user ON post.authorId=user.userId WHERE ";

$i = 0;
foreach($values as $v){
    $v=trim($v);

    if($i==0) {
        $sql.=" (postTitle LIKE '%".$v."%' OR postContent LIKE '%".$v."%'";
    }
    else {
        $sql.=" OR postTitle LIKE '%".$v."%' OR postContent LIKE '%".$v."%'";
    }
    $i++;
}

$sql = $sql.") ";

if  (strcmp($topic, "none") == 0) {
    $sql = $sql."ORDER BY (titleRel + contentRel) DESC LIMIT ".$numPosts." OFFSET ".$rowOffset.";";
} else {
    // Figure out topics
    // $sql = $sql." AND LIMIT ".$numPosts." OFFSET ".$rowOffset";";    
}
// echo $sql;

$postData = array();
$results = mysqli_query($connection, $sql);

if(mysqli_num_rows($results) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($results)) {
        $postData[$i] = array();
        $postData[$i]['postId'] = $row['postId'];
        $postData[$i]['authorName'] = $row['userName'];
        $postData[$i]['postTitle'] = $row['postTitle'];
        $postData[$i]['postContent'] = $row['postContent'];
        $postData[$i]['creationDateTime'] = $row['creationDate'];
        $i++;
    }

    if (!isset($_SESSION['userId'])) {
        trackUserActivity($connection, $_SESSION['userId'], "SEARCH_POSTS");
    }
    returnData("QUERIED_POSTS", $connection, $postData);

} else {
    returnData("QUERIED_POSTS_EMPTY", $connection);
}

?>