<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $ID = array_key_exists('NODE_ID',$post )?$post['NODE_ID']:null;
    $NODE_NAME = array_key_exists('NODE_NAME',$post )?$post['NODE_NAME']:null;    
    $ALERT_ID = array_key_exists('ALERT_ID',$post )?$post['ALERT_ID']:null;
    if($ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Node ID is empty";
        echo json_encode($RESPONSE);
        die();
    }

    $sqlIndex = '';
    if($ALERT_ID == null)
        $sqlIndex = "SELECT NOTIFICATIONS.ID, NOTIFICATIONS.TIME, NOTIFICATIONS.MESSAGE, NOTIFICATIONS.NOTIFIED_USERS FROM NOTIFICATIONS LEFT JOIN RL_LOC_NODES ON NOTIFICATIONS.MAC=RL_LOC_NODES.MAC WHERE RL_LOC_NODES.NODE_ID='$ID' ORDER BY NOTIFICATIONS.TIME DESC LIMIT 10";           
    else
        $sqlIndex = "SELECT NOTIFICATIONS.ID, NOTIFICATIONS.TIME, NOTIFICATIONS.MESSAGE, NOTIFICATIONS.NOTIFIED_USERS FROM NOTIFICATIONS LEFT JOIN RL_LOC_NODES ON NOTIFICATIONS.MAC=RL_LOC_NODES.MAC WHERE RL_LOC_NODES.NODE_ID='$ID' AND NOTIFICATIONS.ID<'$ALERT_ID' ORDER BY NOTIFICATIONS.TIME DESC LIMIT 10";
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
        $RESPONSE -> MESSAGE = "Fail to get notification data of this node";
        echo json_encode($RESPONSE);
        die();
    }
    mysqli_close($conn);
}

die();
?>