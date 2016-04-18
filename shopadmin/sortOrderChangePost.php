<?
include("common/config.shop.php");
foreach($_POST as $k=>$v) {
	${"tr_".$k}=$v;
}
if($tr_moveType=='up') {
	$query="select sortCode,sortOrder from sortCodes where uxCode='$tr_uxCode' and umCode='$tr_umCode'
									and sortOrder<'$tr_sortOrder' order by sortOrder desc limit 0,1";
} else if($tr_moveType=='down') {
	$query="select sortCode,sortOrder from sortCodes where uxCode='$tr_uxCode' and umCode='$tr_umCode'
									and sortOrder>'$tr_sortOrder' order by sortOrder asc limit 0,1";
}
$result=mysql_query($query) or die($query);
$rows=mysql_num_rows($result);
if($rows<1) {
	echo "no";
	exit;
}
$ou_sortCode=mysql_result($result,0,0);
$ou_sortOrder=mysql_result($result,0,1);

$query="update sortCodes set sortOrder='$ou_sortOrder' where uxCode='$tr_uxCode' and umCode='$tr_umCode'
								and sortCode='$tr_sortCode'";
mysql_query($query) or die($query);
$query="update sortCodes set sortOrder='$tr_sortOrder' where uxCode='$tr_uxCode' and umCode='$tr_umCode'
								and sortCode='$ou_sortCode'";
mysql_query($query) or die($query);
header("Content-type: text/plain; charset=utf-8");
?>
{
	sortCode:"<?=$tr_sortCode?>",
	uxCode:"<?=$tr_uxCode?>",
	umCode:"<?=$tr_umCode?>",
	moveType:"<?=$tr_moveType?>",
	liId:"<?=$tr_liId?>",
	sortOrderS:"<?=$tr_sortOrder?>",
	sortOrderT:"<?=$ou_sortOrder?>"
}
