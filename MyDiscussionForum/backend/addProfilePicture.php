<?php

/* For updating the profile picture of a user */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Check for login
session_start();
if (!isset($_SESSION['userLoggedIn']) || $_SESSION['userLoggedIn'] !== true) {
    returnData("PROFILE_PICTURE_NOT_UPLOADED");
    exit();
}

// Validate post
validateMethodPost();

// Validate the file upload
if (isset($_FILES["profilepicture"]) && $_FILES["profilepicture"]["error"] == 0) {
    $targetDir = "../res/img/";
    $fileName = basename($_FILES["profilepicture"]["name"]);
    $targetFile = $targetDir . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Validate file type
    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
    if (!in_array($fileType, $allowedTypes)) {
        returnData("INVALID_FILE_TYPE");
        exit();
    }

    // Attempt to move the uploaded file
    if (!move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $targetFile)) {
        returnData("PROFILE_PICTURE_NOT_UPLOADED");
        exit();
    }
} else {
    returnData("NO_FILE_UPLOADED");
    exit();
}

// Connect to the database
$connection = connectToDB();

// Prepare the update statement
$stmt = $connection->prepare("UPDATE userdetails SET profilePicFileName = ? WHERE userId = (SELECT userId FROM user WHERE userName = ?)");
$stmt->bind_param("ss", $fileName, $_SESSION['username']);

// Execute the statement
if ($stmt->execute() && $stmt->affected_rows > 0) {
    returnData("PROFILE_PICTURE_UPLOADED", $connection);
} else {
    returnData("PROFILE_PICTURE_NOT_UPLOADED", $connection);
}

$stmt->close();
$connection->close();

?>