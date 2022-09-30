<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $ID = array_key_exists('ID',$post )?$post['ID']:null;
    if($ID == null){
        $RESPONSE -> MESSAGE = "SENSOR is empty";
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
	$rows = [];
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM NODES WHERE ID='$ID'";
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $sensorName = $row['NAME'];
        $sqlIndex = "SELECT * FROM RL_LOC_NODES WHERE NODE_ID='$ID'";
        $result = $conn->query($sqlIndex);
        if($result->num_rows > 0){
            $sqlIndex = "DELETE FROM NODES WHERE ID='$ID'";
            $result = $conn->query($sqlIndex);
            if($conn->query($sqlIndex) == TRUE){
                $sqlIndex = "DELETE FROM RL_LOC_NODES WHERE NODE_ID='$ID'";
                $result = $conn->query($sqlIndex);
                if($conn->query($sqlIndex) == TRUE){
                    $RESPONSE -> CODE = CODE_SUCCESS;
                    echo json_encode($RESPONSE);
                } else {
                    $RESPONSE -> CODE = CODE_ERROR;
                    $RESPONSE -> MESSAGE = "Unable to delete Sensor on RL Table, Please Try again later!";
                    echo json_encode($RESPONSE);
                    die();
                }               
                // die();
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "Unable to delete Sensor on Nodes, Please Try again later!";
                echo json_encode($RESPONSE);
                die();
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "SENSOR NOT FOUND ON RL TABLE";
            echo json_encode($RESPONSE);
            die();
        }
        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "SENSOR NOT FOUND ON NODES";
        echo json_encode($RESPONSE);
        die(); 
    }  
    
    mysqli_close($conn);
    
}
die();