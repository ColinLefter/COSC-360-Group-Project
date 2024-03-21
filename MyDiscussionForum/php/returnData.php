<?php

// Point of structure is to return dynamic data
// For example, if FAIL, there will be a msg that can be printed to console
// If we only need confirmation that we succeeded, we only need to return the result

function returnData($msgType, $conn = false) {

    // Big ol' switch
    $dataToReturn = array();

    switch($msgType) {
        // Register
        case "ACCOUNT_CREATION_SUCCESS": // Tested
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Account creation successful!";
            break;
        case "INVALID_PASSWORD":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Password is invalid!";
            break;
        case "INVALID_EMAIL":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Email is invalid!";
            break;
        case "EMPTY_INPUT":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "First name, last name, or username is empty!";
            break;
        case "USER_EXISTS": // Tested
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "<p class='user-exists' style='text-align: center; margin-top: 2px;'>Account already exists! Try another username/email.<p>";
            break;
        // Post validation
        case "REQUEST_METHOD": // Tested
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Request method is not post!";
            break;
        // DB connection failure
        case "DATABASE_CONNECT_ERROR": // Tested
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Could not connect to database!";
            break;

        default:
            // TODO: Add error logging here
            break;

    }

    // If returned while database is connected
    if ($conn != false) {
        mysqli_close($conn);
    }
    echo json_encode($dataToReturn);
    exit();

}


?>