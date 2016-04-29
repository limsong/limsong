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
                <? include_once "mypage_side.php"; ?>
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
                                    <h3>* 주문 배송조회</h3>
                                </div>
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
                                            $class_check = 0;//checkbox class sb and op number maching
                                            $db->query("SELECT buy_seq,buy_code,buy_date,pay_pre_date FROM buy WHERE  user_id='$uname' ORDER BY  buy_seq desc");
                                            $db_buy = $db->loadRows();
                                            $cbuy = count($db_buy);
                                            for ($i = 0; $i < $cbuy; $i++) {
                                                $buy_seq = $db_buy[$i]["buy_seq"];//신청한 주문 일련번호
                                                $buy_date = $db_buy[$i]["buy_date"];//주문일
                                                $buy_code = $db_buy[$i]["buy_code"];//주문코드(주문번호)
                                                $pay_pre_date = $db_buy[$i]["pay_pre_date"];//입금예정일

                                                $db->query("SELECT buy_goods_seq,buy_goods_status,buy_goods_code,buy_goods_name,buy_goods_prefix,buy_goods_option,buy_goods_price,buy_goods_count,buy_goods_price_total,buy_goods_dlv_type FROM buy_goods WHERE buy_seq='$buy_seq' AND buy_goods_status<=16");
                                                $db_buy_goods = $db->loadRows();
                                                $cbuy_goods = count($db_buy_goods);

                                                ?>
                                                <tbody>
                                                    <?php
                                                    $tmp_goods_code = "0";
                                                    FOR ($j = 0; $j < $cbuy_goods; $j++) {
                                                        $buy_goods_seq = $db_buy_goods[$j]["buy_goods_seq"];//주문 상품 일련번호
                                                        $buy_goods_code = $db_buy_goods[$j]["buy_goods_code"];//상품코드
                                                        $buy_goods_name = $db_buy_goods[$j]["buy_goods_name"];//상품명
                                                        $buy_goods_prefix = $db_buy_goods[$j]["buy_goods_prefix"];//상품명 머리말
                                                        $buy_goods_suffix = $db_buy_goods[$j]["buy_goods_suffix"];//상품명 꼬리말
                                                        $buy_goods_option = $db_buy_goods[$j]["buy_goods_option"];//옵션 1:있음 0:없음
                                                        $buy_goods_price = $db_buy_goods[$j]["buy_goods_price"];//판매단가 (+옵션가격포함)
                                                        $buy_goods_count = $db_buy_goods[$j]["buy_goods_count"];//구매개수
                                                        $buy_goods_price_total = $db_buy_goods[$j]["buy_goods_price_total"];//상품 총가격
                                                        $buy_goods_dlv_type = $db_buy_goods[$j]["buy_goods_dlv_type"];//배송비 유형 - 1:무료, 2:고정금액(주문시 선결제처럼추가됨?), 3:착불, 4:주문금액별, 5:무게별, 6:부피별
                                                        $buy_goods_status = $db_buy_goods[$j]["buy_goods_status"];//입금대기,입금완료,배송중....

                                                        $db->query("SELECT ImageName FROM upload_timages WHERE goods_code='$buy_goods_code'");
                                                        $db_upload_timages = $db->loadRows();
                                                        $tImageName = $db_upload_timages[0]["ImageName"];

                                                        if ($tmp_goods_code != $buy_goods_code) {
                                                            $db->query("SELECT buy_goods_seq FROM buy_goods WHERE buy_goods_code='$buy_goods_code' AND buy_seq='$buy_seq'");
                                                            $db_buy_goods_code = $db->loadRows();
                                                            $rowspan = count($db_buy_goods_code);
                                                        }
                                                        if($buy_goods_option=="0"){
                                                            $mod = "buy_goods";
                                                        }else{
                                                            $mod = "buy_option";
                                                        }

                                                        if ($buy_goods_option == "0") {
                                                            ?>
                                                            <tr>
                                                                <?php
                                                                if ($j == 0) {
                                                                    ?>
                                                                    <td rowspan="<?= $cbuy_goods ?>">
                                                                        <?= date("Y-m-d", strtotime($buy_date)) ?>
                                                                        <br>
                                                                        (<?= $buy_code ?>)
                                                                        <br>

                                                                        <?php
                                                                        if ($buy_goods_status < 2) {
                                                                            echo '<button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data="cAll" data-code="' . $buy_code . '" data-seq="' . $buy_seq . '">주문전체취소</button>';
                                                                        } elseif ($buy_goods_status == 8) {
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light buy_ok" data="cList"  data-seq="' . $buy_seq . '">구매확정</button></p>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                ?>
                                                                <td>
                                                                    <div style="width:100%;float: left;">
                                                                        <label class="chk" style="float: left;">
                                                                            <input type="checkbox" name="sb_checkbox"
                                                                                   class="sb_checkbox<?= $class_check ?> citem<?= $buy_seq ?>"
                                                                                   data="<?= $class_check ?>"
                                                                                   value="<?= $buy_goods_seq ?>">
                                                                        </label>
                                                                        <span style="float: left;margin-left:5px;">
                                                                            <img
                                                                                src="userFiles/images/brandImages/<?=$tImageName?>"
                                                                                width="50" height="50">
                                                                        </span>
                                                                        <div
                                                                            style="overflow:hidden;text-align: left;padding-left:5px;">
                                                                            <?php
                                                                            $db->query("SELECT id,goods_name,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$buy_goods_code'");
                                                                            $db_goods = $db->loadRows();
                                                                            $goods_opt_type = $db_goods[0]["goods_opt_type"];
                                                                            $goods_opt_num = $db_goods[0]["goods_opt_num"];
                                                                            $goods_name = $db_goods[0]["goods_name"];
                                                                            $goods_id = $db_goods[0]["id"];
                                                                            ?>
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
                                                                    <?= number_format($buy_goods_price_total) ?>원
                                                                    <br>
                                                                    (<?= $buy_goods_count ?>개)
                                                                </td>
                                                                <?php
                                                                if ($tmp_goods_code != $buy_goods_code) {
                                                                    ?>
                                                                    <td rowspan="<?= $rowspan ?>">
                                                                        <?php
                                                                        if ($buy_goods_dlv_type == "1") {
                                                                            $dlv_str = "무료";
                                                                        } else {

                                                                            $dlv_str = "2,500원";
                                                                        }
                                                                        if ($dlv_str == "") {
                                                                            echo "무료";
                                                                        } else if ($dlv_str != "무료") {
                                                                            echo "2,500원";
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <?php
                                                                    $tmp_goods_code = $buy_goods_code;
                                                                }
                                                                ?>
                                                                <td class="cart-total-price"><?php echo goods_status($buy_goods_status); ?>
                                                                    <br>
                                                                    <?php
                                                                    if ($buy_goods_status == 1) {
                                                                        echo "(" . date("m-d", strtotime($pay_pre_date)) . ")이내";
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <?php
                                                                if ($j == 0) {
                                                                    ?>
                                                                    <td rowspan="<?= $cbuy_goods ?>"
                                                                        class="cart-total-price">
                                                                        <?
                                                                        if ($buy_goods_status < 2) {
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data-cancel="0" data="cList"  data-seq="' . $buy_seq . '">주문취소</button></p>';
                                                                        } elseif ($buy_goods_status >= 2 && $buy_goods_status < 4) {
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data-cancel="1" data-status="1" data="cList"  data-seq="' . $buy_seq . '">환불신청</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data-cancel="3" data-status="1" data="cList"  data-seq="' . $buy_seq . '">교환신청</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light confirm_goods_qna" data="cList"  data-seq="' . $buy_seq . '">상품문의</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light goods_qna" data="cList"  data-seq="' . $buy_seq . '">1:1상담하기</button></p>';
                                                                        } elseif ($buy_goods_status == 4) {
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data-cancel="2" data-status="1" data="cList"  data-seq="' . $buy_seq . '">반품신청</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data-cancel="3" data-status="1" data="cList"  data-seq="' . $buy_seq . '">교환신청</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light bbs" mod="'.$mod.'" data="goods_qna" goods-seq="'.$goods_id.'" buy-goods-seq="' . $buy_goods_seq . '">상품문의</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light bbs" mod="'.$mod.'" data="onetoone" goods-seq="'.$goods_id.'" buy-goods-seq="' . $buy_goods_seq . '">1:1상담하기</button></p>';
                                                                        } elseif ($buy_goods_status == 8) {
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light view_dlv"  data="' . $buy_goods_seq . '">배송조회 </button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light bbs" mod="'.$mod.'" data="goods_qna"  goods-seq="'.$goods_id.'" buy-goods-seq="' . $buy_goods_seq . '">상품문의</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light bbs" mod="'.$mod.'" data="onetoone"  goods-seq="'.$goods_id.'" buy-goods-seq="' . $buy_goods_seq . '">1:1상담하기</button></p>';
                                                                        } elseif ($buy_goods_status == 16) {
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data-cancel="2" data-status="2" data="cList"  data-seq="' . $buy_seq . '">반품신청</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light cancel" data-cancel="3" data-status="2" data="cList"  data-seq="' . $buy_seq . '">교환신청</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light buy_ok" data="cList"  data-seq="' . $buy_seq . '">구매후기</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light bbs" data="cList" mod="'.$mod.'" goods-seq="'.$goods_id.'" buy-data="goods_qna" buy-goods-seq="' . $buy_goods_seq . '">상품문의</button></p>';
                                                                            echo '<p><button type="button" class="btn btn-xs btn-default waves-effect waves-light bbs" data="cList" mod="'.$mod.'" goods-seq="'.$goods_id.'" buy-data="onetoone" buy-goods-seq="' . $buy_goods_seq . '">1:1상담하기</button></p>';
                                                                        }
                                                                        ?>
                                                                    </td>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tr>
                                                            <?php
                                                            $class_check++;
                                                        } elseif ($buy_goods_option == "1") {
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <div style="width:100%;float: left;">
                                                                        <label class="chk" style="float: left;">
                                                                            <input type="checkbox"
                                                                                   class="op_checkbox<?= $class_check - 1 ?> citem<?= $buy_seq ?>"
                                                                                   data="<?= $class_check - 1 ?>"
                                                                                   name="op_checkbox"
                                                                                   value="<?= $buy_goods_seq ?>">
                                                                        </label>
                                                                        <div
                                                                            style="overflow:hidden;text-align: left;padding-left:5px;">
                                                                            <p style="word-break: break-all;border-collapse: collapse;">[추가상품]<? echo $buy_goods_name . "_" . $buy_goods_prefix ?></p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td><?= number_format($buy_goods_price) ?>원
                                                                    <br>
                                                                    (<?= $buy_goods_count ?>개)
                                                                </td>
                                                                <td><?php echo goods_status($buy_goods_status); ?>
                                                                    <br>
                                                                    (<? echo date("m-d", strtotime($pay_pre_date)) ?>이내)
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
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
    <? include_once("js.php") ?>

    <script type="text/javascript">
        $(".cancel").click(function () {
            var seq = "";
            var mod = $(this).attr("data");
            var data_cancel = $(this).attr("data-cancel");
            var data_status = $(this).attr("data-status");

            //alert(data_cancel + "---" + data_status);

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

            } else {
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
                mod: mod,
                data_cancel: data_cancel,
                data_status: data_status
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
            $(".modal-footer").css("display", "block");
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
        $(".buy_ok").click(function () {
            var message = confirm("구매확정하시겠습니까?");
            if (message == false) {
                return false;
            }
            var data_seq = $(this).attr("data-seq");
            var url = "buy_ok.php";
            var form_data = {
                data_seq: data_seq
            };
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                error: function (response) {
                    alert("mypage");
                },
                success: function (response) {
                    alert("구매확정 되셨습니다.감사합니다.");
                    location.reload();
                }
            });
        });
        $(".view_dlv").click(function () {
            var data_seq = $(this).attr("data");
            var url = "get_dlv_info.php";
            var form_data = {
                data_seq: data_seq
            };
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                error: function (response) {
                    alert("mypage");
                },
                success: function (response) {
                    $("#myModalLabel").text("배송업체 정보");
                    $(".modal-body").html("");
                    add_goods(response);
                    $(".modal-footer").css("display", "none");
                }
            });
        });
        $(".bbs").click(function () {
            var tdata = $(this).attr("data");//goods_qna onetoone
            var goods_seq = $(this).attr("goods-seq");
            var buy_goods_seq = $(this).attr("buy-goods-seq");
            var mod = $(this).attr("mod");//buy_goods ,buy_option
            if(tdata=="goods_qna"){
                var str = "상품문의";
            }else{
                var str = "1:1상담";
            }
            var form_data = {
                tdata : tdata,
                goods_seq : goods_seq,
                buy_goods_seq : buy_goods_seq,
                mod : mod
            };
            var url = "getbbs.php";
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                error: function (response) {
                    alert("mypage");
                },
                success: function (response) {
                    $("#myModalLabel").text(str);
                    $(".modal-body").html("");
                    add_goods(response);
                    //$(".modal-footer").css("display", "none");
                }
            });
        });
    </script>
</body></html>
