<?php
/**
 * Created by PhpStorm.
 * User: limsong
 * Date: 2016. 4. 12.
 * Time: 오후 4:34
 */
include("common/config.shop.php");
include("check.php");
$mod = $_POST["mod"];
$ordernum = $_POST["ordernum"];
if($mod == "goods"){
        //상품검색
        $query = "select * from buy where buy_code='$ordernum'";
        $result = mysql_query($query) or die($query);

}
echo "true";
mysql_close($db);
?>