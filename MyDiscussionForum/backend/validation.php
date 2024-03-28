<?php

include_once "returnData.php";

function validateMethodPost() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        returnData("INVALID_REQUEST");
        return false; // Indicates that the method is not POST
    }
    return true; // Indicates that the method is POST
}

function validatePassword($pass) {
    $specialChars = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

    if (!isset($pass) || preg_match($specialChars, $pass) == 0) {
        returnData("INVALID_PASSWORD");
    }
}

function validateEmail($address) {
    if (!isset($address) || !filter_var($address, FILTER_VALIDATE_EMAIL)) {
        returnData("INVALID_EMAIL");
    }
}
?>