<?
include("common/config.shop.php");
include_once ("session.php");
$in_comment=addslashes($_POST["comment"]);
$in_subject=addslashes($_POST["subject"]);
$in_notify = $_POST["notify"];
$in_ref=0;  //방문자수
$in_signdate=date("Y-m-d H:i:s",time());
$query="insert into tbl_notice (name,subject,comment,notify,signdate)
				 values ('$uname','$in_subject','$in_comment','$in_notify','$in_signdate')";
mysql_query($query) or die($query);
$queryString=makeQueryString();
$goUrl="boardList.php?bbs_code=notice".$queryString;
goPURL("입력되었습니다.",$goUrl);
?>
