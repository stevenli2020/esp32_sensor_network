<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NODE_NAME = array_key_exists('NODE_NAME',$post )?$post['NODE_NAME']:null;
    $LOC_UID = array_key_exists('LOC_UID',$post )?$post['LOC_UID']:null;
    $sqlIndex = '';
    if($LOC_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "LOCATION NAME IS EMPTY";
        echo json_encode($RESPONSE);
        die(); 
    } 
    $sqlIndex = "SELECT RL_LOC_NODES.NODE_ID, NODES.NAME, NODES.SENSOR_TYPE FROM RL_LOC_NODES RIGHT JOIN NODES ON RL_LOC_NODES.NODE_ID=NODES.ID WHERE LOC_UID='$LOC_UID'";
    // $RESPONSE -> SQL = $sqlIndex;
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[]= $row;                
        }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "SENSOR DATA NOT FOUND";
        echo json_encode($RESPONSE);
        die(); 
    } 
        
          
    mysqli_close($conn);
    
}
die();