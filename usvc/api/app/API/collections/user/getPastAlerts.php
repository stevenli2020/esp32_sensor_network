<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $ID = array_key_exists('NODE_ID',$post )?$post['NODE_ID']:null;
    $sqlIndex = query("DAY", $ID); 
    $result = mysqli_query($conn, $sqlIndex);
    // $RESPONSE->SQL1 = $sqlIndex;
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Day_Alerts = $row['total'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO ALERTS FOR PAST DAY';
        // echo json_encode($RESPONSE);
        // die();
    }
    $sqlIndex = query('WEEK', $ID);  
    $result = mysqli_query($conn, $sqlIndex);
    // $RESPONSE->SQL2 = $sqlIndex;
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Week_Alerts = $row['total'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO ALERTS FOR PAST WEEK';
        // echo json_encode($RESPONSE);
        // die();
    }            
    $sqlIndex = query("MONTH", $ID);
    $result = mysqli_query($conn, $sqlIndex);
    // $RESPONSE->SQL3 = $sqlIndex;
    if ($result->num_rows > 0) {      
        while($row = $result->fetch_assoc()) {
            $temp = new stdClass();
            $temp -> Past_Month_Alerts = $row['total'];
            $RESPONSE -> DATA[]= $temp;                
        }        
    } else {
        // $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NO ALERTS FOR PAST MONTH';
        // echo json_encode($RESPONSE);
        // die();
    }
     

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);
    
    mysqli_close($conn);
    
}

function query($time, $id){
    $sql = '';
    if($time == "DAY")
        $sql = "SELECT COUNT(NOTIFICATIONS.ID) as total FROM NOTIFICATIONS LEFT JOIN NODES ON NOTIFICATIONS.MAC=NODES.MAC WHERE NODES.ID='$id' AND TIME BETWEEN NOW() - INTERVAL 1 DAY AND NOW()";
    elseif($time == "WEEK")
        $sql = "SELECT COUNT(NOTIFICATIONS.ID) as total FROM NOTIFICATIONS LEFT JOIN NODES ON NOTIFICATIONS.MAC=NODES.MAC WHERE NODES.ID='$id' AND TIME BETWEEN NOW() - INTERVAL 1 WEEK AND NOW()";
    elseif($time == "MONTH")
        $sql = "SELECT COUNT(NOTIFICATIONS.ID) as total FROM NOTIFICATIONS LEFT JOIN NODES ON NOTIFICATIONS.MAC=NODES.MAC WHERE NODES.ID='$id' AND TIME BETWEEN NOW() - INTERVAL 1 MONTH AND NOW()";    
    return $sql;    
}

die();