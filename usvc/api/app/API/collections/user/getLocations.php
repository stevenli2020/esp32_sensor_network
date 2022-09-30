<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $FACILITY_NAME = array_key_exists('FACILITY_NAME',$post )?$post['FACILITY_NAME']:null;
    $LOCATION_UID = array_key_exists('LOCATION_UID',$post )?$post['LOCATION_UID']:null;
    $FACILITY_UID = '';
    $sqlIndex = '';
    if($FACILITY_NAME == null && $LOCATION_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "LOCATION NAME IS EMPTY";
        echo json_encode($RESPONSE);
        die(); 
    } 
    if($LOCATION_UID == null){
        $sqlIndex = "SELECT * FROM FACILITIES WHERE NAME='$FACILITY_NAME'";
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $FACILITY_UID= $row['UID'];                
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "FACILITY NOT FOUND";
            echo json_encode($RESPONSE);
            die(); 
        }
        $sqlIndex = "SELECT * FROM LOCATIONS WHERE FACILITY_UID='$FACILITY_UID'";
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $RESPONSE -> DATA[]= $row;                
            }
            $RESPONSE -> CODE = CODE_SUCCESS;
            echo json_encode($RESPONSE);
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "NO LOCATIONS ON DATABASE";
            echo json_encode($RESPONSE);
            die(); 
        }
    } else {
        $sqlIndex = "SELECT * FROM LOCATIONS WHERE LOCATION_UID='$LOCATION_UID'";
        // $RESPONSE -> SQL = $sqlIndex;
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $TEMP -> DATA[] = new stdClass();
                $TEMP -> DATA[0] -> LOCATION_NAME = $row['LOCATION_NAME'];
                $TEMP -> DATA[0] -> LOCATION_UID = $row['LOCATION_UID'];
                $TEMP -> DATA[0] -> LOCATION_IMG_LINK = $row['LOCATION_IMG_LINK'];
                $FAC_UID = $row['FACILITY_UID'];
                $Supervisor_UID = $row['SUPERVISOR_UID'];
                $Cleaner_UID = $row['CLEANER_UID'];
                if($FAC_UID != null){
                    $sqlIndex = "SELECT NAME, UID FROM FACILITIES WHERE UID='$FAC_UID'";
                    $result = $conn-> query($sqlIndex);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            $TEMP -> DATA[0] -> FACILITY = $row['NAME'];
                            $TEMP -> DATA[0] -> FACILITY_UID = $row['UID'];
                        }
                    }
                }
                if($Supervisor_UID != null){
                    $sqlIndex = "SELECT LOGIN_NAME, CODE FROM USERS WHERE CODE='$Supervisor_UID'";
                    $result = $conn-> query($sqlIndex);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            $TEMP -> DATA[0] -> SUPERVISOR = $row['LOGIN_NAME'];
                            $TEMP -> DATA[0] -> SUPERVISOR_UID = $row['CODE'];
                        }
                    }
                }
                if($Cleaner_UID != null){
                    $sqlIndex = "SELECT LOGIN_NAME, CODE FROM USERS WHERE CODE='$Cleaner_UID'";
                    $result = $conn-> query($sqlIndex);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            $TEMP -> DATA[0] -> CLEANER = $row['LOGIN_NAME'];
                            $TEMP -> DATA[0] -> CLEANER_UID = $row['CODE'];
                        }
                    }
                }                
                $RESPONSE = $TEMP;     
                $RESPONSE -> CODE = CODE_SUCCESS;
                echo json_encode($RESPONSE);           
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "LOCATION NAME NOT FOUND";
            echo json_encode($RESPONSE);
            die(); 
        }
    }   
       
    mysqli_close($conn);
    
}
die();