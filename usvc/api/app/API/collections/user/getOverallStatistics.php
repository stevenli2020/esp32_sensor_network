<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $VALUE = array_key_exists('VALUE',$post )?$post['VALUE']:null;
    // if (strpos($TYPE, 'Air') !== false) {
    //     $TYPE = "a9";
    // } elseif (strpos($TYPE, 'Motion') !== false){
    //     $TYPE = "03";
    // } else {
    //     $TYPE = "0d";
    // }
    $sqlIndex = query("HOUR", "03"); 
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Hour_Detection = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PAST HOUR DETECTION';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query('DAY', "03");  
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Day_Detection = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR DAY DETECTION';
        // echo json_encode($RESPONSE);
        // die();
    }            
    $sqlIndex = query("WEEK", "03");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Week_Detection = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR WEEK DETECTION';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query("HOUR", "a9");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Hour_Avg_Air_Quality = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PAST HOUR AIR AVG';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query("DAY", "a9");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Day_Avg_Air_Quality = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PAST DAY AIR AVG';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query("WEEK", "a9");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Week_Avg_Air_Quality = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PAST WEEK AIR AVG';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query("HOUR", "0d");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Hour_Avg_Fill_Level = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PAST HOUR DIST AVG';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query("DAY", "0d");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Day_Avg_Fill_Level = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PAST DAY DIST AVG';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query("WEEK", "0d");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Week_Avg_Fill_Level = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PAST WEEK DIST AVG';
        // echo json_encode($RESPONSE);
        // die();
    }

    

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);
    
    mysqli_close($conn);
    
}

function query($time,$type){
    $sqlIndex = '';
    // $rows = [];
    if($type == "03"){
        if($time == "HOUR")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='$type' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW()";
        elseif($time == "DAY")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='$type' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW()";
        elseif($time == "WEEK")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='$type' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW()";
    } else {
        if($time == "HOUR")
            $sqlIndex = "SELECT AVG(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='$type' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW()";
        elseif($time == "DAY")
            $sqlIndex = "SELECT AVG(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='$type' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW()";
        elseif($time == "WEEK")
            $sqlIndex = "SELECT AVG(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='$type' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW()";
    }
            
    
    return $sqlIndex;    
}

die();