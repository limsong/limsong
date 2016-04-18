<?
include("common/config.shop.php");
$tr_uxCode=$_POST['uxCode'];
$tr_umCode=$_POST['umCode'];
$tr_dType=$_POST['dType'];
$query="select * from sortCodes where uxCode='$tr_uxCode' and umCode='$tr_umCode' order by sortOrder asc";
$result=mysql_query($query) or die($query);
header("Content-type:text/xml");
echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
?>
<sortlists dtype="<?=$tr_dType?>">
<?
while($row=mysql_fetch_assoc($result)) {
	foreach($row as $k=>$v) {
		${"ou_".$k}=rawurlencode(stripslashes($v));
	}
	if(!$ou_sortImage) {
		$ou_sortImage="noImage";
	}else {
		$ou_sortImage=$sortImagesWebDir.$ou_sortImage;
	}
    if($ou_sortUrl == ""){
        $ou_sortUrl = "Null";
    }
?>
	<sortitem>
		<sortcode><?=$ou_sortCode?></sortcode>
		<sortname><?=$ou_sortName?></sortname>
        <sorturl><?=$ou_sortUrl?></sorturl>
		<sorttype><?=$ou_sortType?></sorttype>
		<uxcode><?=$ou_uxCode?></uxcode>
		<umcode><?=$ou_umCode?></umcode>
		<sortorder><?=$ou_sortOrder?></sortorder>
		<sortimage><?=$ou_sortImage?></sortimage>
	</sortitem>
<?
}
?>
</sortlists>
