<?php
/**
 * Created by PhpStorm.
 * User: Livingroom
 * Date: 2016. 4. 24.
 * Time: 오전 2:52
 */
include("common/config.shop.php");
include("check.php");
foreach ($_POST as $key => $value) {
        ${$key} = $value;
}
$pay_date = date("Y-m-d H:i:s",time());
$codeArr = explode(",",$code);
$count = count($codeArr);
for($i=0;$i<$count;$i++){
        if($addQuery == ""){
                $addQuery = "WHERE buy_seq='".$codeArr[$i]."'";
        }else{
                $addQuery .= " OR buy_seq='".$codeArr[$i]."'";
        }
}


$query = "UPDATE buy set buy_status='$mod',pay_date='$pay_date' $addQuery";
mysql_query($query) or die("payStatus");
$query = "UPDATE buy_goods set buy_goods_status='$mod' $addQuery";
mysql_query($query) or die("payStatus");
echo "success";
mysql_close($db);
?>