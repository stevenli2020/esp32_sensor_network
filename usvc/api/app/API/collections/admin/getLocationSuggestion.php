<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $VALUE = array_key_exists('VALUE',$post )?$post['VALUE']:null;
    $FACILITY_UID = array_key_exists('FACILITY_UID',$post )?$post['FACILITY_UID']:null;
        
    $sqlIndex = '';
    $sqlIndex = "SELECT LOCATION_NAME, LOCATION_UID FROM LOCATIONS WHERE FACILITY_UID='$FACILITY_UID' AND LOCATION_NAME LIKE '%$VALUE%'";
    // $RESPONSE->SQL = $sqlIndex;
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[]= $row;                
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Facility Name must be select from suggestion";
        echo json_encode($RESPONSE);
        die(); 
    }

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();