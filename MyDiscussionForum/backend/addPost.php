<?php

/* For use on createPost page, adding post */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Check for login
session_start();
if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== true) {
    returnData("POST_NOT_ADDED");
    exit();
}

// Validate post
validateMethodPost();

$communityId = $_POST['communityId'] ?? null;
$postTitle = $_POST['postTitle'] ?? null;
$postContent = $_POST['postContent'] ?? null;

if (empty($communityId) || empty($postTitle) || empty($postContent)) {
    returnData("EMPTY_INPUT_GENERAL");
    exit();
}

// Connect to the database
$connection = connectToDB();

// Getting the userId for the logged-in user
$stmt = $connection->prepare("SELECT userId FROM user WHERE userName = ?");
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $userId = $row['userId'];
} else {
    returnData("USER_NOT_FOUND", $connection);
    exit;
}

// Prepare the insert statement for the post
$stmt = $connection->prepare("INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $userId, $communityId, $postTitle, $postContent);

// Execute the statement
if ($stmt->execute()) {
    returnData("POST_ADDED", $connection);
} else {
    returnData("POST_NOT_ADDED", $connection);
}

$stmt->close();
$connection->close();

?>