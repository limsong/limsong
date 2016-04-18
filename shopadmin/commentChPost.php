<?php
include("common/config.shop.php");
foreach($_POST as $k=>$v) {
	${"tm_".$k}=$v;
}
if($tm_type=="modify") {
  $jjCode=$tm_code."_comment";
    /*
  $in_jjUid=iconv('UTF-8','EUC-KR',rawurldecode($tm_jjUid));
  $in_jjName=iconv('UTF-8','EUC-KR',rawurldecode($tm_jjName));
  $in_jjComment=iconv('UTF-8','EUC-KR',rawurldecode($tm_jjComment));
    */
    $in_jjUid=$tm_jjUid;
    $in_jjName=$tm_jjName;
    $in_jjComment=$tm_jjComment;
  $in_jjName=addslashes($in_jjName);
  $in_jjComment=addslashes($in_jjComment);
  $query="update $jjCode set name='$in_jjName',comment='$in_jjComment' where uid='$in_jjUid'";
  $result=mysql_query($query) or die($query);
 header("Content-type:text/xml");
 echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
?>
<blist>
	<bitem>
		<jjuid><?=$tm_jjUid?></jjuid>
		<jjname><?=$tm_jjName?></jjname>
		<jjcomment><?=$tm_jjComment?></jjcomment>
		<jjsigndate>none</jjsigndate>
		<jjipinfo>none</jjipinfo>
	</bitem>
</blist>
<?
}else if($tm_type=="delete") {
 $jjCode=$tm_code."_comment";
 /*$in_jjUid=iconv('UTF-8','EUC-KR',rawurldecode($tm_jjUid));*/
    $in_jjUid=$tm_jjUid;
 $query="delete from $jjCode where uid='$in_jjUid'";
 $result=mysql_query($query) or die($query);
  header("Content-type:text/xml");
  echo"<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
?>
<blist>
	<bitem>
		<jjuid><?=$tm_jjUid?></jjuid>
		<jjname>none</jjname>
		<jjcomment>none</jjcomment>
		<jjsigndate>none</jjsigndate>
		<jjipinfo>none</jjipinfo>
	</bitem>
</blist>
<?
}
?>
