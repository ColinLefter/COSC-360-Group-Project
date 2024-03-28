<?php

session_start();

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

$currentPassword = $_POST['currentPassword'];
$newPassword = $_POST['newPassword'];

if (empty($currentPassword) || empty($newPassword)) {
    returnData("EMPTY_INPUT");
    exit();
}

// Connect to database with error handling
$connection = connectToDB();

if (!$connection) { // Something went wrong, so we call our custom handleError function from the commonFunctions.php file
    handleError("Database connection failed", $connection);
}

// We are using the session to get the username of the currently logged in user
$username = $_SESSION['username'];
$stmt = $connection -> prepare("SELECT username, password FROM user WHERE username = ?;");
$stmt -> bind_param("s", $username);
$stmt -> execute();
$results = $stmt -> get_result();

if ($results -> num_rows > 0) {
  $row = $results -> fetch_assoc();
  // We are using password_verify for secure password checking
  if (password_verify($currentPassword, $row['password'])) { // If the current password matches the one we just retrieved
    $stmt = $connection -> prepare("UPDATE user SET password = ? WHERE username = ?;");
    $newPassword = password_hash($newPassword, PASSWORD_DEFAULT); // Hash the new password
    $stmt -> bind_param("ss", $newPassword, $username);
    $stmt -> execute();
    $results = $stmt -> get_result();

    header('Content-Type: application/json');
    returnData("PASSWORD_UPDATED", $connection);
  } else {
    returnData("INVALID_PASSWORD", $connection);
  }
} else {
    returnData("USER_NOT_FOUND", $connection);
}

closeDB($connection); // Close the DB connection
exit();

?>
