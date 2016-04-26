<?
include("common/config.shop.php");
include("check.php");
$page = @$_GET["page"];
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
if ($ou_delivery == "") {
      $ou_delivery = 1;
}
if ($ou_delivery == "1") {
      //입금대기 무통장
      $addQuery = " buy_status='1'";//입금대기
      $include_page = "buy_pay_wait.php";
} elseif ($ou_delivery == "2") {
      //입금완료
      $addQuery = " buy_status='2'";//입금완료
      $include_page = "buy_pay_ok.php";
} elseif ($ou_delivery == "4") {
      //배송 준비중
      $addQuery = " buy_status='4'";
      $include_page = "buy_dlv_wait.php";
} elseif ($ou_delivery == "8") {
      //배송중
      $addQuery = " buy_status='8'";
      $include_page = "buy_dlv_ing.php";
} elseif ($ou_delivery == "16") {
      //구매확정 배송완료
      $addQuery = " buy_status='16'";
      $include_page = "buy_dlv_ok.php";
} elseif ($ou_delivery == "32_8192") {
      //입금전 교환 취소
      $addQuery = " buy_status='1'";
      $addQuery .= "and pay_date!='0000-00-00 00:00:00'";
}
if (!empty($key)) {
      if (!empty($addQuery)) {
            $addQuery .= " and $keyfield='$key'";
      } else {
            $addQuery = " $keyfield='$key'";
      }
}
if (!empty($addQuery)) {
      $addQuery = " WHERE " . $addQuery;
}
if (empty($page)) {
      $page = 1;
}
$query = "select count(*) from buy $addQuery";

$result = mysql_query($query) or die($query);
$total_record = mysql_result($result, 0, 0);
if ($total_record == 0) {
      $first = 1;
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
            <script type="text/javascript" src="common/jslb_ajax.js"></script>
            <script type="text/javascript" src="common/brandList.js"></script>
            <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
            <script type="text/javascript" src="layer/layer.js"></script>
      </head>
      <body>
            <div id="total">
                  <? include("include/include.header.php"); ?>
                  <div id="left">
                        <ul id="x">
                              <?
                              //주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료,
                              // 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료
                              //입금대기(N)-결제와료/배송대기중(D)-배송중(Y)-배송완료(O)-반송중(R)-주문취소(C)
                              ?>
                              <li class="TitleLi1">주문관리</li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "1") echo "class='active'"; ?> href="orderList.php?delivery=1">입금대기중</a>
                              </li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "2") echo "class='active'"; ?> href="orderList.php?delivery=2">입금완료</a>
                              </li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "4") echo "class='active'"; ?> href="orderList.php?delivery=4">배송준비중</a>
                              </li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "8") echo "class='active'"; ?> href="orderList.php?delivery=8">배송중</a>
                              </li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "16") echo "class='active'"; ?> href="orderList.php?delivery=16">구매확정</a>
                              </li>
                              <li class="ml10">
                                    <a<?php if ($ou_delivery == "") echo "class='active'"; ?> href="orderList.php">주문리스트(전체)</a>
                              </li>
                              <li class="TitleLi1">주문취소 관리</li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "32_8192") echo "class='active'"; ?> href="orderList.php?delivery=32_8192">입금전 교환/취소 (0)</a>
                              </li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "D") echo "class='active'"; ?> href="orderList.php?delivery=D">배송전 교환/환불 (0)</a>
                              </li>
                              <li class="ml10">
                                    <a <?php if ($ou_delivery == "Y") echo "class='active'"; ?> href="orderList.php?delivery=Y">배송후 반품 (0)</a>
                              </li>
                              <li class="ml10">
                                    <a href="orderList.php?delivery=Y">배송후 교환 (0)</a>
                              </li>
                              <li class="ml10">
                                    <a href="orderList.php?delivery=O">미처리 주문 리스트 (0)</a>
                              </li>
                              <li class="ml10">
                                    <a href="orderList.php?delivery=R">주문리스트(전체)</a>
                              </li>
                              <li class="TitleLi1">거래증빙 관리</li>
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
                              </li>
                        </ul>
                  </div>
                  <div id="main">
                        <?
                        switch ($ou_delivery) {
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
                                    include_once ("buy_dlv_ing.php");
                                    break;
                              case 16:
                                    include_once ("buy_dlv_ok.php");
                                    break;
                        }

                        ?>
                  </div>
            </div>
      </body>
      <script>
            ;
            !function () {

//加载扩展模块
                  layer.config({
                        extend: 'extend/layer.ext.js'
                  });

//页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕

                  //官网欢迎页
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
                                    if (response == "true") {
                                          layer.tab({
                                                area: ['600px', '300px'],
                                                tab: [{
                                                      title: 'TAB1',
                                                      content: '内容1'
                                                }, {
                                                      title: 'TAB2',
                                                      content: '内容2'
                                                }, {
                                                      title: 'TAB3',
                                                      content: '内容3'
                                                }]
                                          });
                                    } else {
                                          alert("잠시후 다시 시도해 주세요.")
                                    }
                              }
                        });
                  });
//关于
                  $('#about').on('click', function () {
                        layer.alert(layer.v + ' - 贤心出品 sentsin.com');
                  });

            }();
            function CheckAll(val) {
                  $("input[name='check[]']").each(function () {
                        this.checked = val;
                  });
            }
      </script>
</html>
