<?php
session_start();

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

$connection = connectToDB();

// This won't really every happen as it is impossible to access the page without being logged in.
// This is more of a safety net and for documentation to show that the user must be logged in to access this page.
if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== true) {
  header("Location: login.html");
  exit;
}

// Validate post
validateMethodPost();

// What has been received from the frontend
$firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

// We are checking to see if the user actually changed anything before we update the database
$changesMade = $firstName !== $_SESSION['firstName'] || $lastName !== $_SESSION['lastName'] || $email !== $_SESSION['email'] || $username !== $_SESSION['username'];

if ($changesMade) {
  $stmt = $connection->prepare("UPDATE user SET firstName = ?, lastName = ?, email = ?, userName = ? WHERE userId = ?;"); // Use userID as users can change usernames
  $stmt->bind_param("sssss", $firstName, $lastName, $email, $username, $userId);

  if ($stmt -> execute()) {
    // Now we update the session variables as well
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;
    $_SESSION['email'] = $email;
    $_SESSION['username'] = $username;

    header('Content-Type: application/json');
    returnData("ACCOUNT_UPDATED", $connection);
  } else {
    returnData("ACCOUNT_UPDATE_FAILED", $connection);
  }

  $stmt -> close();
} else {
  echo json_encode(returnData("NO_NEW_ACCOUNT_CHANGES", $connection));
  returnData("NO_NEW_ACCOUNT_CHANGES", $connection);
}

closeDB($connection);
exit();

?>