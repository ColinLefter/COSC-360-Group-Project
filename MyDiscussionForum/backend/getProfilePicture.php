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

$userId = $_SESSION['userId'];

$sql = "SELECT profilePicName FROM userdetails WHERE userId=?;";
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $userId);


// Execute the query
$stmt->execute();
$result = $stmt->get_result();
$picData = array();

if ($result -> num_rows > 0) {
    $row = $result -> fetch_assoc();
        $picData[0] = array(
            'profilepicture' => $row['profilePicName'],
            // 'userId' => $_SESSION['userId'],
        );

    returnData("PROFILE_PICTURE", $connection, $picData);

} else {
    returnData("PROFILE_PICTURE_EMPTY", $connection);
}

$stmt->close();
closeDB($connection);

?>