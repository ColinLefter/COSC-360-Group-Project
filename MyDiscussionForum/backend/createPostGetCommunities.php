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

$sql = "SELECT communityName, communityId FROM community ORDER BY communityId DESC;";    

$results = mysqli_query($connection, $sql);
$communityData = array();

if(mysqli_num_rows($results) > 0) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($results)) {
        $communityData[$i] = array();
        $communityData[$i]['communityId'] = $row['communityId'];
        $communityData[$i]['communityName'] = $row['communityName'];
        $i++;
    }

    returnData("CREATE_POST_COMMUNITIES", $connection, $communityData);

} else {
    returnData("CREATE_POST_COMMUNITIES_EMPTY", $connection);
}

?>