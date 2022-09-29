<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('NAME',$post )?$post['NAME']:null;
    $MAC = array_key_exists('MAC',$post )?$post['MAC']:null;
    $CLUSTER_ID = array_key_exists('CLUSTER_ID',$post )?$post['CLUSTER_ID']:null;
    $SENSOR_TYPE = array_key_exists('SENSOR_TYPE',$post )?$post['SENSOR_TYPE']:null;
    $ADDR = array_key_exists('ADDR',$post )?$post['ADDR']:null;
    $LATITUDE = array_key_exists('LATITUDE',$post )?$post['LATITUDE']:null;
    $LONGITUDE = array_key_exists('LONGITUDE',$post )?$post['LONGITUDE']:null;
    $DESCRPTIONS = array_key_exists('DESCRPTIONS',$post )?$post['DESCRPTIONS']:null;   

    if($DESCRPTIONS == null){
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = "Please add description!";
        echo json_encode($RESPONSE);
        die();
    }
    
    $sqlIndex = '';
    $set_String = '';
    $sqlIndex = "SELECT * FROM NODES WHERE MAC='$MAC'";
    // $RESPONSE->SQL1 = $sqlIndex;
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result -> fetch_assoc();
        $oriName = $row['NAME'];
        // update node table
		if($NAME != null){
            $set_String = "NAME='$NAME',";
        }
        if($CLUSTER_ID != null){
            $set_String = $set_String."CLUSTER_ID='$CLUSTER_ID',";
        }
        if($SENSOR_TYPE != null){
            $set_String = $set_String."SENSOR_TYPE='$SENSOR_TYPE' ";
        } else 
            $set_String = $set_String ." MAC = '$MAC' ";
        $sqlIndex = "UPDATE NODES SET ".$set_String." WHERE MAC='$MAC'";
        // $RESPONSE->SQL2 = $sqlIndex;
        $result = $conn->query($sqlIndex);

        // update locations table
        $sqlIndex = "SELECT * FROM LOCATIONS WHERE NAME='$oriName'";
        // $RESPONSE->SQL3 = $sqlIndex;
        $result = $conn->query($sqlIndex);
        if($result->num_rows > 0){
            $row = $result -> fetch_assoc();
            $ID = $row['ID'];
            if($NAME != null){
                $set_String = "NAME='$NAME',";
            }else{
                $set_String = "";
            }
            if($ADDR != null){
                $set_String = $set_String."ADDR='$ADDR',";
            }
            if($LATITUDE != null){
                $set_String = $set_String."LATITUDE='$LATITUDE',";
            }
            if($LONGITUDE != null){
                $set_String = $set_String."LONGITUDE='$LONGITUDE',";
            }
            if($DESCRPTIONS != null){
                $set_String = $set_String."DESCRPTIONS='$DESCRPTIONS' ";
            }

            $sqlIndex = "UPDATE LOCATIONS SET ".$set_String." WHERE ID='$ID'";
            // $RESPONSE->SQL4 = $sqlIndex;
            $result = $conn->query($sqlIndex);
            if($conn->query($sqlIndex) == TRUE){
                //TODO: sent added password noti to user
                $RESPONSE -> CODE = CODE_SUCCESS;
                echo json_encode($RESPONSE);
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "Fail to update location";
                echo json_encode($RESPONSE);
                die();
            }
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "Couldn't update location, please try again later";
            echo json_encode($RESPONSE);
            die();
        }
        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'NODE NOT FOUND';
        echo json_encode($RESPONSE);
        die();
    }

    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();