<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $VALUE = array_key_exists('VALUE',$post )?$post['VALUE']:null;
    // $FACILITY_UID = array_key_exists('FACILITY_UID',$post )?$post['FACILITY_UID']:null;
        
    $sqlIndex = '';
    // $sqlIndex = "SELECT NODES.ID, NODES.NAME, NODES.SENSOR_TYPE, NODES.MAC FROM NODES JOIN RL_LOC_NODES ON NODES.MAC!=RL_LOC_NODES.MAC WHERE NODES.MAC LIKE '%348%' GROUP BY NODES.ID;";
    // $sqlIndex = "SELECT NODES.ID, NODES.NAME, NODES.SENSOR_TYPE, NODES.MAC FROM NODES JOIN RL_LOC_NODES ON NODES.MAC!=RL_LOC_NODES.MAC WHERE NODES.MAC LIKE '%$VALUE%' GROUP BY NODES.ID";
    $RESPONSE->SQL = $sqlIndex;
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[]= $row;                
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "No MAC address found";
        echo json_encode($RESPONSE);
        die(); 
    }

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();