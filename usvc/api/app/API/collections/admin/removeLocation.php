<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOCATION_UID = array_key_exists('LOCATION_UID',$post )?$post['LOCATION_UID']:null;
    if($LOCATION_UID == null){
        $RESPONSE -> MESSAGE = "LOCATION is empty";
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
	$rows = [];
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM LOCATIONS WHERE LOCATION_UID='$LOCATION_UID'";
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $locationName = $row['NAME'];
        $sqlIndex = "DELETE FROM LOCATIONS WHERE LOCATION_UID='$LOCATION_UID'";
        $result = $conn->query($sqlIndex);
        if($conn->query($sqlIndex) == TRUE){
            $sqlIndex = "DELETE FROM RL_FAC_NODES WHERE LOC_UID='$LOCATION_UID'";
            $result = $conn->query($sqlIndex);
            if($conn->query($sqlIndex) == TRUE){                
                $RESPONSE -> CODE = CODE_SUCCESS;
                echo json_encode($RESPONSE);
                // die();
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "Unable to delete Location, Please Try again later!";
                echo json_encode($RESPONSE);
                die();
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "Unable to delete Location, Please Try again later!";
            echo json_encode($RESPONSE);
            die();
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "LOCATION NOT FOUND";
        echo json_encode($RESPONSE);
        die(); 
    }  
    
    mysqli_close($conn);
    
}
die();