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
    returnData("COMMUNITY_NOT_ADDED");
    exit();
}

// Validate post
validateMethodPost();

$communityName = $_POST['communityName'];
$communityDescription = $_POST['communityDescription'];

if (!isset($communityName) || !isset($communityDescription)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// // Sanitize
$communityName = mysqli_real_escape_string($connection, $communityName);
$communityDescription = mysqli_real_escape_string($connection, $communityDescription);

$sql = "INSERT INTO community (communityName, description) VALUES ('".$communityName."', '".$communityDescription."');";    

// echo $sql;
$results = mysqli_query($connection, $sql);

if(mysqli_affected_rows($connection) > 0) {
    returnData("COMMUNITY_ADDED", $connection);

} else {
    returnData("COMMUNITY_NOT_ADDED", $connection);
}

?>