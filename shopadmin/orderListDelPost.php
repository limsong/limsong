<?
include("common/config.shop.php");

$arrOrderNum=$_POST["check"];
for($i=0;$i<count($arrOrderNum);$i++) {
	if($i==0) {
		$addQuery="where v_oid='$arrOrderNum[$i]'";
	} else {
		$addQuery.="or v_oid='$arrOrderNum[$i]'";
	}
}

if($addQuery) {
	$query="delete from basket $addQuery";
	mysql_query($query) or die($query);
?>
<script type="text/javascript">
alert("삭제 되었습니다.");
parent.location.reload();
</script>
<?
}
include("common/closedb.php");
?>