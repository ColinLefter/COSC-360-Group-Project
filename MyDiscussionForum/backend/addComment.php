<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

session_start();
if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== true) {
    // Handle the case where the user is not logged in
    returnData("USER_NOT_LOGGED_IN");
    exit;
}

$userName = $_SESSION['username'];

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

// Validate input presence
if (empty($_POST['postId']) || empty($_POST['content'])) {
    returnData("EMPTY_INPUT_GENERAL");
    exit;
}

$postId = $_POST['postId'];
$content = $_POST['content'];
$parentId = isset($_POST['parentId']) ? $_POST['parentId'] : null;

// Connect to the database
$connection = connectToDB();

// Prepare the userId query to get userId from userName
$stmt = $connection->prepare("SELECT userId FROM user WHERE userName = ?");
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $userId = $row['userId'];
} else {
    returnData("USER_NOT_FOUND", $connection);
    exit;
}

// Prepare the insert statement for the comment
if ($parentId === null || $parentId === "NULL") {
    $stmt = $connection->prepare("INSERT INTO comment (postId, userId, parentId, commentContent) VALUES (?, ?, NULL, ?)");
} else {
    $stmt = $connection->prepare("INSERT INTO comment (postId, userId, parentId, commentContent) VALUES (?, ?, ?, ?)");
}

if ($parentId === null || $parentId === "NULL") {
    $stmt->bind_param("iis", $postId, $userId, $content);
} else {
    $stmt->bind_param("iiis", $postId, $userId, $parentId, $content);
}

// Execute the statement
if ($stmt->execute()) {
    returnData("COMMENT_ADDED", $connection);
} else {
    returnData("COMMENT_NOT_ADDED", $connection);
}

$stmt->close();
$connection->close();

?>