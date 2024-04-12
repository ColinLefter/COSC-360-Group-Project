<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

session_start();

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

$query = $_POST['query'];
$values = explode(' ', $query);
$paramTypes = ''; // This will hold the types of the parameters
$paramValues = []; // This array will hold the actual values to bind

// Connect
$connection = connectToDB();

$sql = "SELECT postId, user.userName, postTitle, postContent, creationDate FROM post INNER JOIN user ON post.authorId = user.userId WHERE ";

$conditions = [];
foreach ($values as $value) {
    $value = trim($value);
    if (!empty($value)) {
        $conditions[] = "(postTitle LIKE CONCAT('%', ?, '%') OR postContent LIKE CONCAT('%', ?, '%'))";
        $paramTypes .= 'ss'; // Adding two string types for each value
        $paramValues[] = &$value; // Adding the value twice (once for title and once for content)
        $paramValues[] = &$value;
    }
}

// Concatenating all conditions with OR
if (count($conditions) > 0) {
    $sql .= implode(' OR ', $conditions);
}

$stmt = $connection->prepare($sql);

// Bind parameters
array_unshift($paramValues, $paramTypes); // Prepend types at the beginning of the array
call_user_func_array([$stmt, 'bind_param'], $paramValues);

// Execute and process results
$stmt->execute();
$result = $stmt->get_result();
$postData = [];

while ($row = $result->fetch_assoc()) {
    $postData[] = [
        'postId' => $row['postId'],
        'authorName' => $row['userName'],
        'postTitle' => $row['postTitle'],
        'postContent' => $row['postContent'],
        'creationDateTime' => $row['creationDate'],
    ];
}

returnData("QUERIED_POSTS", $connection, $postData);

$stmt->close();
$connection->close();
?>
