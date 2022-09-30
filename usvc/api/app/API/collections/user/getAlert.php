<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $ID = array_key_exists('ID',$post )?$post['ID']:null;
    
    if($ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Alert ID is empty";
        echo json_encode($RESPONSE);
        die();
    }

    $sqlIndex = '';
    
    $sqlIndex = "SELECT NOTIFICATIONS.ID, NOTIFICATIONS.TIME, NOTIFICATIONS.MESSAGE, NOTIFICATIONS.NOTIFIED_USERS, NOTIFICATIONS.ACK_USER, NOTIFICATIONS.STATUS, USERS.LOGIN_NAME FROM NOTIFICATIONS JOIN RL_LOC_NODES ON NOTIFICATIONS.MAC=RL_LOC_NODES.MAC JOIN LOCATIONS ON RL_LOC_NODES.LOC_UID=LOCATIONS.LOCATION_UID JOIN USERS ON LOCATIONS.CLEANER_UID=USERS.CODE WHERE NOTIFICATIONS.ID='$ID'";           
        
    $result = mysqli_query($conn, $sqlIndex);
    // $RESPONSE->SQL = $sqlIndex;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[] = $row;       
        }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);            
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Fail to get data of this notification";
        echo json_encode($RESPONSE);
        die();
    }
    mysqli_close($conn);
}

die();
?>