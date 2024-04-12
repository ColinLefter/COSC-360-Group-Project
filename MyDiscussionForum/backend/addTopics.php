<?php

/* For use on createPost page, adding topics to posts */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Check for login
session_start();
if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== true) {
    returnData("TOPICS_NOT_ADDED");
    exit();
}

// Validate post method
validateMethodPost();

$topics = $_POST['topics'];

if (empty($topics)) {
    returnData("EMPTY_INPUT_GENERAL");
    exit();
}

$topicsData = json_decode($topics, true);
if (!is_array($topicsData)) {
    returnData("INVALID_INPUT_FORMAT");
    exit();
}

// Connect to the database
$connection = connectToDB();

// Get most recent post id
$stmt = $connection->prepare("SELECT MAX(postId) AS id FROM post");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$id = $row['id']; // Will always be the latest post

// Check if $id is valid
if (!$id) {
    returnData("POST_NOT_FOUND", $connection);
    exit();
}

// Insert topics
$stmt = $connection->prepare("INSERT INTO topic (postId, topicName) VALUES (?, ?)");

$affectedRows = 0;
foreach ($topicsData as $topic) {
    $stmt->bind_param("is", $id, $topic);
    $stmt->execute();
    $affectedRows += $stmt->affected_rows;
}

if ($affectedRows > 0) {
    returnData("TOPICS_ADDED", $connection);
} else {
    returnData("TOPICS_NOT_ADDED", $connection);
}

$stmt->close();
$connection->close();

?>