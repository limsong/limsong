<?
include("common/config.shop.php");
include("check.php");
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
$code=$_GET['code'];
if($code == "faq"){
    $title = "FAQ";
}else{
    $title = "공지글";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>notiWrite</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/memberRead.css" />
        <script type="text/javascript">
            function checkBForm() {
                var fromObj=eval("document.bForm");
                if(!fromObj.subject.value.trim()) {
                    alert("제목을 입력해 주세요");
                    fromObj.subject.value="";
                    fromObj.subject.focus();
                    return false;
                }
                fromObj.submit();
            }
        </script>
    </head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>
	<div id="main">
		<h4 id="mainTitle"><?=$title?></h4>
		<form name="bForm" action="noticePost.php?code=<?=$code?>" target="action_frame" onsubmit="return checkBForm(this)" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th style="width:150px;">제목</th>
                    <td><input class="inp" type="text" name="subject" /></td>
                </tr>
                <?php
                if($code !='faq'){
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
                            <script id="container" name="comment" type="text/plain"></script>
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
                <input type="submit" class="memEleB" value="등록"/>
                <input type="button" class="memEleB" value="취소" onclick="location.href='boardList.php?bbs_code=notice'" />
            </div>
        </form>
	</div>
	<iframe name="action_frame" width="610"  height="100" style="display:none"></iframe>
	</div>
</div>
</body>
</html>
