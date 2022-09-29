<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('NAME',$post )?$post['NAME']:null;
    $MAC = array_key_exists('MAC',$post )?$post['MAC']:null;
    $SENSOR_TYPE = array_key_exists('SENSOR_TYPE',$post )?$post['SENSOR_TYPE']:null;

    if($NAME == null){
        $RESPONSE -> MESSAGE[] = "Coordinator Name is empty";
    }
    if($MAC == null){
        $RESPONSE -> MESSAGE[] = "MAC Address is empty";
    }
    if($SENSOR_TYPE == null){
        $RESPONSE -> MESSAGE[] = "Node Type is empty";
    }
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }

	$rows = [];
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM NODES WHERE NAME='$NAME'";
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $locationName = $row['NAME'];
        $sqlIndex = "DELETE FROM NODES WHERE NAME='$NAME'";
        $result = $conn->query($sqlIndex);
        $sqlIndex = "DELETE FROM LOCATIONS WHERE NAME='$locationName'";
        $result = $conn->query($sqlIndex);

        $RESPONSE -> CODE = CODE_SUCCESS;
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "NODES NAME NOT FOUND";
        echo json_encode($RESPONSE);
        die(); 
    }
    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();