<?php
/**
 * Created by PhpStorm.
 * User: ONE
 * Date: 2016. 5. 27.
 * Time: 오후 12:44
 */
include_once("include/config.php");
include_once("include/sqlcon.php");
date_default_timezone_set('Asia/Seoul');
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$mod = $_POST["mod"];
if($mod == "find_id"){
    $mail_subject = "아이디 ";
    $db->query("SELECT id FROM shopmembers WHERE name='$user_name' and email='$user_email'");
    $db_shopmembers_query = $db->loadRows();
    $id = $db_shopmembers_query[0]["id"];
    echo "<p>찾으시는 아이디 : <b>".$id ."</b> 입니다.</p>";
    exit;
}elseif($mod=="find_pw"){
    $mail_subject = "비밀번호";
}
require_once('libs/INIStdPayUtil.php');
$SignatureUtil = new INIStdPayUtil();
//$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성
$timestamp = date("Y-m-d H:i:s",time());
$expirationdate = date("Y-m-d H:i:s", strtotime("$offer_date + 3 day"));;
$params = array(
    "email" => $user_email,
    "timestamp" => $timestamp
);
$sign = $SignatureUtil->makeSignature($params, "sha256");
$str = 'http://sozo.bestvpn.net/resetPasswd.php?sign='.$sign;
$url = '<a href="http://sozo.bestvpn.net/resetPasswd.php?sign='.$sign.'">'.$str.'</a>';
//64개
//573c7560947d022fbafb9d430dc1d133ffa68468d2317246b8518b633dea8c6d
//메일 보내기
include_once("PHPMailer/PHPMailerAutoload.php");
//Create a new PHPMailer instance
$mail = new PHPMailer(true);
$mail->SMTPSecure = 'ssl';

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.naver.com';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;//465 : ssl port      587 : tls port

//Set the encryption system to use - ssl (deprecated) or tls

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "wdarray";//smtp 인증 아이디

//Password to use for SMTP authentication
$mail->Password = "#mymacpro#";//smtp 인증 비밀번호

//Set who the message is to be sent from
$mail->setFrom('wdarray@naver.com', '뉴엔에스');//보낸사람 이름 smtp 인증아이디하고 같은 메일주소를 꼭 써야함

//Set an alternative reply-to address
$mail->addReplyTo('nohseong@naver.com', '뉴엔에스');//답장 클릭시 이름하고 메일주소

//Set who the message is to be sent to
$mail->addAddress($user_email, $user_name);//nohseong2받는사람 이름 받는사람 메일주소

//Set the subject line
$mail->Subject = $mail_subject;//메일제목

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($url, dirname(__FILE__));//메일내용

//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
$mail->CharSet="UTF-8";
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    /*`auth_email_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '이메일 인증 요청페이지 구분 (1:회원가입, 2:비밀번호찾기)',
    `auth_email_address` varchar(100) NOT NULL DEFAULT '' COMMENT '이메일 인증 주소',
    `auth_email_token` varchar(100) NOT NULL DEFAULT '' COMMENT '이메일 인증 토큰 (이메일+시간)',
    `auth_email_request_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '이메일 인증 요청일시',
    `auth_email_expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '이메일 인증 만료일시',
    `auth_email_complete` int(11) NOT NULL DEFAULT '0' COMMENT '이메일 인증 완료 여부',*/
    $db->query("INSERT INTO user_auth_email (auth_email_type,auth_email_address,auth_email_token,auth_email_request_date,auth_email_expire_date) 
                            VALUES ('2','$user_email','$sign','$timestamp','$expirationdate')");
    echo "ok";
}
?>