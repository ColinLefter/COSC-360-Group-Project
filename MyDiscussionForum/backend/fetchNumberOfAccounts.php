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

$query = "SELECT COUNT(*) AS totalUsers FROM user;";
$result = $connection -> query($query);

if ($result) {
  $row = $result -> fetch_assoc();
  echo json_encode(['result' => 'SUCCESS', 'totalUsers' => $row['totalUsers']]);
} else {
  echo json_encode(['result' => 'FAIL', 'msg' => 'Failed to fetch the number of accounts!']);
}

closeDB($connection); // Close the DB connection
exit();

?>
