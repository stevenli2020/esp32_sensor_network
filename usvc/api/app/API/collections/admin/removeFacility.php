<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('NAME',$post )?$post['NAME']:null;
    $UID = array_key_exists('UID',$post )?$post['UID']:null;
    if($UID == null){
        $RESPONSE -> MESSAGE = "UID is empty";
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    // if(count(get_object_vars($RESPONSE)) > 0){
    //     $RESPONSE -> CODE = CODE_ERROR;
    //     echo json_encode($RESPONSE);
    //     die();
    // }

	$rows = [];
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM FACILITIES WHERE UID='$UID'";
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $locationName = $row['NAME'];
        $sqlIndex = "DELETE FROM FACILITIES WHERE UID='$UID'";
        $result = $conn->query($sqlIndex);
        if($conn->query($sqlIndex) == TRUE){
            $sqlIndex = "DELETE FROM LOCATIONS WHERE FACILITY_UID='$UID'";
            $result = $conn->query($sqlIndex);
            if($conn->query($sqlIndex) == TRUE){
                $sqlIndex = "DELETE FROM RL_FAC_NODES WHERE FAC_UID='$UID'";
                $result = $conn->query($sqlIndex);
                if($conn->query($sqlIndex) == TRUE){
                    $RESPONSE -> CODE = CODE_SUCCESS;
                    echo json_encode($RESPONSE);
                } else {
                    $RESPONSE -> CODE = CODE_ERROR;
                    $RESPONSE -> MESSAGE = "Unable to delete Facility's Location, Please Try again later!";
                    echo json_encode($RESPONSE);
                    die();
                }
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "Unable to delete Facility's Location, Please Try again later!";
                echo json_encode($RESPONSE);
                die();
            }            
            // die();
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "Unable to delete Facility, Please Try again later!";
            echo json_encode($RESPONSE);
            die();
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "FACILITY NOT FOUND";
        echo json_encode($RESPONSE);
        die(); 
    }
    // $RESPONSE -> CODE = CODE_SUCCESS;
    // echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();