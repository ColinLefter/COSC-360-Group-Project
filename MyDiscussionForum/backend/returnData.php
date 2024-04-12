<?php

// Point of structure is to return dynamic data
// For example, if FAIL, there will be a msg that can be printed to console
// If we only need confirmation that we succeeded, we only need to return the result

function returnData($msgType, $conn = false, $data = null) {

    // Big ol' switch
    $dataToReturn = array();

    switch($msgType) {
        // Register
        case "ACCOUNT_CREATION_SUCCESS": // Tested
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Account creation successful!";
            break;
        case "ACCOUNT_UPDATED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Account changes successfully applied.";
            break;
        case "NO_NEW_ACCOUNT_CHANGES":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "No new account changes.";
            break;
        case "USER_NOT_FOUND":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "User not found!";
            break;
        case "ACCOUNT_UPDATE_FAILED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Unable to update account settings.";
            break;
        case "INVALID_PASSWORD":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Password is invalid!";
            break;
        case "IS_BANNED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "User is banned!";
            break;
        case "PASSWORDS_DO_NOT_MATCH":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Passwords do not match!";
            break;
        case "PASSWORD_UPDATED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Your password has been successfully updated!";
            break;
        case "INVALID_EMAIL":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Email is invalid!";
            break;
        case "INVALID_REQUEST":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Request method is invalid!";
            break;
        case "EMPTY_INPUT":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "First name, last name, or username is empty!";
            break;
        case "EMPTY_INPUT_GENERAL":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Data passed to PHP is not set!";
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
        // recent posts
        case "RECENT_POSTS": // Tested
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Recent posts returned successfully!";
            $dataToReturn['data'] = $data;
            break;
        case "RECENT_POSTS_EMPTY": // Tested
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Recent posts reached end of posts!";
            break;
        case "CURRENT_POST":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Post returned successfully!";
            $dataToReturn['data'] = $data;
            break;
        case "CURRENT_POST_EMPTY":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Post not found!";
            break;           
        case "CURRENT_COMMENTS":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Comments returned successfully!";
            $dataToReturn['data'] = $data;
            break;
        case "CURRENT_COMMENTS_EMPTY":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "No comments found!";
            break;         
        case "USER_SSO":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "User SSO successful!";
            $dataToReturn['data'] = $data;
            break;
        case "QUERIED_POSTS":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Queried posts return successfully!";
            $dataToReturn['data'] = $data;
            break;
        case "QUERIED_POSTS_EMPTY":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "No posts match query!";
            break;
        case "COMMENT_ADDED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Comment added successfully!";
            break;
        case "QUERIED_POSTS_EMPTY":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Comment not added!";
            break;
        case "BAD_NUM_ACCOUNTS_FETCH":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Unable to retrieve the number of accounts!";
            break;
        case "BAD_DAU_FETCH":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Unable to retrieve the number of daily active users!";
            break;
        case "BAD_MAU_FETCH":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Unable to retrieve the number of monthly active users!";
            break;
        case "CREATE_POST_COMMUNITIES":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Community names and id returned successfully!";
            $dataToReturn['data'] = $data;
            break;
        case "CREATE_POST_COMMUNITIES_EMPTY":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Communities not returned!";
            break;
        case "POST_ADDED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Post added successfully!";
            break;
        case "POST_NOT_ADDED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Post not added!";
            break;
        case "COMMUNITY_INFO":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Community info returned!";
            $dataToReturn['data'] = $data;
            break;
        case "PROFILE_PICTURE":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture returned!";
            $dataToReturn['data'] = $data;
            break;
        case "PROFILE_PICTURE_EMPTY":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture not found!";
            break; 
        case "PROFILE_PICTURE_UPLOADED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture uploaded!";
            break;
        case "PROFILE_PICTURE_NOT_UPLOADED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture not uploaded!";
            break; 
        case "PROFILE_PICTURE":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture returned!";
            $dataToReturn['data'] = $data;
            break;
        case "PROFILE_PICTURE_EMPTY":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture not found!";
            break; 
        case "PROFILE_PICTURE_UPLOADED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture uploaded!";
            break;
        case "PROFILE_PICTURE_NOT_UPLOADED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Profile picture not uploaded!";
            break; 
        case "POST_DELETED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Post deleted successfully!";
            break;
        case "POST_NOT_DELETED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Post not deleted.";
            break; 
        case "COMMUNITY_ADDED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Community added successfully!";
            break;
        case "COMMUNITY_NOT_ADDED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Community not added!";
            break;
        case "TOPICS_ADDED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Topics added successfully!";
            break;
        case "TOPICS_NOT_ADDED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Topics not added!";
            break;
        case "TOPICS_RETURNED":
            $dataToReturn['result'] = "SUCCESS";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Topics returned successfully!";
            $dataToReturn['data'] = $data;
            break;
        case "TOPICS_NOT_RETURNED":
            $dataToReturn['result'] = "FAIL";
            $dataToReturn['type'] = $msgType;
            $dataToReturn['msg'] = "Topics not returned!";
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