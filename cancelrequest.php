<? include_once("doctype.php") ?>
<body class="home-2">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <? include_once("head.php") ?>
        <section class="category-area-one control-car mar-bottom">
                <div class="container-fluid">
                        <div class="row">
                                <div class="cat-area-heading">
                                        <h4><strong>My</strong>account</h4>
                                </div>
                                <div class="col-md-3 col-lg-2">
                                        <div class="small-cat-menu">
                                                <ul class="cat-menu-ul">
                                                        <li class="cat-menu-li"><a href="mypage.php">주문/배송조회</a></li>
                                                        <li class="cat-menu-li"><a class="active" href="cancelrequest.php">취소/반품/교환 신청</a></li>
                                                        <li class="cat-menu-li"><a href="cancelstatus.php">취소/반품/교환 현황</a></li>
                                                        <li class="cat-menu-li"><a href="displayrefundpayment.php">환불/입금내역</a></li>
                                                        <li class="cat-menu-li"><a href="point.php">적립금현황</a></li>
                                                        <li class="cat-menu-li"><a href="mem_modify.php">회원정보수정</a></li>
                                                </ul>
                                        </div>
                                </div>
                                <style type="text/css">
                                        .active{
                                                background: #76caf1 none repeat scroll 0 0!important;
                                        }
                                        .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
                                                border:none;
                                                vertical-align: middle;
                                                text-align: center;
                                                cursor: pointer;
                                        }
                                        .table-bordered{
                                                border:none;
                                                border-bottom:1px solid #ddd;
                                        }
                                        .txt_ag_left{
                                                text-align: left !important;
                                                padding-left:20px !important;
                                        }
                                </style>

                                <div class="col-md-9 col-lg-10 no-padding">
                                        <section class="cart-area-wrapper">
                                                <div class="container-fluid">
                                                        <div class="row cart-top">
                                                                <div class="col-md-12">
                                                                        <div class="table-responsive">
                                                                                <div class="col-md-12">
                                                                                        <form name="userinfoform" class="userinfoform" method="post" action="mem_modifyPost.php">
                                                                                                <div class="coupon-accordion">
                                                                                                        <div class="col-lg-8 col-md-8">
                                                                                                                <div class="checkbox-form">
                                                                                                                        <h3>회원 정보</h3>
                                                                                                                        <div class="row">
                                                                                                                                <?
                                                                                                                                $db->query("SELECT * FROM shopMembers WHERE id = '$uname'");
                                                                                                                                $dbdata = $db->loadRows();
                                                                                                                                ?>
                                                                                                                                <div class="col-md-12">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>아이디</label>
                                                                                                                                                <?=$dbdata[0]['id']?>
                                                                                                                                        </div>
                                                                                                                                </div>

                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>비밀번호 (6-18자 영문,숫자)<span class="required">*</span></label>
                                                                                                                                                <input type="password" name="passwd" class="passwd" placeholder="">
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>비밀번호 확인  <span class="required">*</span></label>
                                                                                                                                                <input type="password" name="passwd2" class="passwd2" placeholder="">
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-12">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>이름<span class="required">*</span></label>
                                                                                                                                                <?=$dbdata[0]['name']?>
                                                                                                                                        </div>
                                                                                                                                </div>

                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>우편번호<span class="required">*</span></label>
                                                                                                                                                <input type="text" readonly="readonly" name="zipcode" value="<?=$dbdata[0]['hPost']?>" class="zipcode postcodify_postcode" id="postcode" placeholder="">
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label> <span class="required">&nbsp;</span></label>
                                                                                                                                                <div class="order-button-payment">
                                                                                                                                                        <input type="button" value="우편번호검색" id="search_button" style="height:42px;margin:0px;">
                                                                                                                                                </div>
                                                                                                                                        </div>
                                                                                                                                </div>



                                                                                                                                <div class="col-md-12">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>주소</label>
                                                                                                                                                <input type="text" readonly="readonly" name="add1" value="<?=$dbdata[0]['hAddr1']?>" id="address" class="add1 postcodify_address" placeholder="">
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-12">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>나머지 주소</label>
                                                                                                                                                <input type="text" name="add2" value="<?=$dbdata[0]['hAddr2']?>" class="add2" placeholder="">
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>전화번호 (- 없이 입력해주세요)  <span class="required"></span></label>
                                                                                                                                                <input type="text" name="phone" value="<?=$dbdata[0]['phone']?>" class="phone" placeholder="">
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>휴대전화 (- 없이 입력해주세요)  <span class="required"></span></label>
                                                                                                                                                <input type="text" name="hphone" value="<?=$dbdata[0]['mphone']?>" class="hphone"  placeholder="">
                                                                                                                                        </div>
                                                                                                                                </div>

                                                                                                                                <div class="col-md-12">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label>이메일 <span class="required"></span></label>
                                                                                                                                                <?=$dbdata[0]['email']?>
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <?
                                                                                                                                $db->disconnect();
                                                                                                                                ?>
                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label> <span class="required">&nbsp;</span></label>
                                                                                                                                                <div class="order-button-payment">
                                                                                                                                                        <input type="submit" value="정보수정" style="height:42px;margin:0px;">
                                                                                                                                                </div>
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                        <div class="checkout-form-list">
                                                                                                                                                <label> <span class="required">&nbsp;</span></label>
                                                                                                                                                <div class="order-button-payment">
                                                                                                                                                        <input type="button" value="취소" style="height:42px;margin:0px;background-color:#6e6e6e;">
                                                                                                                                                </div>
                                                                                                                                        </div>
                                                                                                                                </div>
                                                                                                                        </div>
                                                                                                                </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                        </form>
                                                                                </div>
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

        <!-- zip pop js
        ============================================ -->
        <script src="js/search.min.js"></script>
        <script type="text/javascript">
                $(document).ready(function(){
                        $("#search_button").postcodifyPopUp();
                });
        </script>
</body>
</html>