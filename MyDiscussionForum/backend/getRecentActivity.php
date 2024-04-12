<?php

include_once "returnData.php";
include "databaseFunc.php";
include "validation.php";

// Validate Request Method
validateMethodPost();

// Connect
$connection = connectToDB();

// Nothing to sanitize

session_start();


$stmt = $connection -> prepare("SELECT name, isCommunity, cid, activityId FROM recentActivity WHERE userId=? ORDER BY activityId DESC;");
$stmt->bind_param("i", $_SESSION['userId']);
    
// Execute the query
$stmt->execute();
$result = $stmt->get_result();

$recentData = array();

if($result->num_rows > 0) {

    $i = 0;
    while ($row = $result->fetch_assoc()) {
        $recentData[$i]['name'] = $row['name'];
        $recentData[$i]['isCommunity'] = $row['isCommunity'];
        $recentData[$i]['cid'] = $row['cid'];
        $i++;
    }

    echo json_encode(['result' => 'SUCCESS', 'type' => 'RECENT_ACTIVITY_RETURNED', 'msg' => 'activity returned.', 'data' => $recentData]);

} else {

    echo json_encode(['result' => 'FAIL', 'type' => 'NO_RECENT_ACTIVITY_RETURNED', 'msg' => 'Activities not returned']);
}

closeDB($connection); // Close the DB connection
exit();

?>