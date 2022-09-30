<?php
require("phpmailer/PHPMailer.php");
require("phpmailer/Exception.php");
require("phpmailer/SMTP.php");
function sendMail($To, $Subject, $content){
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); // enable SMTP

    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    // $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465; // or 587
    $mail->IsHTML(true);
    $mail->Username = "www.digiflow.com.sg@gmail.com";
    // $mail->Password = "digiflow2022";
    $mail->Password = "btvbgvlcpqjlnozj";
    $mail->SetFrom("www.digiflow.com.sg@gmail.com", "Digiflow Admin");
	$mail->addReplyTo("www.digiflow.com.sg@gmail.com", "Digiflow Admin");
    $mail->Subject = $Subject;
    // $content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class</b>.";
    // $mail->Body = "hello";
	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body
	// $mail->msgHTML(file_get_contents('contents.html'), __DIR__);	
	$mail->msgHTML($content);	
    $mail->AddAddress($To);

     if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
     } else {
        // echo "OK";
     }
}
// if($_SERVER["REQUEST_METHOD"] == "POST"){
// 	 if(isset($_POST["api_key"])){
// 		if (strpos(file_get_contents("api_keys"), sha1("apikey".$_POST["api_key"])) === false) {
// 			die("API key error");
// 		}
// 	 } else {
// 		 die("API key not present");
// 	 }
// 	 if(isset($_POST["target"])){
// 		$TO = $_POST['target'];
// 	 } else {
// 		 die("Email target not present");
// 	 }	
// 	 if(isset($_POST["subject"])){
// 		$SUBJECT = $_POST['subject'];
// 	 } else {
// 		 die("Email subject not present");
// 	 }
//     if(isset($_FILES["file"]) && $_FILES["file"]["error"] == 0){
// 		move_uploaded_file($_FILES["file"]["tmp_name"], "contents.html");
//     } else{
//         die("Error: " . $_FILES["file"]["error"]);
//     }	 

//     $mail = new PHPMailer\PHPMailer\PHPMailer();
//     $mail->IsSMTP(); // enable SMTP

//     $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
//     $mail->SMTPAuth = true; // authentication enabled
//     $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
//     $mail->Host = "smtp.gmail.com";
//     $mail->Port = 465; // or 587
//     $mail->IsHTML(true);
//     $mail->Username = "www.digiflow.com.sg@gmail.com";
//     $mail->Password = "digiflow2022";
//     $mail->SetFrom("www.sbox.sg@gmail.com", "sBox Admin");
// 	$mail->addReplyTo("www.sbox.sg@gmail.com", "sBox Admin");
//     $mail->Subject = $SUBJECT;
//     // $mail->Body = "hello";
// 	//Read an HTML message body from an external file, convert referenced images to embedded,
// 	//convert HTML into a basic plain-text alternative body
// 	$mail->msgHTML(file_get_contents('contents.html'), __DIR__);	
//     $mail->AddAddress($TO);

//      if(!$mail->Send()) {
//         echo "Mailer Error: " . $mail->ErrorInfo;
//      } else {
//         echo "OK";
//      }
	 
// } else {
// 	echo "NAK";
// }

?>