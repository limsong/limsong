<?
include("common/config.shop.php");
include("fckeditor/fckeditor.php");
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
$number = $_GET["number"];
$query="select * from tbl_notice where uid='$number'";
$result=mysql_query($query) or die($query);
$row=mysql_fetch_assoc($result);
$ou_name=stripslashes($row['name']);
$ou_subject=stripslashes($row['subject']);
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
<script type="text/javascript" src="common/common2.js"></script>
</head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>
	<div id="main">
		<form name="noticeForm" method="post" action="noticeChangePost.php?code=<?=$code?>&number=<?=$number?>&page=<?=$page?>&key=<?=$key?>
		&keyfield=<?=$keyfield?>" target="action_frame" enctype="multipart/form-data">
			<input type="Hidden" name="mode" />
			<dl id="readContent">
				<dt>제목</dt>
				<dd><input class="inp" type="text" name="subject" value="<?=$ou_subject?>" /></dd>
				<dt>필독</dt>
				<dd><input type="checkbox" name="notify" value="y" /></dd>
				<dt>내용</dt>
				<dd class="inputDd">
                <?php
                $sBasePath ="fckeditor/";
                $oFCKeditor = new FCKeditor('comment');
                $oFCKeditor->BasePath	= $sBasePath;
                $oFCKeditor->Width='100%';
                $oFCKeditor->Height=600;
                $oFCKeditor->Value=$ou_comment;
                $oFCKeditor->ToolbarSet='BoardSet'; 					//fckconfig.js P99
                $oFCKeditor->Create();
                ?>
				</dd>
			</dl>
			<div class="buttonBox">
				<a href="#A" onclick="checkBForm('modify')"><img src="img/btn_modify2.gif" alt="수정" width="63" height="25" /></a>
				<a href="#A" onclick="checkBForm('delete')"><img src="img/btn_delete2.gif" alt="삭제"  /></a>
				<a href="boardList.php?bbs_code=notice&key=<?=$key?>&keyfield=<?=$keyfield?>"><img src="img/netpop_btnall.gif" alt="목록" /></a>
			</div>
		</form>
	</div>
</div>
<iframe name="action_frame" width="610"  height="300" style="display:none"></iframe>
</body>
</html>
