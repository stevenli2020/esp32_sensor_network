<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $TIME = array_key_exists('TIME',$post )?$post['TIME']:null;
    $LOCATION_NAME = array_key_exists('LOCATION_NAME',$post )?$post['LOCATION_NAME']:null;
    $TYPE = array_key_exists('SENSOR_TYPE',$post )?$post['SENSOR_TYPE']:null;
    $LOCATION_ID = array_key_exists('LOCATION_ID',$post )?$post['LOCATION_ID']:null;
    if($TIME == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Time is empty";
    }

    // if($SENSOR_NAME == null){
    //     $RESPONSE -> CODE = CODE_ERROR;
    //     $RESPONSE -> MESSAGE[] = "Sensor name is empty";
    // }

    if($LOCATION_ID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Location id is empty";
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
    // SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate FROM Orders INNER JOIN Customers ON Orders.CustomerID=Customers.CustomerID;
    // $sqlIndex = "SELECT NODES.LOC_UID, NODES.PARENT, SUM(EVENTS.SENSOR_DATA), EVENTS.DATA_TYPE, EVENTS.COORDINATOR, EVENTS.TIME FROM NODES INNER JOIN EVENTS ON NODES.PARENT=EVENTS.COORDINATOR AND NODES.LOC_UID='14eb4503e21db3f0703ee52178b40c6e' WHERE EVENTS.DATA_TYPE='03' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*5)) ORDER BY EVENTS.TIME ASC;";
    // for($x=0; $x<3; $x++){
    //     if($x==0){
    //         $TYPE = "a9";
    //     } elseif($x==1){
    //         $TYPE = "03";
    //     } else {
    //         $TYPE = "d3";
    //     }
    if($TIME == "HOUR"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*5)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 HOUR AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*5)) ORDER BY EVENTS.TIME ASC;";
    } else if($TIME == "DAY"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*30)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*30)) ORDER BY EVENTS.TIME ASC;";
    } else if($TIME == "WEEK"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*6)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*6)) ORDER BY EVENTS.TIME ASC;";
    } else if($TIME == "MONTH"){
        if($TYPE == "a9" || $TYPE == "0d")
            $sqlIndex = "SELECT AVG(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*24)) ORDER BY EVENTS.TIME ASC;";
        else 
            $sqlIndex = "SELECT SUM(EVENTS.SENSOR_DATA), EVENTS.TIME FROM RL_LOC_NODES RIGHT JOIN EVENTS ON RL_LOC_NODES.MAC=EVENTS.NODE_ID AND RL_LOC_NODES.LOC_UID='$LOCATION_ID' WHERE LOC_UID='$LOCATION_ID' AND EVENTS.DATA_TYPE='$TYPE' AND EVENTS.TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW() GROUP BY round(UNIX_TIMESTAMP(EVENTS.TIME) DIV (60*60*24)) ORDER BY EVENTS.TIME ASC;";
    }
    $result = mysqli_query($conn, $sqlIndex);
    $RESPONSE->SQL = $sqlIndex;
    if ($result->num_rows > 0) {
        // $temp = new stdClass();
        while($row = $result->fetch_assoc()) {
            // if($x == 0){
            //     $temp -> AIR[] = $row;
            // } elseif($x == 1) {
            //     $temp -> MOTION[] = $row;
            // } else {
            //     $temp -> DISTANCE[] = $row;
            // } 
            $RESPONSE -> DATA[] = $row;       
        }
        $RESPONSE -> CODE = CODE_SUCCESS;
        echo json_encode($RESPONSE);
        // $RESPONSE -> DATA[] = $temp;             
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