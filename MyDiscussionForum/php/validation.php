<?php

function validateMethodPost() {
    if (strcmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) {
        $returnData['result'] = "FAIL";
        $returnData['type'] = "REQUEST_METHOD";
        $returnData['msg'] = "Request method is not post!";
        echo json_encode($returnData);
        exit();
    }
}
?>