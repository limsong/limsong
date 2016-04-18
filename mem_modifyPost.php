<?php
include_once("session.php");
include_once("include/check.php");
include_once("include/config.php");
include_once("include/sqlcon.php"); //unicode support
$in_passwd = $_POST["passwd"];
if($in_passwd!=""){
	$in_passwd = crypt($in_passwd);
}
$in_hname = $_POST["user_name"];//실명
$in_hPost = $_POST["zipcode"];
$in_address1 = $_POST["add1"];
$in_address2 = $_POST["add2"];

$in_phone = $_POST["phone"];
$in_hphone = $_POST["hphone"];
//$in_signdate = date("y-m-d H:i:s",time());
if($in_passwd!=""){
	$db->query("UPDATE shopMembers set `passwd`='$in_passwd',`phone`='$in_phone',`mphone`='$in_hphone',`hPost`='$in_hPost',`hAddr1`='$in_address1',`hAddr2`='$in_address2' WHERE id='$uname'");
}else{
	$db->query("UPDATE shopMembers set `phone`='$in_phone',`mphone`='$in_hphone',`hPost`='$in_hPost',`hAddr1`='$in_address1',`hAddr2`='$in_address2' WHERE id='$uname'");
}

$db->disconnect();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<script type="text/javascript">
			alert("회원정보 수정 되였습니다.");
			location.href='mem_modify.php';
		</script>
	</head>
	<body></body>
</html>