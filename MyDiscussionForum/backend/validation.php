<?php

include_once "returnData.php";

function validateMethodPost() {
    if (strcmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
        returnData("REQUEST_METHOD");
    }
}

function validatePassword($pass) {

    $pattern = "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";

    if (!isset($pass) || preg_match($pattern, $pass) == 0) {
        returnData("INVALID_PASSWORD");
    }
}

function validateEmail($address) {


    if (!isset($address) || !filter_var($address, FILTER_VALIDATE_EMAIL)) {
        returnData("INVALID_EMAIL");
    }
}
?>