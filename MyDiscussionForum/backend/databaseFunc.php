<?php

include_once "returnData.php";

function connectToDB() {

    include "databaseCred.php";

    try {
        // Connect to database and check success.
        $connection = mysqli_connect($host, $user, $dbpassword, $database);
        $error = mysqli_connect_error();
    if ($error != null) {
        returnData("DATABASE_CONNECT_ERROR");
    }
    } catch(Exception $e) {
        returnData("DATABASE_CONNECT_ERROR"); // If you are getting this error, modify databaseCred.php to match your local database
    }
    return $connection;
}

function closeDB($connection) {
    mysqli_close($connection);
}

?>