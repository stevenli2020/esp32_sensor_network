<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('NAME',$post )?$post['NAME']:null;
    $MAC = array_key_exists('MAC',$post )?$post['MAC']:null;
    $CLUSTER_ID = array_key_exists('CLUSTER_ID',$post )?$post['CLUSTER_ID']:null;
    $SENSOR_TYPE = array_key_exists('SENSOR_TYPE',$post )?$post['SENSOR_TYPE']:null;
    $ADDR = array_key_exists('ADDR',$post )?$post['ADDR']:null;
    $LATITUDE = array_key_exists('LATITUDE',$post )?$post['LATITUDE']:null;
    $LONGITUDE = array_key_exists('LONGITUDE',$post )?$post['LONGITUDE']:null;
    $DESCRPTIONS = array_key_exists('DESCRPTIONS',$post )?$post['DESCRPTIONS']:null;

    if($NAME == null){
        $RESPONSE -> MESSAGE[] = "Coordinator Name can't be empty";
    } else {
        if(strpos($NAME, "'") !== false){
            $RESPONSE -> MESSAGE[] = "Single quote is not allowed in Name";
        }
    }
    if($MAC == null){
        $RESPONSE -> MESSAGE[] = "MAC Address can't be empty";
    }
    if($CLUSTER_ID == null){
        $RESPONSE -> MESSAGE[] = "Cluster Id can't be empty";
    }

    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }

	$rows = [];
    $sqlIndex = '';
    if($SENSOR_TYPE == null)
        $SENSOR_TYPE = 'a9';
    $sqlIndex = "INSERT INTO NODES (MAC, NAME, CLUSTER_ID, SENSOR_TYPE) VALUES ('$MAC', '$NAME', '$CLUSTER_ID', '$SENSOR_TYPE')";
    if($conn->query($sqlIndex) == TRUE){
        $RESPONSE -> DATA -> SUCCESS[] = "New node " .$NAME . " added successfully";
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "MAC AND NAME must be unique";
        echo json_encode($RESPONSE);
        die(); 
    }
    $sqlIndex = "INSERT INTO LOCATIONS (NAME, ADDR, LATITUDE, LONGITUDE, DESCRPTIONS) VALUES ('$NAME', '$ADDR', '$LATITUDE', '$LONGITUDE', '$DESCRPTIONS')";
    if($conn->query($sqlIndex) == TRUE){
        $RESPONSE -> DATA -> SUCCESS[] = "Location of " .$NAME." added succefully";
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "NAME must be unique";
        echo json_encode($RESPONSE);
        die(); 
    }
    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);
    // $COORDINATOR = '';
    // if($VALUE != null){
    //     $sqlIndex = "SELECT * FROM NODES WHERE NAME LIKE '%$VALUE%'";
    //     $result = mysqli_query($conn, $sqlIndex);
    //     if ($result->num_rows > 0) {      
    //         while($row = $result->fetch_assoc()) {
    //             $RESPONSE -> DATA[]= $row;                
    //         }
    //         $RESPONSE -> CODE = CODE_SUCCESS;
    //         echo json_encode($RESPONSE);
    //     } else {
    //         $RESPONSE -> CODE = CODE_ERROR;
    //         $RESPONSE -> MESSAGE = "NO DATA";
    //         echo json_encode($RESPONSE);
    //     }
    // }   

    
    
    mysqli_close($conn);
    
}
die();