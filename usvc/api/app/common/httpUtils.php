<?php
header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL & ~E_NOTICE);

const CODE_SUCCESS = 0;
const CODE_ERROR = -1;


function getHeader() {
    $headers = array();
    foreach ($_SERVER as $key => $value) {
//         echo $key . " - " . $value . "\n";
//         error_log($key . " - " . $value);
        if ('HTTP_' == substr($key, 0, 5)) {
            $headers[str_replace('_', '-', substr($key, 5))] = $value;
        }
        
    }
    if (isset($_SERVER['PHP_AUTH_DIGEST'])) {
        $headers['AUTHORIZATION'] = $_SERVER['PHP_AUTH_DIGEST'];
    } elseif (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
        $headers['AUTHORIZATION'] = base64_encode($_SERVER['PHP_AUTH_USER'] . ':' . $_SERVER['PHP_AUTH_PW']);
    }
    
    if (isset($_SERVER['CONTENT_LENGTH'])) {
        $headers['CONTENT-LENGTH'] = $_SERVER['CONTENT_LENGTH'];
    }
    
    if (isset($_SERVER['CONTENT_TYPE'])) {
        $headers['CONTENT-TYPE'] = $_SERVER['CONTENT_TYPE'];
    }
    return $headers;
}

function checkRequest() {
    header('Content-Type: application/json');
    $header = getHeader();
    if ('POST' != $_SERVER['REQUEST_METHOD']){
        header($_SERVER['SERVER_PROTOCOL']. " 405 ". getHttpStatusMessage('405'));//file_put_contents("DEBUG","POST");
        return FALSE;
    }
    if (strncasecmp('application/json', $header['CONTENT-TYPE'], strlen('application/json')) != 0){
        header($_SERVER['SERVER_PROTOCOL']. " 400 ". getHttpStatusMessage('400'));//file_put_contents("DEBUG","JSON");
        return FALSE;
    }
    return TRUE;
}

function getHttpStatusMessage($statusCode){
	$httpStatus = array(100=>'Continue',101=>'Switching Protocols',200=>'OK',201=>'Created',202=>'Accepted',203=>'Non-Authoritative Information',204=>'No Content',205=>'Reset Content',206=>'Partial Content',300=>'Multiple Choices',301=>'Moved Permanently',302=>'Found',303=>'See Other',304=>'Not Modified',305=>'Use Proxy',306=>'(Unused)',307=>'Temporary Redirect',400=>'Bad Request',401=>'Unauthorized',402=>'Payment Required',403=>'Forbidden',404=>'Not Found',405=>'Method Not Allowed',406=>'Not Acceptable',407=>'Proxy Authentication Required',408=>'Request Timeout',409=>'Conflict',410=>'Gone',411=>'Length Required',412=>'Precondition Failed',413=>'Request Entity Too Large',414=>'Request-URI Too Long',415=>'Unsupported Media Type',416=>'Requested Range Not Satisfiable',417=>'Expectation Failed',500=>'Internal Server Error',501=>'Not Implemented',502=>'Bad Gateway',503=>'Service Unavailable',504=>'Gateway Timeout',505=>'HTTP Version Not Supported');
    return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $status[500];
}

?>