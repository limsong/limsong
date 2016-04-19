<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 19
 * Time: 오후 1:56
 */
include_once("doctype.php");
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
                                        <td><?php echo $_SESSION[$app_oid."_user_id"]; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>입금은행</th>
                                        <td> <?php echo $_SESSION[$app_oid."_phone"]; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>계좌번호</th>
                                        <td> <?php echo "(" . $_SESSION[$app_oid."_zipcode"] . ")" . $_SESSION[$app_oid."_newadd"] . $_SESSION[$app_oid."_alladd"]; ?> </td>
                                    </tr>
                                    <tr>
                                        <th>입금기한</th>
                                        <td><?php echo $_SESSION[$app_oid."_ship_message"]; ?></td>
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
</body></html>
