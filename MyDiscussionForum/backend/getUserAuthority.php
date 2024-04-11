<?php
session_start();
include "databaseFunc.php";

$response = ['authority' => 0]; // Default to normal user

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    $connection = connectToDB();

    if (!$connection) {
        echo json_encode($response);
        exit();
    }

    $stmt = mysqli_prepare($connection, "SELECT userAuthority FROM userDetails WHERE userId = ?");
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $response['authority'] = (int)$row['userAuthority'];
    }
    
    mysqli_close($connection);
}

echo json_encode($response);
?>