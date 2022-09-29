<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
    $PWD = array_key_exists('PWD',$post )?$post['PWD']:null;
    $CPWD = array_key_exists('CPWD',$post )?$post['CPWD']:null;
    $CODE = array_key_exists('CODE',$post )?$post['CODE']:null;
    $AUTH = array_key_exists('AUTH',$post )?$post['AUTH']:null;
    // $USER = array_key_exists('USER',$post )?$post['USER']:null;

    // if($AUTH == ADD_PASSWORD){
    if($LOGIN_NAME == null){
        $RESPONSE -> MESSAGE[] = "Login Name can't be empty";
    } else {
        if(strpos($LOGIN_NAME, "'") !== false){
            $RESPONSE -> MESSAGE[] = "Single quote is not allowed in Login Name";
        }else if(strpos($LOGIN_NAME, "'") !== false){
            $RESPONSE -> MESSAGE[] = "Space is not allowed in Login Name";
        }
    }
    if($PWD == null){
        $RESPONSE -> MESSAGE[] = "Password1 can't be empty";
    }
    if($CPWD == null){
        $RESPONSE -> MESSAGE[] = "Confirm Password can't be empty";
    } else if($PWD != $CPWD){
        $RESPONSE -> MESSAGE[] = "Both Passwords must be eqaul";
    }
    if($CODE == null){
        $RESPONSE -> MESSAGE[] = "Code is missing";
    }
    if($AUTH == null){
        $RESPONSE -> MESSAGE[] = "Not Authorise to add new code";
    }    
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = '';
    
    $PWD = password_hash($PWD, PASSWORD_BCRYPT);

    if($AUTH == ADD_PASSWORD){
        $sqlIndex = "UPDATE USERS SET PWD='$PWD', STATUS='AddPW' WHERE LOGIN_NAME='$LOGIN_NAME' AND CODE='$CODE'";
    } elseif ($AUTH == UPDATE_PASSWORD){
        $sqlIndex = "UPDATE USERS SET PWD='$PWD', STATUS='UpdatePW' WHERE LOGIN_NAME='$LOGIN_NAME' AND CODE='$CODE'";
    }
    // $RESPONSE -> SQL = $sqlIndex;
    $result = $conn-> query($sqlIndex);
    if($conn->query($sqlIndex) == TRUE){
        //TODO: sent added password noti to user
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Fail to add password";
        echo json_encode($RESPONSE);
        die();
    }
        
    // $RESPONSE -> CODE = CODE_SUCCESS;
    // echo json_encode($RESPONSE);

    
    
    mysqli_close($conn);
    
}
die();

// <?php
// // See the password_hash() example to see where this came from.
// $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

// if (password_verify('rasmuslerdorf', $hash)) {
//     echo 'Password is valid!';
// } else {
//     echo 'Invalid password.';
// }
// ?>