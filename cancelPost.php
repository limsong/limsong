<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 20
 * Time: 오후 7:02
 */
include_once("include/config.php");
include_once("session.php");
include_once("include/sqlcon.php");
require_once('libs/INIStdPayUtil.php');
$SignatureUtil = new INIStdPayUtil();

foreach ($_POST as $key => $value) {
    ${$key} = $value;
    //echo $key." : ". $value."<br>";
}
$cancel_mod = $_POST["cancel_mod"];
$cancel_dlv_free = $_POST["cancel_dlv_free"];
//array POST
$cancel_sb_buy_goods_seq = $_POST["cancel_sb_buy_goods_seq"];
$cancel_sb_buy_seq = $_POST["cancel_sb_buy_seq"];
$sb_num = $_POST["sb_num"];
$cancel_op_buy_goods_seq = $_POST["cancel_op_buy_goods_seq"];
$cancel_op_buy_seq = $_POST["cancel_op_buy_seq"];
$op_num = $_POST["op_num"];
$time = date("Ymd", time());
$time2 = date("Y-m-d H:i:s", time());


$buy_good_req_seq = $cancel_sb_buy_goods_seq;//신청한 상품 일련번호
$sb_buy_good_req_count = $sb_num;
$op_buy_good_req_count = $op_num;


$buy_seq = $cancel_sb_buy_seq;//신청한 주문 일련번호
$buy_refund_ch_dlv_fee = $cancel_dlv_free;
//sb
$buy_goodsAdd = "";
foreach ($cancel_sb_buy_goods_seq as $item => $item_val) {
    if ($buy_goodsAdd == "") {
        $buy_goodsAdd = "WHERE buy_goods_seq='$item_val'";
    } else {
        $buy_goodsAdd .= " or buy_goods_seq='$item_val'";
    }
}
$db->query("SELECT buy_goods_price_total FROM buy_goods $buy_goodsAdd");
$db_buy_goods = $db->loadRows();
$count = count($db_buy_goods);
for ($i = 0; $i < $count; $i++) {
    $buy_claim_price_total += $db_buy_goods[$i]["buy_goods_price_total"] * $sb_num[$i];
}

$buy_claim_price_total_tmp = $buy_claim_price_total;
//op
$buy_goodsAdd = "";
foreach ($cancel_op_buy_goods_seq as $item => $item_val) {
    if ($buy_goodsAdd == "") {
        $buy_goodsAdd = "WHERE buy_goods_seq='$item_val'";
    } else {
        $buy_goodsAdd .= " or buy_goods_seq='$item_val'";
    }
}

$db->query("SELECT buy_goods_status,buy_goods_price_total FROM buy_goods $buy_goodsAdd");
$db_buy_goods = $db->loadRows();
$count = count($db_buy_goods);
for ($i = 0; $i < $count; $i++) {
    $buy_claim_price_total2 += $db_buy_goods[$i]["buy_goods_price_total"] * $op_num[$i];
    $buy_goods_status = $db_buy_goods[$i]["buy_goods_status"];
}
//'주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료, 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료',
if ($data_cancel == "0") {
    //취소신청
    $buy_status = "32";
    $buy_claim_status_before = "0";//입금전 취소   0 입금전 1 배송전 2 배송후
    $buy_claim_code = 'C' . $SignatureUtil->getTimestamp();
} elseif ($data_cancel == "1") {
    //환불신청
    $buy_claim_code = 'R' . $SignatureUtil->getTimestamp();
    if ($data_status == "1") {
        $buy_status = "128";
        $buy_claim_status_before = "1";//입금전 취소   0 입금전 1 배송전 2 배송후
    } elseif ($data_status == "2") {
        $buy_status = "128";
        $buy_claim_status_before = "2";//입금전 취소   0 입금전 1 배송전 2 배송후
    }

} elseif ($data_cancel == "2") {
    //반품신청
    $buy_claim_code = 'T' . $SignatureUtil->getTimestamp();
    if ($data_status == "1") {
        $buy_status = "512";
        $buy_claim_status_before = "1";//입금전 취소   0 입금전 1 배송전 2 배송후
    } elseif ($data_status == "2") {
        $buy_status = "512";
        $buy_claim_status_before = "2";//입금전 취소   0 입금전 1 배송전 2 배송후
    }
} elseif ($data_cancel == "3") {
    //교환신청
    $buy_claim_code = 'E' . $SignatureUtil->getTimestamp();
    if ($data_status == "1") {
        $buy_status = "8192";
        $buy_claim_status_before = "1";//입금전 취소   0 입금전 1 배송전 2 배송후
    } elseif ($data_status == "2") {
        $buy_status = "8192";
        $buy_claim_status_before = "2";//입금전 취소   0 입금전 1 배송전 2 배송후
    }
}

$buy_refund_price = $buy_claim_price_total + $buy_claim_price_total2 + $buy_refund_ch_dlv_fee;
IF ($cancel_mod == "cAll") {
    $db->query("INSERT INTO buy_claim (
                              buy_claim_status,
                              buy_claim_code,
                              buy_claim_status_before,
                              buy_claim_is_all,
                              buy_seq,
                              user_id,
                              buy_claim_type,
                              buy_claim_sdate,
                              buy_claim_edate,
                              buy_claim_price_total,
                              buy_refund_price,
                              buy_refund_ch_dlv_fee) 
                      VALUES (
                              '$buy_status',
                              '$buy_claim_code',
                              '$buy_claim_status_before',
                              '1',
                              '$cancel_sb_buy_seq',
                              '$uname',
                              '1',
                              '$time2',
                              '',
                              '$buy_claim_price_total_tmp',
                              '$buy_refund_price',
                              '$buy_refund_ch_dlv_fee')
                      ");


    $db->query("SELECT buy_claim_seq FROM buy_claim WHERE buy_claim_code='$buy_claim_code'");
    $db_buy_claim = $db->loadRows();
    $buy_claim_seq = $db_buy_claim[0]["buy_claim_seq"];
    $i = 0;
    foreach ($cancel_sb_buy_goods_seq as $key2 => $value2) {
        //$buy_claim_seqa = generate_password();
        $db->query("INSERT INTO buy_claim_goods (buy_claim_seq,
                                                buy_goods_req_seq,
                                                buy_goods_new_seq,
                                                buy_goods_copy_seq,
                                                buy_goods_req_count,
                                                buy_goods_new_count,
                                                buy_goods_org_count) 
                                        VALUES ('$buy_claim_seq','$cancel_sb_buy_goods_seq[$i]','','','$sb_num[$i]','$sb_num[$i]','$sb_org_count[$i]')");
        $db->query("UPDATE buy_goods SET buy_goods_count='0',buy_goods_status='$buy_status' WHERE buy_goods_seq='$cancel_sb_buy_goods_seq[$i]'");
        $i++;
    }

    $i = 0;
    foreach ($cancel_op_buy_goods_seq as $key3 => $value3) {
        //$buy_claim_seqb = generate_password();
        $db->query("INSERT INTO buy_claim_goods (buy_claim_seq,
                                                buy_goods_req_seq,
                                                buy_goods_new_seq,
                                                buy_goods_copy_seq,
                                                buy_goods_req_count,
                                                buy_goods_new_count,
                                                buy_goods_org_count) 
                                        VALUES ('$buy_claim_seq','$cancel_op_buy_goods_seq[$i]','','','$op_num[$i]','$op_num[$i]','$op_org_count[$i]')");
        $db->query("UPDATE buy_goods SET buy_goods_count='0',buy_goods_status='$buy_status' WHERE buy_goods_seq='$cancel_op_buy_goods_seq[$i]'");
        //echo "UPDATE buy_goods SET buy_goods_count='0',buy_goods_status='64' WHERE buy_goods_seq='$cancel_op_buy_goods_seq[$i]'"."<br>";
        $i++;
    }
} else {


    $db->query("INSERT INTO buy_claim (buy_claim_status,
                                      buy_claim_code,
                                      buy_claim_status_before,
                                      buy_claim_is_all,
                                      buy_seq,
                                      user_id,
                                      buy_claim_type,
                                      buy_claim_sdate,
                                      buy_claim_edate,
                                      buy_claim_price_total,
                                      buy_refund_price,
                                      buy_refund_ch_dlv_fee) 
                      VALUES ('$buy_status',
                              '$buy_claim_code',
                              '$buy_claim_status_before',
                              '0',
                              '$cancel_sb_buy_seq',
                              '$uname',
                              '1',
                              '$time2',
                              '',
                              '$buy_claim_price_total_tmp',
                              '$buy_refund_price',
                              '$buy_refund_ch_dlv_fee')
              ");


    $db->query("SELECT buy_claim_seq FROM buy_claim WHERE buy_claim_code='$buy_claim_code'");
    $db_buy_claim = $db->loadRows();
    $buy_claim_seq = $db_buy_claim[0]["buy_claim_seq"];
    $i = 0;
    foreach ($cancel_sb_buy_goods_seq as $key2 => $value2) {
        //$buy_claim_seqa = generate_password();
        $db->query("INSERT INTO buy_claim_goods (
                                                buy_claim_seq,
                                                buy_goods_req_seq,
                                                buy_goods_new_seq,
                                                buy_goods_copy_seq,
                                                buy_goods_req_count,
                                                buy_goods_new_count,
                                                buy_goods_org_count) 
                                        VALUES ('$buy_claim_seq','$cancel_sb_buy_goods_seq[$i]','','','$sb_num[$i]','$sb_num[$i]','$sb_org_count[$i]')");

        $buy_goods_count = "";
        $buy_goods_count = $sb_org_count[$i] - $sb_num[$i];
        if ($buy_goods_count == 0) {
            $db->query("UPDATE buy_goods SET buy_goods_count='$buy_goods_count',buy_goods_status='$buy_status' WHERE buy_goods_seq='$cancel_sb_buy_goods_seq[$i]'");
        } else {
            $db->query("UPDATE buy_goods SET buy_goods_count='$buy_goods_count' WHERE buy_goods_seq='$cancel_sb_buy_goods_seq[$i]'");
        }
        //echo "UPDATE buy_goods SET buy_goods_count='$buy_goods_count' WHERE buy_goods_seq='$cancel_sb_buy_goods_seq[$i]'"."<br>";
        $i++;
    }

    $i = 0;
    if ($cancel_op_buy_goods_seq != "") {
        foreach ($cancel_op_buy_goods_seq as $key3 => $value3) {
            //$buy_claim_seqb = generate_password();
            $db->query("INSERT INTO buy_claim_goods (
                                                buy_claim_seq,
                                                buy_goods_req_seq,
                                                buy_goods_new_seq,
                                                buy_goods_copy_seq,
                                                buy_goods_req_count,
                                                buy_goods_new_count,
                                                buy_goods_org_count) 
                                        VALUES ('$buy_claim_seq','$cancel_op_buy_goods_seq[$i]','','','$op_num[$i]','$op_num[$i]','$op_org_count[$i]')");

            $buy_goods_count = "";
            $buy_goods_count = $op_org_count[$i] - $op_num[$i];
            if ($buy_goods_count == 0) {
                $db->query("UPDATE buy_goods SET buy_goods_count='$buy_goods_count',buy_goods_status='$buy_status' WHERE buy_goods_seq='$cancel_op_buy_goods_seq[$i]'");
            } else {
                $db->query("UPDATE buy_goods SET buy_goods_count='$buy_goods_count' WHERE buy_goods_seq='$cancel_op_buy_goods_seq[$i]'");
            }
            //echo "UPDATE buy_goods SET buy_goods_count='$buy_goods_count' WHERE buy_goods_seq='$cancel_op_buy_goods_seq[$i]'"."<br>";
            $i++;
        }
    }
}

$db->disconnect();
echo '<script language="javascript">window.top.document.location.href="/mypage.php";</script>';
header("Location:/mypage.php");
?>