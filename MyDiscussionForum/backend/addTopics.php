<?php

/* For use on createPost page, adding post */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Check for login
session_start();
if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true) {
    $userName = $_SESSION['username'];
} else {
    returnData("TOPICS_NOT_ADDED");
    exit();
}

// Validate post
validateMethodPost();

$topics = $_POST['topics'];

if (!isset($topics)) {
    returnData("EMPTY_INPUT_GENERAL");
}

$topicsData = json_decode($topics, true);

// Connect
$connection = connectToDB();

// // Sanitize
for ($i = 0; $i < count($topicsData); $i++) {
    $topicsData[$i] = mysqli_real_escape_string($connection, $topicsData[$i]);
}

// Get most recent post
$sql = "SELECT MAX(postId) AS id FROM post;";
$results = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($results);
$id = $row['id']; // Will always be the latest post

// Insert
for ($i = 0; $i < count($topicsData); $i++) {
    $sql = "INSERT INTO topic (postId, topicName) VALUES ('".$id."', '".$topicsData[$i]."');";  
    $results = mysqli_query($connection, $sql);  
}

if(mysqli_affected_rows($connection) > 0) {
    returnData("TOPICS_ADDED", $connection);

} else {
    returnData("TOPICS_NOT_ADDED", $connection);
}

?>