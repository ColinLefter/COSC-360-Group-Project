<?php

/* For use on createPost page, adding post */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Check for login
session_start();
if(isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] === true) {
    $userName = $_SESSION['username'];
} else {
    exit();
}

// Validate post
validateMethodPost();

// Upload file
$targetFile = "../res/img/". basename($_FILES["profilepicture"]["name"]);
$fileName = basename($_FILES["profilepicture"]["name"]);
$result = move_uploaded_file($_FILES["profilepicture"]["tmp_name"], $targetFile);

// Connect
$connection = connectToDB();

// // Sanitize
$fileName = mysqli_real_escape_string($connection, $fileName);

$sql = "UPDATE userdetails SET profilePicFileName='".$fileName."' WHERE userdetails.userId=(SELECT userId FROM user WHERE userName='".$userName."');";
// echo $sql;
$results = mysqli_query($connection, $sql);

if(mysqli_affected_rows($connection) > 0) {
    returnData("PROFILE_PICTURE_UPLOADED", $connection);

} else {
    returnData("PROFILE_PICTURE_NOT_UPLOADED", $connection);
}

?>