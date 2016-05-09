<?php
include_once ("session.php");
include_once ("include/check.php");
include_once("doctype.php");
?>
<body class="home-2">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong>
        browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a>
        to improve your experience.
    </p><![endif]-->
    <? include_once("head.php") ?>
    <section class="category-area-one control-car mar-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="cat-area-heading">
                    <h4>
                        <strong>My</strong>
                        account
                    </h4>
                </div>
                <? include_once "mypage_side.php";?>
                <style type="text/css">
                    .active {
                        background: #76caf1 none repeat scroll 0 0 !important;
                    }

                    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                        border: none;
                        vertical-align: middle;
                        text-align: center;
                        cursor: pointer;
                    }

                    .table-bordered {
                        border: none;
                        border-bottom: 1px solid #ddd;
                    }

                    .txt_ag_left {
                        text-align: left !important;
                        padding-left: 20px !important;
                    }
                </style>

                <div class="col-md-9 col-lg-10 no-padding">
                    <section class="cart-area-wrapper">
                        <div class="container-fluid">
                            <div class="row cart-top">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <div class="col-md-12"
                                             style="margin: 0px 0px 5px 0px;padding:0px;">* 적립금 보유내역입니다.
                                        </div>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr style="border-top:2px solid #76caf1;">
                                                    <td width="15%" class="txt_ag_left">적립금 보유액</td>
                                                    <?
                                                    $db->query("SELECT * FROM shopMembers WHERE id='$uname'");
                                                    $dbdata = $db->loadRows();
                                                    ?>
                                                    <td class="txt_ag_left"><?= $dbdata['0']['name'] ?> (ID: <?= $dbdata['0']['id'] ?>) 님의 적립금은 <?= number_format($dbdata['0']['milage']) ?>원 입니다.</td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td class="txt_ag_left">사용안내</td>
                                                    <td class="txt_ag_left">무료</td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td class="txt_ag_left">총 결제금액</td>
                                                    <td class="txt_ag_left">
                                                        적립된 금액이 1,000,000원 이상 누적되었을 때, 사용하실 수 있습니다.
                                                        <br>
                                                        결재시 적립금 사용여부를 확인하는 안내문이 나옵니다.
                                                        <br>
                                                        주문번호를 클릭하시면 해당 상품의 주문내역을 확인하실 수 있습니다.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="col-md-12"
                                             style="margin: 20px 0px 5px 0px;padding:0px;">* 적립금 사용내역입니다..
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td width="15%">적립날짜</td>
                                                    <td width="15%">적립금</td>
                                                    <td>적립내용</td>
                                                </tr>
                                            </thead>
                                            <?
                                            $db->query("SELECT * FROM milage_log WHERE user_id='$uname'");
                                            $dbdata = $db->loadRows();
                                            $count = count($dbdata);
                                            for ($i = 0; $i < $count; $i++) {
                                                ?>
                                                <tbody>
                                                    <tr>
                                                        <td><?= $dbdata[$i]['milage_time'] ?></td>
                                                        <td><?= $dbdata[$i]['milage'] ?> 원</td>
                                                        <td class="txt_ag_left"><?= $dbdata[$i]['milage_info'] ?></td>
                                                    </tr>
                                                </tbody>
                                                <?
                                            }
                                            $db->disconnect();
                                            ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!--FOOTER AREA START-->
    <? include_once("footer.php") ?>
    <!--FOOTER AREA END-->


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
