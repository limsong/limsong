<?
include("common/config.shop.php");
$arrgoods_code=explode("|",$_GET["goods_codeGroup"]);
$tabArr = array("goods","goods_option","optionName","optionValue","upload_timages","upload_simages","upload_mimages","upload_bimages");
$tabArrCount = count($tabArr);
$tabImgArr = array("upload_timages","upload_simages","upload_mimages","upload_bimages");
$tabImgArrCount = count($tabImgArr);
for($i=0;$i<count($arrgoods_code);$i++) {
	if($i==0){
		$addQuery="WHERE goods_code='$arrgoods_code[$i]' ";
		/*
		$addQuery_goods_option="WHERE goods_code='$arrgoods_code[$i]' ";
		$addQuery_optionName="WHERE goods_code='$arrgoods_code[$i]' ";
		$addQuery_optionValue="WHERE goods_code='$arrgoods_code[$i]' ";
		$addQuery_upload_timages="WHERE goods_code='$arrgoods_code[$i]' ";
		$addQuery_upload_simages="WHERE goods_code='$arrgoods_code[$i]' ";
		$addQuery_upload_mimages="WHERE goods_code='$arrgoods_code[$i]' ";
		$addQuery_upload_bimages="WHERE goods_code='$arrgoods_code[$i]' ";
		*/
	}else {
		$addQuery.=" OR goods_code='$arrgoods_code[$i]'";
		/*
		$addQuery_goods_option.=" OR goods_code='$arrgoods_code[$i]'";
		$addQuery_optionName.=" OR goods_code='$arrgoods_code[$i]'";
		$addQuery_optionValue.=" OR goods_code='$arrgoods_code[$i]'";
		$addQuery_upload_timages.=" OR goods_code='$arrgoods_code[$i]'";
		$addQuery_upload_simages.=" OR goods_code='$arrgoods_code[$i]'";
		$addQuery_upload_mimages.=" OR goods_code='$arrgoods_code[$i]'";
		$addQuery_upload_bimages.=" OR goods_code='$arrgoods_code[$i]'";
		*/
	}
	//$dest=$brandImagesDir.$arrgoods_code[$i]."*";
	//exec("rm -f $dest");
}
if($addQuery) {
	for($i=0;$i<$tabImgArrCount;$i++){
		$query = "SELECT ImageName FROM $tabImgArr[$i] $addQuery";
		$result = mysql_query($query) or die($query);
		while ($rows=mysql_fetch_assoc($result)) {
			$ImageName=$rows["ImageName"];
			if(move_file_to_trash($ImageName)){
				$query="DELETE FROM $tabImgArr[$i] $addQuery";
				mysql_query($query) or die($query);
			}else{
				echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
				alertExit("파일 업로드 실패 관리자에게 문의해주세요.");
			}
		}
	}
	for($i=0;$i<$tabArrCount;$i++){
		$query="DELETE FROM $tabArr[$i] $addQuery";
		mysql_query($query) or die($query);
	}
	/*
	$query="DELETE FROM goods $addQuery_goods";
	mysql_query($query) or die($query);
	$query="DELETE FROM goods_option $addQuery_goods_option";
	mysql_query($query) or die($query);
	$query="DELETE FROM optionName $addQuery_goods_option";
	mysql_query($query) or die($query);
	$query="DELETE FROM optionValue $addQuery_goods_option";
	mysql_query($query) or die($query);
	$query="DELETE FROM upload_timages $addQuery_goods_option";
	mysql_query($query) or die($query);
	$query="DELETE FROM upload_simages $addQuery_goods_option";
	mysql_query($query) or die($query);
	$query="DELETE FROM upload_mimages $addQuery_goods_option";
	mysql_query($query) or die($query);
	$query="DELETE FROM upload_bimages $addQuery_goods_option";
	mysql_query($query) or die($query);
	*/
}
?>
<script type="text/javascript">
	alert("삭제 되었습니다");
	parent.location.reload();
</script>
