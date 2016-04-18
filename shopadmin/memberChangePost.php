<?
include("common/config.shop.php");
$page=$_GET["page"];
$key=$_GET["key"];
$keyfield=$_GET["kefield"];
foreach($_POST as $k=>$v) {
	${"in_".$k}=addslashes($v);
}
if($in_mode=="delete") {
	$query="delete from shopMembers where id='$in_memId'";
	mysql_query($query) or die($query); 
?>
<script type="text/javascript">
	alert("삭제되었습니다.");
	parent.location.href='memberList.php?page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>';
</script>
<?
exit;
} else if($in_mode=="modify") {
	if($in_memPasswd) {
		$addQuery=" ,passwd='$in_memPasswd'";
	}else {
		$addQuery="";
	}
	if($in_memPhone1) {
		$in_memPhone=$in_memPhone1."-".$in_memPhone2."-".$in_memPhone3;
	}else {
		$in_memPhone="";
	}
	if($in_memMphone1) {
		$in_memMphone=$in_memMphone1."-".$in_memMphone2."-".$in_memMphone3;
	}else {
		$in_memMphone="";
	}
	if($in_memHpost1) {
		$in_memHpost=$in_memHpost1."-".$in_memHpost2;
	}else {
		$in_memHpost="";
	}
	if($in_memOpost1) {
		$in_memOpost=$in_memOpost1."-".$in_memOpost2;
	}else {
		$in_memOpost="";
	}
	if($in_memRegNum1) {
		$in_memRegNum=$in_memRegNum1."-".$in_memRegNum2;
	}else {
		$in_memRegNum="";
	}
	$query="update shopMembers set name='$in_memName',email='$in_memEmail',regNum='$in_memRegNum',phone='$in_memPhone',mphone='$in_memMphone',hPost='$in_memHpost',oPost='$in_memOpost',hAddr1='$in_memHaddr1',hAddr2='$in_memHaddr2',oAddr1='$in_memOaddr1',oAddr2='$in_memOaddr2',yesSMS='$in_memYesSMS',yesEmail='$in_memYesEmail',milage='$in_memMilage' $addQuery where id='$in_memId'";
	mysql_query($query) or die($query);
?>
<script type="text/javascript">
	alert("수정되었습니다.");
	parent.location.reload();
</script>
<?
}
?>
