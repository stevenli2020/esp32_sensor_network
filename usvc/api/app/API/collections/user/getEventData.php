<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $TIME = array_key_exists('TIME',$post )?$post['TIME']:null;
    $SENSOR_NAME = array_key_exists('SENSOR_NAME',$post )?$post['SENSOR_NAME']:null;
    $SENSOR_ID = array_key_exists('SENSOR_ID',$post )?$post['SENSOR_ID']:null;
    $MAC = '';

    if($TIME == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Time is empty";
    }

    // if($SENSOR_NAME == null){
    //     $RESPONSE -> CODE = CODE_ERROR;
    //     $RESPONSE -> MESSAGE[] = "Sensor name is empty";
    // }

    if($SENSOR_ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Sensor id is empty";
    }

    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM NODES WHERE ID='$SENSOR_ID'";
    // $RESPONSE -> SQL1 = $sqlIndex;
    $result = mysqli_query($conn, $sqlIndex);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $MAC = $row['PARENT'];
            $TYPE = $row['SENSOR_TYPE'];
            if($TIME == "HOUR"){
                if($TYPE == "a9")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";
                elseif($TYPE == "0d")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";
                else
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, SUM(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";                    
            } elseif($TIME == "DAY"){
                if($TYPE == "a9")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";
                elseif($TYPE == "0d")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*30)) ORDER BY `TIME` ASC";
                else
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*30)) ORDER BY `TIME` ASC";                    
            } elseif($TIME == "WEEK"){
                if($TYPE == "a9")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID,  AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";
                elseif($TYPE == "0d")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*6)) ORDER BY `TIME` ASC";
                else
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*6)) ORDER BY `TIME` ASC";                    
            } elseif($TIME == "MONTH"){
                if($TYPE == "a9")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID,  AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*5)) ORDER BY `TIME` ASC";
                elseif($TYPE == "0d")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*24)) ORDER BY `TIME` ASC";
                else
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*24)) ORDER BY `TIME` ASC";                    
            } elseif($TIME == "YEAR"){
                if($TYPE == "a9")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID,  AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*30)) ORDER BY `TIME` ASC";
                elseif($TYPE == "0d")
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID, AVG(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*24*7)) ORDER BY `TIME` ASC";
                else
                    $sqlIndex = "SELECT BATT_PCT, NODE_ID,  SUM(SENSOR_DATA) as SENSOR_DATA, DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 YEAR AND NOW() GROUP BY round(UNIX_TIMESTAMP(TIME) DIV (60*60*24*7)) ORDER BY `TIME` ASC";                    
            } elseif($TIME == "REAL"){
                // if($TYPE == "03")
                //     $sqlIndex = "SELECT BATT_PCT, NODE_ID, SUM(SENSOR_DATA) as SENSOR_DATA , DATE_FORMAT(MIN(TIME), '%Y-%m-%d %H:%i:00') AS TIME FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' AND TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() ORDER BY `TIME` ASC";
                // else
                $sqlIndex = "SELECT * FROM EVENTS WHERE DATA_TYPE = '$TYPE' AND COORDINATOR = '{$MAC}' ORDER BY ID DESC LIMIT 1";
                // SELECT * FROM `EVENTS` WHERE DATA_TYPE='a9' AND COORDINATOR='3083985382B4' ORDER BY ID DESC LIMIT 1;
            }
        
            $result = mysqli_query($conn, $sqlIndex);
            // $RESPONSE -> SQL2 = $sqlIndex;
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
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Sensor id is not found";
        echo json_encode($RESPONSE);
        die();
    }
    mysqli_close($conn);
}

die()
?>