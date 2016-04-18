<?php
include_once("include/config.php");
$in_uname = $_POST["user_id"];
$in_passwd = $_POST["passwd"];
$in_passwd = crypt($in_passwd);
$in_hname = $_POST["user_name"];//실명
$in_hPost = $_POST["zipcode"];
$in_address1 = $_POST["add1"];
$in_address2 = $_POST["add2"];
$in_email1 = $_POST["mail1"];
$in_email2 = $_POST["mail2"];
$in_email3 = $_POST["mail3"];
if($in_email2!="11"){
    $in_email = $in_email1."@".$in_email2;
}else{
    $in_email = $in_email1."@".$in_email3;
}
$in_phone = $_POST["phone"];
$in_hphone = $_POST["hphone"];
//$in_gender = $_POST["gender"];//sms수신여부
$in_signdate = date("y-m-d H:i:s",time());
$ou_uname = $db->siftDown($in_uname);
$db->query("SELECT count(id) FROM shopMembers WHERE id = '$ou_uname'");
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
		        location.href='/';
		    </script>
	    </head>
	    <body></body>
	</html>
    <?
}else{
    $db->query("INSERT INTO shopMembers (`id`,`name`,`passwd`,`email`,`phone`,`mphone`,`hPost`,`hAddr1`,`hAddr2`,`oPost`,`oAddr1`,`oAddr2`,`signdate`,`milage`)
                VALUES ('$in_uname','$in_hname','$in_passwd','$in_email','$in_phone','$in_hphone','$in_hPost','$in_address1','$in_address2',
                '','','','$in_signdate','1000')");
    $in_milage_time = date("y-m-d H:i:s",time());
    $in_milage = "1000";
    $db->query("INSERT INTO milage_log (`user_id`,`milage_time`,`milage`,`milage_info`) VALUES ('$in_uname','$in_milage_time','$in_milage','신규가입')");
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