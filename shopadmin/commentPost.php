<?php
include("common/config.shop.php");
foreach($_POST as $k=>$v) {
	${"tm_".$k}=$v;
}
$jjCode=$tm_code."_comment";
/*
$in_puid=iconv('UTF-8','EUC-KR',rawurldecode($tm_number));
$in_jjName=iconv('UTF-8','EUC-KR',rawurldecode($tm_jjName));
$in_jjPasswd=iconv('UTF-8','EUC-KR',rawurldecode($tm_jjPasswd));
$in_jjComment=iconv('UTF-8','EUC-KR',rawurldecode($tm_jjComment));
*/
$in_puid=$tm_number;
$in_jjName=$tm_jjName;
$in_jjPasswd=$tm_jjPasswd;
$in_jjComment=$tm_jjComment;
$in_jjName=addslashes($in_jjName);
$in_jjComment=addslashes($in_jjComment);
$in_ipInfo=$_SERVER["REMOTE_ADDR"];
$in_signdate=time();
$query="insert into $jjCode (puid,name,passwd,comment,signdate,ipInfo)
					values ('$in_puid','$in_jjName','$in_jjPasswd','$in_jjComment','$in_signdate','$in_ipInfo')";
mysql_query($query) or die("querro");
$tm_jjSigndate=date("Y-m-d: H:i:s",$in_signdate);
$jjUid=mysql_insert_id();
header("Content-type:text/xml");
echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
?>
<blist>
	<bitem>
		<jjuid><?=$jjUid?></jjuid>
		<jjname><?=$tm_jjName?></jjname>
		<jjcomment><?=$tm_jjComment?></jjcomment>
		<jjsigndate><?=$tm_jjSigndate?></jjsigndate>
		<jjipinfo><?=$in_ipInfo?></jjipinfo>
	</bitem>
</blist>
