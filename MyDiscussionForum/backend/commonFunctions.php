<?php

function handleError($message, $connection = null) {
  if ($connection) {
      closeDB($connection);
  }
  error_log($message); // Log error server-side
  returnData("ERROR", false, $message);
}

?>