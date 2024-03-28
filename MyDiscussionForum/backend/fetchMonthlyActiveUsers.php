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

$firstDayOfMonth = date('Y-m-01'); // First day of the current month
$today = date('Y-m-d'); // Today's date, to ensure we include the current day in our count

$query = "SELECT COUNT(DISTINCT userId) AS monthlyActiveUsers FROM userActivity WHERE activityDate BETWEEN ? AND ? AND activityType LIKE 'LOGIN';";
$stmt = $connection->prepare($query);
$stmt -> bind_param("ss", $firstDayOfMonth, $today); // Between includes both the first day and the current day
$stmt -> execute();
$result = $stmt -> get_result();

if ($result) {
  $row = $result -> fetch_assoc();
  echo json_encode(['result' => 'SUCCESS', 'monthlyActiveUsers' => $row['monthlyActiveUsers']]);
} else {
  echo json_encode(['result' => 'FAIL', 'msg' => 'Failed to fetch monthly active users!']);
}

closeDB($connection); // Close the DB connection
exit();

?>
