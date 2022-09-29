<?php
$RESPONSE = new stdClass();
require_once "/var/www/html/common/httpUtils.php";
include "/var/www/html/dbconfig/sensor_db.php";
if (checkRequest()) {
    $content = file_get_contents('php://input');
    $post = (array)json_decode($content, true);
    $LOGIN_NAME = array_key_exists('LOGIN_NAME',$post )?$post['LOGIN_NAME']:null;
    $PWD = array_key_exists('PWD',$post )?$post['PWD']:null;
    $AUTH = array_key_exists('AUTH',$post )?$post['AUTH']:null;

    if($AUTH != LOGIN_USER){
        $RESPONSE -> MESSAGE[] = "Unauthorised";
    }
    
    if($LOGIN_NAME == null){
        $RESPONSE -> MESSAGE[] = "Username is empty";
    } 
    if($PWD == null){
        $RESPONSE -> MESSAGE[] = "Password is empty";
    }    
    if(count(get_object_vars($RESPONSE)) > 0){
        $RESPONSE -> CODE = CODE_ERROR;
        echo json_encode($RESPONSE);
        die();
    }
    $sqlIndex = "SELECT * FROM USERS WHERE LOGIN_NAME='$LOGIN_NAME'";
    $result = $conn-> query($sqlIndex);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            if(password_verify($PWD, $row['PWD'])){
                $RESPONSE -> CODE = CODE_SUCCESS;
                $UTOKEN = password_hash($row['CODE'], PASSWORD_BCRYPT);
                $RESPONSE -> TOKEN = $UTOKEN;
                $RESPONSE -> UNAME = $row['LOGIN_NAME'];
                $RESPONSE -> TYPE = $row['TYPE'];
                $NAME = $row['LOGIN_NAME'];
                $sqlIndex = "UPDATE USERS SET STATUS='LOGIN' WHERE LOGIN_NAME='$NAME'";
                $result = $conn->query($sqlIndex);
                if($conn->query($sqlIndex) == TRUE){
                    //TODO: sent added password noti to user
                    // $RESPONSE -> CODE = CODE_SUCCESS;
                    // echo json_encode($RESPONSE);
                } else {
                    $RESPONSE -> CODE = CODE_ERROR;
                    $RESPONSE -> MESSAGE[] = "Fail to update status";
                    echo json_encode($RESPONSE);
                    die();
                }
                echo json_encode($RESPONSE);
                die();
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE[] = "Incorrect Username and Password";
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