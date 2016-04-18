<?php
include("common/config.shop.php");
foreach($_POST as $k=>$v) {
	${"tm_".$k}=$v;
}
$jjCode=$tm_code."_comment";
$query="select name,comment from $jjCode where uid='$tm_jjUid'";
$result=mysql_query($query) or die("$tm_code");

$ou_jjName=stripslashes(mysql_result($result,0,0));
$ou_jjComment=stripslashes(mysql_result($result,0,1));

/*
$ou_jjName=iconv('EUC-KR','UTF-8',$ou_jjName);
$ou_jjComment=iconv('EUC-KR','UTF-8',$ou_jjComment);
*/
$ou_jjName=rawurlencode($ou_jjName);
$ou_jjComment=rawurlencode($ou_jjComment);
header("Content-type:text/xml");
echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
?>
<blist>
	<bitem>
		<jjuid><?=$tm_jjUid?></jjuid>
		<jjname><?=$ou_jjName?></jjname>
		<jjcomment><?=$ou_jjComment?></jjcomment>
		<jjsigndate>none</jjsigndate>
		<jjipinfo>none</jjipinfo>
	</bitem>
</blist>
