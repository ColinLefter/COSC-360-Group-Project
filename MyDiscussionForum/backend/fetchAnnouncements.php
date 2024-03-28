<?php

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

$query = "SELECT announcementTitle, DATE_FORMAT(announcementDate, '%Y-%m-%d') AS formattedDate, announcementAuthor, announcementContent FROM adminAnnouncement ORDER BY announcementDate DESC;";
$result = $connection->query($query);

if ($result) {
    $announcements = [];
    while ($row = $result->fetch_assoc()) {
        $announcements[] = [
            'title' => $row['announcementTitle'],
            'date' => $row['formattedDate'],
            'author' => $row['announcementAuthor'],
            'content' => $row['announcementContent']
        ];
    }
    echo json_encode(['result' => 'SUCCESS', 'announcements' => $announcements]);
} else {
    echo json_encode(['result' => 'FAIL', 'msg' => 'Failed to fetch announcements']);
}

closeDB($connection);

?>
