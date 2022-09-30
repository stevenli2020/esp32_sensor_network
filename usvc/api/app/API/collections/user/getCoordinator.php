<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $VALUE = array_key_exists('VALUE',$post )?$post['VALUE']:null;
    // $YEAR = (string)$TIME;
	// $rows = [];
    $sqlIndex = '';
    $COORDINATOR = '';
    if($VALUE != null){
        $sqlIndex = "SELECT * FROM NODES WHERE NAME LIKE '%$VALUE%'";
        $result = mysqli_query($conn, $sqlIndex);
        if ($result->num_rows > 0) {      
            while($row = $result->fetch_assoc()) {
                $RESPONSE -> DATA[]= $row;                
            }
            $RESPONSE -> CODE = CODE_SUCCESS;
            echo json_encode($RESPONSE);
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "NO DATA";
            echo json_encode($RESPONSE);
        }
    }
    

    // if ($result->num_rows > 0) {      
    //     while($row = $result->fetch_assoc()) {
    //         $temp = new stdClass();
    //         $temp -> SENSOR_DATA = $row['SENSOR_DATA'];
    //         $temp -> BATT_PCT = $row['BATT_PCT'];
    //         $temp -> NODE_ID = $row['NODE_ID'];
    //         $temp -> TIME = $row['TIME'];
    //         $RESPONSE -> DATA[]= $temp;                        
    //     }
    //     $RESPONSE -> CODE = CODE_SUCCESS;
    //     echo json_encode($RESPONSE);
    // } else {
    //     $RESPONSE -> CODE = CODE_ERROR;
    //     $RESPONSE -> MESSAGE = "NO DATA";
    //     echo json_encode($RESPONSE);
    // }
    
    
    mysqli_close($conn);
    // $RESPONSE -> db = $conn;
    // $RESPONSE -> result = $result;
    // $RESPONSE -> SQL = $sqlIndex;    
    // $RESPONSE -> DATA = $rows?$rows:null;
    
}
die();