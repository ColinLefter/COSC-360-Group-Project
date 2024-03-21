<?php

include "databaseCred.php";

function connectToDB() {
    // Connect to database and check success.
    $connection = mysqli_connect($host, $user, $dbpassword, $database);
    $error = mysqli_connect_error();
    if($error != null) {
        $returnData['result'] = "FAIL";
        $returnData['type'] = "DATABASE_CONNECT_ERROR";
        $returnData['msg'] = "Could not connect to database!";
        echo json_encode($returnData);
        exit();
    }

    return $connection;
}

function closeDB($connection) {
    mysqli_close($connection);
}

?>