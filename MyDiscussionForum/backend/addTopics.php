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

if (!isset($communityId) || !isset($postTitle) || !isset($postContent)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// // Sanitize
$communityId = mysqli_real_escape_string($connection, $communityId);
$postTitle = mysqli_real_escape_string($connection, $postTitle);
$postContent = mysqli_real_escape_string($connection, $postContent);

$sql = "INSERT INTO post (authorId, communityId, postTitle, postContent) VALUES ((SELECT userId from user WHERE userName='".$userName."'), '".$communityId."', '".$postTitle."', '".$postContent."');";    

// echo $sql;
$results = mysqli_query($connection, $sql);

if(mysqli_affected_rows($connection) > 0) {
    returnData("POST_ADDED", $connection);

} else {
    returnData("POST_NOT_ADDED", $connection);
}

?>