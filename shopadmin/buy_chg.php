<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 27
 * Time: 오후 2:02
 */
include("common/config.shop.php");
include("check.php");
$tdata=$_POST["tdata"];//R(환불) T(반품) E(교환)
$tdata_status=$_POST["tdata_status"];// 1:배송전 2:배송후
$tdata_seq=$_POST["tdata_seq"];//buy_claim_seq
$tdata_num = $_POST["tdata_num"];
//주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료,
//128:환불신청, 256:환불완료, 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료',

if($tdata_status == "1"){
    switch ($tdata_num){
        case 128:
            $buy_claim_status = "256";
            break;
        case 8192:
            $buy_claim_status = "65536";
            break;

    }
}else{
    switch ($tdata_num){
        case 128:
            $buy_claim_status = "256";
            break;
        case 512:
            $buy_claim_status = "1024";
            break;
        case 1024:
            $buy_claim_status = "2048";
            break;
        case 2048:
            $buy_claim_status = "4096";
            break;
        case 8192:
            $buy_claim_status = "16384";
            break;
        case 16384:
            $buy_claim_status = "65536";
            break;

    }
}
mysql_query("UPDATE buy_claim SET buy_claim_status=$buy_claim_status WHERE buy_claim_seq='$tdata_seq'") or die("buy_chg");
echo "true";
mysql_close($db);
?>