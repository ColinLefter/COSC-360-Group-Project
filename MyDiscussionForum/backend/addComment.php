<?php

/* For use on post page, adding comment */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Check for login
session_start();
if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true) {
    $userName = $_SESSION['username'];
}

// Validate post
validateMethodPost();

$postId = $_POST['postId'];
$parentId = $_POST['parentId'];
$content = $_POST['content'];

if (!isset($postId) || !isset($content) || !isset($parentId)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// // Sanitize
$postId = mysqli_real_escape_string($connection, $postId);
$parentId = mysqli_real_escape_string($connection, $parentId);
$content = mysqli_real_escape_string($connection, $content);

if (strcmp($parentId, "NULL") == 0) {
    $sql = "INSERT INTO comment (postId, userId, parentId, commentContent) VALUES ('".$postId."', (SELECT userId from user WHERE userName='".$userName."'), NULL, '".$content."');";    
} else {
    $sql = "INSERT INTO comment (postId, userId, parentId, commentContent) VALUES ('".$postId."', (SELECT userId from user WHERE userName='".$userName."'), '".$parentId."', '".$content."');";    
}
// echo $sql;
$results = mysqli_query($connection, $sql);

if(mysqli_affected_rows($connection) > 0) {
    returnData("COMMENT_ADDED", $connection);

} else {
    returnData("COMMENT_NOT_ADDED", $connection);
}

?>