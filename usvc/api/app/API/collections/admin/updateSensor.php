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
    $ID = array_key_exists('ID',$post )?$post['ID']:null;  
    $THRESHOLD = array_key_exists('THRESHOLD',$post )?$post['THRESHOLD']:null;

    if($LOC_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Location name must be select from suggestion";
    }
    if($FAC_UID == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Facility name must be select from suggestion";
    }
    if($NODE_NAME == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Node name is Empty";
    }
    if($SENSOR_TYPE == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Sensor type must be select one of the value";
    }
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = '';
    $set_String = '';
    $update_Node = '';
    $sqlIndex = "SELECT * FROM NODES WHERE ID='$ID'";
    // $RESPONSE->SQL1 = $sqlIndex;
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result -> fetch_assoc();
        $oriName = $row['NAME'];
        $ID = $row['ID'];
        $oriMAC = $row['MAC'];
        $oriSEN = $row['SENSOR_TYPE'];
        // update node table
		if($NODE_NAME != $oriName){
            // $set_String = "NODE_NAME='$NODE_NAME', ";
            $update_Node = "NAME='$NODE_NAME', ";
        }
        if($oriMAC != $MAC){
            $set_String = $set_String."MAC='$MAC', ";
            $update_Node = $update_Node."MAC='$MAC', ";
        }
        // if($FAC_UID != null){
        //     $set_String = $set_String."FAC_UID='$FAC_UID',";
        // }
        // if($THRESHOLD != null){
        //     $set_String = $set_String."THRESHOLD='$THRESHOLD', ";            
        // }
        if($LOC_UID != null){
            $set_String = $set_String."LOC_UID='$LOC_UID', ";            
        } 
        // if($FAC_UID != null){
        //     $set_String = $set_String."FAC_UID='$FAC_UID', ";
        // }
        if($SENSOR_TYPE != $oriSEN){
            // $set_String = $set_String."SENSOR_TYPE='$SENSOR_TYPE', ";
            $update_Node = $update_Node."SENSOR_TYPE='$SENSOR_TYPE', ";
        }
        if($THRESHOLD != null){
            $update_Node = $update_Node."THRESHOLD='$THRESHOLD', ";
        }
        
        $set_String = $set_String ." NODE_ID = '$ID'";
        $update_Node = $update_Node." ID = '$ID'";
        $sqlIndex = "UPDATE NODES SET ".$update_Node." WHERE ID='$ID'";
        // $RESPONSE->SQL = $sqlIndex;
        $result = $conn->query($sqlIndex);
        if($conn->query($sqlIndex) == TRUE){
            $sqlIndex = "UPDATE RL_LOC_NODES SET ".$set_String." WHERE NODE_ID='$ID'";
            // $RESPONSE->SQL2 = $sqlIndex;
            $result = $conn->query($sqlIndex);
            if($conn->query($sqlIndex) == TRUE){
                // $sqlIndex = "UPDATE NODES SET THRESHOLD='$THRESHOLD' WHERE ID='$ID'";
                // if($conn->query($sqlIndex) == TRUE){
                //     $RESPONSE -> CODE = CODE_SUCCESS;
                //     echo json_encode($RESPONSE);
                // } else {
                //     $RESPONSE -> CODE = CODE_ERROR;
                //     $RESPONSE -> MESSAGE[] = "Unable to update threshold value";
                //     echo json_encode($RESPONSE);
                //     die();
                // }      
                $RESPONSE -> CODE = CODE_SUCCESS;
                echo json_encode($RESPONSE);          
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "Fail to update Relationship tables";
                echo json_encode($RESPONSE);
                die();
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "Fail to update Node";
            echo json_encode($RESPONSE);
            die();
        }
        
        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'LOCATION NOT FOUND';
        echo json_encode($RESPONSE);
        die();
    }
  
    
    mysqli_close($conn);
    
}
die();