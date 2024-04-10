<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

session_start();

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== true) {
    exit();
}

$userName = $_SESSION['username'];

// Assuming 'id' is always expected to be an integer
$postId = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$postUserName = $_POST['userName'];
if ($postId <= 0) {
    returnData("EMPTY_INPUT_GENERAL");
    exit();
}

// Not actually a valid request. 
if ($postUserName !== $userName) {
    exit();
}

// Connect to the database
$connection = connectToDB();

// Prepared statement for fetching the post details
$sql = "DELETE FROM post WHERE postId=?;";    
$stmt = $connection->prepare($sql);

// Bind the integer parameter
$stmt->bind_param("i", $postId);

// Execute the query
$stmt->execute();
if($stmt->affected_rows > 0) {

    returnData("POST_DELETED", $connection);

} else {
    returnData("POST_NOT_DELETED", $connection);
}

$stmt->close();
closeDB($connection);

?>