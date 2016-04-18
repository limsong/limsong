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
$addQuery = "";
if (!empty($ou_delivery)) {
    $addQuery = " pay_method='$ou_delivery'";
}
if (!empty($ou_payMethod)) {
    if (!empty($addQuery)) {
        $addQuery .= " and pay_method='$ou_payMethod'";
    } else {
        $addQuery = " pay_method='$ou_payMethod'";
    }
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

//echo $addQuery;
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
            <li class="ml10"><a href="orderList.php?delivery=1">입금대기중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=2">입금완료</a></li>
            <li class="ml10"><a href="orderList.php?delivery=4">배송준비중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=8">배송중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=O">구매확정</a></li>
            <li class="ml10"><a href="orderList.php?delivery=R">주문리스트(전체)</a></li>
            <li class="TitleLi1">주문취소 관리</li>
            <li class="ml10"><a href="orderList.php?delivery=N">입금대기중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=D">입금완료</a></li>
            <li class="ml10"><a href="orderList.php?delivery=Y">배송준비중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=Y">배송중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=O">구매확정</a></li>
            <li class="ml10"><a href="orderList.php?delivery=R">주문리스트(전체)</a></li>
            <li class="TitleLi1">거래증빙 과리</li>
            <li class="ml10"><a href="orderList.php?delivery=N">입금대기중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=D">입금완료</a></li>
            <li class="ml10"><a href="orderList.php?delivery=Y">배송준비중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=Y">배송중</a></li>
            <li class="ml10"><a href="orderList.php?delivery=O">구매확정</a></li>
            <li class="ml10"><a href="orderList.php?delivery=R">주문리스트(전체)</a></li>
            <li class="TitleLi1">장바구니 과리</li>
            <li class="ml10"><a href="#">장바구니 관리</a></li>
            <li class="TitleLi1">주문관련 설정</li>
            <li class="ml10"><a href="#">주문관련 설정</a></li>
        </ul>
    </div>
    <div id="main">
        <div id="maninfo">
            <form name="orderListForm" method="post"
                  action="orderListDelPost.php?page=<?= $page ?>&keyfield=<?= $keyfield ?>&key=<?= $key ?>"
                  target="action_frame">
                <table align="center" width="100%" class="memberListTable" border="0" cellspacing="0" ellpadding="0">
                    <tr class="menuTr">
                        <th width="5%" height="30">선택</th>
                        <th width="13%">주문일시</th>
                        <th width="14%">주문번호</th>
                        <th width="10%">주문인</th>
                        <th width="10%">수령인</th>
                        <th width="17%">결제금액/결제방법</th>
                        <th width="8%">진행상태</th>
                        <!--
                        <th width="18%">결제방법</th>
                        <th width="13%">결제일자</th>
                        -->
                    </tr>
                    <?php
                    $currentTime = time();
                    $query = "SELECT * FROM buy $addQuery ORDER BY buy_seq DESC limit $first,$bnum_per_page";
                    $result = mysql_query($query) or die($query);
                    while ($row = mysql_fetch_assoc($result)) {
                        $ou_name = $row["buy_user_name"];
                        $ou_payMethod = $row["pay_method"];//결제방법-카드(C)-무통장(B)-핸드폰(H)-실시간계좌이체(T)
                        $ou_orderNum = $row["buy_code"];//주문번호
                        //주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료,
                        // 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료
                        $ou_delivery = $row["buy_status"];
                        $ou_payPrice = $row["buy_total_price"];//결제금액
                        $user_id = $row["user_id"];
                        $ou_oDate = $row["buy_date"];//주문날짜
                        $ou_name = $row["buy_user_name"];//수령인

                        $query = "SELECT name FROM shopmembers WHERE id='$user_id'";
                        $result = mysql_query($query) or die("error");
                        $sname = mysql_result($result, 0, 0);//주문인
                        ?>
                        <tr class="contentTr" onmouseover="this.style.backgroundColor='#f0f0f0'"
                            onmouseout="this.style.backgroundColor=''">

                            <td align="center" height="30">
                                <input type="checkbox"
                                       value="<?= $ou_orderNum ?>"
                                       name="check[]"/>
                            </td>
                            <td align="center"><?= $ou_oDate ?></td>
                            <td align="center">
                                <!--
                                                                <a href="orderRead.php?orderNum=<?= $ou_orderNum ?>&page=<?= $page ?>&key=<?= $key ?>&keyfield=<?= $keyfield ?>">
                                                                <?= $ou_orderNum ?>
                                                                </a>
                                                                -->
                                <a href="javascript:;" class="oid" data="goods"><?= $ou_orderNum ?></a>
                            </td>
                            <td align="center"><?= $sname ?></td>
                            <td align="center"><?= $ou_name ?></td>
                            <td align="center">
                                <?= number_format($ou_payPrice) ?> <span class="dlv_txt">(
                                    <?
                                    switch ($ou_payMethod) {
                                        case "1":
                                            echo "무통장입금";
                                            break;
                                        case "2":
                                            echo "카드결제";
                                            break;
                                        case "32":
                                            echo "실시간계좌이체";
                                            break;
                                        case "16":
                                            echo "핸드폰결제";
                                            break;
                                    }
                                    ?>
                                    )</span>
                            </td>
                            <td align="center"><?
                                //주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료,
                                // 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료
                                $ou_delivery = $row["buy_status"];
                                switch ($ou_delivery) {
                                    case "0" :
                                        echo "주문중";
                                        break;
                                    case "1" :
                                        echo "입금대기";
                                        break;
                                    case "2" :
                                        echo "입금완료";
                                        break;
                                    case "4" :
                                        echo "배송대기";
                                        break;
                                    case "8" :
                                        echo "배송중";
                                        break;
                                    case "16" :
                                        echo "배송완료";
                                        break;
                                    case "32" :
                                        echo "취소신청";
                                        break;
                                    case "64" :
                                        echo "취소완료";
                                        break;
                                    case "128" :
                                        echo "환불신청";
                                        break;
                                    case "256" :
                                        echo "환불완료";
                                        break;
                                    case "512" :
                                        echo "반품신청";
                                        break;
                                    case "1024" :
                                        echo "반품배송중";
                                        break;
                                    case "2048" :
                                        echo "반품환불";
                                        break;
                                    case "4096" :
                                        echo "반품완료";
                                        break;
                                    case "8197" :
                                        echo "교환신청";
                                        break;
                                    case "16384" :
                                        echo "교환배송중";
                                        break;
                                    case "32768" :
                                        echo "재주문처리";
                                        break;
                                    case "65536" :
                                        echo "교환완료";
                                        break;
                                }
                                ?>
                            </td>
                            <!--
                                                        <td align="center"><?
                            switch ($ou_payMethod) {
                                case "1":
                                    echo "무통장입금";
                                    break;
                                case "2":
                                    echo "카드결제";
                                    break;
                                case "32":
                                    echo "실시간계좌이체";
                                    break;
                                case "16":
                                    echo "핸드폰결제";
                                    break;
                            }
                            ?>
                                                        </td>
                                                        -->
                            <!--
                                                        <td align="center" id="pDateTd">
                                                                <?php
                            if ($ou_delivery != 'N') {
                                echo $ou_pDate;
                            } else {
                                echo '-';
                            }
                            ?>
                                                        </td>
                                                        -->
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </form>
        </div>
        <div class="pageNavi" style="text-align: center;">
            <?php
            $total_page = ceil($total_record / $bnum_per_page);                //35
            $total_block = ceil($total_page / $bpage_per_block);
            $block = ceil($page / $bpage_per_block);

            $first_page = ($block - 1) * $bpage_per_block + 1;
            if ($block >= $total_block) {
                $last_page = $total_page;
            } else {
                $last_page = $block * $bpage_per_block;
            }
            if ($page > 1) {
                echo("<a href='orderList.php?code=$code&key=$key&keyfield=$keyfield&page=1'> <img src='images/ico_first.gif' class='ico_arr' alt='처음으로가기' /></a>");
            }
            if ($block > 1) {
                $bPage = $first_page - 1;
                echo "[<a href='orderList.php?code=$code&key=$key&keyfield=$keyfield&page=$bPage'>[이전 " . $bpage_per_block . "개]</a>] ";
            }
            if ($page > 1) {
                $bfPage = $page - 1;
                echo("<a href='orderList.php?code=$code&key=$key&keyfield=$keyfield&page=$bfPage'> <img src='images/ico_pre.gif' class='ico_arr' alt='이전페이지' /></a>");
            }


            for ($my_page = $first_page; $my_page <= $last_page; $my_page++) {
                if ($page == $my_page) {
                    echo(" [<b>" . $my_page . "</b>]");
                } else {
                    echo(" [<a href='orderList.php?code=$code&key=$key&keyfield=$keyfield&page=$my_page'>" . $my_page . "</a>]");
                }
            }
            if ($page < $total_page) {
                $nxPage = $page + 1;
                echo("<a href='orderList.php?code=$code&key=$key&keyfield=$keyfield&page=$nxPage'> <img src='images/ico_next.gif' class='ico_arr' alt='다음페이지' /></a>");
            }
            if ($block < $total_block) {
                $nPage = $last_page + 1;
                echo "[<a href='orderList.php?code=$code&key=$key&keyfield=$keyfield&page=$nPage'>[다음 " . $bpage_per_block . "개]</a>]";
            }
            if ($page < $total_page) {
                echo("<a href='orderList.php?code=$code&key=$key&keyfield=$keyfield&page=$total_page'> <img src='images/ico_last.gif' class='ico_arr' alt='마지막으로가기' /></a>");
            }
            ?>
        </div>
        <form name="searchForm" method="post" action="orderList.php">
            <ul class="memberBottom">
                <li>
                    <input type="text" class="border2" name="key" size="16"/>
                    <select name="keyfield" class="border3">
                        <option value="id">이름</option>
                        <option value="v_oid">주문번호</option>
                    </select>
                    <input type="submit" class="memEleB" value="검색"/>
                    <input type="button" class="memEleB" value="삭제" name="delete"
                           onclick="orderListDel(document.orderListForm)"/>
                </li>
            </ul>
        </form>
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
            alert(oid+"--"+mod);
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
</script>
</html>
