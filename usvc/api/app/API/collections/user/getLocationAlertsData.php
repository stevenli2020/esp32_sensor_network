<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOCATION_ID = array_key_exists('LOC_UID',$post )?$post['LOC_UID']:null;
    $NODE_NAME = array_key_exists('NODE_NAME',$post )?$post['NODE_NAME']:null;    

    if($LOCATION_ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Location Name is empty";
        echo json_encode($RESPONSE);
        die();
    }

    $sqlIndex = '';
    // $sqlIndex = "SELECT * FROM FACILITIES WHERE NAME='$FACILITY_NAME'";
    // $result = mysqli_query($conn, $sqlIndex);
    // if ($result->num_rows > 0) {
    //     while($row = $result->fetch_assoc()) {
    //         $FACILITY_ID = $row['UID'];      
    //     }            
    // } else {
    //     $RESPONSE -> CODE = CODE_ERROR;
    //     $RESPONSE -> MESSAGE = "Facility Not Found";
    //     echo json_encode($RESPONSE);
    //     die();
    // }
    $sqlIndex = "SELECT NOTIFICATIONS.ID, NOTIFICATIONS.TIME, NOTIFICATIONS.MESSAGE, NOTIFICATIONS.NOTIFIED_USERS, NOTIFICATIONS.ACK_USER, NOTIFICATIONS.STATUS FROM NOTIFICATIONS LEFT JOIN RL_LOC_NODES ON NOTIFICATIONS.MAC=RL_LOC_NODES.MAC JOIN LOCATIONS ON RL_LOC_NODES.LOC_UID=LOCATIONS.LOCATION_UID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' ORDER BY NOTIFICATIONS.TIME DESC LIMIT 5";           
        
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
        $RESPONSE -> MESSAGE = "Fail to get notification data of this location";
        echo json_encode($RESPONSE);
        die();
    }
    mysqli_close($conn);
}

die();
?>