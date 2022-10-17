<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $ID = array_key_exists('ID',$post )?$post['ID']:null;
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
    if($ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Alert ID is empty";
        echo json_encode($RESPONSE);
        die();
    }

    $sqlIndex = '';
    
    $sqlIndex = "SELECT * FROM NOTIFICATIONS WHERE ID='$ID'";           
        
    $result = mysqli_query($conn, $sqlIndex);
    // $RESPONSE->SQL = $sqlIndex;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // $RESPONSE -> DATA[] = $row;      
            if(strpos($row['NOTIFIED_USERS'], $LOGIN_NAME)){
                $sqlIndex = "UPDATE NOTIFICATIONS SET STATUS=1, ACK_USER='$LOGIN_NAME' WHERE ID='$ID'";
                if($conn->query($sqlIndex) == TRUE){
                    //TODO: sent added password noti to user
                    $RESPONSE -> CODE = CODE_SUCCESS;
                    echo json_encode($RESPONSE);
                }
            }
        }
        // $RESPONSE -> CODE = CODE_SUCCESS;
        // echo json_encode($RESPONSE);            
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Fail to acknowledge of this notification";
        echo json_encode($RESPONSE);
        die();
    }
    mysqli_close($conn);
}

die();
?>