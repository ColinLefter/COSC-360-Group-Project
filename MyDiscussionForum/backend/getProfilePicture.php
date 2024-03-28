<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

session_start();

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

// Connect to the database
$connection = connectToDB();

$username = $_SESSION['username'];

// Since prepared statements do not support binding LIMIT and OFFSET directly, these must be integers
// if ($communtyId == null) {
$sql = "SELECT profilePicFileName FROM userdetails INNER JOIN user ON userDetails.userId=user.userId WHERE userName=?;";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $username);


// Execute the query
$stmt->execute();
$result = $stmt->get_result();
$picData = array();

if ($result -> num_rows > 0) {
    $row = $result -> fetch_assoc();
        $picData[0] = array(
            'profilepicture' => $row['profilePicFileName'],
        );

    returnData("PROFILE_PICTURE", $connection, $picData);

} else {
    returnData("PROFILE_PICTURE_EMPTY", $connection);
}

$stmt->close();
closeDB($connection);

?>