<?php

/* For use with community column */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate request method
validateMethodPost();

$topic = $_POST['topic'];

if (!isset($topic)) {
    returnData("EMPTY_INPUT_GENERAL");
}

// Connect
$connection = connectToDB();

// Sanitize
$topic = mysqli_real_escape_string($connection, $topic);

session_start();
if(isset($_SESSION['userId'])) {
    $sql = "INSERT INTO recentActivity (userId, isCommunity, name) VALUES ('".$_SESSION['userId']."','0', '".$topic."');";
    $results = mysqli_query($connection, $sql);

    echo json_encode(['result' => 'SUCCESS', 'type' => 'TOPIC_ACTIVITY_LOGGED', 'msg' => 'Topic logged.']);

}


closeDB($connection); // Close the DB connection
exit();

?>