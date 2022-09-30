<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('NAME',$post )?$post['NAME']:null;
    // $YEAR = (string)$TIME;
	// $rows = [];
    $sqlIndex = '';
    $COORDINATOR = '';
    if($NAME != null){
        $sqlIndex = "SELECT * FROM NODES WHERE NAME = '{$NAME}'";
        $result = mysqli_query($conn, $sqlIndex);
        if ($result->num_rows > 0) {      
            while($row = $result->fetch_assoc()) {
                $COORDINATOR = $row['PARENT'];                
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            // $RESPONSE -> SQL = $sqlIndex;
            $RESPONSE -> MESSAGE = "NODE NAME NOT FOUND";
            echo json_encode($RESPONSE);
            die();
        }
    }
    
    $sqlIndex = "SELECT * FROM NODES WHERE PARENT='$COORDINATOR'";
    $result = mysqli_query($conn, $sqlIndex);

    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[]= $row;                        
        }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> SQL = $sqlIndex;
        $RESPONSE -> MESSAGE = "NO DATA";
        echo json_encode($RESPONSE);
        die();
    }
    
    
    mysqli_close($conn);
    // $RESPONSE -> db = $conn;
    // $RESPONSE -> result = $result;
    // $RESPONSE -> SQL = $sqlIndex;    
    // $RESPONSE -> DATA = $rows?$rows:null;
    
}
die();