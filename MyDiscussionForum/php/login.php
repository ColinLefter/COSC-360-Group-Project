<?php

// TODO: Add error logging

/* Run on register account */
include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate post
validateMethodPost();

// What has been received from the frontend
$username = $_POST['username'];
$password = $_POST['password'];

// Validation
if (!isset($username) || !isset($password)) {
    returnData("EMPTY_INPUT");
}

// Hash the password, 128 bit output. Needs no sanitization
$passhash = md5($password);

// Connect to database
$connection = connectToDB();

$stmt = $connection -> prepare("SELECT userName, password FROM user WHERE userName = ?;");
$stmp -> bind_param("s", $username); // Using prepared statements to prevent SQL injections
$stmt -> execute();
$result = $stmt -> get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  if ($row['password'] == $passhash) {
      returnData("USER_SSO", $connection);
  } else {
      returnData("INVALID_PASSWORD", $connection);
  }
} else {
  returnData("USER_NOT_FOUND", $connection);
}

// Should be impossible to get here, but just in case
closeDB($connection);
exit();

?>