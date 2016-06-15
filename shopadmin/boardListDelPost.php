<?
include("common/config.shop.php");
$arrUid=$_POST["check"];
$code=$_POST["tbl"];
for($i=0;$i<count($arrUid);$i++) {
	if($i==0){
		$addQuery=" where uid='$arrUid[$i]' ";
	}	else {
			$addQuery.=" or uid='$arrUid[$i]' ";
	}
}
/*$sql="select userFile1,userFile2 from $code $addQuery";
$result=mysql_query($sql) or die($sql);
$row=mysql_fetch_row($result);
$i=0;
while($i<mysql_num_rows($result)) {
	$userFile1=mysql_result($result,$i,0);
	$userFile2=mysql_result($result,$i,1);
	for($j=1;$j<3;$j++) {
		$dest=$userFileDir.$userFile.$j."*";
		//exec("rm -f $dest");
		unlink($dest);
	}
	$i++;
}*/
$query = "DELETE FROM $code $addQuery";
mysql_query($query) or die($query);
?>
<script type="text/javascript">
	alert("삭제 되었습니다");
	parent.location.reload();
</script>