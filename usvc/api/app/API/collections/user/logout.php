<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
    $CODE = array_key_exists('CODE',$post )?$post['CODE']:null;
        
    if($LOGIN_NAME == null){
        $RESPONSE -> MESSAGE[] = "Username is empty";
    }    
    if($CODE == null){
        $RESPONSE -> MESSAGE[] = "Token is empty";
    }
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = "SELECT * FROM USERS WHERE LOGIN_NAME='$LOGIN_NAME'";
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            if(password_verify($row['CODE'], $CODE)){
                $RESPONSE -> CODE = CODE_SUCCESS;
                $NAME = $row['LOGIN_NAME'];
                $sqlIndex = "UPDATE USERS SET STATUS='LOGOUT' WHERE LOGIN_NAME='$NAME'";
                $result = $conn->query($sqlIndex);
                if($conn->query($sqlIndex) == TRUE){
                } else {
                    $RESPONSE -> CODE = CODE_ERROR;
                    $RESPONSE -> MESSAGE[] = "Fail to update status";
                    echo json_encode($RESPONSE);
                    die();
                }
                echo json_encode($RESPONSE);
                die();
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE[] = "Token not found";
                echo json_encode($RESPONSE);
                die(); 
            }
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Username Not Found";
        echo json_encode($RESPONSE);
        die(); 
    }
    

    
    
    mysqli_close($conn);
    
}
die();

 ?>