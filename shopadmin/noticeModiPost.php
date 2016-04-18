<?
include("common/config.shop.php");
$code=$_GET["code"];
$number=$_GET["number"];
$in_name=addslashes($_GET["name"]); //addslashes()  = ' = 이 있으면 \'으로 박워준다.
$in_comment=addslashes($_GET["comment"]);
$in_subject=addslashes($_GET["subject"]);
$query="update $code set  name='$in_name',subject='$in_subject',comment='$in_comment' where uid='$number'";
mysql_query($query) or die($query);
$queryString=makeQueryString();
$goUrl="noticeList.php".$queryString;
goPURL("수정 되었습니다.",$goUrl);
?>
