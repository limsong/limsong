<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 20
 * Time: 오후 7:02
 */
include_once ("include/config.php");
include_once ("session.php");
include_once ("include/sqlcon.php");
require_once('libs/INIStdPayUtil.php');
$SignatureUtil = new INIStdPayUtil();

foreach ($_POST as $key => $value) {
    ${$key} = $value;
    echo $key." : ". $value."<br>";
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
$time = date("Ymd",time());
$time2 = date("Y-m-d H:i:s",time());

$buy_claim_code = "C".$SignatureUtil->getTimestamp();

$buy_good_req_seq = $cancel_sb_buy_goods_seq;//신청한 상품 일련번호
$sb_buy_good_req_count = $sb_num;
$op_buy_good_req_count = $op_num;


$buy_seq = $cancel_sb_buy_seq;//신청한 주문 일련번호
$buy_refund_ch_dlv_fee = $cancel_dlv_free;
//sb
$buy_goodsAdd="";
foreach ($cancel_sb_buy_goods_seq as $item => $item_val) {
    if($buy_goodsAdd==""){
        $buy_goodsAdd = "WHERE buy_goods_seq='$item_val'";
    }else{
        $buy_goodsAdd .= " or buy_goods_seq='$item_val'";
    }
}
$db->query("SELECT buy_goods_price_total FROM buy_goods $buy_goodsAdd");
$db_buy_goods = $db->loadRows();
$count = count($db_buy_goods);
for($i=0;$i<$count;$i++){
    $buy_claim_price_total += $db_buy_goods[$i]["buy_goods_price_total"]*$sb_num[$i];
}

$buy_claim_price_total_tmp = $buy_claim_price_total;
//op
$buy_goodsAdd="";
foreach ($cancel_op_buy_goods_seq as $item => $item_val) {
    if($buy_goodsAdd==""){
        $buy_goodsAdd = "WHERE buy_goods_seq='$item_val'";
    }else{
        $buy_goodsAdd .= " or buy_goods_seq='$item_val'";
    }
}

$db->query("SELECT buy_goods_price_total FROM buy_goods $buy_goodsAdd");
$db_buy_goods = $db->loadRows();
$count = count($db_buy_goods);
for($i=0;$i<$count;$i++){
    $buy_claim_price_total2 += $db_buy_goods[$i]["buy_goods_price_total"]*$op_num[$i];
}


$buy_refund_price=$buy_claim_price_total+$buy_claim_price_total2+$buy_refund_ch_dlv_fee;
IF($cancel_mod=="cAll"){

}else{
    /*`buy_claim_status` int(11) NOT NULL DEFAULT '0' COMMENT '주문 클레임 상태 - 취소/환불/반품/교환 - 32~65536',
    `buy_claim_code` varchar(30) NOT NULL DEFAULT '' COMMENT '주문 클레임 코드 - C, R, T, E (ex) C11111',
    `buy_claim_is_all` tinyint(4) NOT NULL DEFAULT '0' COMMENT '주문 전체/부분여부 - 0:부분, 1:전체',
    `buy_seq` int(11) NOT NULL DEFAULT '0' COMMENT '신청한 주문 일련번호',
    `buy_copy_seq` int(11) NOT NULL DEFAULT '0' COMMENT '재주문 일련번호(교환주문)',
    `user_id` varchar(70) NOT NULL DEFAULT '' COMMENT '신청자 ID',
    `buy_claim_officer_id` varchar(70) NOT NULL DEFAULT '' COMMENT '처리자 ID',
    `buy_claim_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '클레임 처리유형 - 1:고객, 2: 관리자, 3: 자동',
    `buy_claim_sdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '클레임 신청일',
    `buy_claim_edate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '클레임 완료일',
    `buy_claim_msg` text NOT NULL COMMENT '클레임 신청사유(buy_good_status_msg 고객/관리자 메시지)',
    `buy_claim_admin_msg` text NOT NULL COMMENT '클레임 로그(관리자)',
    `buy_claim_price_total` double NOT NULL DEFAULT '0' COMMENT '클레임 총상품금액(상품소계, 환불신청총액)',
    `buy_refund_price` double NOT NULL DEFAULT '0' COMMENT '환불 실제금액(배송비등 모두포함)',
    `buy_refund_coupon` double NOT NULL DEFAULT '0' COMMENT '환불 쿠폰',
    `buy_refund_mile` double NOT NULL DEFAULT '0' COMMENT '환불 적립금',
    `buy_refund_ch_dlv_fee` double NOT NULL DEFAULT '0' COMMENT '환불 변동 배송비',
    `buy_refund_instant_discount` double NOT NULL DEFAULT '0' COMMENT '환불 즉시할인',
    `buy_refund_user_level_discount` double NOT NULL DEFAULT '0' COMMENT '환불 회원등급 할인액',
    `buy_refund_admin_price` double NOT NULL DEFAULT '0' COMMENT '환불 관리자 할인/할증',
    `buy_refund_method` tinyint(4) NOT NULL DEFAULT '0' COMMENT '환불 방법 - 1:환불액 입금 2:환불액 적립 3:카드결제 취소(주문전체 취소) 4:카드부분취소 5:계좌이체부분취소 11:주문수정',
    `buy_refund_bank_name` varchar(100) NOT NULL DEFAULT '' COMMENT '환불 은행명',
    `buy_refund_acc_number` varchar(100) NOT NULL DEFAULT '' COMMENT '환불 신청자 계좌번호',
    `buy_refund_acc_name` varchar(100) NOT NULL DEFAULT '' COMMENT '환불 계좌의 예금주',
    `buy_exch_price` double NOT NULL DEFAULT '0' COMMENT '교환비용',*/
    echo count($cancel_sb_buy_seq);
    print_r($cancel_sb_buy_seq);
    foreach ($cancel_sb_buy_seq as $key1 => $value1){
        $db->query("INSERT INTO buy_claim (buy_claim_status,
                                          buy_claim_code,
                                          buy_claim_is_all,
                                          buy_seq,
                                          user_id,
                                          buy_claim_type,
                                          buy_claim_sdate,
                                          buy_claim_edate,
                                          buy_claim_price_total,
                                          buy_refund_price,
                                          buy_refund_ch_dlv_fee) 
                          VALUES ('32',
                                  '$buy_claim_code',
                                  '0',
                                  '$value1',
                                  '$uname',
                                  '1',
                                  '$time2',
                                  '$time2',
                                  '$buy_claim_price_total_tmp',
                                  '$buy_refund_price',
                                  '$buy_refund_ch_dlv_fee')
                  ");
    }

    /*`buy_claim_seq` INT(11) NOT NULL DEFAULT '0' COMMENT '클레임 일련번호',
	`buy_goods_req_seq` INT(11) NOT NULL DEFAULT '0' COMMENT '신청한 상품 일련번호',
	`buy_goods_new_seq` INT(11) NOT NULL DEFAULT '0' COMMENT '새로 생성된 상품 일련번호(환불건)',
	`buy_goods_copy_seq` INT(11) NOT NULL DEFAULT '0' COMMENT '재주문상품 일련번호(교환에 의한 재주문상품)',
	`buy_goods_req_count` INT(11) NOT NULL DEFAULT '0' COMMENT '신청한 수량',
	`buy_goods_new_count` INT(11) NOT NULL DEFAULT '0' COMMENT '실제 처리된 수량',
	`buy_goods_org_count` INT(11) NOT NULL DEFAULT '0' COMMENT '원본 주문시 수량',*/
    $db->query("SELECT buy_claim_seq FROM buy_claim WHERE buy_claim_code='$buy_claim_code'");
    $db_buy_claim = $db->loadRows();
    $buy_claim_seq = $db_buy_claim[0]["buy_claim_seq"];
    $i=0;
    foreach ($cancel_sb_buy_goods_seq as $key2 => $value2){
        $buy_claim_seqa = generate_password();
        $db->query("INSERT INTO buy_claim_goods (buy_claim_seq,
                                                buy_goods_req_seq,
                                                buy_goods_new_seq,
                                                buy_goods_copy_seq,
                                                buy_goods_req_count,
                                                buy_goods_new_count,
                                                buy_goods_org_count) 
                                        VALUES ('$buy_claim_seq','$buy_claim_seqa','','','$sb_num[$i]','$sb_num[$i]','$sb_org_count[$i]')");
        $i++;
    }

    $i=0;
    foreach ($cancel_op_buy_goods_seq as $key3 => $value3){
        $buy_claim_seqb = generate_password();
        $db->query("INSERT INTO buy_claim_goods (buy_claim_seq,
                                                buy_goods_req_seq,
                                                buy_goods_new_seq,
                                                buy_goods_copy_seq,
                                                buy_goods_req_count,
                                                buy_goods_new_count,
                                                buy_goods_org_count) 
                                        VALUES ('$buy_claim_seq','$buy_claim_seqb','','','$op_num[$i]','$op_num[$i]','$op_org_count[$i]')");
        $i++;
    }
}

$db->disconnect();
?>