<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
        
    $sqlIndex = '';
    $sqlIndex = "SELECT ID, LOGIN_NAME, DISPLAY_NAME, EMAIL, PHONE FROM USERS WHERE LOGIN_NAME='$LOGIN_NAME'";
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[]= $row;                
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "NO USER ON DATABASE";
        echo json_encode($RESPONSE);
        die(); 
    }

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();