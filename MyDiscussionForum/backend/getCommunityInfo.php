<?php

/* For use with community column */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate request method
validateMethodPost();

// if isPost is 0, the id is the community id, other wise it is the postId
$id = $_POST['id'];
$isPost = $_POST['ispost'];

if (!isset($id) || !isset($isPost)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// Sanitize
$rowOffset = mysqli_real_escape_string($connection, $id);
$numPosts = mysqli_real_escape_string($connection, $isPost);

$communityData = array();

// If isPost, return communityId as well
if (strcmp($isPost, "0") == 0) { // community page
    $sql = "SELECT communityName, description FROM community WHERE communityId='".$id."';";
    $results = mysqli_query($connection, $sql);
    if(mysqli_num_rows($results) > 0) {
        $row = mysqli_fetch_assoc($results);
        $communityData[0] = array();
        $communityData[0]['communityName'] = $row['communityName'];
        $communityData[0]['communityDesc'] = $row['description'];
    }

    // Log an entry for a community page visit
    session_start();
    if(isset($_SESSION['userId'])) {
        $sql = "INSERT INTO recentActivity (userId, isCommunity, name, cid) VALUES ('".$_SESSION['userId']."','1', '".$row['communityName']."', '".$id."');";
        $results = mysqli_query($connection, $sql);
    }
    returnData("COMMUNITY_INFO", $connection, $communityData);
} else { // post page
    $sql = "SELECT communityName, description, community.communityId FROM community INNER JOIN post ON community.communityId=post.communityId WHERE postId='".$id."';";
    $results = mysqli_query($connection, $sql);
    if(mysqli_num_rows($results) > 0) {
        $row = mysqli_fetch_assoc($results);
        $communityData[0] = array();
        $communityData[0]['communityName'] = $row['communityName'];
        $communityData[0]['communityDesc'] = $row['description'];
        $communityData[0]['communityId'] = $row['communityId'];
    }

    returnData("COMMUNITY_INFO", $connection, $communityData);
}

?>