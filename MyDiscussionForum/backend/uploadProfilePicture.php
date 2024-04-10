<?php

/* For use on createPost page, adding post */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Check for login
session_start();
if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true) {
    $userName = $_SESSION['username'];
    $userID = $_SESSION['userId'];
} else {
    exit();
}

// Validate post
validateMethodPost();

// Upload file
$targetFile = "../res/img/". basename($_FILES["profilepicture"]["name"]);
$fileName = basename($_FILES["profilepicture"]["name"]);
// $imagedata = file_get_contents($_FILES['profilepicture']['tmp_name']);
// $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
//     exit();
// }

$result = move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $targetFile);

// Connect
$connection = connectToDB();

// // Sanitize
$fileName = mysqli_real_escape_string($connection, $fileName);

// Upload to BLOB (Consider storing on database)
// $sql = "INSERT INTO userImages (userID, contentType, image) VALUES (?,?,?)";
// $stmt = mysqli_stmt_init($connection);
// mysqli_stmt_prepare($stmt, $sql);

// $null = NULL;
// mysqli_stmt_bind_param($stmt, "isb", $userID, $imageFileType, $null);
// mysqli_stmt_send_long_data($stmt, 2, $imagedata);

// $result = mysqli_stmt_execute($stmt);
// mysqli_stmt_close($stmt);
// echo $fileName;

$sql = "UPDATE userDetails SET profilePicName='".$fileName."' WHERE userDetails.userId='".$userID."';";
$results = mysqli_query($connection, $sql);

if(mysqli_affected_rows($connection) > 0) {
    returnData("PROFILE_PICTURE_UPLOADED", $connection);

} else {
    returnData("PROFILE_PICTURE_NOT_UPLOADED", $connection);
}

?>