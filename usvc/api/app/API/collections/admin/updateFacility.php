<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('NAME',$post )?$post['NAME']:null;
    $UID = array_key_exists('UID',$post )?$post['UID']:null;
    $UPDATENAME = array_key_exists('UPDATENAME',$post )?$post['UPDATENAME']:null;
    $ADDR = array_key_exists('ADDR',$post )?$post['ADDR']:null;
    $LATITUDE = array_key_exists('LATITUDE',$post )?$post['LATITUDE']:null;
    $LONGITUDE = array_key_exists('LONGITUDE',$post )?$post['LONGITUDE']:null;    
    $IMG_NAME = array_key_exists('IMG_NAME',$post )?$post['IMG_NAME']:null;
    $IMG_DATA = array_key_exists('IMG_DATA',$post )?$post['IMG_DATA']:null;
    $IMG_LINK = array_key_exists('IMG_LINK',$post )?$post['IMG_LINK']:null;  

    // if($DESCRPTIONS == null){
    //     $RESPONSE -> CODE = CODE_ERROR;
    //     $RESPONSE -> MESSAGE = "Please add description!";
    //     echo json_encode($RESPONSE);
    //     die();
    // }
    
    $sqlIndex = '';
    $set_String = '';
    $sqlIndex = "SELECT * FROM FACILITIES WHERE UID='$UID'";
    // $RESPONSE->SQL1 = $sqlIndex;
    $result = $conn->query($sqlIndex);
    if($result->num_rows > 0){
        $row = $result -> fetch_assoc();
        $oriName = $row['NAME'];
        $ID = $row['ID'];
        // update node table
		if($UPDATENAME != null){
            $set_String = "NAME='$UPDATENAME',";
        }
        if($ADDR != null){
            $set_String = $set_String."ADDR='$ADDR',";
        }
        if($LATITUDE != null){
            $set_String = $set_String."LATITUDE='$LATITUDE', ";
        } 
        // else 
        //     $set_String = $set_String ." MAC = '$MAC' ";
        if($LONGITUDE != null){
            $set_String = $set_String."LONGITUDE='$LONGITUDE', ";
        }
        if($IMG_NAME != null){
            $set_String = $set_String."IMG_NAME='$IMG_NAME', ";
        }
        if($IMG_DATA != null){
            $set_String = $set_String."IMG_DATA='$IMG_DATA', ";
        }
        if($IMG_LINK != null){
            $set_String = $set_String."IMG_LINK='$IMG_LINK', ";
            // if(checkImage($IMG_LINK)){
            //     $set_String = $set_String."IMG_LINK='$IMG_LINK', ";
            // } else {
            //     $set_String = $set_String."IMG_LINK='https://picsum.photos/200', ";
            //     $RESPONSE -> MESSAGE = "Image link is not working";
            // }    
            
        } else if($row['IMG_LINK'] == null)
            $set_String = $set_String ." IMG_LINK = 'https://picsum.photos/200', ";
        
        $set_String = $set_String ." UID = '$UID'";

        $sqlIndex = "UPDATE FACILITIES SET ".$set_String." WHERE NAME='$NAME'";
        $RESPONSE->SQL = $sqlIndex;
        $result = $conn->query($sqlIndex);
        if($conn->query($sqlIndex) == TRUE){
            $RESPONSE -> CODE = CODE_SUCCESS;
            echo json_encode($RESPONSE);
            // die();
        } else {
            $RESPONSE -> CODE = CODE_ERROR;
            $RESPONSE -> MESSAGE = "Fail to update facility";
            echo json_encode($RESPONSE);
            die();
        }
        // update locations table
        // $sqlIndex = "SELECT * FROM LOCATIONS WHERE NAME='$oriName'";
        // $RESPONSE->SQL3 = $sqlIndex;
        // $result = $conn->query($sqlIndex);
        // if($result->num_rows > 0){
        //     $row = $result -> fetch_assoc();
        //     $ID = $row['ID'];
        //     if($NAME != null){
        //         $set_String = "NAME='$NAME',";
        //     }else{
        //         $set_String = "";
        //     }
        //     if($ADDR != null){
        //         $set_String = $set_String."ADDR='$ADDR',";
        //     }
        //     if($LATITUDE != null){
        //         $set_String = $set_String."LATITUDE='$LATITUDE',";
        //     }
        //     if($LONGITUDE != null){
        //         $set_String = $set_String."LONGITUDE='$LONGITUDE',";
        //     }
        //     if($DESCRPTIONS != null){
        //         $set_String = $set_String."DESCRPTIONS='$DESCRPTIONS' ";
        //     }

        //     $sqlIndex = "UPDATE LOCATIONS SET ".$set_String." WHERE ID='$ID'";
        //     // $RESPONSE->SQL4 = $sqlIndex;
        //     $result = $conn->query($sqlIndex);
        //     if($conn->query($sqlIndex) == TRUE){
        //         //TODO: sent added password noti to user
        //         $RESPONSE -> CODE = CODE_SUCCESS;
        //         echo json_encode($RESPONSE);
        //     } else {
        //         $RESPONSE -> CODE = CODE_ERROR;
        //         $RESPONSE -> MESSAGE = "Fail to update location";
        //         echo json_encode($RESPONSE);
        //         die();
        //     }
        // } else {
        //     $RESPONSE -> CODE = CODE_ERROR;
        //     $RESPONSE -> MESSAGE = "Couldn't update location, please try again later";
        //     echo json_encode($RESPONSE);
        //     die();
        // }
        
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE = 'FACILITIES NOT FOUND';
        echo json_encode($RESPONSE);
        die();
    }

    // $RESPONSE -> CODE = CODE_SUCCESS;
    // echo json_encode($RESPONSE);    
    
    mysqli_close($conn);
    
}
die();