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

$postUserName = $_POST['userName'];

// Connect to the database
$connection = connectToDB();

// Prepared statement for fetching the post details
$sql = "DELETE FROM user WHERE userName=?;";    
$stmt = $connection->prepare($sql);

// Bind the integer parameter
$stmt->bind_param("s", $postUserName);

// Execute the query
$stmt->execute();
if($stmt->affected_rows > 0) {

    echo json_encode(['result' => 'SUCCESS', 'type' => 'USER_DELETED', 'msg' => 'User successfully deleted.']);

} else {
    echo json_encode(['result' => 'FAIL', 'type' => 'USER_NOT_DELETED', 'msg' => 'User not deleted.']);
}

$stmt->close();
closeDB($connection);

?>