<?php

/* For use on createPost.html and right column */

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate Request Method
validateMethodPost();

// Connect
$connection = connectToDB();

// Nothing to sanitize

$sql = "SELECT topicName, postId FROM topic ORDER BY postId DESC;";    

$results = mysqli_query($connection, $sql);
$communityData = array();

if(mysqli_num_rows($results) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($results)) {
        $communityData[$i] = array();
        $communityData[$i]['topicName'] = $row['topicName'];
        $i++;
    }

    returnData("TOPICS_RETURNED", $connection, $communityData);

} else {
    returnData("TOPICS_NOT_RETURNED", $connection);
}

?>