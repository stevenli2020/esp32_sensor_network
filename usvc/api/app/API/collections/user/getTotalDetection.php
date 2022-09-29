<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $VALUE = array_key_exists('VALUE',$post )?$post['VALUE']:null;

    $sqlIndex = query(null, null); 
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> TOTAL_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR TOTAL DETECTION';
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = query('DAY', null);  
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> DAY_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR DAY DETECTION';
        echo json_encode($RESPONSE);
        die();
    }            
    $sqlIndex = query("DAY", "DAY");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> PERCENT_DAY_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PERCENT DAY DETECTION';
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = query("WEEK", null);
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> WEEK_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR WEEK DETECTION';
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = query("WEEK", "WEEK");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> PERCENT_WEEK_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PERCENT WEEK DETECTION';
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = query("MONTH", null);
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> MONTH_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR MONTH DETECTION';
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = query("MONTH", "MONTH");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> PERCENT_MONTH_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PERCENT_MONTH DETECTION';
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = query("QUARTER", null);
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> QUARTER_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR QUARTER DETECTION';
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = query("QUARTER", "QUARTER");
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> PERCENT_QUARTER_DETECTION = $row['SENSOR_DATA'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO DATA FOR PERCENT QUARTER DETECTION';
        echo json_encode($RESPONSE);
        die();
    }

    

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);
    
    mysqli_close($conn);
    
}

function query($time, $percent){
    $sqlIndex = '';
    $rows = [];
    if($time == null and $percent == null)
        $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03'";
    elseif($percent == null){
        if($time == "DAY")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW()";
        elseif($time == "WEEK")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW()";
        elseif($time == "MONTH")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW()";
        else
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 4 MONTH AND NOW()";
    } 
    else {
        if($percent == "DAY")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 2 DAY AND NOW() - INTERVAL 1 DAY";
        elseif($percent == "WEEK")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 2 WEEK AND NOW() - INTERVAL 1 WEEK";
        elseif($percent == "MONTH")
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 2 MONTH AND NOW() - INTERVAL 1 MONTH";
        else
            $sqlIndex = "SELECT SUM(SENSOR_DATA) as SENSOR_DATA FROM EVENTS WHERE DATA_TYPE='03' AND TIME BETWEEN NOW() - INTERVAL 8 MONTH AND NOW() - INTERVAL 4 MONTH";
    }        
    return $sqlIndex;    
}

die();