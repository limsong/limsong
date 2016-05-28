<?php
include_once ("session.php");
include_once("include/config.php");
if ($uname != "") {
    echo '<script languate="javascript">top.window.location.href="index.php";</script>';
    exit;
}
$check_id = $_POST["check_id"];
if($check_id != "o"){
    echo '
    <!DOCTYPE html>
	<html lang="en">
	    <head>
	        <meta charset="utf-8">
		    <script type="text/javascript">
		        alert("아이디 중복 확인을 해주세요.");
		        location.href="join_step2.php";
		    </script>
	    </head>
	    <body></body>
	</html>
    ';
    exit;
}
include_once ("include/sqlcon.php");
$in_uname = $_POST["user_id"];
$in_passwd = $_POST["passwd"];
$in_passwd = crypt($in_passwd);
$in_hname = $_POST["user_name"];//실명
$in_hPost = $_POST["zipcode"];
$in_address1 = $_POST["add1"];
$in_address2 = $_POST["add2"];
$in_address3 = $_POST["add3"];
$in_email1 = $_POST["mail1"];
$in_email2 = $_POST["mail2"];
$in_email3 = $_POST["mail3"];
if($in_email2!="11"){
    $in_email = $in_email1."@".$in_email2;
}else{
    $in_email = $in_email1."@".$in_email3;
}
$in_phone1 = $_POST["phone1"];
$in_phone2 = $_POST["phone2"];
$in_phone3 = $_POST["phone3"];

$in_phone = $in_phone1."-".$in_phone2."-".$in_phone3;

$in_hphone1 = $_POST["hphone1"];
$in_hphone2 = $_POST["hphone2"];
$in_hphone3 = $_POST["hphone3"];

$in_hphone = $in_hphone1."-".$in_hphone2."-".$in_hphone3;
//$in_gender = $_POST["gender"];//sms수신여부

$db->query("SELECT count(id) FROM shopMembers WHERE id = '$in_uname'");
if($db->countRows()==1)
    $dbdata = $db->loadRows();
//TODO: To Process $dbdata
$ou_id = $dbdata[0]['count(id)'];
if($ou_id > 0){
    $db->disconnect();
    ?>
    <!DOCTYPE html>
	<html lang="en">
	    <head>
	        <meta charset="utf-8">
		    <script type="text/javascript">
		        alert("사용중인 아이디 입니다.");
		        location.href='join_step2.php';
		    </script>
	    </head>
	    <body></body>
	</html>
    <?
}else{
    $in_time = date("y-m-d H:i:s",time());
    $db->query("INSERT INTO shopMembers (`id`,`name`,`passwd`,`email`,`phone`,`mphone`,`hPost`,`hAddr1`,`hAddr2`,`hAddr3`,`yesSMS`,`yesEmail`,`signdate`,`milage`)
                VALUES ('$in_uname','$in_hname','$in_passwd','$in_email','$in_phone','$in_hphone','$in_hPost','$in_address1','$in_address2','$in_address3','n','n','$in_time','1000')");
    $in_milage = "1000";
    $db->query("INSERT INTO milage_log (`user_id`,`milage_time`,`milage`,`milage_info`) VALUES ('$in_uname','$in_time','$in_milage','신규가입')");
    $db->disconnect();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
	    <script type="text/javascript">
	        alert("회원가입해주셔서 감사합니다.");
	        location.href='/';
	    </script>
    </head>
    <body></body>
</html>
<?
}
?>