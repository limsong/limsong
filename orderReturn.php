<?php
include_once ("session.php");
include_once("doctype.php");
require_once('libs/INIStdPayUtil.php');
require_once('libs/HttpClient.php');
$util = new INIStdPayUtil();

try {
    //#############################
    // 인증결과 파라미터 일괄 수신
    //#############################
    //		$var = $_REQUEST["data"];
    //		System.out.println("paramMap : "+ paramMap.toString());
    //#####################
    // 인증이 성공일 경우만
    //#####################
    if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

        //echo "####인증성공/승인요청####";
        //echo "<br/>";
        //############################################
        // 1.전문 필드 값 설정(***가맹점 개발수정***)
        //############################################

        $mid = $_REQUEST["mid"];     // 가맹점 ID 수신 받은 데이터로 설정

        $signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 키(이니라이트키) (가맹점 수정후 고정) !!!절대!! 전문 데이터로 설정금지

        $timestamp = $util->getTimestamp();   // util에 의해서 자동생성

        $charset = "UTF-8";        // 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)

        $format = "JSON";        // 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)
        // 추가적 noti가 필요한 경우(필수아님, 공백일 경우 미발송, 승인은 성공시, 실패시 모두 Noti발송됨) 미사용
        //String notiUrl	= "";

        $authToken = $_REQUEST["authToken"];   // 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)

        $authUrl = $_REQUEST["authUrl"];    // 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)

        $netCancel = $_REQUEST["netCancelUrl"];   // 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

        //#####################
        // 2.signature 생성
        //#####################
        $signParam["authToken"] = $authToken;  // 필수
        $signParam["timestamp"] = $timestamp;  // 필수
        // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
        $signature = $util->makeSignature($signParam);

        $price = ""; // 가맹점에서 최종 결제 가격 표기 (필수입력)

        //#####################
        // 3.API 요청 전문 생성
        //#####################
        $authMap["mid"] = $mid;   // 필수
        $authMap["authToken"] = $authToken; // 필수
        $authMap["signature"] = $signature; // 필수
        $authMap["timestamp"] = $timestamp; // 필수
        $authMap["charset"] = $charset;  // default=UTF-8
        $authMap["format"] = $format;  // default=XML
        $authMap["price"] = $price;  //  필수 (가격위변조체크기능)
        //if(null != notiUrl && notiUrl.length() > 0){
        //	authMap.put("notiUrl"		,notiUrl);
        //}


        try {

            $httpUtil = new HttpClient();

            //#####################
            // 4.API 통신 시작
            //#####################

            $authResultString = "";
            if ($httpUtil->processHTTP($authUrl, $authMap)) {
                $authResultString = $httpUtil->body;
            } else {
                echo "Http Connect Error\n";
                echo $httpUtil->errormsg;

                throw new Exception("Http Connect Error");
            }

            //############################################################
            //5.API 통신결과 처리(***가맹점 개발수정***)
            //############################################################
            //echo "## 승인 API 결과 ##";

            $resultMap = json_decode($authResultString, true);

            #echo "<br>YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY<br>";
            //print_r($resultMap);
            #echo "<br>YYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY";

            $str .= "<table width='100%' class='table borderless user-info'>";

            if (strcmp("0000", $resultMap["resultCode"]) == 0) {
                /*                         * ***************************************************************************
                 * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.

                  [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
                  처리중 에러 발생시 망취소를 한다.
                 * **************************************************************************** */
                $app_time = $resultMap["applTime"];//승인시간 131805
                $app_date = $resultMap["applDate"];//2016411
                $app_method = $resultMap["payMethod"];//Card
                $app_device = $resultMap["payDevice"];//pc
                $app_card_code = $resultMap["CARD_Code"];//01  카드 종류
                $app_email = $resultMap["buyerEmail"];//email
                $app_card_num = $resultMap["CARD_Num"];//411904*********3
                $app_price = $resultMap["applPrice"];//1000결제금액
                $app_purchaseName = $resultMap["CARD_PurchaseName"];//외환계열
                $app_tel = $resultMap["buyerTel"];//010-5387-4806 주문인 전화번호
                $app_card_bankcode = $resultMap["CARD_BankCode"];//05 카드 발급사
                $app_pay_seq = $resultMap["tid"];
                $app_oid = $resultMap["MOID"];
                $pay_price_mile = 0;//결제금액 적립금
                $app_ip = get_real_ip();

                $db->query("SELECT * FROM basket WHERE ordernum='$P_OID'");
                $db_basket_query = $db->loadRows();

                $date = date("Y-m-d H:i:s", strtotime($P_AUTH_DT));
                $bid = $db_basket_query[0]["v_oid"];
                $zipcode = $db_basket_query[0]["zipcode"];
                $user_id = $db_basket_query[0]["user_id"];//수령인 이름
                $buy_dlv_name = $user_id;
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
                $buy_goods_type = $db_basket_query[0]["goods_type"];
                $new_add = $db_basket_query[0]["new_addr"];
                if ($new_add == "y") {
                    $db->query("INSERT INTO user_address (user_id,user_name,zipcode,addr1,addr2,addr3,phone) values ('$uname','$user_id','$zipcode','$oldadd','$newadd','$alladd','$buy_user_mobile')");
                }


                $date = date("Y-m-d H:i:s");
                $bid = $_SESSION[$app_oid . "_bid"];
                /*$zipcode = $_SESSION[$app_oid . "_zipcode"];
                $user_id = $_SESSION[$app_oid . "_user_id"];
                $phone = $_SESSION[$app_oid . "_phone"];
                $oldadd = $_SESSION[$app_oid . "_oldadd"];
                $newadd = $_SESSION[$app_oid . "_newadd"];
                $alladd = $_SESSION[$app_oid . "_alladd"];
                $buy_goods_type = $_SESSION[$orderNumber . "_buy_goods_type"];*/

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

                $ship_message = $_SESSION[$app_oid . "_ship_message"];
                if ($app_method == "Card") {
                    $buy_status = "2";
                    $app_method = "2";
                    $pay_mesg = "결제완료";
                    $payMethod = "카드";

                    $pay_date = date("Y-m-d H:i:s", strtotime($resultMap["applDate"]));//결제완료일
                } elseif ($app_method == "VBank") {//가상계좌
                    $buy_status = "1";
                    $app_method = "64";
                    $pay_mesg = "입금하실 금액";
                    $payMethod = "가상계좌";
                    $pay_online_name = $resultMap["VACT_InputName"];//송금자
                    $pay_online_account = $resultMap["vactBankName"] . " | " . $resultMap["VACT_Num"];//입금은행명 입금계좌
                    $pay_pre_date = date("Y-m-d", strtotime($resultMap["VACT_Date"])) . " " . date("H:i:s", strtotime($resultMap["VACT_Time"]));//입금예정일
                    //$pay_date = date("Y-m-d H:i:s", strtotime($resultMap["applDate"]));//결제완료일
                } elseif ($app_method == "DirectBank") {//실시간 게좌이체
                    $buy_status = "2";
                    $app_method = "32";
                    $pay_mesg = "결제완료";
                    $payMethod = "실시간계좌이체";
                    $pay_online_name = $resultMap["VACT_InputName"];//송금자
                    $pay_online_account = vbankCode($resultMap["ACCT_BankCode"]);//입금은행명 입금계좌
                    //$resultMap["CSHR_ResultCode"];//
                    //$resultMap["CSHR_Type"];//현금영수증 발급코드구분 (0:소득공제용 1:지출증빙용);
                    $pay_date = date("Y-m-d H:i:s", strtotime($resultMap["applDate"]));
                }


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
                $user_id = $uname;
                $buy_code = $app_oid;
                $buy_date = $date;
                $buy_total_price = $_SESSION[$app_oid . "_buy_total_price"];//총상품총액(할인전금액);
                $buy_expect_mile = "";
                $pay_seq = $app_pay_seq;
                $pay_method = $app_method;
                $pay_price_normal = "";
                //$pay_date = $date;//위에있음
                $pay_info_no = $app_card_num;
                $buy_memo = $ship_message;
                $buy_user_name = $_SESSION[$app_oid . "_user_id"];
                $buy_user_tel = $app_tel;
                $buy_user_mobile = $app_tel;
                $buy_user_email = $app_email;
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
                $buy_instant_discount = $_SESSION[$app_oid . "_buy_instant_discount"];//상품 즉시할인 금액(총 할인금액)
                $buy_mile_amount = "";
                $pay_dlv_fee = $_SESSION[$app_oid . "_pay_dlv_fee"];
                $buy_mobile = $resultMap["PayDevice"];


                $db->query("INSERT INTO buy (
                            user_id,buy_code,buy_status,buy_goods_type,buy_date,buy_total_price,buy_expect_mile,pay_seq,pay_method,pay_price_normal,pay_dlv_fee,pay_price_mile,pay_pre_date
                            ,pay_date,pay_online_name,pay_online_account,pay_info_no,buy_memo,buy_user_name,buy_user_tel,buy_user_mobile,buy_user_email,buy_user_ip,buy_dlv_name,buy_dlv_tel,buy_dlv_mobile
                            ,buy_dlv_email,buy_dlv_zipcode,buy_dlv_addr_base,buy_dlv_addr_etc,buy_dlv_pre_date,coupon_data_seq,buy_bill_type,buy_instant_discount,buy_mile_amount,buy_mobile)
                            VALUES
                            ('$user_id','$buy_code','$buy_status','$buy_goods_type','$buy_date','$buy_total_price','$buy_expect_mile','$pay_seq','$pay_method','$pay_price_normal','$pay_dlv_fee','$pay_price_mile','$pay_pre_date',
                            '$pay_date','$pay_online_name','$pay_online_account','$pay_info_no','$buy_memo','$buy_user_name','$buy_user_tel','$buy_user_mobile','$buy_dlv_email','$buy_user_ip','$buy_dlv_name','$buy_dlv_tel','$buy_dlv_mobile',
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


                        $db->query("SELECT goods_name,sb_sale,sellPrice,goods_type,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_num,manufacture FROM goods WHERE goods_code='$goods_code'");
                        $goods_value_query = $db->loadRows();
                        $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
                        $goods_name = $goods_value_query[0]["goods_name"];
                        $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];//배송유형 1:무료 2:고정
                        $goods_opt_type = $goods_value_query[0]["goods_opt_type"];//가격선택옵션(2) 일반옵션(1) 옵션없음 구분(0)
                        $goods_opt_num = $goods_value_query[0]["goods_opt_num"];//가격선택옵션 2,3 구분
                        $goods_sellPrice = $goods_value_query[0]["sellPrice"];//단가
                        $manufacture = $goods_value_query[0]["manufacture"];//제조사
                        $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];


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
                            $opName3 = "";
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
                            $buy_goods_prefix = "";
                            $buy_goods_suffix = "";
                            $opName3 = "";
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
                            $buy_goods_prefix = "";
                            $buy_goods_suffix = "";
                            $opName3 = "";
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


                    $db->query("SELECT goods_name,sb_sale,sellPrice,goods_type,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_num,manufacture FROM goods WHERE goods_code='$goods_code'");
                    $goods_value_query = $db->loadRows();
                    $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
                    $goods_name = $goods_value_query[0]["goods_name"];
                    $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];//배송유형 1:무료 2:고정
                    $goods_opt_type = $goods_value_query[0]["goods_opt_type"];//가격선택옵션(2) 일반옵션(1) 옵션없음 구분(0)
                    $goods_opt_num = $goods_value_query[0]["goods_opt_num"];//가격선택옵션 2,3 구분
                    $goods_sellPrice = $goods_value_query[0]["sellPrice"];//단가
                    $manufacture = $goods_value_query[0]["manufacture"];//제조사
                    $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];


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
                        $opName3 = "";
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
                        $buy_goods_prefix = "";
                        $buy_goods_suffix = "";
                        $opName3 = "";
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

            }

            //공통 부분만
            /*$str .= "<tr>

                        <th class='col-lg-3 col-md-3'>거래 번호</th>
                        <td class='td02'>" . @(in_array($resultMap["tid"], $resultMap) ? $resultMap["tid"] : "null") . "</td></tr>

                        <tr><th class='col-lg-3 col-md-3'>결제방법(지불수단)</th>
                        <td class='td02'>" . $payMethod . "</td></tr>

                        <tr><th class='col-lg-3 col-md-3'>결과 코드</th>
                        <td class='td02'>" . @(in_array($resultMap["resultCode"], $resultMap) ? $resultMap["resultCode"] : "null") . "</td></tr>

                        <tr><th class='col-lg-3 col-md-3'>결과 내용</th>
                        <td class='td02'>" . @(in_array($resultMap["resultMsg"], $resultMap) ? $resultMap["resultMsg"] : "null") . "</td></tr>

                        <tr><th class='col-lg-3 col-md-3'>" . $pay_mesg . "</th>
                        <td class='td02'>" . @(in_array($resultMap["TotPrice"], $resultMap) ? $resultMap["TotPrice"] : "null") . "원</td></tr>
                        <tr><th class='col-lg-3 col-md-3'>주문 번호</th>
                        <td class='td02'>" . @(in_array($resultMap["MOID"], $resultMap) ? $resultMap["MOID"] : "null") . "</td></tr>
                        <tr><th class='col-lg-3 col-md-3'>승인날짜</th>
                        <td class='td02'>" . date("Y-m-d", strtotime($resultMap["applDate"])) . "</td></tr>

                        <tr><th class='col-lg-3 col-md-3'>승인시간</th>
                        <td class='td02'>" . @(in_array($resultMap["applTime"], $resultMap) ? $resultMap["applTime"] : "null") . "</td>

                        </tr>";*/
            $str .= "<tr>
                        <tr><th class='col-lg-3 col-md-3'>결제방법(지불수단)</th>
                        <td class='td02'>" . $payMethod . "</td></tr>
                        
                        <tr><th class='col-lg-3 col-md-3'>결과 내용</th>
                        <td class='td02'>" . @(in_array($resultMap["resultMsg"], $resultMap) ? $resultMap["resultMsg"] : "null") . "</td></tr>

                        <tr><th class='col-lg-3 col-md-3'>" . $pay_mesg . "</th>
                        <td class='td02'>" . @(in_array($resultMap["TotPrice"], $resultMap) ? $resultMap["TotPrice"] : "null") . "원</td></tr>
                        <tr><th class='col-lg-3 col-md-3'>승인날짜</th>
                        <td class='td02'>" . date("Y-m-d", strtotime($resultMap["applDate"])) . "</td></tr>

                        <tr><th class='col-lg-3 col-md-3'>승인시간</th>
                        <td class='td02'>" . date("H:i:s", strtotime($resultMap["applTime"])) . "</td>

                        </tr>";

            if (isset($resultMap["payMethod"]) && strcmp("VBank", $resultMap["payMethod"]) == 0) { //가상계좌
                $str .= "<tr><th class='col-lg-3 col-md-3'>입금 계좌번호</th>
                            <td class='td02'>" . @(in_array($resultMap["VACT_Num"], $resultMap) ? $resultMap["VACT_Num"] : "null") . "</td></tr>

                            <tr><th class='col-lg-3 col-md-3'>입금 은행코드</th>
                            <td class='td02'>" . @(in_array($resultMap["VACT_BankCode"], $resultMap) ? $resultMap["VACT_BankCode"] : "null") . "</td></tr>

                            <tr><th class='col-lg-3 col-md-3'>입금 은행명</th>
                            <td class='td02'>" . @(in_array($resultMap["vactBankName"], $resultMap) ? $resultMap["vactBankName"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>예금주 명</th>
                            <td class='td02'>" . @(in_array($resultMap["VACT_Name"], $resultMap) ? $resultMap["VACT_Name"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>송금자 명</th>
                            <td class='td02'>" . @(in_array($resultMap["VACT_InputName"], $resultMap) ? $resultMap["VACT_InputName"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>송금 일자</th>
                            <td class='td02'>" . date("Y-m-d", strtotime($resultMap["VACT_Date"])) . " 까지</td></tr>

                            <tr><th class='col-lg-3 col-md-3'>송금 시간</th>
                            <td class='td02'>" . @(in_array($resultMap["VACT_Time"], $resultMap) ? $resultMap["VACT_Time"] : "null") . "</td>
                            
                            </tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("DirectBank", $resultMap["payMethod"]) == 0) { //실시간계좌이체
                $str .= "<tr><th class='col-lg-3 col-md-3'>은행코드</th>
                            <td class='td02'>" . @(in_array($resultMap["ACCT_BankCode"], $resultMap) ? $resultMap["ACCT_BankCode"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>현금영수증 발급결과코드</th>
                            <td class='td02'>" . @(in_array($resultMap["CSHR_ResultCode"], $resultMap) ? $resultMap["CSHR_ResultCode"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>현금영수증 발급구분코드 <font color=red><b>(0 - 소득공제용, 1 - 지출증빙용)</b></font></th>
                            <td class='td02'>" . @(in_array($resultMap["CSHR_Type"], $resultMap) ? $resultMap["CSHR_Type"] : "null") . "</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("HPP", $resultMap["payMethod"]) == 0) { //휴대폰
                $str .= "<tr><th class='col-lg-3 col-md-3'>통신사</th>
                            <td class='td02'>" . @(in_array($resultMap["HPP_Corp"], $resultMap) ? $resultMap["HPP_Corp"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>결제장치</th>
                            <td class='td02'>" . @(in_array($resultMap["payDevice"], $resultMap) ? $resultMap["payDevice"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>휴대폰번호</th>
                            <td class='td02'>" . @(in_array($resultMap["HPP_Num"], $resultMap) ? $resultMap["HPP_Num"] : "null") . "</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("KWPY", $resultMap["payMethod"]) == 0) { //뱅크월렛 카카오
                $str .= "<tr><th class='col-lg-3 col-md-3'>휴대폰번호</th>
                                <td class='td02'>" . @(in_array($resultMap["KWPY_CellPhone"], $resultMap) ? $resultMap["KWPY_CellPhone"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>거래금액</th>
                                <td class='td02'>" . @(in_array($resultMap["KWPY_SalesAmount"], $resultMap) ? $resultMap["KWPY_SalesAmount"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>공급가액</th>
                                <td class='td02'>" . @(in_array($resultMap["KWPY_Amount"], $resultMap) ? $resultMap["KWPY_Amount"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>부가세</th>
                                <td class='td02'>" . @(in_array($resultMap["KWPY_Tax"], $resultMap) ? $resultMap["KWPY_Tax"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>봉사료</th>
                                <td class='td02'>" . @(in_array($resultMap["KWPY_ServiceFee"], $resultMap) ? $resultMap["KWPY_ServiceFee"] : "null") . "</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("DGCL", $resultMap["payMethod"]) == 0) { //게임문화상품권
                $sum = "0";
                $sum2 = "0";
                $sum3 = "0";
                $sum4 = "0";
                $sum5 = "0";
                $sum6 = "0";

                $str .= "<tr><th class='col-lg-3 col-md-3'>게임문화상품권승인금액</th>
                            <td class='td02'>" . @(in_array($resultMap["GAMG_ApplPrice"], $resultMap) ? $resultMap["GAMG_ApplPrice"] : "null") . "원</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>사용한 카드수</th>
                            <td class='td02'>" . @(in_array($resultMap["GAMG_Cnt"], $resultMap) ? $resultMap["GAMG_Cnt"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>사용한 카드번호</th>
                            <td class='td02'>" . @(in_array($resultMap["GAMG_Num1"], $resultMap) ? $resultMap["GAMG_Num1"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>카드잔액</th>
                            <td class='td02'>" . @(in_array($resultMap["GAMG_Price1"], $resultMap) ? $resultMap["GAMG_Price1"] : "null") . "원</td></tr>";
                if (!strcmp("", $resultMap["GAMG_Num2"]) == 0) {
                    $str .= "<tr><th class='col-lg-3 col-md-3'>사용한 카드번호</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Num2"], $resultMap) ? $resultMap["GAMG_Num2"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>카드잔액</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Price2"], $resultMap) ? $resultMap["GAMG_Price2"] : "null") . "원</td></tr>";
                }
                if (!strcmp("", $resultMap["GAMG_Num3"]) == 0) {

                    $str .= "<tr><th class='col-lg-3 col-md-3'>사용한 카드번호</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Num3"], $resultMap) ? $resultMap["GAMG_Num3"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>카드잔액</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Price3"], $resultMap) ? $resultMap["GAMG_Price3"] : "null") . "원</td></tr>";
                }
                if (!strcmp("", $resultMap["GAMG_Num4"]) == 0) {

                    $str .= "<tr><th class='col-lg-3 col-md-3'>사용한 카드번호</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Num4"], $resultMap) ? $resultMap["GAMG_Num4"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>카드잔액</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Price4"], $resultMap) ? $resultMap["GAMG_Price4"] : "null") . "원</td></tr>";
                }
                if (!strcmp("", $resultMap["GAMG_Num5"]) == 0) {

                    $str .= "<tr><th class='col-lg-3 col-md-3'>사용한 카드번호</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Num5"], $resultMap) ? $resultMap["GAMG_Num5"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>카드잔액</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Price5"], $resultMap) ? $resultMap["GAMG_Price5"] : "null") . "원</td></tr>";
                }
                if (!strcmp("", $resultMap["GAMG_Num6"]) == 0) {

                    $str .= "<tr><th class='col-lg-3 col-md-3'>사용한 카드번호</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Num6"], $resultMap) ? $resultMap["GAMG_Num6"] : "null") . "</td></tr>
                                <tr><th class='col-lg-3 col-md-3'>카드잔액</th>
                                <td class='td02'>" . @(in_array($resultMap["GAMG_Price6"], $resultMap) ? $resultMap["GAMG_Price6"] : "null") . "원</td></tr>";
                }
            } else if (isset($resultMap["payMethod"]) && strcmp("OCBPoint", $resultMap["payMethod"]) == 0) { //오케이 캐쉬백
                $str .= "<tr><th class='col-lg-3 col-md-3'>지불구분</th>
                            <td class='td02'>" . @(in_array($resultMap["PayOption"], $resultMap) ? $resultMap["PayOption"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>결제완료금액2</th>
                            <td class='td02'>" . @(in_array($resultMap["applPrice"], $resultMap) ? $resultMap["applPrice"] : "null") . "원</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>OCB 카드번호</th>
                            <td class='td02'>" . @(in_array($resultMap["OCB_Num"], $resultMap) ? $resultMap["OCB_Num"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>적립 승인번호</th>
                            <td class='td02'>" . @(in_array($resultMap["OCB_SaveApplNum"], $resultMap) ? $resultMap["OCB_SaveApplNum"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>사용 승인번호</th>
                            <td class='td02'>" . @(in_array($resultMap["OCB_PayApplNum"], $resultMap) ? $resultMap["OCB_PayApplNum"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>OCB 지불 금액</th>
                            <td class='td02'>" . @(in_array($resultMap["OCB_PayPrice"], $resultMap) ? $resultMap["OCB_PayPrice"] : "null") . "</td></tr>";
            } else if (isset($resultMap["payMethod"]) && (strcmp("GSPT", $resultMap["payMethod"]) == 0)) { //GSPoint
                $str .= "<tr><th class='col-lg-3 col-md-3'>지불구분</th>
                            <td class='td02'>" . @(in_array($resultMap["PayOption"], $resultMap) ? $resultMap["PayOption"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>GS 포인트 승인금액</th>
                            <td class='td02'>" . @(in_array($resultMap["GSPT_ApplPrice"], $resultMap) ? $resultMap["GSPT_ApplPrice"] : "null") . "원</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>GS 포인트 적립금액</th>
                            <td class='td02'>" . @(in_array($resultMap["GSPT_SavePrice"], $resultMap) ? $resultMap["GSPT_SavePrice"] : "null") . "원</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>GS 포인트 지불금액</th>
                            <td class='td02'>" . @(in_array($resultMap["GSPT_PayPrice"], $resultMap) ? $resultMap["GSPT_PayPrice"] : "null") . "원</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("UPNT", $resultMap["payMethod"]) == 0) {  //U-포인트
                $str .= "<tr><th class='col-lg-3 col-md-3'>U포인트 카드번호</th>
                            <td class='td02'>" . @(in_array($resultMap["UPoint_Num"], $resultMap) ? $resultMap["UPoint_Num"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>가용포인트</th>
                            <td class='td02'>" . @(in_array($resultMap["UPoint_usablePoint"], $resultMap) ? $resultMap["UPoint_usablePoint"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>포인트지불금액</th>
                            <td class='td02'>" . @(in_array($resultMap["UPoint_ApplPrice"], $resultMap) ? $resultMap["UPoint_ApplPrice"] : "null") . "</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("KWPY", $resultMap["payMethod"]) == 0) {  //뱅크월렛 카카오
                $str .= "<tr><th class='col-lg-3 col-md-3'>결제방법</th>
                            <td class='td02'>" . @(in_array($resultMap["payMethod"], $resultMap) ? $resultMap["payMethod"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>결과 코드</th>
                            <td class='td02'>" . @(in_array($resultMap["resultCode"], $resultMap) ? $resultMap["resultCode"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>결과 내용</th>
                            <td class='td02'>" . @(in_array($resultMap["resultMsg"], $resultMap) ? $resultMap["resultMsg"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>거래 번호</th>
                            <td class='td02'>" . @(in_array($resultMap["tid"], $resultMap) ? $resultMap["tid"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>주문 번호</th>
                            <td class='td02'>" . @(in_array($resultMap["orderNumber"], $resultMap) ? $resultMap["orderNumber"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>결제완료금액3</th>
                            <td class='td02'>" . @(in_array($resultMap["price"], $resultMap) ? $resultMap["price"] : "null") . "원</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>사용일자</th>
                            <td class='td02'>" . @(in_array($resultMap["applDate"], $resultMap) ? $resultMap["applDate"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>사용시간</th>
                            <td class='td02'>" . @(in_array($resultMap["applTime"], $resultMap) ? $resultMap["applTime"] : "null") . "</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("YPAY", $resultMap["payMethod"]) == 0) { //엘로우 페이
                //별도 응답 필드 없음
            } else if (isset($resultMap["payMethod"]) && strcmp("TEEN", $resultMap["payMethod"]) == 0) { //틴캐시
                $str .= "<tr><th class='col-lg-3 col-md-3'>틴캐시 승인번호</th>
                            <td class='td02'>" . @(in_array($resultMap["TEEN_ApplNum"], $resultMap) ? $resultMap["TEEN_ApplNum"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>틴캐시아이디</th>
                            <td class='td02'>" . @(in_array($resultMap["TEEN_UserID"], $resultMap) ? $resultMap["TEEN_UserID"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>틴캐시승인금액</th>
                            <td class='td02'>" . @(in_array($resultMap["TEEN_ApplPrice"], $resultMap) ? $resultMap["TEEN_ApplPrice"] : "null") . "원</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("Bookcash", $resultMap["payMethod"]) == 0) { //도서문화상품권
                $str .= "<tr><th class='col-lg-3 col-md-3'>도서상품권 승인번호</th>
                            <td class='td02'>" . @(in_array($resultMap["BCSH_ApplNum"], $resultMap) ? $resultMap["BCSH_ApplNum"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>도서상품권 사용자ID</th>
                            <td class='td02'>" . @(in_array($resultMap["BCSH_UserID"], $resultMap) ? $resultMap["BCSH_UserID"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>도서상품권 승인금액</th>
                            <td class='td02'>" . @(in_array($resultMap["BCSH_ApplPrice"], $resultMap) ? $resultMap["BCSH_ApplPrice"] : "null") . "원</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("PhoneBill", $resultMap["payMethod"]) == 0) { //폰빌전화결제
                $str .= "<tr><th class='col-lg-3 col-md-3'>승인전화번호</th>
                                                                        <td class='td02'>" . @(in_array($resultMap["PHNB_Num"], $resultMap) ? $resultMap["PHNB_Num"] : "null") . "</td></tr>";
            } else if (isset($resultMap["payMethod"]) && strcmp("Bill", $resultMap["payMethod"]) == 0) { //빌링결제
                $str .= "<tr><th class='col-lg-3 col-md-3'>빌링키</th>
                            <td class='td02'>" . @(in_array($resultMap["CARD_BillKey"], $resultMap) ? $resultMap["CARD_BillKey"] : "null") . "</td></tr>";
            } else { //카드
//					int  quota=Integer.parseInt(resultMap.get("CARD_Quota"));
                if (isset($resultMap["EventCode"]) && !is_null($resultMap["EventCode"])) {
                    $str .= "<tr><th class='col-lg-3 col-md-3'>이벤트 코드</th>
                            <td class='td02'>" . @(in_array($resultMap["EventCode"], $resultMap) ? $resultMap["EventCode"] : "null") . "</td></tr>";
                }
                $str .= "<tr><th class='col-lg-3 col-md-3'>카드번호</th>
                            <td class='td02'>" . @(in_array($resultMap["CARD_Num"], $resultMap) ? $resultMap["CARD_Num"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>할부기간</th>
                            <td class='td02'>" . @(in_array($resultMap["CARD_Quota"], $resultMap) ? $resultMap["CARD_Quota"] : "null") . "</td></tr>";
                if (isset($resultMap["EventCode"]) && isset($resultMap["CARD_Interest"]) && (strcmp("1", $resultMap["CARD_Interest"]) == 0 || strcmp("1", $resultMap["EventCode"]) == 0)) {
                    $str .= "<tr><th class='col-lg-3 col-md-3'>할부 유형</th>";
                } else if (isset($resultMap["CARD_Interest"]) && !strcmp("1", $resultMap["CARD_Interest"]) == 0) {
                    $str .= "<tr><th class='col-lg-3 col-md-3'>할부 유형</th>
									                <td class='td02'>유이자 <font color='red'> *유이자로 표시되더라도 EventCode 및 EDI에 따라 무이자 처리가 될 수 있습니다.</font></td></tr>";
                }
                if (isset($resultMap["point"]) && strcmp("1", $resultMap["point"]) == 0) {
                    $str .= "<td class='td02'></td></tr>
                            <tr><th class='col-lg-3 col-md-3'>포인트 사용 여부</th>
                            <td class='td02'>사용</td></tr>";
                } else {
                    $str .= "<td class='td02'></td></tr>
                            <tr><th class='col-lg-3 col-md-3'>포인트 사용 여부</th>
                            <td class='td02'>미사용</td></tr>";
                }
                $str .= "<tr><th class='col-lg-3 col-md-3'>카드 종류</th>
                            <td class='td02'>" . @(in_array($resultMap["CARD_Code"], $resultMap) ? $resultMap["CARD_Code"] : "null") . "</td></tr>
                            <tr><th class='line' colspan='2'></th></tr>
                            <tr><th class='col-lg-3 col-md-3'>카드 발급사</th>
                            <td class='td02'>" . @(in_array($resultMap["CARD_BankCode"], $resultMap) ? $resultMap["CARD_BankCode"] : "null") . "</td></tr>";

                if (isset($resultMap["OCB_Num"]) && !is_null($resultMap["OCB_Num"]) && !empty($resultMap["OCB_Num"])) {
                    $str .= "<tr><th class='col-lg-3 col-md-3'>OK CASHBAG 카드번호</th>
                            <td class='td02'>" . @(in_array($resultMap["OCB_Num"], $resultMap) ? $resultMap["OCB_Num"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>OK CASHBAG 적립 승인번호</th>
                            <td class='td02'>" . @(in_array($resultMap["OCB_SaveApplNum"], $resultMap) ? $resultMap["OCB_SaveApplNum"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>OK CASHBAG 포인트지불금액</th>
                            <td class='td02'>" . @(in_array($resultMap["OCB_PayPrice"], $resultMap) ? $resultMap["OCB_PayPrice"] : "null") . "</td></tr>";
                }
                if (isset($resultMap["GSPT_Num"]) && !is_null($resultMap["GSPT_Num"]) && !empty($resultMap["GSPT_Num"])) {
                    $str .= "<tr><th class='col-lg-3 col-md-3'>GS&Point 카드번호</th>
                            <td class='td02'>" . @(in_array($resultMap["GSPT_Num"], $resultMap) ? $resultMap["GSPT_Num"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>GS&Point 잔여한도</th>
                            <td class='td02'>" . @(in_array($resultMap["GSPT_Remains"], $resultMap) ? $resultMap["GSPT_Remains"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>GS&Point 승인금액</th>
                            <td class='td02'>" . @(in_array($resultMap["GSPT_ApplPrice"], $resultMap) ? $resultMap["GSPT_ApplPrice"] : "null") . "</td></tr>";
                }
                if (isset($resultMap["UNPT_CardNum"]) && !is_null($resultMap["UNPT_CardNum"]) && !empty($resultMap["UNPT_CardNum"])) {
                    $str .= "<tr><th class='col-lg-3 col-md-3'>U-Point 카드번호</th>
                            <td class='td02'>" . @(in_array($resultMap["UNPT_CardNum"], $resultMap) ? $resultMap["UNPT_CardNum"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>U-Point 가용포인트</th>
                            <td class='td02'>" . @(in_array($resultMap["UPNT_UsablePoint"], $resultMap) ? $resultMap["UPNT_UsablePoint"] : "null") . "</td></tr>
                            <tr><th class='col-lg-3 col-md-3'>U-Point 포인트지불금액</th>
                            <td class='td02'>" . @(in_array($resultMap["UPNT_PayPrice"], $resultMap) ? $resultMap["UPNT_PayPrice"] : "null") . "</td></tr>";
                }
            }
            $str .= "</table>
                            <span style='padding-left : 100px;'>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<!--input type='button' value='거래취소' onclick='cancelTid()' style='width : 50px ; height : 40px; font-size= 10pt; margin : 0 auto;' /-->
                            </span>
                            <form name='frm' method='post'> 
                            <input type='hidden' name='tid' value='" . @(in_array($resultMap["tid"], $resultMap) ? $resultMap["tid"] : "null") . "'/>
                            </form>	";
            // 수신결과를 파싱후 resultCode가 "0000"이면 승인성공 이외 실패
            // 가맹점에서 스스로 파싱후 내부 DB 처리 후 화면에 결과 표시
            // payViewType을 popup으로 해서 결제를 하셨을 경우
            // 내부처리후 스크립트를 이용해 opener의 화면 전환처리를 하세요
            //throw new Exception("강제 Exception");
        } catch (Exception $e) {
            //    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            //####################################
            // 실패시 처리(***가맹점 개발수정***)
            //####################################
            //---- db 저장 실패시 등 예외처리----//
            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            echo $s;
            //#####################
            // 망취소 API
            //#####################
            $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)
            if ($httpUtil->processHTTP($netCancel, $authMap)) {
                $netcancelResultString = $httpUtil->body;
            } else {
                echo "Http Connect Error\n";
                echo $httpUtil->errormsg;
                throw new Exception("Http Connect Error");
            }
            echo "## 망취소 API 결과 ##";
            $netcancelResultString = str_replace("<", "&lt;", $$netcancelResultString);
            $netcancelResultString = str_replace(">", "&gt;", $$netcancelResultString);
            echo "<pre>", $netcancelResultString . "</pre>";
            // 취소 결과 확인
        }
    } else {
        //#############
        // 인증 실패시
        //#############

    }
} catch (Exception $e) {
    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
    echo $s;
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
                            <a href="index.php" style="font-size:20px;">BLUE START
                            </a>
                            <?php
                            if (strcmp("0000", $resultMap["resultCode"]) == 0) {
                                echo "주문완료";
                            } else {
                                echo "인증실패";
                            }
                            ?>
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
                    <?php
                    if (strcmp("0000", $resultMap["resultCode"]) == 0) {
                        //print_r($resultMap);
                        echo $str;
                        //var_dump($_REQUEST);
                    } else {
                        //var_dump($_REQUEST);
                        echo "결제 실패 하였습니다.";
                    }


                    ?>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="your-order">
                        <h3 style="margin:0px;">주문상품</h3>
                        <div class="container-fluid no-padding">
                            <div class="row cart-top">
                                <div class="col-md-12">
                                    <div class="table-responsive cart-area-wrapper">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <td colspan="5">상품/옵션정보</td>
                                                    <td>상품금액</td>
                                                    <td>배송비</td>
                                                </tr>
                                            </thead>
                                            <?php

                                            if ($bid != "") {
                                                $db->query("SELECT uid,v_oid,goods_code,sbid,sbnum,opid,opnum,signdate FROM basket $basketQuery AND id='$uname' ORDER BY uid ASC");
                                                $dbdata2 = $db->loadRows();
                                                foreach ($dbdata2 as $key => $vv) {
                                                    $sbid = $vv["sbid"];
                                                    $sbidArr = explode(",", $sbid);
                                                    $sbnum = $vv["sbnum"];
                                                    $sbnumArr = explode(",", $sbnum);
                                                    $goods_code = $vv["goods_code"];
                                                    $pay_goods_name .= $vv["goods_name"];
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
                                                    $opid = $vv["opid"];
                                                    $opidArr = explode(",", $opid);
                                                    $opnum = $vv["opnum"];
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


                                                    $db->query("SELECT goods_name,sb_sale,sellPrice,goods_type,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$goods_code'");
                                                    $goods_value_query = $db->loadRows();
                                                    $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
                                                    $goods_name = $goods_value_query[0]["goods_name"];
                                                    $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];
                                                    $goods_opt_type = $goods_value_query[0]["goods_opt_type"];
                                                    $goods_opt_num = $goods_value_query[0]["goods_opt_num"];
                                                    $goods_sellPrice = $goods_value_query[0]["sellPrice"];
                                                    $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];
                                                    $goods_type = $goods_value_query[0]["goods_type"];

                                                    if($goods_type == "0"){
                                                        //일반상품
                                                        $total_dShipping = $goods_dlv_fee;
                                                    }else if($goods_dlv_type == "8"){
                                                        //구매대행
                                                        $total_dShipping += $goods_dlv_fee;
                                                    }

                                                    $db->query("SELECT imageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id ASC limit 0,1");
                                                    $dbdata = $db->loadRows();
                                                    $imgSrc = $brandImagesWebDir . $dbdata[0]["imageName"];

                                                    if ($goods_opt_type == "0") {
                                                        // 옵션없음
                                                        $goods_count = count($goods_value_query);
                                                    } else if ($goods_opt_type == "1") {
                                                        //일반옵션
                                                        $db->query("SELECT opName1,opName2,sellPrice,quantity FROM goods_option_single_value $sbidQuery ORDER BY id ASC");
                                                        $goods_value_query = $db->loadRows();
                                                        $goods_count = count($goods_value_query);
                                                    } else if ($goods_opt_type == "2") {
                                                        //가격선택옵션 opValue2 판매가
                                                        $db->query("SELECT opName1,opName2,opName3,opValue2,opValue3 FROM goods_option_grid_value $sbidQuery ORDER BY id ASC");
                                                        $goods_value_query = $db->loadRows();
                                                        $goods_count = count($goods_value_query);
                                                    }
                                                    $sum = 0;
                                                    for ($i = 0; $i < $goods_count; $i++) {
                                                        if ($goods_opt_type == "2") {
                                                            $sum += $goods_value_query[$i]["opValue2"] * $sbnumArr[$i];
                                                        } else {
                                                            $sum += $goods_value_query[$i]["sellPrice"] * $sbnumArr[$i];
                                                        }
                                                    }
                                                    $sum2 = 0;
                                                    if ($goods_opt_type != "0") {
                                                        if ($opidQuery != "") {
                                                            $db->query("SELECT id,opName1,opName2,opValue2,quantity FROM goods_option $opidQuery ");
                                                            $goods_option = $db->loadRows();
                                                            $goods_optionCount = count($goods_option);
                                                            $rowspan = $goods_count + $goods_optionCount + 1;
                                                            for ($i = 0; $i < $goods_optionCount; $i++) {
                                                                $sum += $goods_option[$i]["opValue2"] * $opnumArr[$i];
                                                            }
                                                        } else {
                                                            $rowspan = $goods_count + 3;
                                                        }
                                                    } else {
                                                        $rowspan = $goods_count + 3;
                                                    }
                                                    $total_sum += $sum;
                                                    $total_sum2 += $sum2;
                                                    ?>
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:left;background-color:#ddd;"
                                                                colspan="5">
                                                                <span
                                                                    style="display: inline-block;vertical-align: middle;">
                                                                    <img title="blandit blandit" width="50" height="50"
                                                                         alt="BlueStartImages" src="<?= $imgSrc ?>">
                                                                </span>
                                                                <span
                                                                    style="display: inline-block;vertical-align: middle;">
                                                                    <a href="item_view.php?code=<?= $goods_code ?>"><?= $goods_name ?></a>
                                                                </span>
                                                            </td>

                                                            <td class="cross Tprice" rowspan="<?= $rowspan ?>"
                                                                data-price="<?= $sum * $sb_sale + $sum2 ?>">
                                                                <?= number_format($sum * $sb_sale + $sum2) ?>
                                                                원
                                                            </td>
                                                            <td class="cross shipping"
                                                                data-shipping="<?=$goods_dlv_fee?>" rowspan="<?= $rowspan ?>">
                                                                <?=number_format($goods_dlv_fee)?> 원
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($goods_value_query as $e => $f) {
                                                            if ($goods_opt_type == "1") {
                                                                $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                            } elseif ($goods_opt_type == "2") {
                                                                if ($goods_opt_num == "2") {
                                                                    $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                                } else {
                                                                    $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"] . "_" . $goods_value_query[$i]["opName3"];
                                                                }
                                                            }
                                                            if ($goods_opt_type != "2") {
                                                                $goods_sellPrice = $f["sellPrice"] * $sb_sale;
                                                            } else {
                                                                $goods_sellPrice = $f["opValue2"];
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td class="col-md-7" style="text-align:left;">
                                                                    <div class="cm7">
                                                                        옵션명 : <?= $goods_name ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?= number_format($goods_sellPrice) ?> 원
                                                                </td>
                                                                <td class="u-d">
                                                                    <?= $sbnumArr[$i] . "개" ?>
                                                                </td>
                                                                <td>
                                                                    <span class="price" data-num="<?= $sbnumArr[$i] ?>"
                                                                          data-price="<?= $goods_sellPrice ?>"
                                                                          style="font-weight:bold;"><?php echo number_format($goods_sellPrice * $sbnumArr[$i]); ?>
                                                                        원
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        if ($goods_opt_type != "0") {
                                                            $i = 0;
                                                            foreach ($goods_option as $e => $f) {
                                                                $goods_option_name = $f["opName1"] . "_" . $f["opName2"];
                                                                ?>
                                                                <tr>
                                                                    <td></td>
                                                                    <td class="col-md-7" style="text-align:left;">
                                                                        <div class="cm7">
                                                                            추가 옵션명 : <?= $goods_option_name ?>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?= number_format($f["opValue2"]) ?>
                                                                        원
                                                                    </td>
                                                                    <td class="u-d">
                                                                        <?= $opnumArr[$i] . "개" ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="price"
                                                                              data-num="<?= $opnumArr[$i] ?>"
                                                                              data-price="<?= $f['opValue2'] ?>"
                                                                              style="font-weight:bold;"><?= number_format($f['opValue2'] * $opnumArr[$i]) ?>
                                                                            원
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <?php
                                                }
                                                //$db->query("DELETE FROM basket $basketQuery");
                                            } else {
                                                $sbid = $_SESSION[$app_oid . "_sbid"];
                                                $sbidArr = explode(",", $sbid);
                                                $sbnum = $_SESSION[$app_oid . "_sbnum"];
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
                                                $opid = $_SESSION[$app_oid . "_opid"];
                                                $opidArr = explode(",", $opid);
                                                $opnum = $_SESSION[$app_oid . "_opnum"];
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


                                                $db->query("SELECT goods_name,sb_sale,sellPrice,goods_dlv_type,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$goods_code'");
                                                $goods_value_query = $db->loadRows();
                                                $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
                                                $goods_name = $goods_value_query[0]["goods_name"];
                                                $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];
                                                $goods_opt_type = $goods_value_query[0]["goods_opt_type"];
                                                $goods_opt_num = $goods_value_query[0]["goods_opt_num"];
                                                $goods_sellPrice = $goods_value_query[0]["sellPrice"];

                                                $db->query("SELECT imageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id ASC limit 0,1");
                                                $dbdata = $db->loadRows();
                                                $imgSrc = $brandImagesWebDir . $dbdata[0]["imageName"];

                                                if ($goods_opt_type == "0") {
                                                    // 옵션없음
                                                    $goods_count = count($goods_value_query);
                                                } else if ($goods_opt_type == "1") {
                                                    //일반옵션
                                                    $db->query("SELECT opName1,opName2,sellPrice,quantity FROM goods_option_single_value $sbidQuery ORDER BY id ASC");
                                                    $goods_value_query = $db->loadRows();
                                                    $goods_count = count($goods_value_query);
                                                } else if ($goods_opt_type == "2") {
                                                    //가격선택옵션 opValue2 판매가
                                                    $db->query("SELECT opName1,opName2,opName3,opValue2,opValue3 FROM goods_option_grid_value $sbidQuery ORDER BY id ASC");
                                                    $goods_value_query = $db->loadRows();
                                                    $goods_count = count($goods_value_query);
                                                }
                                                $sum = 0;
                                                for ($i = 0; $i < $goods_count; $i++) {
                                                    if ($goods_opt_type == "2") {
                                                        $sum += $goods_value_query[$i]["opValue2"] * $sbnumArr[$i];
                                                    } else {
                                                        $sum += $goods_value_query[$i]["sellPrice"] * $sbnumArr[$i];
                                                    }
                                                }
                                                $sum2 = 0;
                                                if ($goods_opt_type != "0") {
                                                    if ($opidQuery != "") {
                                                        $db->query("SELECT id,opName1,opName2,opValue2,quantity FROM goods_option $opidQuery ");
                                                        $goods_option = $db->loadRows();
                                                        $goods_optionCount = count($goods_option);
                                                        $rowspan = $goods_count + $goods_optionCount + 1;
                                                        for ($i = 0; $i < $goods_optionCount; $i++) {
                                                            $sum += $goods_option[$i]["opValue2"] * $opnumArr[$i];
                                                        }
                                                    } else {
                                                        $rowspan = $goods_count + 3;
                                                    }
                                                } else {
                                                    $rowspan = $goods_count + 3;
                                                }
                                                $total_sum += $sum;
                                                $total_sum2 += $sum2;
                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align:left;background-color:#ddd;" colspan="5">
                                                            <span style="display: inline-block;vertical-align: middle;">
                                                                <img title="blandit blandit" width="50" height="50"
                                                                     alt="BlueStartImages" src="<?= $imgSrc ?>">
                                                            </span>
                                                            <span style="display: inline-block;vertical-align: middle;">
                                                                <a href="item_view.php?code=<?= $goods_code ?>"><?= $goods_name ?></a>
                                                            </span>
                                                        </td>

                                                        <td class="cross Tprice" rowspan="<?= $rowspan ?>"
                                                            data-price="<?= $sum * $sb_sale + $sum2 ?>">
                                                            <?= number_format($sum * $sb_sale + $sum2) ?>
                                                            원
                                                        </td>
                                                        <td class="cross shipping"
                                                            data-shipping="<?php if ($goods_dlv_type == "1") {
                                                                echo "0";
                                                            } else {
                                                                echo "2500";
                                                            } ?>" rowspan="<?= $rowspan ?>">
                                                            <?php
                                                            if ($goods_dlv_type == "1") {
                                                                echo "0 원";
                                                                $total_dShipping = $total_dShipping + 0;
                                                            } else {
                                                                echo number_format(2500) . " 원";
                                                                if ($total_dShipping == "") {
                                                                    $total_dShipping = "2500";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    $i = 0;
                                                    foreach ($goods_value_query as $e => $f) {
                                                        if ($goods_opt_type == "1") {
                                                            $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                        } elseif ($goods_opt_type == "2") {
                                                            if ($goods_opt_num == "2") {
                                                                $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                            } else {
                                                                $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"] . "_" . $goods_value_query[$i]["opName3"];
                                                            }
                                                        }
                                                        if ($goods_opt_type != "2") {
                                                            $goods_sellPrice = $f["sellPrice"] * $sb_sale;
                                                        } else {
                                                            $goods_sellPrice = $f["opValue2"];
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td></td>
                                                            <td class="col-md-7" style="text-align:left;">
                                                                <div class="cm7">
                                                                    옵션명 : <?= $goods_name ?>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?= number_format($goods_sellPrice) ?> 원
                                                            </td>
                                                            <td class="u-d">
                                                                <?= $sbnumArr[$i] . "개" ?>
                                                            </td>
                                                            <td>
                                                                <span class="price" data-num="<?= $sbnumArr[$i] ?>"
                                                                      data-price="<?= $goods_sellPrice ?>"
                                                                      style="font-weight:bold;"><?php echo number_format($goods_sellPrice * $sbnumArr[$i]); ?>
                                                                    원
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    if ($goods_opt_type != "0") {
                                                        $i = 0;
                                                        foreach ($goods_option as $e => $f) {
                                                            $goods_option_name = $f["opName1"] . "_" . $f["opName2"];
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td class="col-md-7" style="text-align:left;">
                                                                    <div class="cm7">
                                                                        추가 옵션명 : <?= $goods_option_name ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?= number_format($f["opValue2"]) ?>
                                                                    원
                                                                </td>
                                                                <td class="u-d">
                                                                    <?= $opnumArr[$i] . "개" ?>
                                                                </td>
                                                                <td>
                                                                    <span class="price" data-num="<?= $opnumArr[$i] ?>"
                                                                          data-price="<?= $f['opValue2'] ?>"
                                                                          style="font-weight:bold;"><?= number_format($f['opValue2'] * $opnumArr[$i]) ?>
                                                                        원
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <?php
                                            }
                                            $db->disconnect();
                                            ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="checkbox-form">
                        <h3 class="col-md-12" style="margin:0px;padding-left:0px;border-bottom:none;margin-top:20px;">
                            받는사람
                        </h3>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table borderless user-info">
                                    <tr>
                                        <th class="col-lg-3 col-md-3">이름</th>
                                        <td><?php echo $_SESSION[$app_oid . "_user_id"]; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>휴대폰</th>
                                        <td> <?php echo $_SESSION[$app_oid . "_phone"]; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>주소</th>
                                        <td> <?php echo "(" . $_SESSION[$app_oid . "_zipcode"] . ")" . $_SESSION[$app_oid . "_newadd"] . $_SESSION[$app_oid . "_alladd"]; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>배송메시지</th>
                                        <td><?php echo $_SESSION[$app_oid . "_ship_message"]; ?></td>
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
                                        <span class="checkout-price">결제 예정금액</span>
                                    </th>
                                </thead>
                                <tbody>
                                    <td><?= number_format($_SESSION[$app_oid . "_buy_total_price"]) ?>
                                        <span class="won">원</span>
                                    </td>
                                    <td class="cross">
                                        <i class="fa fa-plus-square"></i> <?= number_format($_SESSION[$app_oid . "_pay_dlv_fee"]) ?>
                                        <span class="won">원
                                        </span>
                                    </td>
                                    <td class="cross">
                                        <i class="fa fa-minus-square"></i> <?= number_format($_SESSION[$app_oid . "_buy_instant_discount"]) ?>
                                        <span class="won">원</span>
                                    </td>
                                    <td>
                                        <span
                                            class="checkout-price"><?= number_format($_SESSION[$app_oid . "_buy_total_price"] - $_SESSION[$app_oid . "_buy_instant_discount"] + $_SESSION[$app_oid . "_pay_dlv_fee"]) ?></span>
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
    <!-- checkout-area end -->
    <!--footer area start-->

    <!--footer area end-->

    <!-- JS -->

    <!-- jquery-1.11.3.min js
    ============================================ -->
    <script src="js/vendor/jquery-1.11.3.min.js"></script>

    <!-- price-slider js -->
    <script src="js/price-slider.js"></script>

    <!-- bootstrap js
            ============================================ -->
    <script src="js/bootstrap.min.js"></script>

    <!-- nevo slider js
    ============================================ -->
    <script src="js/jquery.nivo.slider.pack.js"></script>

    <!-- owl.carousel.min js
    ============================================ -->
    <script src="js/owl.carousel.min.js"></script>

    <!-- count down js
    ============================================ -->
    <script src="js/jquery.countdown.min.js" type="text/javascript"></script>

    <!--zoom plugin
    ============================================ -->
    <script src='js/jquery.elevatezoom.js'></script>

    <!-- wow js
    ============================================ -->
    <script src="js/wow.js"></script>

    <!--Mobile Menu Js
    ============================================ -->
    <script src="js/jquery.meanmenu.js"></script>

    <!-- jquery.fancybox.pack js -->
    <script src="js/fancybox/jquery.fancybox.pack.js"></script>

    <!-- jquery.scrollUp js
    ============================================ -->
    <script src="js/jquery.scrollUp.min.js"></script>

    <!-- jquery.collapse js
    ============================================ -->
    <script src="js/jquery.collapse.js"></script>

    <!-- mixit-up js
            ============================================ -->
    <script src="js/jquery.mixitup.min.js"></script>

    <!-- plugins js
    ============================================ -->
    <script src="js/plugins.js"></script>

    <!-- main js
    ============================================ -->
    <script src="js/main.js"></script>
</body>
</html>