<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NODE_NAME = array_key_exists('NODE_NAME',$post )?$post['NODE_NAME']:null;
    $LOC_UID = array_key_exists('LOC_UID',$post )?$post['LOC_UID']:null;
    $FAC_UID = array_key_exists('FAC_UID',$post )?$post['FAC_UID']:null;
    $MAC = array_key_exists('MAC',$post )?$post['MAC']:null;
    $SENSOR_TYPE = array_key_exists('SENSOR_TYPE',$post )?$post['SENSOR_TYPE']:null;
    $THRESHOLD = array_key_exists('THRESHOLD',$post )?$post['THRESHOLD']:null;

    if($NODE_NAME == null){
        $RESPONSE -> MESSAGE[] = "Node Name can't be empty";
    } 
    else {
        if(strpos($NODE_NAME, "'") !== false){
            $RESPONSE -> MESSAGE[] = "Single quote is not allowed in Node Name";
        }
    }
    if($FAC_UID == null){
        $RESPONSE -> MESSAGE[] = "Facility Name must be select from suggestion";
    }  
    if($LOC_UID == null){
        $RESPONSE -> MESSAGE[] = "Location Name must be select from suggestion";
    }  
    if($SENSOR_TYPE == null || $SENSOR_TYPE == 'Sensor Type'){
        $RESPONSE -> MESSAGE[] = "Sensor type must be select from suggestion";
    }

    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    // while(true){
    //     $SENSOR_UID = bin2hex(random_bytes(16));
    //     $sqlIndex = "SELECT * FROM NODES WHERE SENSOR_UID = $SENSOR_UID";
    //     $result = $conn-> query($sqlIndex);
    //     if($result->num_rows > 0){
    //         continue;
    //     } else {
    //         break;
    //     }
    // }
	
    $sqlIndex = '';
    $sqlIndex = "SELECT * FROM FACILITIES WHERE UID='$FAC_UID'";
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $sqlIndex = "SELECT * FROM LOCATIONS WHERE LOCATION_UID='$LOC_UID' AND FACILITY_UID='$FAC_UID'";
        $result = $conn->query($sqlIndex);
        if($result->num_rows > 0){
            $sqlIndex = "SELECT * FROM NODES WHERE MAC='$MAC'";
            $result = $conn->query($sqlIndex);
            // $RESPONSE->SQL1 = $sqlIndex;
            if($result->num_rows > 0){
                // $sqlIndex = "UPDATE NODES SET LOC_UID='$LOC_UID' WHERE MAC='$MAC'";
                while($row = $result->fetch_assoc()) {
                    $NODE_ID = $row['ID'];
                    $sqlIndex = "INSERT INTO RL_LOC_NODES (NODE_ID, LOC_UID, MAC) VALUES ('$NODE_ID', '$LOC_UID', '$MAC')";
                    // $RESPONSE->SQL = $sqlIndex;
                    if($conn->query($sqlIndex) == TRUE){
                        $sqlIndex = "UPDATE NODES SET THRESHOLD='$THRESHOLD' WHERE ID='$NODE_ID'";
                        // $RESPONSE->SQL3 = $sqlIndex;
                        // $result = $conn-> query($sqlIndex);
                        if($conn->query($sqlIndex) == TRUE){
                            $RESPONSE -> DATA -> SUCCESS[] = "New sensor " .$NODE_NAME." added succefully";
                        } else {
                            $RESPONSE -> CODE = CODE_ERROR;
                            $RESPONSE -> MESSAGE[] = "Unable to add threshold value";
                            echo json_encode($RESPONSE);
                            die();
                        }
                    } else {
                        $RESPONSE -> CODE = CODE_ERROR;
                        $RESPONSE -> MESSAGE[] = "Unable to add new sensor";
                        echo json_encode($RESPONSE);
                        die(); 
                    }
                }
                
            } else {
                // $sqlIndex = "INSERT INTO NODES (MAC, NAME, SENSOR_UID, LOC_UID, FAC_UID, SENSOR_TYPE) VALUES ('$MAC', '$NODE_NAME', '$SENSOR_UID', '$LOC_UID', '$FAC_UID', '$SENSOR_TYPE')";
                $sqlIndex = "INSERT INTO NODES (NAME, MAC, SENSOR_TYPE, THRESHOLD) VALUES ('$NODE_NAME', '$MAC', '$SENSOR_TYPE', '$THRESHOLD')";
                // $RESPONSE->SQL = $sqlIndex;
                if($conn->query($sqlIndex) == TRUE){
                    $sqlIndex = "SELECT * FROM NODES WHERE MAC='$MAC'";
                    // $RESPONSE -> SQL = $sqlIndex;
                    $result = $conn-> query($sqlIndex);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            $NODE_ID = $row['ID'];    
                            $sqlIndex = "INSERT INTO RL_LOC_NODES (NODE_ID, LOC_UID, MAC) VALUES ('$NODE_ID', '$LOC_UID', '$MAC')";
                            // $RESPONSE->SQL2 = $sqlIndex;
                            if($conn->query($sqlIndex) == TRUE){
                                $RESPONSE -> DATA -> SUCCESS[] = "New sensor " .$NODE_NAME." added succefully";                                
                            } else {
                                $RESPONSE -> CODE = CODE_ERROR;
                                $RESPONSE -> MESSAGE[] = "Unable to add new sensor";
                                echo json_encode($RESPONSE);
                                die(); 
                            }            
                        }
                    } else {
                        $RESPONSE -> CODE = CODE_ERROR;
                        $RESPONSE -> MESSAGE[] = "Unable to get node data";
                        echo json_encode($RESPONSE);
                        die(); 
                    }
                } else {
                    $RESPONSE -> CODE = CODE_ERROR;
                    $RESPONSE -> MESSAGE[] = "Unable to add new node";
                    echo json_encode($RESPONSE);
                    die(); 
                }
                // if($conn->query($sqlIndex) == TRUE){
                //     $RESPONSE -> DATA -> SUCCESS[] = "New sensor " .$NODE_NAME." added succefully";
                // } else {
                //     $RESPONSE -> CODE = CODE_ERROR;
                //     $RESPONSE -> MESSAGE[] = "Unable to add new sensor";
                //     echo json_encode($RESPONSE);
                //     die(); 
                // }
            }            
            $RESPONSE -> CODE = CODE_SUCCESS;
            echo json_encode($RESPONSE);
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE[] = "Location Name not found";
            echo json_encode($RESPONSE);
            die();
        }
        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Facility Name not found";
        echo json_encode($RESPONSE);
        die();
    }
        
    
    mysqli_close($conn);
    
}
die();