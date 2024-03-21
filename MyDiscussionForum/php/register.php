<?php

// TODO: Add error logging

/* Run on register account */
include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate post
validateMethodPost();

// Variables are subject to change
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Validation
if (!isset($firstname) || !isset($lastname) || !isset($username)) {
    returnData("EMPTY_INPUT");
}
validateEmail($email);
validatePassword($password);

// Hash the password, 128 bit output
$passhash = md5($password);

// Connect to database
$connection = connectToDB();

// check for users
$sql = "SELECT username, email FROM user WHERE username='".$username."' OR email='".$email."';";    
$results = mysqli_query($connection, $sql);
if(mysqli_num_rows($results) > 0) {
    returnData("USER_EXISTS", $connection);

} else {
    // Insert user information
    $sql = "INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('".$username."', '".$firstname."', '".$lastname."', '".$email."', '".$passhash."');";
    $results = mysqli_query($connection, $sql);
    returnData("ACCOUNT_CREATION_SUCCESS", $connection);

    // TODO: Insert default details into userDetails table

}

// Should be impossible to get here, but just in case
closeDB($connection);
exit();

?>