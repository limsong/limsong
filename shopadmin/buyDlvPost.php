<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 25
 * Time: 오후 1:04
 */
include("common/config.shop.php");
include("check.php");
foreach ($_POST as $key => $value) {
      ${$key} = $value;
      //echo $key ." = ".print_r($value)."<br>";
}
//$check  = buy_seq
//buy_good_dlv_tag_no[]       송장번호

//일괄등록
$count = count($check);
$sdate = date("Y-m-d H:i:s",time());
for ($i = 0; $i < $count; $i++) {
      $buy_seq = $check[$i];
      $ou_buy_goods_dlv_tag_no = ${"buy_good_dlv_tag_no" . $buy_seq};
      $dlv_company = $dlv_company3;
      if($pay_buy_status == ""){
            $query = "UPDATE buy_goods SET buy_goods_dlv_tag_no='$ou_buy_goods_dlv_tag_no',dlv_com_seq='$dlv_company' WHERE buy_seq='$buy_seq'";
            mysql_query($query) or die("buyDlvPost");
      }else{
            if($ou_buy_goods_dlv_tag_no != "") {
                  $query = "UPDATE buy_goods SET buy_goods_status='$buy_status_chg',buy_goods_dlv_tag_no='$ou_buy_goods_dlv_tag_no',dlv_com_seq='$dlv_company',buy_goods_dlv_sdate='$sdate' WHERE buy_seq='$buy_seq'";
                  mysql_query($query) or die("buyDlvPost");
                  $query = "UPDATE buy SET buy_status='$buy_status_chg' WHERE buy_seq = '$buy_seq'";
                  mysql_query($query) or die("buyDlvPost");
            }
      }

}

mysql_close($db);
if($pay_buy_status == ""){
?>
            <script type="text/javascript">
                  alert("송장번호가 등록되였습니다.");
                  parent.location.reload();
            </script>
      </head>
      <body></body>
</html>
<?php
}else {
?>
      <script type="text/javascript">
            alert("주문상태가 변경되였습니다..");
            parent.location.reload();
      </script>
      </head>
      <body></body>
      </html>
<?php
}
?>
