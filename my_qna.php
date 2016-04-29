<?
include_once("doctype.php");
$del_qna = $_POST["del_qna"];
if($del_qna != ""){
    $db->query("DELETE FROM tbl_bbs WHERE uid='$del_qna' AND user_id='$uname'");
    echo '<script>alert("삭제되였습니다.");location.href="goods_qna.php";</script>';
}
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
                <? include_once "mypage_side.php"; ?>
                <style type="text/css">
                    .active {
                        background: #76caf1 none repeat scroll 0 0 !important;
                    }

                    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
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
                                <div class="table-responsive">
                                    <?php
                                    $db->query("SELECT * FROM tbl_bbs WHERE user_id='$uname' AND qna_mod='1'");
                                    $dbdata = $db->loadRows();
                                    $count = count($dbdata);
                                    ?>
                                    <div class="col-md-12 no-padding">
                                        <ul style="width:100%;margin:10px 0px;float:left;">
                                            <li style="float: left;">총 상담문의 <b><?=$count?></b>건&nbsp;&nbsp;&nbsp;&nbsp;완료 <b>2</b>건&nbsp;&nbsp;&nbsp;&nbsp;대기 <b>2</b>건&nbsp;&nbsp;&nbsp;&nbsp;보류 <b>2</b>건</li>
                                            <li style="float: right;">
                                                <button type="button" class="buynow btn btn-purple btn-xs waves-effect waves-light my_qna" data-mod="my_qna">상담등록</button>
                                            </li>
                                        </ul>

                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td width="5%">NO</td>
                                                <td width="15%">분류</td>
                                                <td width="*">제목</td>
                                                <!--<td width="15%">관련정보</td>-->
                                                <td width="10%">등록일</td>
                                                <td width="15%">처리</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        for ($i = 0; $i < $count; $i++) {
                                            $uid = $dbdata[$i]["uid"];
                                            $buy_goods_seq = $dbdata[$i]["buy_goods_seq"];
                                            $goods_seq = $dbdata[$i]["goods_seq"];
                                            $user_id = $dbdata[$i]["user_id"];
                                            $title = $dbdata[$i]["title"];
                                            $comment = $dbdata[$i]["comment"];
                                            $qna_reg_date = date("Y-m-d",strtotime($dbdata[$i]["qna_reg_date"]));
                                            $cate_code = $dbdata[$i]["cate_code"];//배송관련,모델지원,환불관련,상품문의
                                            $qna_status = $dbdata[$i]["qna_status"];

                                            if($qna_status == 0){
                                                $btn = '<button type="button" class="buynow btn btn-default btn-xs waves-effect waves-light">미답변</button>
                                                        <button type="submit" class="buynow btn btn-default btn-xs waves-effect waves-light">답변취소</button>';
                                            }
                                            $db->query("SELECT goods_code,goods_name FROM goods WHERE id='$goods_seq'");
                                            $db_goods = $db->loadRows();
                                            $goods_code = $db_goods[0]["goods_code"];
                                            $goods_name = $db_goods[0]["goods_name"];
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td><?= $dbdata[$i]['uid'] ?></td>
                                                    <td><?= $cate_code ?></td>
                                                    <td class="txt_ag_left">
                                                        <a href="javascript:;" class="qna" data="<?=$uid?>"><?= $title ?></a>
                                                    </td>
                                                    <!--<td></td>-->
                                                    <td><?= $qna_reg_date ?></td>
                                                    <td>
                                                        <form action="my_qna.php" method="post">
                                                            <input type="hidden" name="del_qna" value="<?=$uid?>">
                                                            <?= $btn ?>
                                                        </form>
                                                    </td>
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
                    </section>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display: none;">Launch demo modal </button>
        <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
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
    <? include_once("footer.php") ?>
    <!--FOOTER AREA END-->


    <!-- JS -->
    <? include_once("js.php") ?>

    <script>
        $(".my_qna").click(function () {
            var mod = $(this).attr("data-mod");//goods_qna,my_qna

            var form_data = {
                mod : mod
            };
            var url = "write_my_qna.php";
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                error: function (response) {
                    alert("mypage");
                },
                success: function (response) {
                    $("#myModalLabel").text("qna");
                    $(".modal-body").html("");
                    add_goods(response);
                    //$(".modal-footer").css("display", "none");
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
                if($(".qna_data").val()==""){
                    alert("내용이 비였습니다.");
                    return false
                }
                $(".cancelForm").submit();
            });
        }
        $(".qna").click(function () {
            var tdata = $(this).attr("data");//goods_qna,my_qna

            var form_data = {
                tdata : tdata
            };
            var url = "get_qna.php";
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                error: function (response) {
                    alert("mypage");
                },
                success: function (response) {
                    $("#myModalLabel").text("qna");
                    $(".modal-body").html("");
                    add_goods(response);
                    $(".modal-footer").css("display", "none");
                }
            });
        });
    </script>
</body></html>
