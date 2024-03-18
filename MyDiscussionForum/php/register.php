<?php
/* Run on register account */
include "databaseCred.php";

// Variables are subject to change
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$passhash = md5($password);

// Return array
$returnData = array();

// Connect to database and check success.
$connection = mysqli_connect($host, $user, $dbpassword, $database);
$error = mysqli_connect_error();
if($error != null) {
    $returnData['result'] = "FAIL";
    $returnData['type'] = "DATABASE_CONNECT_ERROR";
    $returnData['msg'] = "Could not connect to database!";
    echo json_encode($returnData);
    exit();
}

// check for users
$sql = "SELECT username, email FROM user WHERE username='".$username."' OR email='".$email."';";    
$results = mysqli_query($connection, $sql);
if(mysqli_num_rows($results) > 0) {
    $returnData['result'] = "FAIL";
    $returnData['type'] = "USER_EXISTS";
    $returnData['msg'] = "<p class='user-exists' style='text-align: center; margin-top: 2px;'>Account already exists! Try another username/email.<p>";
} else {
    // Insert user information
    $sql = "INSERT INTO user (userName, firstName, lastName, email, password) VALUES ('".$username."', '".$firstname."', '".$lastname."', '".$email."', '".$passhash."');";
    $results = mysqli_query($connection, $sql);
    $returnData['result'] = "SUCCESS";

    // TODO: Insert default details into userDetails table

}

mysqli_close($connection);
echo json_encode($returnData);
exit();

?>