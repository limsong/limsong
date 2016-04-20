<? include_once("doctype.php") ?>
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
                                <div class="col-md-3 col-lg-2">
                                        <div class="small-cat-menu">
                                                <ul class="cat-menu-ul">
                                                        <li class="cat-menu-li">
                                                                <a class="active" href="mypage.php">주문/배송조회</a>
                                                        </li>
                                                        <li class="cat-menu-li">
                                                                <a href="cancelrequest.php">취소/반품/교환 신청</a>
                                                        </li>
                                                        <li class="cat-menu-li">
                                                                <a href="cancelstatus.php">취소/반품/교환 현황</a>
                                                        </li>
                                                        <li class="cat-menu-li">
                                                                <a href="displayrefundpayment.php">환불/입금내역</a>
                                                        </li>
                                                        <li class="cat-menu-li">
                                                                <a href="point.php">적립금현황</a>
                                                        </li>
                                                        <li class="cat-menu-li">
                                                                <a href="mem_modify.php">회원정보수정</a>
                                                        </li>
                                                </ul>
                                        </div>
                                </div>
                                <style type="text/css">
                                        .active {
                                                background: #76caf1 none repeat scroll 0 0 !important;
                                        }

                                        .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                                                border: none;
                                                vertical-align: middle;
                                                text-align: center;
                                                cursor: pointer;
                                                border:1px solid #ddd;
                                        }

                                        .table-bordered {
                                                border: none;
                                                border-bottom: 1px solid #ddd;
                                        }
                                </style>

                                <div class="col-md-9 col-lg-10 no-padding">
                                        <section class="cart-area-wrapper">
                                                <div class="container-fluid">
                                                        <div class="row cart-top">
                                                                <div class="col-md-12">* 내가 주문한 상품내역 및 배송정보</div>
                                                                <div class="col-md-12">
                                                                        <div class="table-responsive">
                                                                                <table class="table table-bordered">
                                                                                        <thead>
                                                                                                <tr>
                                                                                                        <td>주문일자</td>
                                                                                                        <td>주문상품 정보</td>
                                                                                                        <td>상품금액(수량)</td>
                                                                                                        <td>배송비</td>
                                                                                                        <td>주문상태</td>
                                                                                                        <td>확인/취소/리뷰</td>
                                                                                                </tr>
                                                                                        </thead>
                                                                                        <?php
                                                                                        $db->query("SELECT buy_seq FROM buy WHERE buy_status<=2 AND user_id='$uname'");
                                                                                        $db_buy = $db->loadRows();
                                                                                        $cbuy = count($db_buy);
                                                                                        for($i=0;$i<$cbuy;$i++) {


                                                                                                $buy_seq = $db_buy[$i]["buy_seq"];
                                                                                                $db->query("SELECT buy_goods_name,buy_goods_prefix,buy_goods_option,buy_goods_price,buy_goods_count,buy_goods_price_total FROM buy_goods WHERE buy_seq='$buy_seq' AND buy_goods_status<=2");
                                                                                                $db_buy_goods=$db->loadRows();
                                                                                                $cbuy_goods = count($db_buy_goods);
                                                                                        ?>
                                                                                        <tbody>
                                                                                                <tr>
                                                                                                        <td rowspan="<?=$cbuy_goods?>">
                                                                                                                2015-12-24
                                                                                                                <br>
                                                                                                                (INIpayTest_1461079117045)
                                                                                                                <br>
                                                                                                                <button type="button" class="btn btn-xs btn-purple waves-effect waves-light">주문전체취소</button>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                                <div style="width:100%;float: left;">
                                                                                                                        <label class="chk" style="float: left;">
                                                                                                                                <input type="checkbox">
                                                                                                                        </label>
                                                                                                                        <span style="float: left;margin-left:5px;">
                                                                                                                                <img src="userFiles/images/brandImages/0201000024thumImage.jpg" width="50" height="50">
                                                                                                                        </span>
                                                                                                                        <div style="overflow:hidden;text-align: left;padding-left:5px;">
                                                                                                                                <p style="word-break: break-all;border-collapse: collapse;">봄신상 대박세일/최대80%OFF/아디다스/디아도라/휠라/트레이닝복세트</p>
                                                                                                                                <p>
                                                                                                                                        옵션명 : 상품명_아디다스
                                                                                                                                        <br>
                                                                                                                                        옵션명 : 상품명2_아디다스2
                                                                                                                                </p>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                                35,000원
                                                                                                                <br>
                                                                                                                (1개)
                                                                                                        </td>
                                                                                                        <td rowspan="<?=$cbuy_goods?>">
                                                                                                                무료
                                                                                                        </td>
                                                                                                        <td class="cart-total-price">입금대기중</td>
                                                                                                        <td rowspan="2" class="cart-total-price">
                                                                                                                <button type="button" class="btn btn-xs btn-purple waves-effect waves-light">주문취소</button>
                                                                                                        </td>
                                                                                                </tr>
                                                                                                <tr>
                                                                                                        <td>
                                                                                                                <div style="width:100%;float: left;">
                                                                                                                        <label class="chk" style="float: left;">
                                                                                                                                <input type="checkbox">
                                                                                                                        </label>
                                                                                                                        <div style="overflow:hidden;text-align: left;padding-left:5px;">
                                                                                                                                <p style="word-break: break-all;border-collapse: collapse;">[추가상품]F-ZS915E-블루-FREE</p>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </td>
                                                                                                        <td>1,500원
                                                                                                                <br>
                                                                                                                (1개)
                                                                                                        </td>
                                                                                                        <td>입금대기중</td>
                                                                                                </tr>
                                                                                        </tbody>
                                                                                        <?php
                                                                                        }
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
