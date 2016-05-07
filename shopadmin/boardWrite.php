<?
include("common/config.shop.php");
include("fckeditor/fckeditor.php");
$code = $_GET['code'];
$page = $_GET['page'];
if (!$_POST['key']) {
        $key = $_GET['key'];
} else {
        $key = $_POST['key'];
}
if (!$_POST['keyfield']) {
        $keyfield = $_GET['keyfield'];
} else {
        $keyfield = $_POST['keyfield'];
}
$query = "select * from $code where uid='$number'";
$result = mysql_query($query) or die($query);
$row = mysql_fetch_assoc($result);
$ou_name = stripslashes($row['name']);
$ou_subject = stripslashes($row['subject']);
$ou_passwd = $row['passwd'];
$ou_signdate = date("Y-m-d:i:s", $row['signdate']);
$ou_ipInfo = $row['inInfo'];
$ou_userFile1Name = $row['userFile1Name'];
$ou_userFile2Name = $row['userFile2Name'];
$ou_comment = stripslashes($row['comment']);
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
                        <div id="main">
                                <h4 id="mainTitle">faq</h4>
                                <dl id="readContent">
                                        <form name="bForm" action="boardPost.php?code=<?= $code ?>" target="action_frame" onsubmit="return checkBForm(this)" method="post" enctype="multipart/form-data">
                                                <table cellpadding="5" border="0" cellspacing="1" width="99%" height="20">
                                                        <colgroup>
                                                                <col align="center" bgcolor="#f4f4f4" width="20%">
                                                                <col width="80%" bgcolor="#ffffff">
                                                        </colgroup>
                                                        <tr>
                                                                <td>제목</td>
                                                                <td>
                                                                        <input type="Text" size="56" name="subject" class="inp" />
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td>내용</td>
                                                                <td>
                                                                        <textarea name="comment" style="width:100%;height: 200px;border:1px solid #ccc;padding:5px;"></textarea>
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan="2" id="bg" height="26">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                                <td colspan="2" bgcolor="#ffffff" align="center">
                                                                        <input type="submit" class="memEleB" value="등록" />
                                                                        <input type="button" class="memEleB" value="취소" onclick="location.href='boardList.php?bbs_code=faq'" />
                                                                </td>
                                                        </tr>
                                                </table>
                                        </form>
                        </div>
                        <iframe name="action_frame" width="610" height="100" style="display:none;"></iframe>
                </div>
                </div>
        </body>
</html>
