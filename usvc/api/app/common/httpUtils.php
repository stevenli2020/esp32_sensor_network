<?php

header('Access-Control-Allow-Origin: *');
error_reporting(E_ALL & ~E_NOTICE);

const CODE_SUCCESS = 0;
const CODE_ERROR = -1;

// user authentication
const ADD_USER = 0;
const ADD_PASSWORD = 1;
const LOGIN_USER = 2;
const UPDATE_USER = 3;
const UPDATE_PASSWORD = 4;
// const REG_USER = 'REGISTER';
const OPTION = 'digiflow';
const USER = 0;
const ADMIN = 1;
const IP = "167.99.77.130";


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

function checkImage($url){
    // echo $url;
    $headers = get_headers($url, 1);
    if (strpos($headers['Content-Type'], 'image/') !== false) {
        return true;
    } else {
        return false;
    }
}

function mailContent($link, $name, $passType){
    $preheader = '';
    $desc = '';
    $butt = '';
    $descB = '';
    if($passType == ADD_PASSWORD){
        $preheader = "Your account have been added successfully.";
        $desc = "Your account have been added successfully. Please click below button to add password.";
        $butt = "Add Password";
        $descB = "Do not share this email to other people.";
    } elseif($passType == UPDATE_PASSWORD){
        $preheader = "Update your password.";
        $desc = "You are requested to update your password. Please click below button to update password.";
        $butt = "Update Password";
        $descB = "If you are not requested. Please ignore this email and log in using current password. Please do not share this email to other people.";
    }
    return '<!doctype html>
    <html>
      <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Simple Transactional Email</title>
        <style>
          /* -------------------------------------
              GLOBAL RESETS
          ------------------------------------- */
          
          /*All the styling goes here*/
          
          img {
            border: none;
            -ms-interpolation-mode: bicubic;
            max-width: 100%; 
          }
    
          body {
            background-color: #f6f6f6;
            font-family: sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%; 
          }
    
          table {
            border-collapse: separate;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
            width: 100%; }
            table td {
              font-family: sans-serif;
              font-size: 14px;
              vertical-align: top; 
          }
    
          /* -------------------------------------
              BODY & CONTAINER
          ------------------------------------- */
    
          .body {
            background-color: #f6f6f6;
            width: 100%; 
          }
    
          /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
          .container {
            display: block;
            margin: 0 auto !important;
            /* makes it centered */
            max-width: 580px;
            padding: 10px;
            width: 580px; 
          }
    
          /* This should also be a block element, so that it will fill 100% of the .container */
          .content {
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            max-width: 580px;
            padding: 10px; 
          }
    
          /* -------------------------------------
              HEADER, FOOTER, MAIN
          ------------------------------------- */
          .main {
            background: #ffffff;
            border-radius: 3px;
            width: 100%; 
          }
    
          .wrapper {
            box-sizing: border-box;
            padding: 20px; 
          }
    
          .content-block {
            padding-bottom: 10px;
            padding-top: 10px;
          }
    
          .footer {
            clear: both;
            margin-top: 10px;
            text-align: center;
            width: 100%; 
          }
            .footer td,
            .footer p,
            .footer span,
            .footer a {
              color: #999999;
              font-size: 12px;
              text-align: center; 
          }
    
          /* -------------------------------------
              TYPOGRAPHY
          ------------------------------------- */
          h1,
          h2,
          h3,
          h4 {
            color: #000000;
            font-family: sans-serif;
            font-weight: 400;
            line-height: 1.4;
            margin: 0;
            margin-bottom: 30px; 
          }
    
          h1 {
            font-size: 35px;
            font-weight: 300;
            text-align: center;
            text-transform: capitalize; 
          }
    
          p,
          ul,
          ol {
            font-family: sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 0;
            margin-bottom: 15px; 
          }
            p li,
            ul li,
            ol li {
              list-style-position: inside;
              margin-left: 5px; 
          }
    
          a {
            color: #3498db;
            text-decoration: underline; 
          }
    
          /* -------------------------------------
              BUTTONS
          ------------------------------------- */
          .btn {
            box-sizing: border-box;
            width: 100%; }
            .btn > tbody > tr > td {
              padding-bottom: 15px; }
            .btn table {
              width: auto; 
          }
            .btn table td {
              background-color: #ffffff;
              border-radius: 5px;
              text-align: center; 
          }
            .btn a {
              background-color: #ffffff;
              border: solid 1px #3498db;
              border-radius: 5px;
              box-sizing: border-box;
              color: #3498db;
              cursor: pointer;
              display: inline-block;
              font-size: 14px;
              font-weight: bold;
              margin: 0;
              padding: 12px 25px;
              text-decoration: none;
              text-transform: capitalize; 
          }
    
          .btn-primary table td {
            background-color: #3498db; 
          }
    
          .btn-primary a {
            background-color: #3498db;
            border-color: #3498db;
            color: #ffffff; 
          }
    
          /* -------------------------------------
              OTHER STYLES THAT MIGHT BE USEFUL
          ------------------------------------- */
          .last {
            margin-bottom: 0; 
          }
    
          .first {
            margin-top: 0; 
          }
    
          .align-center {
            text-align: center; 
          }
    
          .align-right {
            text-align: right; 
          }
    
          .align-left {
            text-align: left; 
          }
    
          .clear {
            clear: both; 
          }
    
          .mt0 {
            margin-top: 0; 
          }
    
          .mb0 {
            margin-bottom: 0; 
          }
    
          .preheader {
            color: transparent;
            display: none;
            height: 0;
            max-height: 0;
            max-width: 0;
            opacity: 0;
            overflow: hidden;
            mso-hide: all;
            visibility: hidden;
            width: 0; 
          }
    
          .powered-by a {
            text-decoration: none; 
          }
    
          hr {
            border: 0;
            border-bottom: 1px solid #f6f6f6;
            margin: 20px 0; 
          }
    
          /* -------------------------------------
              RESPONSIVE AND MOBILE FRIENDLY STYLES
          ------------------------------------- */
          @media only screen and (max-width: 620px) {
            table.body h1 {
              font-size: 28px !important;
              margin-bottom: 10px !important; 
            }
            table.body p,
            table.body ul,
            table.body ol,
            table.body td,
            table.body span,
            table.body a {
              font-size: 16px !important; 
            }
            table.body .wrapper,
            table.body .article {
              padding: 10px !important; 
            }
            table.body .content {
              padding: 0 !important; 
            }
            table.body .container {
              padding: 0 !important;
              width: 100% !important; 
            }
            table.body .main {
              border-left-width: 0 !important;
              border-radius: 0 !important;
              border-right-width: 0 !important; 
            }
            table.body .btn table {
              width: 100% !important; 
            }
            table.body .btn a {
              width: 100% !important; 
            }
            table.body .img-responsive {
              height: auto !important;
              max-width: 100% !important;
              width: auto !important; 
            }
          }
    
          /* -------------------------------------
              PRESERVE THESE STYLES IN THE HEAD
          ------------------------------------- */
          @media all {
            .ExternalClass {
              width: 100%; 
            }
            .ExternalClass,
            .ExternalClass p,
            .ExternalClass span,
            .ExternalClass font,
            .ExternalClass td,
            .ExternalClass div {
              line-height: 100%; 
            }
            .apple-link a {
              color: inherit !important;
              font-family: inherit !important;
              font-size: inherit !important;
              font-weight: inherit !important;
              line-height: inherit !important;
              text-decoration: none !important; 
            }
            #MessageViewBody a {
              color: inherit;
              text-decoration: none;
              font-size: inherit;
              font-family: inherit;
              font-weight: inherit;
              line-height: inherit;
            }
            .btn-primary table td:hover {
              background-color: #34495e !important; 
            }
            .btn-primary a:hover {
              background-color: #34495e !important;
              border-color: #34495e !important; 
            } 
          }
    
        </style>
      </head>
      <body>
        <!-- <span class="preheader">'.$preheader.'</span> -->
        <span class="preheader">Your account have been added successfully.</span>
        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
          <tr>
            <td>&nbsp;</td>
            <td class="container">
              <div class="content">
    
                <!-- START CENTERED WHITE CONTAINER -->
                <table role="presentation" class="main">
    
                  <!-- START MAIN CONTENT AREA -->
                  <tr>
                    <td class="wrapper">
                      <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>
                            <p>Hi '.$name.',</p>
                            <p>'.$desc.'</p>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
                              <tbody>
                                <tr>
                                  <td align="left">
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                      <tbody>
                                        <tr>
                                          <td> <a href="'.$link.'" target="_blank">'.$butt.'</a> </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <p>'.$descB.'</p>
                            <!-- <p>Good luck! Hope it works.</p> -->
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
    
                <!-- END MAIN CONTENT AREA -->
                </table>
                <!-- END CENTERED WHITE CONTAINER -->
    
                <!-- START FOOTER -->
                <div class="footer">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td class="content-block">
                        <span class="apple-link">Digiflow, 16 Boon Lay Way, #01-55, Singapore</span>
                        <!-- <span class="apple-link">Company Inc, 3 Abbey Road, San Francisco CA 94102</span> -->
                        <!-- <br> Do not like these emails? <a href="http://i.imgur.com/CScmqnj.gif">Unsubscribe</a>. -->
                      </td>
                    </tr>
                    <!-- <tr>
                      <td class="content-block powered-by">
                        Powered by <a href="http://htmlemail.io">HTMLemail</a>.
                      </td>
                    </tr> -->
                  </table>
                </div>
                <!-- END FOOTER -->
    
              </div>
            </td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </body>
    </html>';
}

function checkUser($LOGIN_NAME, $CODE, $TYPE){
    include "/var/www/html/dbconfig/sensor_db.php";
    $RESPONSE = new stdClass();
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
                return $RESPONSE;
                // die();
            } else {
                $RESPONSE -> CODE = CODE_ERROR;
                $RESPONSE -> MESSAGE[] = "Token Error";
                return $RESPONSE;
                // die(); 
            }
        }
    } else {
        $RESPONSE -> CODE = CODE_ERROR;
        $RESPONSE -> MESSAGE[] = "Username Not Found";
        return $RESPONSE;
        // die(); 
    }   
    mysqli_close($conn);
}

function CallAPI($method, $url, $data = false, $header = array('Content-Type: application/json')){
    $curl = curl_init();
    switch ($method){
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if ($header){
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    }
    $result = new stdClass();
    // $result -> inputData = $data;
    // $result -> inputUrl = $url;
    $result -> data = curl_exec($curl);
    $result -> httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    return $result;
}   

function genABEHash(){
    $data = random_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

?>