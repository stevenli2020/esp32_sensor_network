<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
    $DISPLAY_NAME = array_key_exists('DISPLAY_NAME',$post )?$post['DISPLAY_NAME']:null;
    $EMAIL = array_key_exists('EMAIL',$post )?$post['EMAIL']:null;
    $PHONE = array_key_exists('PHONE',$post )?$post['PHONE']:null;
    $AUTH = array_key_exists('AUTH',$post )?$post['AUTH']:null;

    if($LOGIN_NAME == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "USERNAME EMPTY!";
        echo json_encode($RESPONSE);
        die();
    }
    if($AUTH == UPDATE_USER){
        $sqlIndex = '';
        $set_String = '';
        $sqlIndex = "SELECT * FROM USERS WHERE LOGIN_NAME='$LOGIN_NAME'";
        // $RESPONSE->SQL1 = $sqlIndex;
        $result = $conn->query($sqlIndex);
        if($result->num_rows > 0){
            $row = $result -> fetch_assoc();
            $oriName = $row['LOGIN_NAME'];
            // update node table
            if($DISPLAY_NAME != null){
                $set_String = "DISPLAY_NAME='$DISPLAY_NAME',";
            }
            if($EMAIL != null){
                if(!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)){
                    $RESPONSE -> CODE = CODE_ERROR;
                    $RESPONSE -> MESSAGE = "EMAIL ADDRESS IS INVALID!";
                    echo json_encode($RESPONSE);
                    die();
                }
                $set_String = $set_String."EMAIL='$EMAIL',";
            }
            if($PHONE != null){
                $set_String = $set_String."PHONE='$PHONE' ";
            } else {
                $set_String = $set_String ." LOGIN_NAME = '$LOGIN_NAME' ";
            }
            
            $sqlIndex = "UPDATE USERS SET ".$set_String." WHERE LOGIN_NAME='$LOGIN_NAME'";
            // $RESPONSE->SQL2 = $sqlIndex;
            $result = $conn->query($sqlIndex);
            if($conn->query($sqlIndex) == TRUE){
                //TODO: sent added password noti to user
                $RESPONSE -> CODE = CODE_SUCCESS;
                echo json_encode($RESPONSE);
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "Fail to update user";
                echo json_encode($RESPONSE);
                die();
            }
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "Couldn't Update User Details, please try again later";
                echo json_encode($RESPONSE);
                die();
            }

        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);    
        
        mysqli_close($conn);
            
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'AUTH FAIL!';
        echo json_encode($RESPONSE);
        die();
    }

}
    // } else{
    //     $RESPONSE -> CODE = CODE_ERROR;
    //     $RESPONSE -> MESSAGE = "AUTH FAIL!";
    //     echo json_encode($RESPONSE);
    //     die();
    // }
    
 
die();