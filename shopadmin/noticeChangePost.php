<?
include("common/config.shop.php");
include("check.php");
$code=$_GET["code"];
$number=$_GET["number"];
$page=$_GET["page"];
$key=$_GET["key"];
$keyfield=$_GET["keyfield"];

foreach($_POST as $k=>$v) {
	${"in_".$k}=addslashes($v); //addslasher 使用反斜线引用字符串
}
$in_signdate=time();
if($in_mode=="delete") {
	$query="delete from $code where uid='$number'";
	mysql_query($query) or die($query);
?>	
<script type="text/javascript">
alert("삭제 되었습니다.");
parent.location.href='noticeList.php?code=<?=$code?>&page=<?$page?>&key=<?$key?>&keyfield=<?$keyfield?>';
</script>
<?
exit;
} else if($in_mode=="modify") {
	$query="update $code set name='$in_name',subject='$in_subject',comment='$in_comment' where uid='$number'";
	mysql_query($query) or die($query);
	$url="noticeList.php?code=".$code."&page=".$page."&key=".$key."&keyfield=".$keyfield;
	$msg="수정 되었습니다.";
	goPURL($msg,$url);
	mysql_close($db);
exit;
}
?>