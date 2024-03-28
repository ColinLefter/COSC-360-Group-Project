<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

if (!validateMethodGet()) {
    exit(); // Stop script execution if not GET
}

// Connect to database with error handling
$connection = connectToDB();

if (!$connection) { // Something went wrong, so we call our custom handleError function from the commonFunctions.php file
    handleError("Database connection failed", $connection);
}

header('Content-Type: application/json');

$today = date('Y-m-d');
$query = "SELECT COUNT(DISTINCT userId) AS dailyActiveUsers FROM userActivity WHERE activityDate = ? AND activityType LIKE 'LOGIN';";
$stmt = $connection -> prepare($query);
$stmt -> bind_param("s", $today);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result) {
    $row = $result -> fetch_assoc();
    echo json_encode(['result' => 'SUCCESS', 'dailyActiveUsers' => $row['dailyActiveUsers']]);
} else {
    echo json_encode(['result' => 'FAIL', 'msg' => 'Failed to fetch daily active users!']);
}

closeDB($connection); // Close the DB connection
exit();

?>