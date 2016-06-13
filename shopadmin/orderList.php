<?
include("common/config.shop.php");
include("check.php");
$page = @$_GET["page"];
$code = $_GET["code"];
if (!@$_POST['key']) {
    $key = @$_GET['key'];
} else {
    $key = $_POST['key'];
}
if (!@$_POST['keyfield']) {
    $keyfield = @$_GET['keyfield'];
} else {
    $keyfield = $_POST['keyfield'];
}
$ou_delivery = @$_GET["delivery"];
$ou_payMethod = @$_GET["payMethod"];


if ($ou_delivery == "0") {
    $addQuery = "";
} elseif ($ou_delivery == "1") {
    //입금대기 무통장
    $addQuery = " buy_status='1'";//입금대기
} elseif ($ou_delivery == "2") {
    //입금완료
    $addQuery = " buy_status='2'";//입금완료
} elseif ($ou_delivery == "4") {
    //배송 준비중
    $addQuery = " buy_status='4'";
} elseif ($ou_delivery == "8") {
    //배송중
    $addQuery = " buy_status='8'";
} elseif ($ou_delivery == "16") {
    //구매확정 배송완료
    $addQuery = " buy_status='16'";
}
if (!empty($key)) {
    if (!empty($addQuery)) {
        $addQuery .= " and $keyfield='$key'";
    } else {
        $addQuery = " $keyfield='$key'";
    }
}

if (empty($page)) {
    $page = 1;
}
if ($code == "buy" || $code == "") {
    if ($addQuery != "") {
        $addQuery = "WHERE " . $addQuery;
    }
    if ($keyfield != "buy_goods_dlv_tag_no") {
        $query = "select count(buy_seq) from buy $addQuery";
    } else {
        $query = "select count(buy_seq) from buy WHERE buy_seq IN (SELECT buy_seq FROM buy_goods $addQuery)";
        $addQuery = "WHERE buy_seq IN (SELECT buy_seq FROM buy_goods WHERE $keyfield='$key')";//송장번호 조회할때 족건문을 위에거와 다르게 작성한다.
    }
    $result = mysql_query($query) or die($query);
    $total_record = mysql_result($result, 0, 0);
} elseif ($code == "claim") {
    if ($ou_delivery == "32_1") {
        $query = "SELECT count(buy_claim_seq) FROM buy_claim  WHERE  buy_claim_status='32' OR buy_claim_status='8192' AND buy_claim_status_before='0'";
        if ($key != "") {
            $addQuery2 = " buy_seq IN (SELECT buy_seq FROM buy WHERE $keyfield='$key')";
            $addQuery = "  WHERE  $addQuery2 AND buy_claim_status='32' OR buy_claim_status='8192' AND buy_claim_status_before='0'";
        } else {
            $addQuery = "  WHERE  buy_claim_status='32' OR buy_claim_status='8192' AND buy_claim_status_before='0'";
        }
    } elseif ($ou_delivery == "128_4") {
        $query = "SELECT count(buy_claim_seq) FROM buy_claim  WHERE buy_claim_status >='128' AND buy_claim_status <'512' OR buy_claim_status >= '8192' AND buy_claim_status_before='1'";
        if ($key != "") {
            $addQuery2 = " buy_seq IN (SELECT buy_seq FROM buy WHERE $keyfield='$key')";
            $addQuery = "  WHERE  $addQuery2 AND buy_claim_status >='128' AND buy_claim_status <'512' OR $addQuery2 AND buy_claim_status >= '8192' AND buy_claim_status_before='1'";
        } else {
            $addQuery = "  WHERE  buy_claim_status >='128' AND buy_claim_status <'512' OR buy_claim_status >= '8192' AND buy_claim_status_before='1'";
        }
    } elseif ($ou_delivery == "512") {
        $query = "SELECT count(buy_claim_seq) FROM buy_claim  WHERE buy_claim_status >='512' AND buy_claim_status <='4096' AND buy_claim_status_before='2'";
        if ($key != "") {
            $addQuery2 = " buy_seq IN (SELECT buy_seq FROM buy WHERE $keyfield='$key')";
            $addQuery = "  WHERE  $addQuery2 AND buy_claim_status >='512' AND buy_claim_status <='4096' AND buy_claim_status_before='2'";
        } else {
            $addQuery = "  WHERE  buy_claim_status >='512' AND buy_claim_status <='4096' AND buy_claim_status_before='2'";
        }
    } elseif ($ou_delivery == "8192") {
        $query = "SELECT count(buy_claim_seq) FROM buy_claim  WHERE buy_claim_status >='8192' AND buy_claim_status_before='2'";
        if ($key != "") {
            $addQuery2 = " buy_seq IN (SELECT buy_seq FROM buy WHERE $keyfield='$key')";
            $addQuery = "  WHERE  $addQuery2 AND buy_claim_status >='8192' AND buy_claim_status_before='2'";
        } else {
            $addQuery = "  WHERE buy_claim_status >='8192' AND buy_claim_status_before='2'";
        }
    }

    //echo "<span style='color:#fff'>".$query."</span><br>";
    $result = mysql_query($query) or die($query);
    $total_record = mysql_result($result, 0, 0);
}
if ($total_record == 0) {
    $first = 0;
} else {
    $first = ($page - 1) * $bnum_per_page;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>주문내역</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css"/>
        <link rel="stylesheet" type="text/css" href="css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="css/orderList.css"/>
        <link rel="stylesheet" type="text/css" href="css/mask.css"/>
        <link rel="stylesheet" type="text/css" href="layer/skin/layer.css"/>
        <link rel="stylesheet" href="assets/css/font-awesome.css">
        <script type="text/javascript" src="common/jslb_ajax.js"></script>
        <script type="text/javascript" src="common/brandList.js"></script>
        <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="layer/layer.js"></script>
        <style type="text/css">
            .tab-no-border td {
                border:0px !important;
            }
            .memberListTable .label {
                font-size: 10pt;
                font-weight: bold;
                letter-spacing: -1px;
                padding: 0px 10px 0 10px;
                background-color: #f4f4f4;
                color: #5e5e5e;
                height: 30px;
                border-bottom: solid 1px #c8c8c8;
            }
            .memberListTable .box {
                padding: 3px 10px 3px 10px;
            }
            .memberListTable .text {
                border-bottom: solid 1px #c8c8c8;
                border-left: solid 1px #c8c8c8;
                border-top: solid 1px #c8c8c8;
            }
            .fc_red {
                color: #ff1e00;
            }
            .fc_red_b {
                color: #ff1e00;
                font-weight: bold;
            }
            .fc_blue02_s {
                color: #4372e9;
                font-size: 11px;
            }
            .tbstylea .label {
                font-size: 10pt;
                font-weight: bold;
                letter-spacing: -1px;
                padding: 0px 10px 0 10px;
                background-color: #f4f4f4;
                color: #5e5e5e;
                height: 30px;
                border-bottom: solid 1px #c8c8c8 !important;
                border-top: solid 1px #c8c8c8 !important;
            }
            .tbstylea .box {
                padding: 3px 10px 3px 10px;
            }
            .tbstylea .text {
                border-bottom: solid 1px #c8c8c8 !important;
                border-left: solid 1px #c8c8c8 !important;
                border-top: solid 1px #c8c8c8 !important;
            }
            .alignCenter {
                clear: both;
                padding: 10px 0 10px 0;
                text-align: center !important;
            }
        </style>
    </head>
    <body>
        <div id="total">
            <? include("include/include.header.php"); ?>
            <div id="main" style="float: right;">
                <?
                switch ($ou_delivery) {
                    case 0:
                        include_once("buy.php");
                        break;
                    case 1:
                        include_once("buy_pay_wait.php");
                        break;
                    case 2:
                        include_once("buy_pay_ok.php");
                        break;
                    case 4:
                        include_once("buy_dlv_wait.php");
                        break;
                    case 8:
                        include_once("buy_dlv_ing.php");
                        break;
                    case 16:
                        include_once("buy_dlv_ok.php");
                        break;
                    case "32_1":
                        include_once("buy_cancel.php");
                        break;
                    case "128_4":
                        include_once("buy_refund.php");
                        break;
                    case "512":
                        include_once("buy_return.php");
                        break;
                    case "8192":
                        include_once("buy_exch.php");
                        break;
                    case "order":
                        include_once("buy_order.php");
                        break;
                }
                ?>
            </div>
            <div id="left" style="float:left;">
                <ul id="x">
                    <?
                    //주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료,
                    // 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료
                    //입금대기(N)-결제와료/배송대기중(D)-배송중(Y)-배송완료(O)-반송중(R)-주문취소(C)
                    //SELECT buy_seq FROM buy WHERE buy_status='1' ORDER BY buy_seq DESC limit 0,23
                    $query = "SELECT count(buy_seq) FROM buy WHERE buy_status='1'";
                    $result = mysql_query($query) or die("error orderList");
                    $buy_pay_1_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_seq) FROM buy WHERE buy_status='2'";
                    $result = mysql_query($query) or die("error orderList");
                    $buy_pay_2_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_seq) FROM buy WHERE buy_status='4'";
                    $result = mysql_query($query) or die("error orderList");
                    $buy_pay_4_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_seq) FROM buy WHERE buy_status='8'";
                    $result = mysql_query($query) or die("error orderList");
                    $buy_pay_8_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_seq) FROM buy WHERE buy_status='16'";
                    $result = mysql_query($query) or die("error orderList");
                    $buy_pay_16_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_claim_goods_seq) FROM buy_claim_goods  WHERE buy_claim_goods_seq IN (SELECT buy_claim_seq FROM buy_claim  WHERE buy_claim_status='32' OR buy_claim_status='8192' AND buy_claim_status_before='0')";
                    $result = mysql_query($query) or die("orderList");
                    $buy_cancel_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_claim_goods_seq) FROM buy_claim_goods  WHERE buy_claim_goods_seq IN (SELECT buy_claim_seq FROM buy_claim  WHERE buy_claim_status >='128' AND buy_claim_status <'512' OR buy_claim_status >= '8192' AND buy_claim_status_before='1')";
                    $result = mysql_query($query) or die("orderList");
                    $buy_refund_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_claim_goods_seq) FROM buy_claim_goods  WHERE buy_claim_goods_seq IN (SELECT buy_claim_seq FROM buy_claim  WHERE buy_claim_status >='512' AND buy_claim_status <='4096' AND buy_claim_status_before='2')";
                    $result = mysql_query($query) or die("orderList");
                    $buy_return_count = mysql_result($result, 0, 0);

                    $query = "SELECT count(buy_claim_goods_seq) FROM buy_claim_goods  WHERE buy_claim_goods_seq IN (SELECT buy_claim_seq FROM buy_claim  WHERE buy_claim_status >='8192' AND buy_claim_status_before='2')";
                    $result = mysql_query($query) or die("orderList");
                    $buy_exch_count = mysql_result($result, 0, 0);
                    ?>
                    <li class="TitleLi1">주문관리</li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "1") echo "class='active'"; ?>
                            href="orderList.php?code=buy&delivery=1">입금대기중(<?= $buy_pay_1_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "2") echo "class='active'"; ?>
                            href="orderList.php?code=buy&delivery=2">입금완료(<?= $buy_pay_2_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "4") echo "class='active'"; ?>
                            href="orderList.php?code=buy&delivery=4">배송대기(<?= $buy_pay_4_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "8") echo "class='active'"; ?>
                            href="orderList.php?code=buy&delivery=8">배송중(<?= $buy_pay_8_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "16") echo "class='active'"; ?>
                            href="orderList.php?code=buy&delivery=16">구매확정(<?= $buy_pay_16_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "0") echo "class='active'"; ?>
                            href="orderList.php?delivery=0">주문리스트(전체)
                        </a>
                    </li>
                    <li class="TitleLi1">주문취소 관리</li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "32_1") echo "class='active'"; ?>
                            href="orderList.php?code=claim&delivery=32_1">입금전 교환/취소 (<?= $buy_cancel_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "128_4") echo "class='active'"; ?>
                            href="orderList.php?code=claim&delivery=128_4">배송전 교환/환불 (<?= $buy_refund_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "512") echo "class='active'"; ?>
                            href="orderList.php?code=claim&delivery=512">배송후 반품 (<?= $buy_return_count ?>)
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($ou_delivery == "8192") echo "class='active'"; ?>
                            href="orderList.php?code=claim&delivery=8192">배송후 교환 (<?= $buy_exch_count ?>)
                        </a>
                    </li>
                    <!--<li class="ml10">
                                                <a <?php /*if ($ou_delivery == "order") echo "class='active'"; */ ?>
                                                        href="orderList.php?code=claim&delivery=order">미처리 주문 리스트 (0)
                                                </a>
                                        </li>-->
                    <!--<li class="TitleLi1">거래증빙 관리</li>
                    <li class="ml10">
                            <a href="orderList.php?delivery=N">현금영수증 발행 관리</a>
                    </li>
                    <li class="ml10">
                            <a href="orderList.php?delivery=D">세금계산서 발행 관리</a>
                    </li>
                    <li class="ml10">
                            <a href="orderList.php?delivery=Y">전자세금계산서 관리</a>
                    </li>
                    <li class="ml10">
                            <a href="orderList.php?delivery=Y">전자세금계산서 로그</a>
                    </li>
                    <li class="TitleLi1">장바구니 과리</li>
                    <li class="ml10">
                            <a href="#">장바구니 관리</a>
                    </li>
                    <li class="TitleLi1">주문관련 설정</li>
                    <li class="ml10">
                            <a href="#">주문관련 설정</a>
                    </li>-->
                </ul>
            </div>
        </div>
    </body>

    <script>
        ;
        !function () {
            layer.config({
                extend: 'extend/layer.ext.js'
            });

            $(".oid").click(function () {
                var oid = $(this).text();
                var mod = $(this).attr("data");
                var data_form = {
                    ordernum: oid,
                    mod: mod
                };

                var url = "get_data.php";
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data_form,
                    success: function (response) {
                        layer.tab({
                            area: ['1100px', '750px'],
                            tab: [{
                                title: '주문상세정보',
                                content: response
                            }, {
                                title: '상담내역',
                                content: '<div style="padding:10px;background-color:darkslateblue;">상세내역</div>'
                            }, {
                                title: '주문변경내역',
                                content: '<div style="padding:10px;background-color:indianred;">주문변경내역</div>'
                            }]
                        });
                    }
                });
            });


        }();
        function CheckAll(val) {
            $("input[name='check[]']").each(function () {
                this.checked = val;
            });
        }
        $(".cancel").click(function () {
            var tdata = $(this).attr("data");
            var tdata_status = $(this).attr("data-status");
            var tdata_seq = $(this).attr("data-seq");
            var tdata_num = $(this).attr("data-num");
            var data_form = {
                tdata: tdata,
                tdata_status: tdata_status,
                tdata_seq: tdata_seq,
                tdata_num: tdata_num
            };
            $.ajax({
                url: 'buy_chg.php',
                type: 'POST',
                data: data_form,
                success: function (response) {
                    if (response == "true") {
                        alert("수정되였습니다.");
                        location.reload();
                        return false;
                    }
                }
            });
        });
    </script>
</html>
