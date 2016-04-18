<?
include("common/config.shop.php");
include("check.php");
include("fckeditor/fckeditor.php");
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
$number = $_GET["number"];
$query="select * from $code where uid='$number'";
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
        <title>notiWrite</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/memberRead.css" />
        <script type="text/javascript" src="common/jslb_ajax.js"></script>
        <script type="text/javascript" src="common/common2.js"></script>
    </head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>
	<div id="main">
		<h4 id="mainTitle">회원상세정보</h4>
		<dl id="readContent">
		<form name="bForm" action="noticePost.php?code=<?=$code?>" target="action_frame" onsubmit="return checkBForm(this)" method="post" enctype="multipart/form-data">

            <dl id="readContent">
                <dt>제목</dt>
                <dd><input class="inp" type="text" name="subject" /></dd>
                <dt>이름</dt>
                <dd><input class="inp" type="text" name="name" /></dd>
                <dt>내용</dt>
                <dd class="inputDd">
                <?php
                $sBasePath ="fckeditor/";
                $oFCKeditor = new FCKeditor('comment');
                $oFCKeditor->BasePath	= $sBasePath;
                $oFCKeditor->Width='100%';
                $oFCKeditor->Height=600;
                $oFCKeditor->Value=$ou_comment;
                $oFCKeditor->ToolbarSet='BoardSet'; //fckconfig.js P99
                $oFCKeditor->Create();
                ?>
                </dd>
            </dl>
            <div class="buttonBox">
                <input type="image" src="img/upload.gif" alt="등록" />
                <a href="#A"><img src="img/cancel.gif" alt="취소" onclick="location.href='noticeList.php?code=<?=$code?>'" />
            </div>
        </form>
	</div>
	<iframe name="action_frame" width="610"  height="100" style="display:none"></iframe>
	</div>
</div>
</body>
</html>
