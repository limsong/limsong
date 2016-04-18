<?
include("common/config.shop.php");
$arrMemId=$_POST["check"];
for($i=0;$i<count($arrMemId);$i++) {
	if(i==0) {
		$addQuery=" where id='$arrMemId[$i] '";
	} else {
			$addQuery=" or id='$arrMemId[$i]'";
	}
}
if($arrMemId) {
	$query="delete from shopMembers $addQuery";
	mysql_query($query) or die($query);
?>
<script type="text/javascript">
	alert("삭제 되었습니다.");
	parent.location.reload();
</script>
<?
}
?>
