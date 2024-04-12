<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";
include "commonFunctions.php";

session_start();

if (!validateMethodPost()) {
    exit(); // Stop script execution if not POST
}

$rowOffset = $_POST['offset'] ?? 0;
$numPosts = $_POST['posts'] ?? 10;
$query = $_POST['query'] ?? '';
$topic = $_POST['topic'] ?? 'none';

if (empty($query)) {
    returnData("EMPTY_INPUT_GENERAL");
    exit;
}

// Connect to the database
$connection = connectToDB();

// Sanitize the input
$query = $connection->real_escape_string($query);
$values = explode(' ', $query);
$topicCondition = '';

if ($topic !== 'none') {
    $topic = $connection->real_escape_string($topic);
    $topicCondition = " AND topicName = ?";
}

$searchConditions = [];

foreach ($values as $value) {
    $value = trim($value);
    if (!empty($value)) {
        $searchConditions[] = "postTitle LIKE CONCAT('%', ?, '%') OR postContent LIKE CONCAT('%', ?, '%')";
    }
}

if (empty($searchConditions)) {
    returnData("EMPTY_INPUT_GENERAL");
    exit;
}

$sql = "SELECT postId, user.userName, postTitle, postContent, creationDate,
        MATCH (postTitle, postContent) AGAINST (? IN BOOLEAN MODE) AS relevance
        FROM post
        INNER JOIN user ON post.authorId=user.userId
        WHERE (" . implode(' OR ', $searchConditions) . ")" . $topicCondition . "
        ORDER BY relevance DESC LIMIT ? OFFSET ?";

$stmt = $connection->prepare($sql);

$types = str_repeat('s', count($values) * 2 + 1); // Each value needs two bindings (title and content), plus one for the full-text search
$params = array_merge($values, $values); // Bind each value twice (once for title, once for content)
array_push($params, $query); // For full-text search

if ($topic !== 'none') {
    $types .= 'si'; // Add string type for topic and integers for limit and offset
    array_push($params, $topic, (int)$numPosts, (int)$rowOffset);
} else {
    $types .= 'ii'; // Add integer types for limit and offset
    array_push($params, (int)$numPosts, (int)$rowOffset);
}

$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$postData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $postData[] = array(
            'postId' => $row['postId'],
            'authorName' => $row['userName'],
            'postTitle' => $row['postTitle'],
            'postContent' => $row['postContent'],
            'creationDateTime' => $row['creationDate']
        );
    }

    trackUserActivity($connection, $_SESSION['userId'], "SEARCH_POSTS");
    returnData("QUERIED_POSTS", $connection, $postData);

} else {
    returnData("QUERIED_POSTS_EMPTY", $connection);
}

$stmt->close();
closeDB($connection);

?>