<?
include("common/config.shop.php");
$arrgoods_code=$_POST["check"];
$code=$_GET["code"];
for($i=0;$i<count($arrgoods_code);$i++) {
	if($i==0){
		$addQuery="where uid='$arrgoods_code[$i]' ";
	}else {
		$addQuery.=" or uid='$arrgoods_code[$i]' ";
	}
}
if($addQuery) {
$query="delete from $code $addQuery";
mysql_query($query) or die($query);
?>
<script type="text/javascript">
	alert("삭제 되었습니다");
	parent.location.reload();
</script>
<?
}
?>
