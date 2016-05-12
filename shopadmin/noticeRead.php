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
$ou_code = $_GET["code"];
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
		<form name="noticeForm" method="post" action="noticeChangePost.php?code=<?=$ou_code?>&number=<?=$number?>&page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>" target="action_frame" enctype="multipart/form-data">
			<input type="Hidden" name="mode" />
            <table>
                <tr>
                    <th style="width:150px;">제목</th>
                    <td><input class="inp" type="text" name="subject" value="<?=$ou_subject?>" /></td>
                </tr>
                <?php
                if($code !='q'){
                    ?>
                    <tr>
                        <th>필독</th>
                        <td><input type="checkbox" name="notify" value="y" /></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <th>내용</th>
                    <td>
                        <div style="width:90%;float:left;padding:5px 8px 5px 5px;">
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="comment" type="text/plain"><?=$ou_comment?></script>
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="ueditor/ueditor.config.js"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="ueditor/ueditor.all.js"></script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container');
                            </script>
                        </div>
                    </td>
                </tr>
            </table>
			<div class="buttonBox">
				<a href="#A" onclick="checkBForm('modify')"><img src="img/btn_modify2.gif" alt="수정" width="63" height="25" /></a>
				<a href="#A" onclick="checkBForm('delete')"><img src="img/btn_delete2.gif" alt="삭제"  /></a>
                <?php
                if($ou_code!='q'){
                ?>
				<a href="boardList.php?bbs_code=notice&key=<?=$key?>&keyfield=<?=$keyfield?>"><img src="img/netpop_btnall.gif" alt="목록" /></a>
                <?php
                }else{
                ?>
                    <a href="boardList.php?bbs_code=faq&key=<?=$key?>&keyfield=<?=$keyfield?>"><img src="img/netpop_btnall.gif" alt="목록" /></a>
                <?php
                }
                ?>
			</div>
		</form>
	</div>
</div>
<iframe name="action_frame" width="610"  height="300" style="display:none"></iframe>
</body>
</html>
