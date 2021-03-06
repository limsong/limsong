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
                        <strong>My</strong>account
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
                        border: 1px solid #ddd;
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
                                <div class="col-md-12">
                                    <h3>* 취소/반품/교환 현황</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>주문일자</td>
                                                    <td>주문상품 정보</td>
                                                    <td>상품금액(수량)</td>
                                                    <td>처리</td>
                                                </tr>
                                            </thead>
                                            <?php
                                            $class_check = 0;//checkbox class sb and op number maching
                                            $db->query("SELECT buy_claim_seq,buy_claim_status,buy_claim_code,buy_claim_is_all,buy_seq,buy_claim_type FROM buy_claim WHERE user_id='$uname'");
                                            //echo "SELECT buy_claim_seq,buy_claim_status,buy_claim_code,buy_claim_is_all,buy_seq,buy_claim_type FROM buy_claim WHERE user_id='$uname'";
                                            $db_buy_claim = $db->loadRows();
                                            $cbuy = count($db_buy_claim);
                                            for ($m = 0; $m < $cbuy; $m++) {
                                                //$buy_claim_seq = $db_buy_claim[$i]["buy_claim_seq"];//주문 클레임 일련번호
                                                $buy_claim_status = $db_buy_claim[$m]["buy_claim_status"];//주문 클레임 상태 - 취소/환불/반품/교환 - 32~65536
                                                //$buy_claim_code = $db_buy_claim[$i]["buy_claim_code"];//주문 클레임 코드 - C, R, T, E (ex) C11111
                                                //$buy_claim_is_all = $db_buy_claim[$i]["buy_claim_is_all"];//주문 전체/부분여부 - 0:부분, 1:전체
                                                $buy_claim_seq = $db_buy_claim[$m]["buy_claim_seq"];//신청한 주문 일련번호
                                                //$buy_claim_type = $db_buy_claim[$i]["buy_claim_type"];//클레임 처리유형 - 1:고객, 2: 관리자, 3: 자동
                                                /*if ($i == 0) {
                                                      $buy_claim_goods = "WHERE buy_claim_seq IN ('$buy_seq'";
                                                } else {
                                                      $buy_claim_goods .= ",'$buy_seq'";
                                                }*/

                                                //$buy_claim_goods .= ")";
                                                //echo $buy_claim_goods;


                                                $db->query("SELECT buy_claim_goods_seq,buy_claim_seq,buy_goods_req_seq,buy_goods_req_count,buy_goods_new_count FROM buy_claim_goods");
                                                //echo "SELECT buy_claim_goods_seq,buy_claim_seq,buy_goods_req_seq,buy_goods_req_count,buy_goods_new_count FROM buy_claim_goods";
                                                $db_buy_claim_goods = $db->loadRows();
                                                /*$buy_claim_goods_seq = $db_buy_claim_goods[$i]["buy_claim_goods_seq"];//클레임 상품 일련번호
                                                $buy_claim_seq = $db_buy_claim_goods[$i]["buy_claim_seq"];//클레임 일련번호
                                                $buy_goods_req_seq = $db_buy_claim_goods[$i]["buy_goods_req_seq"];//신청한 상품 일련번호
                                                $buy_goods_req_count = $db_buy_claim_goods[$i]["buy_goods_req_count"];//신청한 수량
                                                $buy_goods_new_count = $db_buy_claim_goods[$i]["buy_goods_new_count"];//실제 처리된 수량*/
                                                //$cbuy_goods = count($db_buy_claim_goods);
                                                $db_buy_claim_goods_count = count($db_buy_claim_goods);

                                                for ($i = 0; $i < $db_buy_claim_goods_count; $i++) {
                                                    $buy_goods_req_seq = $db_buy_claim_goods[$i]["buy_goods_req_seq"];
                                                    if ($i == 0) {
                                                        $buy_goods_query = "WHERE buy_goods_seq IN ('$buy_goods_req_seq'";
                                                    } else {
                                                        $buy_goods_query .= ",'$buy_goods_req_seq'";
                                                    }

                                                }
                                                $buy_goods_query .= ")";

                                                $db->query("SELECT * FROM buy_goods $buy_goods_query");

                                                $db_buy_goods = $db->loadRows();
                                                $db_buy_goods_count = count($db_buy_goods);
                                                for ($i = 0; $i < $db_buy_goods_count; $i++) {
                                                    $buy_goods_seq = $db_buy_goods[$i]["buy_goods_seq"];//주문 상품 일련번호
                                                    $buy_goods_code = $db_buy_goods[$i]["buy_goods_code"];//상품코드
                                                    $buy_goods_name = $db_buy_goods[$i]["buy_goods_name"];
                                                    $buy_goods_prefix = $db_buy_goods[$i]["buy_goods_prefix"];
                                                    $buy_goods_suffix = $db_buy_goods[$i]["buy_goods_suffix"];
                                                    $buy_goods_option = $db_buy_goods[$i]["buy_goods_option"];
                                                    $buy_goods_price = $db_buy_goods[$i]["buy_goods_price"];
                                                    $buy_goods_count = $db_buy_goods[$i]["buy_goods_count"];
                                                    $buy_goods_price_total = $db_buy_goods[$i]["buy_goods_price_total"];
                                                    $buy_goods_dlv_type = $db_buy_goods[$i]["buy_goods_dlv_type"];
                                                    $buy_seq = $db_buy_goods[$i]["buy_seq"];
                                                    $buy_goods_status = $db_buy_goods[$i]["buy_goods_status"];


                                                    $db->query("SELECT buy_code,buy_date FROM buy WHERE buy_seq='$buy_seq'");
                                                    $db_buy_query = $db->loadRows();
                                                    $buy_code = $db_buy_query[0]["buy_code"];
                                                    $buy_date = $db_buy_query[0]["buy_date"];


                                                    $tmp_goods_code = "0";
                                                    $db->query("SELECT goods_name,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$buy_goods_code'");
                                                    $db_goods = $db->loadRows();
                                                    $goods_opt_type = $db_goods[0]["goods_opt_type"];
                                                    $goods_opt_num = $db_goods[0]["goods_opt_num"];
                                                    $goods_name = $db_goods[0]["goods_name"];
                                                    if ($buy_goods_option == "0") {
                                                        ?>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <?= date("Y-m-d", strtotime($buy_date)) ?>
                                                                    <br>
                                                                    (<?= $buy_code ?>)
                                                                </td>
                                                                <td>
                                                                    <div style="width:100%;float: left;">
                                                                        <span style="float: left;margin-left:5px;">
                                                                            <img
                                                                                src="userFiles/images/brandImages/0201000024thumImage.jpg"
                                                                                width="50" height="50">
                                                                        </span>
                                                                        <div
                                                                            style="overflow:hidden;text-align: left;padding-left:5px;">
                                                                            <p style="max-width:500px;word-break: break-all;border-collapse: collapse;"><?= $goods_name ?></p>
                                                                            <p>
                                                                                <?php
                                                                                if ($goods_opt_type == "1") {
                                                                                    $db->query("select * from goods_option_single_name where goods_code='$buy_goods_code' and opName2='$buy_goods_prefix' or opName2='$buy_goods_suffix'");
                                                                                } else {
                                                                                    if ($goods_opt_num == "2") {
                                                                                        $db->query("select * from goods_option_grid_name where goods_code='$buy_goods_code' and opName2='$buy_goods_prefix' or opName2='$buy_goods_suffix'");

                                                                                    } else {
                                                                                        $db->query("select * from goods_option_grid_name where goods_code='$buy_goods_code' and opName2='$buy_goods_prefix' or opName2='$buy_goods_suffix'");
                                                                                    }
                                                                                }
                                                                                $dbquery = $db->loadRows();
                                                                                $cdbquery = count($dbquery);
                                                                                for ($k = 0; $k < $cdbquery; $k++) {
                                                                                    if ($k == 0) {
                                                                                        $str_op_name = $dbquery[$k]["opName1"] . " : " . $dbquery[$k]["opName2"];
                                                                                    } else {
                                                                                        $str_op_name .= "<br>" . $dbquery[$k]["opName1"] . " : " . $dbquery[$k]["opName2"];
                                                                                    }
                                                                                }
                                                                                echo $str_op_name;
                                                                                ?>

                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?= number_format($buy_goods_price_total * $db_buy_claim_goods[$i]["buy_goods_new_count"]) ?>원
                                                                    <br>
                                                                    (<?= $db_buy_claim_goods[$i]["buy_goods_new_count"] ?>개)
                                                                </td>
                                                                <td class="cart-total-price"><?= goods_status($buy_claim_status) ?></td>
                                                            </tr>
                                                            <?php
                                                            $class_check++;
                                                            ?>
                                                        </tbody>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <?= date("Y-m-d", strtotime($buy_date)) ?>
                                                                    <br>
                                                                    (<?= $buy_code ?>)
                                                                </td>
                                                                <td>
                                                                    <div style="width:100%;float: left;">
                                                                        <div
                                                                            style="overflow:hidden;text-align: left;padding-left:5px;">
                                                                            <p style="max-width:500px;word-break: break-all;border-collapse: collapse;">[추가상품]<? echo $buy_goods_name . "_" . $buy_goods_prefix ?></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?= number_format($buy_goods_price_total * $db_buy_claim_goods[$i]["buy_goods_new_count"]) ?>원
                                                                    <br>
                                                                    (<?= $db_buy_claim_goods[$i]["buy_goods_new_count"] ?>개)
                                                                </td>
                                                                <td class="cart-total-price"><?= goods_status($buy_claim_status) ?></td>
                                                            </tr>
                                                            <?php
                                                            $class_check++;
                                                            ?>
                                                        </tbody>
                                                        <?php
                                                    }
                                                }
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
        <!-- Modal -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"
                style="display: none;">Launch demo modal
        </button>
        <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">취소신청</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                        <button type="button" class="btn btn-red submit">확인</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--FOOTER AREA START-->
    <?php include_once("footer.php") ?>
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
    <script src="js/mypage.js"></script>
    <script type="text/javascript">
        $(".cancel").click(function () {
            var seq = "";
            var mod = $(this).attr("data");
            var data_seq = $(this).attr("data-seq");
            if (mod == "cAll") {
                $(".citem" + data_seq).each(function () {
                    if (seq == "") {
                        seq = $(this).val();
                    }
                    else {
                        seq += "," + $(this).val();
                    }
                });
            }
            else {
                $(".citem" + data_seq).each(function () {
                    if ($(this).is(":checked")) {
                        if (seq == "") {
                            seq = $(this).val();
                        }
                        else {
                            seq += "," + $(this).val();
                        }
                    }
                });

            }
            if (!seq) {
                alert("취소할 상품을 체크하세요.");
                return false;
            }
            var url = "getcancelprodInfoajax.php";
            var form_data = {
                seq: seq,
                mod: mod
            };
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                error: function (response) {
                    alert(response.responseText);
                },
                success: function (response) {
                    $(".modal-body").html("");
                    add_goods(response);
                }
            });
        });
        function add_goods(rep) {
            $(".modal-body").append(rep);
            $(".btn-lg").trigger("click");//버튼 클릭//추가옵션  div 보기
            $(".sb_num,.op_num").change(function () {
                var cancel_dlv_free = parseInt($(".cancel_dlv_free").val());
                var ou_price = 0;
                var ou_price_total = 0;
                var ou_cancel_sb_instant_discount = 0;
                var ou_op_total_price = 0;
                $(".sb_num").each(function () {
                    var num = $(this).val();
                    var price = $(this).parent().find(".cancel_sb_price").val();
                    var price_total = $(this).parent().find(".cancel_sb_price_total").val();
                    var cancel_sb_instant_discount = $(this).parent().find(".cancel_sb_instant_discount").val();
                    ou_price += parseInt(num) * parseInt(price);
                    ou_price_total += parseInt(num) * parseInt(price_total);
                    ou_cancel_sb_instant_discount += parseInt(num) * parseInt(cancel_sb_instant_discount);
                });
                $(".op_num").each(function () {
                    var op_num = $(this).val();
                    var op_price = $(this).parent().find(".cancel_op_price").val();
                    ou_op_total_price += parseInt(op_num) * parseInt(op_price);

                });
                $(".sb_price").text(formatNumber(ou_price));

                $(".price_discount").text(formatNumber(ou_cancel_sb_instant_discount));

                $(".checkout-price").text(formatNumber(ou_price_total + ou_op_total_price + cancel_dlv_free));
            });

            $(".submit").click(function () {
                $(".cancelForm").submit();
            })
        }

        $("input[name='sb_checkbox']").click(function () {
            var _data = $(this).attr("data");
            $(".op_checkbox" + _data).prop("checked", this.checked);
        });
        $("input[name='op_checkbox']").click(function () {
            var _data = $(this).attr("data");
            $(".sb_checkbox" + _data).prop("checked", false);
        });
        $(".sb_num").on('change', function () {
            alert("aa");
            ;
        });
        function formatNumber(num, precision, separator) {
            var parts;
            if (!isNaN(parseFloat(num)) && isFinite(num)) {
                num = Number(num);
                num = (typeof precision !== "undefined" ? num.toFixed(precision) : num).toString();
                parts = num.split('.');
                parts[0] = parts[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1" + (separator || ","));
                return parts.join('.');
            }
            return NaN;
        }
    </script>
</body></html>
