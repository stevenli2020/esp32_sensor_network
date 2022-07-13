<?php 
require_once "/var/www/html/common/httpUtils.php";
do {
	if (checkRequest()) {
		$act = $_GET['act'];
		if ($act != null) {
			$content = file_get_contents('php://input');
			$post    = (array)json_decode($content, true);
			// check JSON error
			$json_error = '';
			// switch (json_last_error()){
			// 	case JSON_ERROR_NONE:$json_error='';break;
			// 	case JSON_ERROR_DEPTH:$json_error='Maximum stack depth exceeded';break;
			// 	case JSON_ERROR_STATE_MISMATCH:$json_error='Underflow or the modes mismatch';break;
			// 	case JSON_ERROR_CTRL_CHAR:$json_error='Unexpected control character found';break;
			// 	case JSON_ERROR_SYNTAX:$json_error='Syntax error, malformed JSON';break;
			// 	case JSON_ERROR_UTF8:$json_error='Malformed UTF-8 characters, possibly incorrectly encoded';break;
			// 	default:$json_error='Unknown error';break;
			// }
			// if ($json_error != null) {
			// 	header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));
			// 	$RESPONSE -> CODE = CODE_ERROR;
			// 	$RESPONSE -> MESSAGE = $json_error;
			// 	echo json_encode($RESPONSE);
			// 	// die();
			// 	break;
			// }
            try {@include "collections/".$act.".php";}
            catch(Exception $e){
                header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE = "act";
                echo json_encode($RESPONSE);							
            }
			
		} else {
			header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));
			$RESPONSE -> CODE = CODE_ERROR;
			echo json_encode($RESPONSE);
		} 
	} else {
		$RESPONSE -> CODE = CODE_ERROR;
		$RESPONSE -> MESSAGE = "REQ";
		echo json_encode($RESPONSE);
	}	
} while(0);

// if ((DEBUG_SESSIONS != [])&&(in_array(strtoupper($app_name),DEBUG_APPS))){
// 	$RESPONSE_TIME_MS = intval(microtime(1)*1000);
// 	$REQUEST_TIME_MS = intval($_SERVER['REQUEST_TIME_FLOAT']*1000);
// 	$RESPONSE_PROCESS_TIME = $RESPONSE_TIME_MS - $REQUEST_TIME_MS;
// 	$m = new stdClass();
// 	$m -> REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
// 	$m -> REQUEST_URI = $_SERVER['REQUEST_URI'];
// 	$m -> POST_CONTENT = $content;
// 	$m -> RESPONSE_DATA = $result->data;
// 	$m -> RESPONSE_CODE = $result->httpCode;
// 	$m -> PROCESS_TIME = $RESPONSE_PROCESS_TIME;
// 	$M = json_encode($m);
// 	$key = 'debug1';
// 	$aes = new OpenSSLAES($key, 'AES-128-ECB');
// 	$M_enc = encrypt("debug1",$M);
// 	foreach (DEBUG_SESSIONS as $SESSION_ID) {
// 		shell_exec("mosquitto_pub -h broker.hivemq.com -t /".sha1($SITE)."/".$SESSION_ID." -m '".$M_enc."'");	
// 	}	
// }

// function encrypt($passphrase, $value){
//     $salt = openssl_random_pseudo_bytes(8);
//     $salted = '';
//     $dx = '';
//     while (strlen($salted) < 48) {
//         $dx = md5($dx.$passphrase.$salt, true);
//         $salted .= $dx;
//     }
//     $key = substr($salted, 0, 32);
//     $iv  = substr($salted, 32,16);
//     $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
//     $data = array("ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt));
//     return json_encode($data);
// }




