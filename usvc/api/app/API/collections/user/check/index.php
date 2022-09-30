<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
// echo "working";
if (checkRequest()) {
    $content = file_get_contents('php://input');
    $post = (array)json_decode($content, true);
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
    $CODE = array_key_exists('CODE',$post )?$post['CODE']:null;
    $TYPE = array_key_exists('TYPE',$post )?$post['TYPE']:null;

    if($TYPE == null){
        $RESPONSE -> MESSAGE[] = "TYPE is empty";
    }
    
    if($LOGIN_NAME == null){
        $RESPONSE -> MESSAGE[] = "Username is empty";
    } 
    if($CODE == null){
        $RESPONSE -> MESSAGE[] = "CODE is empty";
    }    
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = "SELECT * FROM USERS WHERE LOGIN_NAME='$LOGIN_NAME' AND TYPE='$TYPE'";
    // echo json_encode($sqlIndex);
    $result = $conn-> query($sqlIndex);
    
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            // echo json_encode($row);
            if(password_verify($row['CODE'], $CODE)){
                $RESPONSE -> CODE = CODE_SUCCESS;
                $UTOKEN = password_hash($row['CODE'], PASSWORD_BCRYPT);
                $RESPONSE -> TOKEN = $UTOKEN;
                $RESPONSE -> UNAME = $row['LOGIN_NAME'];
                $RESPONSE -> TYPE = $row['TYPE'];                
                echo json_encode($RESPONSE);
                die();
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE[] = "Token Error";
                echo json_encode($RESPONSE);
                die(); 
            }
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Username Not Found";
        echo json_encode($RESPONSE);
        die(); 
    }
    

    
    
    mysqli_close($conn);
    
}
die();

// <?php
// // See the password_hash() example to see where this came from.
// $hash = '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq';

// if (password_verify('rasmuslerdorf', $hash)) {
//     echo 'Password is valid!';
// } else {
//     echo 'Invalid password.';
// }
// ?>