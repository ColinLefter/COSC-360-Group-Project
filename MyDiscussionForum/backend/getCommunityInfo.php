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

// Check if isPost indicates a community page
if ($isPost === "0") { // community page
    $stmt = $connection->prepare("SELECT communityName, description FROM community WHERE communityId = ?");
    $stmt->bind_param("i", $id); // Important: communityId is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $communityData[] = array(
            'communityName' => $row['communityName'],
            'communityDesc' => $row['description']
        );
    }
    
    $stmt->close();
    returnData("COMMUNITY_INFO", $connection, $communityData);
} else { // post page
    $stmt = $connection->prepare("SELECT communityName, description, community.communityId FROM community INNER JOIN post ON community.communityId = post.communityId WHERE postId = ?");
    $stmt->bind_param("i", $id); // Important: postId is an integer
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $communityData[] = array(
            'communityName' => $row['communityName'],
            'communityDesc' => $row['description'],
            'communityId' => $row['communityId']
        );
    }

    $stmt->close();
    returnData("COMMUNITY_INFO", $connection, $communityData);
}

closeDB($connection);

?>