<?php

include "commonFunctions.php";
include "databaseFunc.php";

// Starting the session to access the session variables
session_start();

$connection = connectToDB();
trackUserActivity($connection, $_SESSION['userId'], "LOGOUT");

// Unsetting all of the session variables
$_SESSION = array();

// Destroying the session
session_destroy();

// For production:
// $baseUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/jparish/COSC-360-Group-Project/MyDiscussionForum/';

// For development:
$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/cosc-360-group-project/MyDiscussionForum/';
header("Location: " . $baseUrl . "index.html");

exit();
?>