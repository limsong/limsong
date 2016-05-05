<?php
include_once("../doctype.php");
/*
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 5. 3
 * Time: 오후 12:34
 */
if ($_POST['P_STATUS'] === '00') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_POST['P_REQ_URL']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'P_MID=INIpayTest&P_TID=' . $_POST['P_TID']); // 여기 수정하세요!
    $inipay = curl_exec($ch);
    curl_close($ch);

    $result = array();
    parse_str($inipay, $result);
    $cashmoney = $_SESSION[$result['P_OID'] . "_price"];
    if ($result['P_STATUS'] == '00' && (int)$cashmoney === (int)$result['P_AMT']) {
        //save_into_db();
        //header('Location: /shop/success/');
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
        $P_RMESG1;             // 12 결과코드
        $P_RMESG2;             // 13 결과메시지
        $P_NOTI;               // 14 노티메시지(상점에서 올린 메시지)
        $P_AUTH_NO;            // 15 승인번호
        $P_VACT_NUM;           // 16 은행 계좌번호
        $P_VACT_DATE;          // 17 입금기한 일짜
        $P_VACT_TIME;          // 18 입금기한 시간
        $P_VACT_NAME;          // 19 이니시스(주)테스트입
        $P_VACT_BANK_CODE;     // 20 은행코드
        $P_MNAME;              // 21 상점이름 (SOZO)

        foreach ($result as $key => $value) {
            //echo $key."==>".$value."<br>";
            ${$key} = $value;
        }

        $P_UNAME = iconv("EUC-KR", "UTF-8", $P_UNAME);


        $date = date("Y-m-d H:i:s");
        $app_oid = $P_OID;
    }
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
                                <a href="index.php" style="font-size:20px;">BLUE START </a>
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
                                구매하신 상품의 결제가 예약되였습니다.
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
                                            <td> <?php echo vbankCode($P_VACT_BANK_CODE); ?> </td>
                                        </tr>
                                        <tr>
                                            <th>계좌번호</th>
                                            <td> <?php echo $P_VACT_NUM; ?> </td>
                                        </tr>
                                        <tr>
                                            <th>입금기한</th>
                                            <td><?php echo date("Y-m-d", strtotime($P_VACT_DATE)) . " " . date("H:i:s", strtotime($P_VACT_TIME)); ?></td>
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
                                        <td><?= number_format($_SESSION[$app_oid."_buy_total_price"]) ?>
                                            <span class="won">원</span>
                                        </td>
                                        <td class="cross">
                                            <i class="fa fa-plus-square"></i> <?= number_format($_SESSION[$app_oid."_pay_dlv_fee"]) ?>
                                            <span class="won">원
                                            </span>
                                        </td>
                                        <td class="cross">
                                            <i class="fa fa-minus-square"></i> <?= number_format($_SESSION[$app_oid."_buy_instant_discount"]) ?>
                                            <span class="won">원</span>
                                        </td>
                                        <td>
                                            <span class="checkout-price"><?= number_format($_SESSION[$app_oid."_buy_total_price"] - $_SESSION[$app_oid."_buy_instant_discount"] + $_SESSION[$app_oid."_pay_dlv_fee"]) ?></span>
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
                                                <input type="button" onclick="location.href='/'" style="background-color:white;color:#333;border:1px solid #ccc;" value="확인">
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
            <?php
            if($P_TYPE == "VBANK")    //결제수단이 가상계좌이며 실시간 계조이체 BANK 가상계좌 VBANK  카드결제 CARD
            {
                if($P_STATUS != "02") //입금통보 "02" 가 아니면(가상계좌 채번 : 00 또는 01 경우)
                {
                    echo "OK";
                }
            }
            /*  ***************************************************************************
             * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.

              [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
              처리중 에러 발생시 망취소를 한다.
             * **************************************************************************** */
            ?>
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
    </body>
</html>
<?php

$db->disconnect();
?>