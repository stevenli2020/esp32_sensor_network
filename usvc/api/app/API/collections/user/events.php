<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $TIME = array_key_exists('TIME',$post )?$post['TIME']:null;
    $TYPE = array_key_exists('TYPE',$post )?$post['TYPE']:null;
    $LOCATION = array_key_exists('LOCATION',$post )?$post['LOCATION']:null;
    $name = strval($LOCATION);
    // $YEAR = (string)$TIME;
	// $rows = [];
    $sqlIndex = '';
    $COORDINATOR = '';
    if($LOCATION != null){
        $sqlIndex = "SELECT * FROM NODES WHERE NAME = '{$name}'";
        $result = mysqli_query($conn, $sqlIndex);
        if ($result->num_rows > 0) {      
            while($row = $result->fetch_assoc()) {
                $COORDINATOR = $row['PARENT'];                
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            // $RESPONSE -> SQL = $sqlIndex;
            $RESPONSE -> MESSAGE = "LOCATION";
            echo json_encode($RESPONSE);
            die();
        }
    }
    if (strpos($TYPE, 'Air') !== false) {
        $TYPE = "a9";
    } elseif (strpos($TYPE, 'Motion') !== false){
        $TYPE = "03";
    } else {
        $TYPE = "d3";
    }
    if($TIME == "HOUR"){
        if($TYPE == "03")
            $sqlIndex = "SELECT BATT_PCT, NODE_ID, SUM(SENSOR_DATA) , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";
        else
            $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";
    } elseif($TIME == "DAY"){
        if($TYPE == "03")
            // $sqlIndex = "SELECT FROM_UNIXTIME((UNIX_TIMESTAMP(TIME) DIV (60*30))*(60*30)) TIME, SUM(SENSOR_DATA) average FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY TIME DIV (60*30)";
            $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*30)) ORDER BY `TIME` ASC";
        else
            $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*30)) ORDER BY `TIME` ASC";
    } elseif($TIME == "WEEK"){
        if($TYPE == "03")
            $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*6)) ORDER BY `TIME` ASC";
        else
            $sqlIndex = "SELECT BATT_PCT, NODE_ID,  AVG(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*12)) ORDER BY `TIME` ASC";
    } elseif($TIME == "MONTH"){
        if($TYPE == "03")
            $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*24)) ORDER BY `TIME` ASC";
        else
            $sqlIndex = "SELECT BATT_PCT, NODE_ID,  AVG(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*24*2)) ORDER BY `TIME` ASC";
    } elseif($TIME == "YEAR"){
        if($TYPE == "03")
            $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*24*7)) ORDER BY `TIME` ASC";
        else
            $sqlIndex = "SELECT BATT_PCT, NODE_ID,  AVG(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*30)) ORDER BY `TIME` ASC";
    } elseif($TIME == "REAL"){
        // if($TYPE == "03")
        //     $sqlIndex = "SELECT BATT_PCT, NODE_ID, SUM(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() ORDER BY `TIME` ASC";
        // else
        $sqlIndex = "SELECT * FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$COORDINATOR}' ORDER BY ID DESC LIMIT 1";
        // SELECT * FROM `EVENTS` WHERE DATA_TYPE='a9' AND COORDINATOR='3083985382B4' ORDER BY ID DESC LIMIT 1;
    }

    $result = mysqli_query($conn, $sqlIndex);

    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> SENSOR_DATA = $row['SENSOR_DATA'];
            $temp -> BATT_PCT = $row['BATT_PCT'];
            $temp -> NODE_ID = $row['NODE_ID'];
            $temp -> TIME = $row['TIME'];
            $RESPONSE -> DATA[]= $temp;                        
        }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
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