<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $MAC = array_key_exists('MAC',$post )?$post['MAC']:null;
    $sqlIndex = '';
    if($MAC == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "MAC ADDRESS IS EMPTY";
        echo json_encode($RESPONSE);
        die(); 
    } 
    $sqlIndex = "SELECT FACILITIES.NAME as FACILITY_NAME, LOCATIONS.LOCATION_NAME as LOCATION_NAME FROM RL_LOC_NODES JOIN LOCATIONS ON RL_LOC_NODES.LOC_UID=LOCATIONS.LOCATION_UID JOIN FACILITIES ON LOCATIONS.FACILITY_UID=FACILITIES.UID WHERE MAC='$MAC'";
    // $RESPONSE -> SQL = $sqlIndex;
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[] = $row;
            // $TEMP -> DATA[] = new stdClass();
            // $FAC_UID= $row['FAC_UID'];                
            // $LOC_UID= $row['LOC_UID'];     
            // $sqlIndex = "SELECT * FROM LOCATIONS WHERE LOCATION_UID='$LOC_UID'";
            // $result = $conn-> query($sqlIndex);
            // if($result->num_rows > 0){
            //     while($row = $result->fetch_assoc()) {
            //         $TEMP -> DATA[0] -> LOCATION_NAME = $row['LOCATION_NAME'];
            //     }
            // } else {
            //     $RESPONSE -> CODE = CODE_ERROR;
            //     $RESPONSE -> MESSAGE = "LOCATION NOT REGISTER";
            //     echo json_encode($RESPONSE);
            //     die(); 
            // }
            // $sqlIndex = "SELECT * FROM FACILITIES WHERE UID='$FAC_UID'";
            // $result = $conn-> query($sqlIndex);
            // if($result->num_rows > 0){
            //     while($row = $result->fetch_assoc()) {
            //         $TEMP -> DATA[0] -> FACILITY_NAME = $row['NAME'];
            //     }
            // } else {
            //     $RESPONSE -> CODE = CODE_ERROR;
            //     $RESPONSE -> MESSAGE = "FACILITY NOT REGISTER";
            //     echo json_encode($RESPONSE);
            //     die(); 
            // }
        }
        // $RESPONSE = $TEMP;
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "MAC ADDRESS NOT REGISTER";
        echo json_encode($RESPONSE);
        die(); 
    }  
    
       
    mysqli_close($conn);
    
}
die();