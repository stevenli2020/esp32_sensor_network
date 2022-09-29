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
    $LOCATION_IMG_LINK = array_key_exists('LOCATION_IMG_LINK',$post )?$post['LOCATION_IMG_LINK']:null;  

    if($LOCATION_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Location name is empty";
    }
    if($FACILITY_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Facility name must be select from suggestion";
    }
    if($SUPERVISOR_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Supervisor name must be select from suggestion";
    }
    if($CLEANER_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Cleaner name must be select from suggestion";
    }
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = '';
    $set_String = '';
    $sqlIndex = "SELECT * FROM LOCATIONS WHERE LOCATION_UID='$LOCATION_UID'";
    // $RESPONSE->SQL1 = $sqlIndex;
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result -> fetch_assoc();
        $oriName = $row['LOCATION_NAME'];
        $ID = $row['ID'];
        // update node table
		if($LOCATION_NAME != $row['LOCATION_NAME']){
            $set_String = "LOCATION_NAME='$LOCATION_NAME',";
        }
        if($FACILITY_UID != null){
            $set_String = $set_String."FACILITY_UID='$FACILITY_UID',";
        }
        if($SUPERVISOR_UID != null){
            $set_String = $set_String."SUPERVISOR_UID='$SUPERVISOR_UID', ";
        } 
        if($CLEANER_UID != null){
            $set_String = $set_String."CLEANER_UID='$CLEANER_UID', ";
        }
        if($LOCATION_IMG_LINK != null){
            $set_String = $set_String."LOCATION_IMG_LINK='$LOCATION_IMG_LINK', ";
            
        } else if($row['LOCATION_IMG_LINK'] == null)
            $set_String = $set_String ." LOCATION_IMG_LINK = 'https://picsum.photos/200', ";
        
        $set_String = $set_String ." LOCATION_UID = '$LOCATION_UID'";

        $sqlIndex = "UPDATE LOCATIONS SET ".$set_String." WHERE LOCATION_UID='$LOCATION_UID'";
        // $RESPONSE->SQL = $sqlIndex;
        $result = $conn->query($sqlIndex);
        if($conn->query($sqlIndex) == TRUE){
            $RESPONSE -> CODE = CODE_SUCCESS;
            echo json_encode($RESPONSE);
            // die();
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "Fail to update Location";
            echo json_encode($RESPONSE);
            die();
        }
        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'LOCATION NOT FOUND';
        echo json_encode($RESPONSE);
        die();
    }
  
    
    mysqli_close($conn);
    
}
die();