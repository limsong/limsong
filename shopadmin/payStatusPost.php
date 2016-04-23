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
                $addQuery .= " AND buy_seq='".$codeArr[$i]."'";
        }
}

$query = "UPDATE buy set buy_status='2',pay_date='$pay_date' $addQuery";
mysql_query($query) or die("paStatus");
echo "success";
mysql_close($db);
?>