<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $TIME = array_key_exists('TIME',$post )?$post['TIME']:null;
    $TYPE = array_key_exists('SENSOR_TYPE',$post )?$post['SENSOR_TYPE']:null;
    $LOCATION_ID = array_key_exists('LOCATION_ID',$post )?$post['LOCATION_ID']:null;
    if($TIME == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Time is empty";
    }


    if($LOCATION_ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Location ID is empty";
    }
    if($TYPE == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Sensor type is empty";
    }

    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = '';
    if($TIME == "HOUR"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*5)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*5)) ORDER BY EVENTS.TIME ASC;";
    } else if($TIME == "DAY"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*30)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*30)) ORDER BY EVENTS.TIME ASC;";
    } else if($TIME == "WEEK"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*6)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*6)) ORDER BY EVENTS.TIME ASC;";
    } else if($TIME == "MONTH"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*24)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM LOCATIONS RIGHT JOIN RL_LOC_NODES ON LOCATIONS.LOCATION_UID=RL_LOC_NODES.LOC_UID RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID WHERE LOCATIONS.LOCATION_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*24)) ORDER BY EVENTS.TIME ASC;";
    }
    $result = mysqli_query($conn, $sqlIndex);
    // $RESPONSE->SQL = $sqlIndex;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $RESPONSE -> DATA[] = $row;       
        }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);           
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Fail to get data of this location";
        echo json_encode($RESPONSE);
        die();
    }
    // }

    
    
    // $RESPONSE -> SQL1 = $sqlIndex;
    mysqli_close($conn);
}

die();
?>