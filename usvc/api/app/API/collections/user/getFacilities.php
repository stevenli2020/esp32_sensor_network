<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('FACILITY_NAME',$post )?$post['FACILITY_NAME']:null;
        
    $sqlIndex = '';
    if($NAME != null){
        $sqlIndex = "SELECT * FROM FACILITIES WHERE NAME='$NAME'";
    } else 
        $sqlIndex = "SELECT * FROM FACILITIES";
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[]= $row;                
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "NO FACILITIES ON DATABASE";
        echo json_encode($RESPONSE);
        die(); 
    }

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();