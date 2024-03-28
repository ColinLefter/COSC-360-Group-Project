<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

session_start();

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

// Collect input
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validation
if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
    returnData("EMPTY_INPUT");
    exit();
}

validateEmail($email);
validatePassword($password);

// Hash the password with a secure function
$passhash = password_hash($password, PASSWORD_DEFAULT);

// Connect to database
$connection = connectToDB();

// Prepared statement for user existence check
$stmt = $connection -> prepare("SELECT username, email FROM user WHERE username = ? OR email = ?");
$stmt -> bind_param("ss", $username, $email);
$stmt -> execute();
$result = $stmt -> get_result();

if ($result -> num_rows > 0) {
    returnData("USER_EXISTS", $connection);
    exit();
} else {
    // Prepared statement for inserting user information
    $insertStmt = $connection -> prepare("INSERT INTO user (userName, firstName, lastName, email, accountAge, password) VALUES (?, ?, ?, ?, ?)");
    $insertStmt -> bind_param("ssssss", $username, $firstname, $lastname, $email, "30 days", $passhash); // For now every account age is 30 days. We will change this later.

    if ($insertStmt -> execute()) {
        trackUserActivity($connection, $_SESSION['userId'], "ACCOUNT_CREATED");
        returnData("ACCOUNT_CREATION_SUCCESS", $connection);
    } else {
        // Handle potential errors in account creation
        returnData("ACCOUNT_CREATION_FAILURE", $connection);
    }
}

// Close the database connection
closeDB($connection);

?>