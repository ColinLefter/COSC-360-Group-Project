<?php

function handleError($message, $connection = null) {
  if ($connection) {
      closeDB($connection);
  }
  error_log($message); // Log error server-side
  returnData("ERROR", false, $message);
}

function trackUserActivity($connection, $userId, $activityType) {
  $stmt = $connection -> prepare("INSERT INTO userActivity (userId, activityDate, activityType) VALUES (?, CURDATE(), ?);");
  $stmt -> bind_param("is", $userId, $activityType);
  if (!$stmt -> execute()) {
    error_log("Failed to track user activity: " . $stmt -> error);
  }
  $stmt -> close();
}
?>