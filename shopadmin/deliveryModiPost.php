<?
include("common/config.shop.php");
$v_oid=$_GET["v_oid"];
$pDate=time("YmdHis");
if($delivery=="Y") {
	$query="update basket set delivery='$delivery',pDate='$pDate',payMethod='Y' where v_oid='$v_oid'";
} else {
	$query="update basket set delivery='$delivery' where v_oid='$v_oid'";
}
mysql_query($query) or die($query);
alertPntRldExit("수정되었습니다");
include("common/closedb.php");
exit;
?>