<?php
include("common/config.shop.php");
$bcode = $_POST["bcode"];
$query="select goods_code  FROM goods WHERE goods_code like '$bcode%' order by goods_code desc limit 0,1";
$result=mysql_query($query) or die($query);
$rows=mysql_num_rows($result);
if($rows<1) {
    $in_goods_code=$in_xcode.$in_mcode.$in_scode."001";
} else {
    $ou_goods_code=mysql_result($result,0,0);
    $ou_goods_code++;
    $in_goods_code=substr("00".$ou_goods_code,-9);
}
echo $in_goods_code;
mysql_close($db);
?>