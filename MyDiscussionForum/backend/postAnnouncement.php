<?php

session_start();

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

$connection = connectToDB();

if (!$connection) {
    handleError("Database connection failed", $connection);
    exit();
}

header('Content-Type: application/json');

if (!isset($_SESSION["username"])) {
  echo json_encode(['result' => 'FAIL', 'msg' => 'You are not logged in as an admin!']);
  exit();
}

if (!isset($_POST['title']) || !isset($_POST['content'])) {
    echo json_encode(['result' => 'FAIL', 'msg' => 'Please submit both the title and content of the announcement.']);
    exit();
}

$title = $_POST['title'];
$content = $_POST['content'];
$author = $_SESSION["username"];

$query = "INSERT INTO adminAnnouncement (announcementTitle, announcementAuthor, announcementContent) VALUES (?, ?, ?);";
$stmt = $connection->prepare($query);
$stmt->bind_param("sss", $title, $author, $content);

if ($stmt->execute()) {
    echo json_encode(['result' => 'SUCCESS']);
} else {
    echo json_encode(['result' => 'FAIL', 'msg' => 'Failed to insert announcement']);
}

$stmt->close();
closeDB($connection);
?>
