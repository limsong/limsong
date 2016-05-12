<?php
include_once ("session.php");
include_once ("include/check.php");
include_once("doctype.php");
$in_uid = $_POST["uid"];
if($in_uid!=""){
    $in_qna_reg_date = date("Y-m-d H:i:s",time());
    $in_ipInfo = get_real_ip();
    $in_qna_data = $_POST["qna_data"];
    $db->query("INSERT INTO tbl_bbs_comment (puid,user_id,comment,qna_reg_date,ipInfo) VALUES ('$in_uid','$uname','$in_qna_data','$in_qna_reg_date','$in_ipInfo')");
    echo '<script>alert("댓글이 저장되였습니다.");location.href="goods_qna.php";</script>';
}
$del_data = $_POST["del_data"];
if($del_data != ""){
    $db->query("DELETE FROM tbl_bbs_comment WHERE uid='$del_data' AND user_id='$uname'");
    echo '<script>alert("댓글이 삭제되였습니다.");location.href="goods_qna.php";</script>';
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
                        border-bottom: 1px solid #ddd;
                    }

                    .txt_ag_left {
                        text-align: left !important;
                        padding-left: 20px !important;
                    }
                </style>

                <div class="col-md-9 col-lg-10">
                    <section class="cart-area-wrapper">
                        <div class="container-fluid">
                            <div class="row cart-top">
                                <div class="table-responsive">
                                    <div class="col-md-12">상품문의
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <td width="5%">NO</td>
                                                <td width="15%">상품정보</td>
                                                <td width="*">제목</td>
                                                <td width="15%">등록일</td>
                                            </tr>
                                        </thead>
                                        <?
                                        $db->query("SELECT * FROM tbl_bbs WHERE user_id='$uname' AND qna_mod='0'");
                                        $dbdata = $db->loadRows();
                                        $count = count($dbdata);
                                        for ($i = 0; $i < $count; $i++) {
                                            $uid = $dbdata[$i]["uid"];
                                            $buy_goods_seq = $dbdata[$i]["buy_goods_seq"];
                                            $goods_seq = $dbdata[$i]["goods_seq"];
                                            $user_id = $dbdata[$i]["user_id"];
                                            $title = $dbdata[$i]["title"];
                                            $comment = $dbdata[$i]["comment"];
                                            $qna_reg_date = date("Y-m-d",strtotime($dbdata[$i]["qna_reg_date"]));
                                            $db->query("SELECT goods_code FROM goods WHERE id='$goods_seq'");
                                            $db_goods = $db->loadRows();
                                            $goods_code = $db_goods[0]["goods_code"];
                                            $db->query("SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code' LIMIT 0,1");
                                            $db_upload_timages = $db->loadRows();
                                            $imagename = $db_upload_timages[0]["ImageName"];
                                            $imgsrc = "userFiles/images/brandImages/$imagename";
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td><?= $dbdata[$i]['uid'] ?></td>
                                                    <td><a href="http://sozo.bestvpn.net/item_view.php?code=<?=$goods_code?>" target="_blank" style="line-height: 50px;height:50px;vertical-align:top;">
                                                            <img src="<?= $imgsrc ?>" width="50" height="50">
                                                        </a></td>
                                                    <td class="txt_ag_left"><a href="javascript:;" class="qna" data="<?=$uid?>" buy-goods-seq="<?=$buy_goods_seq?>" goods-seq="<?=$goods_seq?>" data-mod="goods_qna"><?= $title ?></a></td>
                                                    <td><?= $qna_reg_date ?></td>
                                                </tr>
                                            </tbody>
                                            <?
                                        }
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
        $(".qna").click(function () {
            var goods_seq = $(this).attr("goods-seq");
            var buy_goods_seq = $(this).attr("buy-goods-seq");
            var mod = $(this).attr("data-mod");//goods_qna,my_qna
            var tdata = $(this).attr("data");

            var form_data = {
                tdata: tdata,
                goods_seq : goods_seq,
                buy_goods_seq : buy_goods_seq,
                mod : mod
            };
            var url = "get_goods_qna.php";
            $.ajax({
                type: "POST",
                url: url,
                data: form_data,
                error: function (response) {
                    alert("mypage");
                },
                success: function (response) {
                    $("#myModalLabel").text("상품문의");
                    $(".modal-body").html("");
                    add_goods(response);
                    //$(".modal-footer").css("display", "none");
                }
            });
        });
        function add_goods(rep) {
            $(".modal-body").append(rep);
            $(".modal-footer").css("display", "none");
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
    </script>
</body></html>
