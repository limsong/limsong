<?
include("common/config.shop.php");
foreach($_POST as $k=>$v) {
	${"tr_".$k}=addslashes($v);
}
$in_uxCode=$tr_uxCode;
$in_umCode=$tr_umCode;
$in_sortCode=$tr_sortCode;
$in_sortType=$tr_sortType;
$in_liId=$tr_liId;
if($in_sortType=='X' || $in_sortType=='O') {
	$in_dType="0";
	$dest=$sortImagesDir."sortImagex".$in_sortCode."0000.*";
} else if($in_sortType=='M' || $in_sortType=='G') {
	$in_dType="1";
	$dest=$sortImagesDir."sortImagem".$in_uxCode.$in_sortCode."00.*";
} else if($in_sortType=='S') {
	$in_dType="2";
	$dest=$sortImagesDir."sortImages".$in_uxCode.$in_umCode.$in_sortCode.".*";
}
exec("rm -f $dest");	//-----------------------이미지삭세-----------------------------
$query="update sortCodes set sortImage=null where uxCode='$in_uxCode' and umCode='$in_umCode' and sortCode='$in_sortCode'";
mysql_query($query) or die($query);
header("Content-type: text/plain; charset=utf-8");
?>
{
	dType:"<?=$in_dType?>",
	liId:"<?=$in_liId?>"
}
