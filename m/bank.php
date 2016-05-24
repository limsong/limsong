<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 5. 3
 * Time: 오후 12:34
 */
include_once("../doctype.php");
$PGIP = $_SERVER['REMOTE_ADDR'];
if ($PGIP == "211.219.96.165" || $PGIP == "118.129.210.25")    //PG에서 보냈는지 IP로 체크
{
    // 이니시스 NOTI 서버에서 받은 Value
    $P_TID;                // 1 거래번호
    $P_MID;                // 2 상점아이디
    $P_AUTH_DT;            // 3 승인일자
    $P_STATUS;             // 4 거래상태 (00:성공, 01:실패)
    $P_TYPE;               // 5 지불수단
    $P_OID;                // 6 상점주문번호
    $P_FN_CD1;             // 7 금융사코드1
    $P_FN_CD2;             // 8 금융사코드2
    $P_FN_NM;              // 9 금융사명 (은행명, 카드사명, 이통사명)
    $P_AMT;                // 10 거래금액
    $P_UNAME;              // 11 결제고객성명
    $P_RMESG1;             // 12 결과코드('P_VACCT_NO=79010590891926|P_EXP_DT=20160515235900')
    $P_RMESG2;             // 13 결과메시지
    $P_NOTI;               // 14 노티메시지(상점에서 올린 메시지)
    $P_AUTH_NO;            // 15 승인번호


    $P_TID = $_REQUEST[P_TID];
    $P_MID = $_REQUEST[P_MID];
    $P_AUTH_DT = $_REQUEST[P_AUTH_DT];
    $P_STATUS = $_REQUEST[P_STATUS];
    $P_TYPE = $_REQUEST[P_TYPE];
    $P_OID = $_REQUEST[P_OID];
    $P_FN_CD1 = $_REQUEST[P_FN_CD1];
    $P_FN_CD2 = $_REQUEST[P_FN_CD2];
    $P_FN_NM = $_REQUEST[P_FN_NM];
    $P_FN_NM = iconv("EUC-KR", "UTF-8", $P_FN_NM);
    $P_AMT = $_REQUEST[P_AMT];
    $P_UNAME = $_REQUEST[P_UNAME];
    $P_UNAME = iconv("EUC-KR", "UTF-8", $P_UNAME);
    $P_RMESG1 = iconv("EUC-KR", "UTF-8", $_REQUEST["P_RMESG1"]);
    $P_RMESG2 = $_REQUEST[P_RMESG2];
    $P_NOTI = $_REQUEST[P_NOTI];
    $P_AUTH_NO = $_REQUEST[P_AUTH_NO];

    $db->query("SELECT pay_seq FROM buy WHERE buy_code='$P_OID'");
    $db_buy_query = $db->loadRows();
    $count = count($db_buy_query);
    if ($count > 0) {
        echo "OK";
        return;
    }


    $db->query("SELECT * FROM basket WHERE ordernum='$P_OID'");
    $db_basket_query = $db->loadRows();

    $date = date("Y-m-d H:i:s", strtotime($P_AUTH_DT));
    $bid = $db_basket_query[0]["v_oid"];
    $zipcode = $db_basket_query[0]["zipcode"];
    $user_id = $db_basket_query[0]["user_id"];
    $phone = $db_basket_query[0]["phone"];
    $oldadd = $db_basket_query[0]["add1"];
    $newadd = $db_basket_query[0]["add2"];
    $alladd = $db_basket_query[0]["add3"];
    $app_ip = $db_basket_query[0]["ipadd"];
    $ship_message = $db_basket_query[0]["ship_message"];
    $pay_dlv_fee = $db_basket_query[0]["pay_dlv_fee"];
    $buy_total_price = $db_basket_query[0]["buy_total_price"];//총상품총액(할인전금액);
    $buy_instant_discount = $db_basket_query[0]["buy_instant_discount"];//상품 즉시할인 금액(총 할인금액)
    $buy_user_tel = $db_basket_query[0]["buy_user_tel"];
    $buy_user_mobile = $db_basket_query[0]["buy_user_mobile"];
    $buy_user_email = $db_basket_query[0]["buy_user_email"];
    $uname = $db_basket_query[0]["id"];//id
    $goods_type = $db_basket_query[0]["goods_type"];


    $app_time = '';//승인시간 131805
    $app_date = $P_AUTH_DT;//2016411
    $app_method = $P_TYPE;//Card
    $app_device = "1";//pc
    $app_card_code = $P_FN_CD1;//01  카드 종류
    $app_email = "";//$resultMap["buyerEmail"];//email
    $app_card_num = "";//$resultMap["CARD_Num"];//411904*********3
    $app_price = $P_AMT;//1000결제금액
    $app_purchaseName = "";//$resultMap["CARD_PurchaseName"];//외환계열
    $app_tel = "";//$resultMap["buyerTel"];//010-5387-4806 주문인 전화번호
    $app_card_bankcode = "";//$resultMap["CARD_BankCode"];//05 카드 발급사
    $app_pay_seq = $P_TID;
    $app_oid = $P_OID;
    $pay_price_mile = 0;//결제금액 적립금


    $bidArr = explode("_", $bid);
    $count = count($bidArr);
    for ($i = 0; $i < $count; $i++) {
        $v_oid = $bidArr[$i];
        if ($basketQuery == "") {
            $basketQuery = "WHERE v_oid='$v_oid'";
        } else {
            $basketQuery .= " OR v_oid='$v_oid'";
        }
    }

    $buy_status = "2";
    $app_method = "32";
    $pay_mesg = "결제완료";
    $payMethod = "실시간계좌이체";
    $pay_online_name = $user_id;//송금자
    $pay_online_account = vbankCode($P_FN_CD1);//입금은행명 입금계좌
    //$resultMap["CSHR_ResultCode"];//
    //$resultMap["CSHR_Type"];//현금영수증 발급코드구분 (0:소득공제용 1:지출증빙용);
    $pay_date = date("Y-m-d H:i:s", strtotime($P_AUTH_DT));


    /*
    buy_seq_parent = $resultMap["tid"] (교환주문 원주문 일련번호)
    user_id = $uname (아이디)
    buy_code = $ordernum (주문번호)
    buy_status = “주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료, 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료”
    buy_date = “2016-04-09 15:39:24” (주문일)
    buy_total_price = 총 상품금액
    buy_expect_mile = 지급 예정 적립금
    pay_seq = 결제로그 일련번호
    pay_method = '결제수단 - 1:무통장, 2:카드, 4:적립금, 8:쿠폰, 16:휴대폰결제, 32:실시간 계좌이체, 64:가상계좌, 128:에스크로, 256:전액할인, 512:다날, 1024:모빌리언스, 2048:네이버 마일리지'
    pay_price_normal = '기본결제수단_총결제금액 (+배송비)'
    pay_dlv_fee = '결제한 총배송비'
    pay_price_mile = '결제금액_적립금'
    pay_date = '결제완료일(입금완료일)'
    pay_info_no = '카드번호/핸드폰번호(table:pay)'
    buy_memo = '배송시요청사항'
    buy_user_name = 주문인
    buy_user_tel = 주문인_전화
    buy_user_mobile = 주문인_휴대폰
    buy_user_email = 주문인_이메일
    buy_user_ip = 주문인_IP
    buy_dlv_name = 배송지_이름
    buy_dlv_tel = 배송지_전화
    buy_dlv_mobile = 배송지_휴대폰
    buy_dlv_email = 배송지_이메일
    buy_dlv_zipcode = 배송지_우편번호
    buy_dlv_addr_base = 배송지_주소_기본
    buy_dlv_addr_etc = 배송지_주소_상세
    buy_dlv_pre_date = 배송지_희망배송일
    coupon_data_seq = 사용 쿠폰 목록 일련번호
    buy_bill_type = 영수증/증빙서류 종류(table:buy_bill) 0:미신청 1:현금영수증신청 2:세금계산서신청
    buy_instant_discount = 상품 즉시할인 금액
    buy_mile_amount = 구매시 지급되는 적립금
    */


    $buy_goods_add_query = "";
    $buy_dlv_name = $user_id;
    $user_id = $uname;
    $buy_code = $app_oid;
    $buy_date = $date;
    $buy_expect_mile = "";
    $pay_seq = $app_pay_seq;
    $pay_method = $app_method;
    $pay_price_normal = "";
    //$pay_date = $date;//위에있음
    $buy_memo = $ship_message;
    $buy_user_name = $P_UNAME;
    $buy_user_ip = $app_ip;

    $buy_dlv_tel = $phone;
    $buy_dlv_mobile = $phone;
    $buy_dlv_email = $buy_user_email;
    $buy_dlv_zipcode = $zipcode;
    $buy_dlv_addr_base = $newadd;
    $buy_dlv_addr_etc = $alladd;
    $buy_dlv_pre_date = "";
    $coupon_data_seq = "";
    $buy_bill_type = "";
    $buy_mile_amount = "";
    $buy_mobile = "1";


    $db->query("INSERT INTO buy (
                    user_id,buy_code,buy_status,buy_goods_type,buy_date,buy_total_price,buy_expect_mile,pay_seq,pay_method,pay_price_normal,pay_dlv_fee,pay_price_mile,pay_pre_date
                    ,pay_date,pay_online_name,pay_online_account,pay_info_no,buy_memo,buy_user_name,buy_user_tel,buy_user_mobile,buy_user_email,buy_user_ip,buy_dlv_name,buy_dlv_tel,buy_dlv_mobile
                    ,buy_dlv_email,buy_dlv_zipcode,buy_dlv_addr_base,buy_dlv_addr_etc,buy_dlv_pre_date,coupon_data_seq,buy_bill_type,buy_instant_discount,buy_mile_amount,buy_mobile)
                    VALUES
                    ('$user_id','$buy_code','$buy_status','$goods_type','$buy_goods_type','$buy_date','$buy_total_price','$buy_expect_mile','$pay_seq','$pay_method','$pay_price_normal','$pay_dlv_fee','$pay_price_mile','$pay_pre_date',
                    '$pay_date','$pay_online_name','$pay_online_account','$pay_info_no','$buy_memo','$buy_user_name','$buy_user_tel','$buy_user_mobile','$buy_dlv_email','$buy_user_ip',''$buy_dlv_name,'$buy_dlv_tel','$buy_dlv_mobile',
                    '$buy_dlv_email','$buy_dlv_zipcode','$buy_dlv_addr_base','$alladd','$buy_dlv_pre_date','$coupon_data_seq','$buy_bill_type','$buy_instant_discount','$buy_mile_amount','$buy_mobile')");

    $db->query("SELECT buy_seq FROM buy WHERE user_id='$uname' AND buy_code='$buy_code'");
    $dbbuyQuery = $db->loadRows();
    $buy_seq = $dbbuyQuery[0]["buy_seq"];

    if ($bid != "") {
        //====================================     장바구니에있는 삼품 구매     ===================================================
        $db->query("SELECT uid,v_oid,goods_code,sbid,sbnum,opid,opnum,signdate FROM basket $basketQuery AND id='$uname'");
        $dbdata = $db->loadRows();
        foreach ($dbdata as $k => $v) {
            $sbid = $v["sbid"];
            $sbidArr = explode(",", $sbid);
            $sbnum = $v["sbnum"];
            $sbnumArr = explode(",", $sbnum);
            $goods_code = $v["goods_code"];


            $i = 0;
            $sbidQuery == "";
            foreach ($sbidArr as $a => $b) {
                if ($i == 0) {
                    $sbidQuery = "WHERE id IN (" . $b . "";
                } else {
                    $sbidQuery .= "," . $b . "";
                }
                $i++;
            }
            $sbidQuery .= ")";


            $opid = $v["opid"];
            $opidArr = explode(",", $opid);
            $opnum = $v["opnum"];
            $opnumArr = explode(",", $opnum);


            $i = 0;
            $opidQuery = "";
            foreach ($opidArr as $c => $d) {
                if ($d != "") {
                    if ($i == 0) {
                        $opidQuery = "WHERE id IN (" . $d . "";
                    } else {
                        $opidQuery .= "," . $d . "";
                    }
                    $i++;
                }
            }
            if ($opidQuery != "") {
                $opidQuery .= ")";
            }


            $db->query("SELECT goods_name,sb_sale,sellPrice,goods_type,goods_dlv_type,goods_dlv_type,goods_dlv_fee,goods_dlv_fee,goods_opt_type,goods_opt_num,manufacture FROM goods WHERE goods_code='$goods_code'");
            $goods_value_query = $db->loadRows();
            $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
            $goods_name = $goods_value_query[0]["goods_name"];
            $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];//배송유형 1:무료 2:고정
            $goods_opt_type = $goods_value_query[0]["goods_opt_type"];//가격선택옵션(2) 일반옵션(1) 옵션없음 구분(0)
            $goods_opt_num = $goods_value_query[0]["goods_opt_num"];//가격선택옵션 2,3 구분
            $goods_sellPrice = $goods_value_query[0]["sellPrice"];//단가
            $manufacture = $goods_value_query[0]["manufacture"];//제조사
            $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];
            $buy_goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];


            /*switch ($goods_dlv_type) {
                    case "1":
                            $goods_dlv_free = "0";
                            $buy_goods_dlv_type = "1";//배송비 유형 - 1:무료, 2:고정금액(주문시 선결제처럼추가됨?), 3:착불, 4:주문금액별, 5:무게별, 6:부피별
                    case "2":
                            $goods_dlv_free = "2500";
                            $buy_goods_dlv_type = "2";//배송비 유형 - 1:무료, 2:고정금액(주문시 선결제처럼추가됨?), 3:착불, 4:주문금액별, 5:무게별, 6:부피별
            }*/

            if ($goods_opt_type == "1") {
                //일반옵션
                $db->query("SELECT opName1,opName2,sellPrice,quantity FROM goods_option_single_value $sbidQuery ORDER BY id ASC");
                $goods_value_query = $db->loadRows();
            } elseif ($goods_opt_type == "2") {
                //가격선택옵션 opValue2 판매가
                $db->query("SELECT opName1,opName2,opName3,opValue2,opValue3 FROM goods_option_grid_value $sbidQuery ORDER BY id ASC");
                $goods_value_query = $db->loadRows();
            }


            $cate_code = "";//카테고리
            $dlv_code = "";//운송장번호
            $buy_goods_code = $goods_code;
            $buy_goods_cost_price = "";//매입가
            $buy_expect_mile = "";//지급 예정 적립금
            $dlv_com_seq = "";//배송사 일련번호(delivery company seq)
            $buy_goods_dlv_method = "1";//배송 방법 - 1:택배, 2:자체배송, 3:빠른등기, 4:일반등기, 5:퀵서비스, 6:소포, 7:해외배송
            $buy_goods_dlv_value = "";//배송비 계산 값(무게, 부피 등)
            $buy_goods_dlv_special = "";//별도 배송 여부
            $buy_goods_dlv_tag_no = "";//송장번호
            $buy_goods_fee_proportion = "";//배송비 선불 수량비례
            $buy_goods_dlv_fee_arrival = "";//배송비 착불
            $buy_goods_arrival_proportion = "";//배송비 착불 수량비례
            $buy_goods_dlv_fee_flag = "";//배송비 플래그(최종 결제결과에 따른 선착불여부) - 0:계산제외?, 1:선불(업체부담), 2:착불(고객부담), 3: 선결제(고객부담), 4:선불(회원등급에 의한 무료)
            $buy_goods_memo = "";//개별 배송시요청사항
            $buy_goods_memo_gift = "";//개별 선물메시지(사용안함)
            $buy_goods_memo_admin = "";//개별 관리자 메모???
            $buy_goods_dlv_sdate = "";//배송 시작일 0000-00-00 00:00:00
            $buy_goods_dlv_edate = "";//배송 완료일 0000-00-00 00:00:00

            $com_seq = "";//상점 거래처 일련번호(매입처 table:shop_company)
            $buy_goods_coupon = "";//상품별 쿠폰
            $buy_goods_user_level_discount = "";//상품별 회원등급별 할인
            $buy_goods_status_type = "";//주문상품 상태변경 상세유형 - 1:고객, 2:관리자, 3:자동(buy_claim에도 저장할것
            $buy_goods_status_msg = "";//주문상품 상태변경 상세메시지 : 변경사유/기타메모(buy_claim에도 저장할것
            $buy_goods_status_sdate = "";//주문상품 상태변경일_신청일 0000-00-00 00:00:00
            $buy_goods_status_edate = "";//주문상품 상태변경일_완료일 0000-00-00 00:00:00
            $buy_goods_open_market = "";//오픈마켓 종류 : 1.네이버 지식쇼핑, 2.다음 쇼핑하우
            $buy_goods_dlv_ok_mileage = "";//구매완료 마일리지
            $buy_goods_add_cancel_type = "";//주문수정시 추가/삭제 상품 설정 (A:추가, C:삭제, N:기본상품)
            $checkout_product_order_id = "";//체크아웃 상품주문번호(ProductOrderID)

            if ($goods_opt_type == "0") {
                //옵션없음
                $buy_goods_name = $goods_name;
                $buy_goods_prefix = "";
                $buy_goods_suffix = "";
                $buy_goods_price = $goods_sellPrice;//단가
                $buy_goods_count = $sbnumArr[$i];//상품수량
                $buy_goods_price_total = $buy_goods_price * $sb_sale;//총상품금액
                $buy_goods_dlv_fee = $goods_dlv_free;//배송비 선불
                $maker_name = $manufacture;//제조사명

                if ($buy_goods_add_query == "") {
                    $buy_goods_add_query = "('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                } else {
                    $buy_goods_add_query .= ",('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                }
            } else {
                $i = 0;
                foreach ($goods_value_query as $e => $f) {
                    if ($goods_opt_type == "1") {
                        $opName1 = $goods_value_query[$i]["opName1"];
                        $opName2 = $goods_value_query[$i]["opName2"];
                        $goods_sellPrice = $f["sellPrice"];

                    } elseif ($goods_opt_type == "2") {
                        $opName1 = $goods_value_query[$i]["opName1"];
                        $opName2 = $goods_value_query[$i]["opName2"];
                        $opName3 = $goods_value_query[$i]["opName3"];
                        $goods_sellPrice = $f["opValue2"];
                    }

                    $buy_goods_name = $opName1;
                    $buy_goods_prefix = $opName2;
                    $buy_goods_suffix = $opName3;
                    $buy_goods_price = $goods_sellPrice;//단가
                    $buy_goods_count = $sbnumArr[$i];//상품수량
                    $buy_goods_price_total = $buy_goods_price * $sb_sale;//총상품금액
                    $buy_goods_dlv_fee = $goods_dlv_free;//배송비 선불
                    $maker_name = $manufacture;//제조사명


                    if ($buy_goods_add_query == "") {
                        $buy_goods_add_query = "('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                    } else {
                        $buy_goods_add_query .= ",('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                    }
                    $i++;
                }
            }


            if ($goods_opt_type != "0") {
                $db->query("SELECT opName1,opName2,opValue2 FROM goods_option $opidQuery");
                $goods_option = $db->loadRows();

                $i = 0;
                foreach ($goods_option as $e => $f) {
                    $option_opName1 = $f["opName1"];
                    $option_opName2 = $f["opName2"];
                    $option_sellPrice = $f["opValue2"];
                    $buy_goods_count = $opnumArr[$i];
                    $buy_goods_name = $option_opName1;
                    $buy_goods_prefix = $option_opName2;
                    $buy_goods_suffix = "";
                    $buy_goods_price = $option_sellPrice;//단가
                    $buy_goods_price_total = $buy_goods_price;//총상품금액
                    $buy_goods_dlv_fee = $goods_dlv_free;//배송비 선불
                    $maker_name = "";//제조사명

                    if ($buy_goods_add_query == "") {
                        $buy_goods_add_query = "('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '1', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                    } else {
                        $buy_goods_add_query .= ",('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '1', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                    }

                    $i++;
                }
            }

        }
    } else {
        //====================================     장바구니에 안넣고 바로구매     ===================================================
        $goods_code = $_SESSION[$app_oid . "_goods_code"];
        $sbnum = $_SESSION[$app_oid . "_sbnum"];
        $sbid = $_SESSION[$app_oid . "_sbid"];
        $opid = $_SESSION[$app_oid . "_opid"];
        $opnum = $_SESSION[$app_oid . "_opnum"];
        $sbidArr = explode(",", $sbid);
        $sbnumArr = explode(",", $sbnum);
        $i = 0;
        $sbidQuery == "";
        foreach ($sbidArr as $a => $b) {
            if ($i == 0) {
                $sbidQuery = "WHERE id IN (" . $b . "";
            } else {
                $sbidQuery .= "," . $b . "";
            }
            $i++;
        }
        $sbidQuery .= ")";
        $opidArr = explode(",", $opid);
        $opnumArr = explode(",", $opnum);
        $i = 0;
        $opidQuery = "";
        foreach ($opidArr as $c => $d) {
            if ($d != "") {
                if ($i == 0) {
                    $opidQuery = "WHERE id IN (" . $d . "";
                } else {
                    $opidQuery .= "," . $d . "";
                }
                $i++;
            }
        }
        if ($opidQuery != "") {
            $opidQuery .= ")";
        }


        $db->query("SELECT goods_name,sb_sale,sellPrice,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_num,manufacture FROM goods WHERE goods_code='$goods_code'");
        $goods_value_query = $db->loadRows();
        $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
        $goods_name = $goods_value_query[0]["goods_name"];
        $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];//배송유형 1:무료 2:고정
        $goods_opt_type = $goods_value_query[0]["goods_opt_type"];//가격선택옵션(2) 일반옵션(1) 옵션없음 구분(0)
        $goods_opt_num = $goods_value_query[0]["goods_opt_num"];//가격선택옵션 2,3 구분
        $goods_sellPrice = $goods_value_query[0]["sellPrice"];//단가
        $manufacture = $goods_value_query[0]["manufacture"];//제조사
        $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];
        $buy_goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];


        /*switch ($goods_dlv_type) {
            case "1":
                $goods_dlv_free = "0";
                $buy_goods_dlv_type = "1";//배송비 유형 - 1:무료, 2:고정금액(주문시 선결제처럼추가됨?), 3:착불, 4:주문금액별, 5:무게별, 6:부피별
            case "2":
                $goods_dlv_free = "2500";
                $buy_goods_dlv_type = "2";//배송비 유형 - 1:무료, 2:고정금액(주문시 선결제처럼추가됨?), 3:착불, 4:주문금액별, 5:무게별, 6:부피별
        }*/

        if ($goods_opt_type == "1") {
            //일반옵션
            $db->query("SELECT opName1,opName2,sellPrice,quantity FROM goods_option_single_value $sbidQuery ORDER BY id ASC");
            $goods_value_query = $db->loadRows();
        } elseif ($goods_opt_type == "2") {
            //가격선택옵션 opValue2 판매가
            $db->query("SELECT opName1,opName2,opName3,opValue2,opValue3 FROM goods_option_grid_value $sbidQuery ORDER BY id ASC");
            $goods_value_query = $db->loadRows();
        }


        $cate_code = "";//카테고리
        $dlv_code = "";//운송장번호
        $buy_goods_code = $goods_code;
        $buy_goods_cost_price = "";//매입가
        $buy_expect_mile = "";//지급 예정 적립금
        $dlv_com_seq = "";//배송사 일련번호(delivery company seq)
        $buy_goods_dlv_method = "1";//배송 방법 - 1:택배, 2:자체배송, 3:빠른등기, 4:일반등기, 5:퀵서비스, 6:소포, 7:해외배송
        $buy_goods_dlv_value = "";//배송비 계산 값(무게, 부피 등)
        $buy_goods_dlv_special = "";//별도 배송 여부
        $buy_goods_dlv_tag_no = "";//송장번호
        $buy_goods_fee_proportion = "";//배송비 선불 수량비례
        $buy_goods_dlv_fee_arrival = "";//배송비 착불
        $buy_goods_arrival_proportion = "";//배송비 착불 수량비례
        $buy_goods_dlv_fee_flag = "";//배송비 플래그(최종 결제결과에 따른 선착불여부) - 0:계산제외?, 1:선불(업체부담), 2:착불(고객부담), 3: 선결제(고객부담), 4:선불(회원등급에 의한 무료)
        $buy_goods_memo = "";//개별 배송시요청사항
        $buy_goods_memo_gift = "";//개별 선물메시지(사용안함)
        $buy_goods_memo_admin = "";//개별 관리자 메모???
        $buy_goods_dlv_sdate = "";//배송 시작일 0000-00-00 00:00:00
        $buy_goods_dlv_edate = "";//배송 완료일 0000-00-00 00:00:00

        $com_seq = "";//상점 거래처 일련번호(매입처 table:shop_company)
        $buy_goods_coupon = "";//상품별 쿠폰
        $buy_goods_user_level_discount = "";//상품별 회원등급별 할인
        $buy_goods_status_type = "";//주문상품 상태변경 상세유형 - 1:고객, 2:관리자, 3:자동(buy_claim에도 저장할것
        $buy_goods_status_msg = "";//주문상품 상태변경 상세메시지 : 변경사유/기타메모(buy_claim에도 저장할것
        $buy_goods_status_sdate = "";//주문상품 상태변경일_신청일 0000-00-00 00:00:00
        $buy_goods_status_edate = "";//주문상품 상태변경일_완료일 0000-00-00 00:00:00
        $buy_goods_open_market = "";//오픈마켓 종류 : 1.네이버 지식쇼핑, 2.다음 쇼핑하우
        $buy_goods_dlv_ok_mileage = "";//구매완료 마일리지
        $buy_goods_add_cancel_type = "";//주문수정시 추가/삭제 상품 설정 (A:추가, C:삭제, N:기본상품)
        $checkout_product_order_id = "";//체크아웃 상품주문번호(ProductOrderID)

        if ($goods_opt_type == "0") {
            //옵션없음
            $buy_goods_name = $goods_name;
            $buy_goods_prefix = "";
            $buy_goods_suffix = "";
            $buy_goods_price = $goods_sellPrice;//단가
            $buy_goods_count = $sbnumArr[$i];//상품수량
            $buy_goods_price_total = $buy_goods_price * $sb_sale;//총상품금액
            $buy_goods_dlv_fee = $goods_dlv_free;//배송비 선불
            $maker_name = $manufacture;//제조사명

            if ($buy_goods_add_query == "") {
                $buy_goods_add_query = "('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
            } else {
                $buy_goods_add_query .= ",('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
            }
        } else {
            $i = 0;
            foreach ($goods_value_query as $e => $f) {
                if ($goods_opt_type == "1") {
                    $opName1 = $goods_value_query[$i]["opName1"];
                    $opName2 = $goods_value_query[$i]["opName2"];
                    $goods_sellPrice = $f["sellPrice"];

                } elseif ($goods_opt_type == "2") {
                    $opName1 = $goods_value_query[$i]["opName1"];
                    $opName2 = $goods_value_query[$i]["opName2"];
                    $opName3 = $goods_value_query[$i]["opName3"];
                    $goods_sellPrice = $f["opValue2"];
                }

                $buy_goods_name = $opName1;
                $buy_goods_prefix = $opName2;
                $buy_goods_suffix = $opName3;
                $buy_goods_price = $goods_sellPrice;//단가
                $buy_goods_count = $sbnumArr[$i];//상품수량
                $buy_goods_price_total = $buy_goods_price * $sb_sale;//총상품금액
                $buy_goods_dlv_fee = $goods_dlv_free;//배송비 선불
                $maker_name = $manufacture;//제조사명


                if ($buy_goods_add_query == "") {
                    $buy_goods_add_query = "('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                } else {
                    $buy_goods_add_query .= ",('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '0', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                }
                $i++;
            }
        }


        if ($goods_opt_type != "0") {
            $db->query("SELECT opName1,opName2,opValue2 FROM goods_option $opidQuery");
            $goods_option = $db->loadRows();

            $i = 0;
            foreach ($goods_option as $e => $f) {
                $option_opName1 = $f["opName1"];
                $option_opName2 = $f["opName2"];
                $option_sellPrice = $f["opValue2"];
                $buy_goods_count = $opnumArr[$i];
                $buy_goods_name = $option_opName1;
                $buy_goods_prefix = $option_opName2;
                $buy_goods_suffix = "";
                $buy_goods_price = $option_sellPrice;//단가
                $buy_goods_price_total = $buy_goods_price;//총상품금액
                $buy_goods_dlv_fee = $goods_dlv_free;//배송비 선불
                $maker_name = "";//제조사명

                if ($buy_goods_add_query == "") {
                    $buy_goods_add_query = "('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '1', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                } else {
                    $buy_goods_add_query .= ",('$buy_seq', '$cate_code', '$dlv_code', '$buy_status', '$buy_goods_code', '$buy_goods_name',
                        '$buy_goods_prefix', '$buy_goods_suffix', '1', '$buy_goods_cost_price', '$buy_goods_price', '$buy_goods_count',
                        '$buy_goods_price_total', '$buy_expect_mile', '$dlv_com_seq', '$buy_goods_dlv_method', '$buy_goods_dlv_type', '$buy_goods_dlv_value',
                        '$buy_goods_dlv_special', '$buy_goods_dlv_tag_no', '$buy_goods_dlv_fee', '$buy_goods_fee_proportion', '$buy_goods_dlv_fee_arrival',
                        '$buy_goods_arrival_proportion', '$buy_goods_dlv_fee_flag', '$buy_goods_memo', '$buy_goods_memo_gift', '$buy_goods_memo_admin',
                        '$buy_goods_dlv_sdate', '$buy_goods_dlv_edate','$maker_name', '$com_seq', '$buy_goods_coupon', '$buy_goods_user_level_discount',
                        '$buy_goods_status_type', '$buy_goods_status_msg', '$buy_goods_status_sdate', '$buy_goods_status_edate', '$buy_goods_open_market',
                        '$buy_goods_dlv_ok_mileage', '$buy_goods_add_cancel_type', '$checkout_product_order_id')";
                }

                $i++;
            }
        }
    }


    $db->query("INSERT INTO buy_goods (
                        buy_seq, cate_code, dlv_code, buy_goods_status, buy_goods_code, buy_goods_name,
                        buy_goods_prefix, buy_goods_suffix, buy_goods_option, buy_goods_cost_price, buy_goods_price, buy_goods_count,
                        buy_goods_price_total, buy_expect_mile, dlv_com_seq, buy_goods_dlv_method, buy_goods_dlv_type, buy_goods_dlv_value,
                        buy_goods_dlv_special, buy_goods_dlv_tag_no, buy_goods_dlv_fee, buy_goods_fee_proportion, buy_goods_dlv_fee_arrival,
                        buy_goods_arrival_proportion, buy_goods_dlv_fee_flag, buy_goods_memo, buy_goods_memo_gift, buy_goods_memo_admin,
                        buy_goods_dlv_sdate, buy_goods_dlv_edate, maker_name, com_seq, buy_goods_coupon, buy_goods_user_level_discount,
                        buy_goods_status_type, buy_goods_status_msg, buy_goods_status_sdate, buy_goods_status_edate, buy_goods_open_market,
                        buy_goods_dlv_ok_mileage, buy_goods_add_cancel_type, checkout_product_order_id)
                     VALUES $buy_goods_add_query");
} else {
    header("Content-Type: text/html; charset=UTF-8");
    echo '<script>alert("결제를 취소하였습니다.");location.href="/mypage.php";</script>';
    exit;
}
?>
<body class="home-1 checkout-page cart-page">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong>
        browser. Please
        <a href="http://browsehappy.com/">upgrade your browser
        </a>
        to improve your experience.<![endif]-->
    <!--header area start-->
    <!--header area end-->
    <!--breadcrumb area start-->
    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bread-crumb">
                        <h1 class="sin-page-title" style="text-align:left;">
                            <a href="index.php" style="font-size:20px;">BLUE START</a>
                            주문완료
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb area end-->
    <!-- checkout-area start -->
    <div class="checkout-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="checkbox-form">
                        <h3 class="col-md-12" style="margin:0px;padding-left:0px;border-bottom:none;margin-top:20px;">
                            구매하신 상품의 결제가 완료되였습니다.
                        </h3>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table borderless user-info">
                                    <tr>
                                        <th class="col-lg-3 col-md-3">입금금액</th>
                                        <td><?php echo $P_AMT; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>입금은행</th>
                                        <td> <?php echo $pay_online_account; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>계좌번호</th>
                                        <td> <?php echo $P_VACT_NUM; ?> </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="your-order">
                        <h3 style="margin:0px;margin-top:20px;">결제정보</h3>
                        <div class="your-order-table table-responsive">
                            <table class="table checkout-table checkout" style="border-top:2px solid #666;">
                                <thead>
                                    <th class="cross">주문금액</th>
                                    <th class="cross">배송비</th>
                                    <th class="cross">할인금액</th>
                                    <th>
                                        <span class="checkout-price">결제 금액</span>
                                    </th>
                                </thead>
                                <tbody>
                                    <?
                                    $bid = $db_basket_query[0]["v_oid"];
                                    $zipcode = $db_basket_query[0]["zipcode"];
                                    $user_id = $db_basket_query[0]["user_id"];
                                    $phone = $db_basket_query[0]["phone"];
                                    $oldadd = $db_basket_query[0]["add1"];
                                    $newadd = $db_basket_query[0]["add2"];
                                    $alladd = $db_basket_query[0]["add3"];
                                    $app_ip = $db_basket_query[0]["ipadd"];
                                    $ship_message = $db_basket_query[0]["ship_message"];
                                    $pay_dlv_fee = $db_basket_query[0]["pay_dlv_fee"];
                                    $buy_total_price = $db_basket_query[0]["buy_total_price"];//총상품총액(할인전금액);
                                    $buy_instant_discount = $db_basket_query[0]["buy_instant_discount"];//상품 즉시할인 금액(총 할인금액)
                                    $buy_user_tel = $db_basket_query[0]["buy_user_tel"];
                                    $buy_user_mobile = $db_basket_query[0]["buy_user_mobile"];
                                    $buy_user_email = $db_basket_query[0]["buy_user_email"];
                                    $uname = $db_basket_query[0]["id"];//id
                                    ?>
                                    <td><?= number_format($buy_total_price) ?>
                                        <span class="won">원</span>
                                    </td>
                                    <td class="cross">
                                        <i class="fa fa-plus-square"></i> <?= number_format($pay_dlv_fee) ?>
                                        <span class="won">원
                                        </span>
                                    </td>
                                    <td class="cross">
                                        <i class="fa fa-minus-square"></i> <?= number_format($buy_instant_discount) ?>
                                        <span class="won">원</span>
                                    </td>
                                    <td>
                                        <span
                                            class="checkout-price"><?= number_format($buy_total_price - $buy_instant_discount + $pay_dlv_fee) ?></span>
                                        <span class="won2">원
                                        </span>
                                    </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="your-order">
                        <div class="your-order-table table-responsive">
                            <table class="table" style="border-top:2px solid #666;margin-bottom: 30px;">
                                <tr>
                                    <td>
                                        <div class="order-button-payment">
                                            <input type="button" onclick="location.href='/'"
                                                   style="background-color:white;color:#333;border:1px solid #ccc;"
                                                   value="확인">
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;">
        <?php echo "OK"; ?>
    </div>
    <!-- checkout-area end -->
    <!--footer area start-->

    <!--footer area end-->

    <!-- JS -->

    <!-- jquery-1.11.3.min js
    ============================================ -->
    <script src="/js/vendor/jquery-1.11.3.min.js"></script>

    <!-- price-slider js -->
    <script src="/js/price-slider.js"></script>

    <!-- bootstrap js
            ============================================ -->
    <script src="/js/bootstrap.min.js"></script>

    <!-- nevo slider js
    ============================================ -->
    <script src="/js/jquery.nivo.slider.pack.js"></script>

    <!-- owl.carousel.min js
    ============================================ -->
    <script src="/js/owl.carousel.min.js"></script>

    <!-- count down js
    ============================================ -->
    <script src="/js/jquery.countdown.min.js" type="text/javascript"></script>

    <!--zoom plugin
    ============================================ -->
    <script src='/js/jquery.elevatezoom.js'></script>

    <!-- wow js
    ============================================ -->
    <script src="/js/wow.js"></script>

    <!--Mobile Menu Js
    ============================================ -->
    <script src="/js/jquery.meanmenu.js"></script>

    <!-- jquery.fancybox.pack js -->
    <script src="/js/fancybox/jquery.fancybox.pack.js"></script>

    <!-- jquery.scrollUp js
    ============================================ -->
    <script src="/js/jquery.scrollUp.min.js"></script>

    <!-- jquery.collapse js
    ============================================ -->
    <script src="/js/jquery.collapse.js"></script>

    <!-- mixit-up js
            ============================================ -->
    <script src="/js/jquery.mixitup.min.js"></script>

    <!-- plugins js
    ============================================ -->
    <script src="/js/plugins.js"></script>

    <!-- main js
    ============================================ -->
    <script src="/js/main.js"></script>
</body></html>
<?php
$db->disconnect();
?>
