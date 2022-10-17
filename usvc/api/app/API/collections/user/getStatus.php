<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $VALUE = array_key_exists('VALUE',$post )?$post['VALUE']:null;

    $sqlIndex = "SELECT * FROM STATUS ORDER BY TIME DESC LIMIT $VALUE";
     
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {            
            $RESPONSE -> DATA[]= $row;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'Error query from database';
        echo json_encode($RESPONSE);
        die();
    }   
    

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);
    
    mysqli_close($conn);
    
}


die();