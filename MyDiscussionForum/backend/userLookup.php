<?php

session_start();

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

header('Content-Type: application/json');

// Connect to database with error handling
$connection = connectToDB();

if (!$connection) {
    handleError("Database connection failed", $connection);
    exit();
}

$username = $_POST['username'];

if (empty($username)) {
  echo json_encode(['result' => 'FAIL', 'msg' => 'Username is empty']);
  exit();
}

$stmt = $connection -> prepare("SELECT * FROM user WHERE userName = ?;"); // We are always guaranteed a unique user since we don't allow duplicate usernames
$stmt -> bind_param("s", $username);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result -> num_rows > 0) {
  $row = $result -> fetch_assoc();
  $userData = [
    'username' => $row['userName'],
    'email' => $row['email'],
    'accountAge' => $row['accountAge'],
    // 'communities' => $row['communities'] will be implemented at a later date
  ];
  echo json_encode(['result' => 'SUCCESS', 'userData' => $userData]);
} else {
  echo json_encode(['result' => 'FAIL', 'msg' => 'Failed to fetch user data']);
}

closeDB($connection);
?>
