<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
    $EMAIL = array_key_exists('EMAIL',$post )?$post['EMAIL']:null;

    if($LOGIN_NAME == null){
        $RESPONSE -> MESSAGE[] = "Login Name is empty";
    }
    if($EMAIL == null){
        $RESPONSE -> MESSAGE[] = "Email Address is empty";
    } else if(!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)){
        $RESPONSE -> MESSAGE[] = "Invalid Email Address";
    }
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }

	$rows = [];
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM USERS WHERE LOGIN_NAME='$LOGIN_NAME' AND EMAIL='$EMAIL'";
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $sqlIndex = "DELETE FROM USERS WHERE LOGIN_NAME='$LOGIN_NAME'";
        $result = $conn->query($sqlIndex);

        $RESPONSE -> CODE = CODE_SUCCESS;
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "USER DETAILS NOT FOUND";
        echo json_encode($RESPONSE);
        die(); 
    }
    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();