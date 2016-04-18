<?
include("common/config.shop.php");
include("../../fckeditor/fckeditor.php");
 $code=$_GET['code'];
$page=$_GET['page'];
if(!$_POST['key']) {
	$key=$_GET['key'];
} else {
	$key=$_POST['key'];
}
if(!$_POST['keyfield']) {
	$keyfield=$_GET['keyfield'];
} else {
	$keyfield=$_POST['keyfield'];
}
$query="select * from $code where uid='$number'";
$result=mysql_query($query) or die($query);
$row=mysql_fetch_assoc($result);
$ou_name=stripslashes($row['name']);
$ou_subject=stripslashes($row['subject']);
$ou_signdate=date("Y-m-d:i:s",$row['signdate']);
$ou_ipInfo=$row['inInfo'];
$ou_notify=$row["notify"];
$ou_userFile1Name=$row['userFile1Name'];
$ou_userFile2Name=$row['userFile2Name'];
$ou_comment=stripslashes($row['comment']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>boardRead</title>
<link rel="stylesheet" type="text/css" href="css/common1.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/memberRead.css" />
<script type="text/javascript" src="common/jslb_ajax.js"></script>
<script type="text/javascript" src="common/common2.js"></script>
</head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>
	<div id="left">
		<h3 id="leftTitle">Manager List</h3>
		<ul id="leftMenu">
			<li>테스터</li>
		</ul>
		<p>&nbsp;</p>
	</div>
	<div id="main">
		<form name="mForm" method="post" action="boardModiPost.php?code=<?=$code?>&page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>&number=<?=$number?>"
				target="action_frame" onsubmit="return checkBForm(this)" enctype="multipart/form-data">
			<dl id="readContent">
				<dt>제목</dt>
				<dd><input class="inp" type="text" name="subject" value="<?=$ou_subject?>" /></dd>
				<dt>이름</dt>
				<dd><input class="inp" type="text" name="name" value="<?=$ou_name?>" /></dd>
				<dt>파일1</dt>
				<dd><input class="inp" type="File" name="userFile1"  /><?=$ou_userFile1Name?></dd>
				<dt>파일2</dt>
				<dd><input class="inp" type="File" name="userFile2" /><?=$ou_userFile2Name?></dd>
				<dt>공지사항</dt>
				<dd><input type="checkbox" name="notify" value="Y" <?if($ou_notify=='Y'){echo "checked='checked'";}?> />(공지글일 경우 체크합니다.)</dd>
				<dt>내용</dt>
				<dd class="inputDd">
					<?php
					$sBasePath ="../../fckeditor/";
					
					$oFCKeditor = new FCKeditor('comment');
					$oFCKeditor->BasePath	= $sBasePath;
					$oFCKeditor->Width='100%';
					$oFCKeditor->Height=300;
					$oFCKeditor->Value=$ou_comment;
					$oFCKeditor->ToolbarSet='BoardSet'; 					//fckconfig.js P99
					$oFCKeditor->Create();
					?>
				</dd>
			</dl>
			<div class="buttonBox">
				<input type="submit" value="확인" class="memEleB" />
				<input type="button" value="목록" class="memEleB" onclick="location.href='boardList.php?code=<?=$code?>&page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>'" />
			</div>
		</form>
	</div>
	<iframe name="action_frame" width="610"  height="100" style="display:none"></iframe>
</div>
</body>
</html>
