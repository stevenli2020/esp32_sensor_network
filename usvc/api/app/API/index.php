<?php 
require_once "/var/www/html/common/httpUtils.php";
$RESPONSE = new stdClass();
do {
	if (checkRequest()) {
		$act = $_GET['act'];
		if ($act != null) {
			$content = file_get_contents('php://input');
			$post    = (array)json_decode($content, true);
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
			// echo json_encode($RESPONSE);
			if(count(get_object_vars($RESPONSE)) > 0){
				if (in_array($act, ["login", "addPassword"])){
					try {@include "collections/".$act.".php";}
					catch(Exception $e){
						header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));
						$RESPONSE -> CODE = CODE_ERROR;
						$RESPONSE -> MESSAGE = "act";
						echo json_encode($RESPONSE);							
					} 
				} else {
					$RESPONSE -> CODE = CODE_ERROR;
					// $RESPONSE -> MESSAGE[] = "Not Authorized";
					echo json_encode($RESPONSE);
					die();
				}
			} else {
				$result = checkUser($LOGIN_NAME, $CODE, $TYPE);
				// echo json_encode($result);
				if($result -> CODE == CODE_SUCCESS){
					if($result -> TYPE == USER){
						try {@include "collections/user/".$act.".php";}
						catch(Exception $e){
							header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));
							$RESPONSE -> CODE = CODE_ERROR;
							$RESPONSE -> MESSAGE = "act";
							echo json_encode($RESPONSE);							
						}
					} else if($result -> TYPE == ADMIN){
						try {@include "collections/user/".$act.".php";@include "collections/admin/".$act.".php";}
						catch(Exception $e){
							header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));
							$RESPONSE -> CODE = CODE_ERROR;
							$RESPONSE -> MESSAGE = "act";
							echo json_encode($RESPONSE);							
						}
					}
					
				} else {
					header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));
					$RESPONSE -> CODE = CODE_ERROR;
					$RESPONSE -> MESSAGE = $result -> MESSAGE;
					echo json_encode($RESPONSE);
				}
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




