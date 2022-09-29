<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $NAME = array_key_exists('NAME',$post )?$post['NAME']:null;
    $UID = array_key_exists('UID',$post )?$post['UID']:null;
    $ADDR = array_key_exists('ADDR',$post )?$post['ADDR']:null;
    $LATITUDE = array_key_exists('LATITUDE',$post )?$post['LATITUDE']:null;
    $LONGITUDE = array_key_exists('LONGITUDE',$post )?$post['LONGITUDE']:null;
    $IMG_NAME = array_key_exists('IMG_NAME',$post )?$post['IMG_NAME']:null;
    $IMG_DATA = array_key_exists('IMG_DATA',$post )?$post['IMG_DATA']:null;
    $IMG_LINK = array_key_exists('IMG_LINK',$post )?$post['IMG_LINK']:null;

    if($NAME == null){
        $RESPONSE -> MESSAGE[] = "Facility Name can't be empty";
    } else {
        if(strpos($NAME, "'") !== false){
            $RESPONSE -> MESSAGE[] = "Single quote is not allowed in Name";
        }
    }
    if($ADDR == null){
        $RESPONSE -> MESSAGE[] = "Address can't be empty";
    }
    if($LATITUDE == null){
        $RESPONSE -> MESSAGE[] = "Latitude can't be empty";
    }

    if($LONGITUDE == null){
        $RESPONSE -> MESSAGE[] = "Longitude can't be empty";
    }
    

    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }

    // if($IMG_LINK != null){
    //     // $RESPONSE -> checkImage = checkImage($IMG_LINK);
    //     if(checkImage($IMG_LINK)){
    //         // $RESPONSE -> URL = $IMG_LINK;
    //         // echo "working";
    //         return;
    //     } else {
    //         $IMG_LINK = 'https://picsum.photos/200';
    //         $RESPONSE -> MESSAGE[] = "Image link is not working";
    //     }

    // }
    while(true){
        $UID = bin2hex(random_bytes(16));
        $sqlIndex = "SELECT * FROM FACILITIES WHERE UID = $UID";
        $result = $conn-> query($sqlIndex);
        if($result->num_rows > 0){
            continue;
        } else {
            break;
        }
    }
    if($IMG_LINK == null)
        $IMG_LINK = 'https://picsum.photos/200';

	$rows = [];
    $sqlIndex = '';
    $sqlIndex = "INSERT INTO FACILITIES (NAME, UID, ADDR, LATITUDE, LONGITUDE, IMG_NAME, IMG_DATA, IMG_LINK) VALUES ('$NAME', '$UID', '$ADDR', '$LATITUDE', '$LONGITUDE', '$IMG_NAME', '$IMG_DATA', '$IMG_LINK')";
    if($conn->query($sqlIndex) == TRUE){
        $RESPONSE -> DATA -> SUCCESS[] = "Facility of " .$NAME." added succefully";
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "NAME must be unique";
        echo json_encode($RESPONSE);
        die(); 
    }
    $RESPONSE -> CODE = CODE_SUCCESS;
    echo json_encode($RESPONSE);
    // $COORDINATOR = '';
    // if($VALUE != null){
    //     $sqlIndex = "SELECT * FROM NODES WHERE NAME LIKE '%$VALUE%'";
    //     $result = mysqli_query($conn, $sqlIndex);
    //     if ($result->num_rows > 0) {      
    //         while($row = $result->fetch_assoc()) {
    //             $RESPONSE -> DATA[]= $row;                
    //         }
    //         $RESPONSE -> CODE = CODE_SUCCESS;
    //         echo json_encode($RESPONSE);
    //     } else {
    //         $RESPONSE -> CODE = CODE_ERROR;
    //         $RESPONSE -> MESSAGE = "NO DATA";
    //         echo json_encode($RESPONSE);
    //     }
    // }   

    
    
    mysqli_close($conn);
    
}
die();