<?
include("common/config.shop.php");
$mode=$_GET["mode"];
$goods_code=$_GET["goods_code"];
if($mode=='modify') {
	$sellPrice=$_GET["sellPrice"];
	$query="update goods set sellPrice='$sellPrice' WHERE goods_code='$goods_code'";
	mysql_query($query) or die($query);
	alertPntRldExit("수정 되었습니다.");
} else if($mode=='delete') {
	$dest=$brandImagesDir.$goods_code."*";
	exec("rm -f $dest");
	$query="delete from goods WHERE goods_code='$goods_code'";
	mysql_query($query);
	alertPntRldExit("삭제 되었습니다.");
}
?>
