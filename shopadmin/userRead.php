<?
include("common/config.shop.php");
include("check.php");
$code="shopMembers";
$page=$_GET["page"];
$key=$_GET['key'];
$keyfield=$_GET['keyfield'];
$id = $_GET["id"];
$query="select * from $code where id='$id'";
$result=mysql_query($query) or die($query);
$row=mysql_fetch_assoc($result);
foreach($row as $k=>$v) {
	${"ou_".$k}=$v;
}
//$ou_signdate=date("Y-m-d",$row["signdate"]);		//글작성한 시간
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>주문관리</title>
        <link rel="stylesheet" type="text/css" href="css/common.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/boardList.css" />
        <script type="text/javascript" src="common/jslb_ajax.js"></script>
        <script type="text/javascript" src="common/common.js"></script>
    </head>
    <body>
        <div id="total">
            <?
            include("include/include.header.php");
            ?>
            <div id="main">
                <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                    <tr class="menuTr">
                        <td width="20%">사용자정보</td>
                        <td></td>
                    </tr>
                    <tr class="contentTr">
                        <td width="20%">이름 :</td>
                        <td><?=$ou_name?></td>
                    </tr>
                    <tr class="contentTr">
                        <td width="20%">비밀번호 :</td>
                        <td>
                            <?=$ou_passwd?>
                        </td>
                    </tr>
                    <tr class="contentTr">
                        <td width="20%">email :</td>
                        <td>
                            <?=$ou_email?>
                        </td>
                    </tr>

                    <tr class="contentTr">
                        <td width="20%">가입날짜 :</td>
                        <td><?=$ou_signdate?></td>
                    </tr>
                    <tr class="contentTr">
                        <td width="20%">전화번호 :</td>
                        <td><?=$ou_phone?></td>
                    </tr>
                    <tr class="contentTr">
                        <td width="20%">상세 주소 :</td>
                        <td><?=$ou_hAddr1?></td>
                    </tr>
                </table>
                <div id="btnBox"><input type="Button" value="목록" class="memEleB" onclick="location.href='userList.php?page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>'" /></div>
            </div>
            <iframe name="action_frame" width="500" height="500" style="display:none"></iframe>
        </div>
    <?
    include("common/closedb.php");
    ?>
    </body>
</html>