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

$communityName = $_POST['communityName'] ?? null;
$communityDescription = $_POST['communityDescription'] ?? null;

if (empty($communityName) || empty($communityDescription)) {
    returnData("EMPTY_INPUT_GENERAL");
    exit();
}

// Connect to the database
$connection = connectToDB();

// Prepare the SQL statement
$stmt = $connection->prepare("INSERT INTO community (communityName, description) VALUES (?, ?)");

// Bind the parameters
$stmt->bind_param("ss", $communityName, $communityDescription);

// Execute the query
if ($stmt->execute()) {
    returnData("COMMUNITY_ADDED", $connection);
} else {
    returnData("COMMUNITY_NOT_ADDED", $connection);
}

// Close the prepared statement and the connection
$stmt->close();
$connection->close();

?>
