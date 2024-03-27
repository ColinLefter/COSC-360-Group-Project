<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

$username = $_POST['username'];
$password = $_POST['password'];

if (empty($_POST['username']) || empty($_POST['password'])) {
    returnData("EMPTY_INPUT");
    exit();
}

// Connect to database with error handling
$connection = connectToDB();

if (!$connection) { // Something went wrong, so we call our custom handleError function from the commonFunctions.php file
    handleError("Database connection failed", $connection);
}

$stmt = $connection -> prepare("SELECT * FROM user WHERE userName = ?;"); // We are always guaranteed a unique user since we don't allow duplicate usernames
$stmt -> bind_param("s", $username);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result -> num_rows > 0) {
    $row = $result -> fetch_assoc();
    // We are using password_verify for secure password checking
    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['userLoggedIn'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['firstName'] = $row['firstName'];
        $_SESSION['lastName'] = $row['lastName'];
        $_SESSION['email'] = $row['email'];
        returnData("USER_SSO", $connection);
    } else {
        returnData("INVALID_PASSWORD", $connection);
    }
} else {
    returnData("USER_NOT_FOUND", $connection);
}

closeDB($connection); // Close the DB connection
exit();

?>
