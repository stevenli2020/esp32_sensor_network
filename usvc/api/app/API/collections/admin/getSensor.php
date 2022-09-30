<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $ID = array_key_exists('ID',$post )?$post['ID']:null;
    $sqlIndex = '';
    if($ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "ID IS EMPTY";
        echo json_encode($RESPONSE);
        die(); 
    } 
    // $sqlIndex = "SELECT * FROM RL_LOC_NODES WHERE NODE_ID='$ID'";
    $sqlIndex = "SELECT NODES.NAME as SENSOR_NAME, NODES.MAC, NODES.SENSOR_TYPE, NODES.THRESHOLD, NODES.ID, FACILITIES.NAME as FACILITY_NAME, FACILITIES.UID, LOCATIONS.LOCATION_NAME, LOCATIONS.LOCATION_UID FROM RL_LOC_NODES JOIN NODES ON ID=RL_LOC_NODES.NODE_ID JOIN LOCATIONS ON RL_LOC_NODES.LOC_UID=LOCATIONS.LOCATION_UID JOIN FACILITIES ON LOCATIONS.FACILITY_UID=FACILITIES.UID WHERE NODE_ID='$ID'";
    $RESPONSE -> SQL = $sqlIndex;
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[]= $row;                
        }
        // while($row = $result->fetch_assoc()) {
        //     $TEMP -> DATA[] = new stdClass();
        //     $TEMP -> DATA[0] -> SENSOR_NAME = $row['NODE_NAME'];
        //     $TEMP -> DATA[0] -> ID = $row['NODE_ID'];
        //     $TEMP -> DATA[0] -> SENSOR_TYPE = $row['SENSOR_TYPE']; 
        //     $TEMP -> DATA[0] -> MAC = $row['MAC'];
        //     $LOCATION_UID = $row['LOC_UID'];                 
        //     $FAC_UID = $row['FAC_UID'];                 
        //     if($LOCATION_UID != null){
        //         $sqlIndex = "SELECT LOCATION_NAME, LOCATION_UID FROM LOCATIONS WHERE LOCATION_UID='$LOCATION_UID'";
        //         $result = $conn-> query($sqlIndex);
        //         if($result->num_rows > 0){
        //             while($row = $result->fetch_assoc()) {
        //                 $TEMP -> DATA[0] -> LOCATION_NAME = $row['LOCATION_NAME'];
        //                 $TEMP -> DATA[0] -> LOCATION_UID = $row['LOCATION_UID'];
        //                 // $FAC_UID = $row['FACILITY_UID'];
        //                 if($FAC_UID != null){
        //                     $sqlIndex = "SELECT NAME, UID FROM FACILITIES WHERE UID='$FAC_UID'";
        //                     $result = $conn-> query($sqlIndex);
        //                     if($result->num_rows > 0){
        //                         while($row = $result->fetch_assoc()) {
        //                             $TEMP -> DATA[0] -> FACILITY_NAME = $row['NAME'];
        //                             $TEMP -> DATA[0] -> FACILITY_UID = $row['UID'];
        //                             $sqlIndex = "SELECT THRESHOLD FROM NODES WHERE ID='$ID'";
        //                             $result = $conn-> query($sqlIndex);
        //                             if($result->num_rows > 0){
        //                                 while($row = $result->fetch_assoc()) {
        //                                     $TEMP -> DATA[0] -> THRESHOLD = $row['THRESHOLD'];
        //                                 }
        //                             }
        //                         }
        //                     }
        //                 }
        //             }
        //         }                
        //     }    
        //     $RESPONSE = $TEMP;     
        // }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "NO DATA FOUND ON THIS LOCATION";
        echo json_encode($RESPONSE);
        die(); 
    } 
}
die();

