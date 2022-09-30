<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
include "/var/www/html/email/index.php";
if (checkRequest()) {
    $LOGIN_NAME = array_key_exists('NEW_USER_NAME',$post )?$post['NEW_USER_NAME']:null;
    $DISPLAY_NAME = array_key_exists('DISPLAY_NAME',$post )?$post['DISPLAY_NAME']:null;
    $EMAIL = array_key_exists('EMAIL',$post )?$post['EMAIL']:null;
    $PHONE = array_key_exists('PHONE',$post )?$post['PHONE']:null;
    $TYPE = array_key_exists('USER_TYPE',$post )?$post['USER_TYPE']:null;
    $PWD = array_key_exists('PWD',$post )?$post['PWD']:null;
    $CODE = array_key_exists('CODE',$post )?$post['CODE']:null;
    $AUTH = array_key_exists('AUTH',$post )?$post['AUTH']:null;
    // $USER = array_key_exists('USER',$post )?$post['USER']:null;

    if($AUTH == ADD_USER){
        if($LOGIN_NAME == null){
            $RESPONSE -> MESSAGE[] = "Login Name can't be empty";
        } else {
            if(strpos($LOGIN_NAME, "'") !== false){
                $RESPONSE -> MESSAGE[] = "Single quote is not allowed in Login Name";
            }else if(strpos($LOGIN_NAME, "'") !== false){
                $RESPONSE -> MESSAGE[] = "Space is not allowed in Login Name";
            }
        }
        if($DISPLAY_NAME == null){
            $RESPONSE -> MESSAGE[] = "Full Name can't be empty";
        }
        if($EMAIL == null){
            $RESPONSE -> MESSAGE[] = "Email can't be empty";
        } else if(!filter_var($EMAIL, FILTER_VALIDATE_EMAIL)){
            $RESPONSE -> MESSAGE[] = "Invalid Email Address";
        }
        if($PHONE == null){
            $RESPONSE -> MESSAGE[] = "Phone Number can't be empty";
        }
        if($TYPE == null || $TYPE == "User Type"){
            $RESPONSE -> MESSAGE[] = "Please Select User Type";
        }    
        if(count(get_object_vars($RESPONSE)) > 0){
            $RESPONSE -> CODE = CODE_ERROR;
            echo json_encode($RESPONSE);
            die();
        }
        $sqlIndex = "SELECT * FROM USERS WHERE LOGIN_NAME = '$LOGIN_NAME'";
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE[] = "Login Name Exist";
            echo json_encode($RESPONSE);
            die(); 
        }
        $sqlIndex = "SELECT * FROM USERS WHERE EMAIL = '$EMAIL'";
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE[] = "Email already taken";
            echo json_encode($RESPONSE);
            die(); 
        }
        $sqlIndex = "SELECT * FROM USERS WHERE PHONE = '$PHONE'";
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE[] = "Phone Number already taken";
            echo json_encode($RESPONSE);
            die(); 
        }
        while(true){
            $CODE = bin2hex(random_bytes(16));
            $sqlIndex = "SELECT * FROM USERS WHERE CODE = $CODE";
            $result = $conn-> query($sqlIndex);
            if($result->num_rows > 0){
                continue;
            } else {
                break;
            }
        }
        
        
        $sqlIndex = "INSERT INTO USERS (LOGIN_NAME, DISPLAY_NAME, EMAIL, PHONE, TYPE, STATUS, PWD, CODE) VALUES ('$LOGIN_NAME', '$DISPLAY_NAME', '$EMAIL', '$PHONE', '$TYPE', 'REGISTER' , '$PWD', '$CODE')";
        if($conn->query($sqlIndex) == TRUE){
            $RESPONSE -> DATA -> SUCCESS[] = "New user " .$LOGIN_NAME . " added successfully";
            // sent url to user mail
            // url link = 'http://167.99.77.130/API/Auth/updatePassword/?code=' . $CODE . '&' . $LOGIN_NAME .'&' . ADD_PASSWORD
            $link = 'http://167.99.77.130/API/Auth/updatePassword/?code=' . $CODE . '&' . $LOGIN_NAME .'&' . ADD_PASSWORD;
            sendMail($EMAIL, "Your Account Added Successfully", mailContent($link, $DISPLAY_NAME, 1));
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            // $RESPONSE -> SQL = $sqlIndex;
            $RESPONSE -> MESSAGE[] = "User can't added";
            echo json_encode($RESPONSE);
            die(); 
        }
    }
    
    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);

    
    
    mysqli_close($conn);
    
}
die();