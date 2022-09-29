<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $LOCATION_NAME = array_key_exists('LOCATION_NAME',$post )?$post['LOCATION_NAME']:null;
    $LOCATION_UID = array_key_exists('LOCATION_UID',$post )?$post['LOCATION_UID']:null;
    $FACILITY_UID = array_key_exists('FACILITY_UID',$post )?$post['FACILITY_UID']:null;
    $SUPERVISOR_UID = array_key_exists('SUPERVISOR_UID',$post )?$post['SUPERVISOR_UID']:null;
    $CLEANER_UID = array_key_exists('CLEANER_UID',$post )?$post['CLEANER_UID']:null;
    $LOCATION_IMG_LINK = array_key_exists('LOCATTION_IMG_LINK',$post )?$post['LOCATTION_IMG_LINK']:null;

    if($LOCATION_NAME == null){
        $RESPONSE -> MESSAGE[] = "Location Name can't be empty";
    } else {
        if(strpos($LOCATION_NAME, "'") !== false){
            $RESPONSE -> MESSAGE[] = "Single quote is not allowed in Name";
        }
    }
    if($FACILITY_UID == null){
        $RESPONSE -> MESSAGE[] = "Facility Name must be select from suggestion";
    }    
    

    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    while(true){
        $LOCATION_UID = bin2hex(random_bytes(16));
        $sqlIndex = "SELECT * FROM LOCATIONS WHERE LOCATION_UID = $LOCATION_UID";
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            continue;
        } else {
            break;
        }
    }
    if($LOCATION_IMG_LINK == null)
        $LOCATION_IMG_LINK = 'https://picsum.photos/200';

	
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM FACILITIES WHERE UID='$FACILITY_UID'";
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $sqlIndex = "INSERT INTO LOCATIONS (LOCATION_NAME, LOCATION_UID, FACILITY_UID, SUPERVISOR_UID, CLEANER_UID, LOCATION_IMG_LINK) VALUES ('$LOCATION_NAME', '$LOCATION_UID', '$FACILITY_UID', '$SUPERVISOR_UID', '$CLEANER_UID', '$LOCATION_IMG_LINK')";
        // $RESPONSE->SQL = $sqlIndex;
        if($conn->query($sqlIndex) == TRUE){
            $RESPONSE -> DATA -> SUCCESS[] = "Facility of " .$LOCATION_NAME." added succefully";
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE[] = "LOCATION NAME must be unique";
            echo json_encode($RESPONSE);
            die(); 
        }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Facility Name not found";
        echo json_encode($RESPONSE);
        die();
    }
        
    
    mysqli_close($conn);
    
}
die();