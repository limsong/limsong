<?php
include_once("session.php");
$UserName = @$_SESSION['UserName'];
$Password = @$_SESSION['Password'];
if ( $UserName == "" || $UserName != "master" || $Password == "" )
{
	echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
	echo "<script languate='javascript'>alert('접근권한이없습니다.');top.window.location.href='/shopadmin/index.php';</script>";
	session_unset();
	exit;
}
?>