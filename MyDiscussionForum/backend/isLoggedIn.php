<?php


session_start();

if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn'] == true) {
    echo json_encode(['result' => 'SUCCESS','msg' => 'User is logged in', 'userName' => $_SESSION['username']]);
} else {
    echo json_encode(['result' => 'FAIL','msg' => 'User is not logged in']);
}

?>