<?
include("common/config.shop.php");
include("check.php");
$number=$_GET["number"];
$page=$_GET["page"];
$key=$_GET["key"];
$keyfield=$_GET["keyfield"];
$bbs_code = $_POST["bbs_code"];
if($bbs_code == "q"){
    $bbs_code = "faq";
}
if($bbs_code == ""){
    mysql_close($db);
    $url="boardList.php";
    $msg="필수 필드가 누락 되였습니다.";
    goPURL($msg,$url);
    exit;
}

foreach($_POST as $k=>$v) {
	${"in_".$k}=addslashes($v); //addslasher 使用反斜线引用字符串
}
$in_signdate=time();
if($in_mode=="delete") {
	$query="delete from tbl_notice where uid='$number'";
	mysql_query($query) or die($query);
?>	
<script type="text/javascript">
alert("삭제 되었습니다.");
parent.location.href='boardList.php?bbs_code=<?=$bbs_code?>&page=<?$page?>&key=<?$key?>&keyfield=<?$keyfield?>';
</script>
<?
exit;
} else if($in_mode=="modify") {
	$query="update tbl_notice set name='$in_name',subject='$in_subject',comment='$in_comment' where uid='$number'";
	mysql_query($query) or die($query);
	$url="boardList.php?bbs_code=".$bbs_code."&page=".$page."&key=".$key."&keyfield=".$keyfield;
	$msg="수정 되었습니다.";
	goPURL($msg,$url);
	mysql_close($db);
}
?>

