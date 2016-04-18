<?
include("common/config.shop.php");
include("check.php");
$page = $_GET["page"];

if (!$_POST['key']) {

        $key = $_GET['key'];

} else {

        $key = $_POST['key'];

}

if (!$_POST['keyfield']) {

        $keyfield = $_GET['keyfield'];

} else {

        $keyfield = $_POST['keyfield'];

}

$ou_delivery = $_GET["delivery"];

$ou_payMethod = $_GET["payMethod"];

$ou_orderNum = $_GET["orderNum"];

if (empty($page)) {

        $page = 1;

}


$addQuery = " where orderNum='$ou_orderNum'";

$addQuery2 = " a.orderNum='$ou_orderNum'";

if (!empty($key)) {

        $addQuery .= " and $keyfield='$key'";

        $addQuery2 .= " and a." . $keyfield . "='$key'";

}

if (!empty($ou_delivery)) {

        $addQuery .= " and delivery='$ou_delivery'";

        $addQuery2 .= " and a.delivery='$ou_delivery'";

}


if (!empty($ou_payMethod)) {

        $addQuery .= " and payMethod='$ou_payMethod'";

        $addQuery2 .= " and a.payMethod='$ou_payMethod'";

}


$query = "select count(*) from basket $addQuery";

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

</head>

<body>

<div id="total">

        <? include("include/include.header.php"); ?>

        <div id="left">

                <ul id="leftMenu">

                        <li class="TitleLi1">결제정보</li>

                        <li class="ml10">- <a href="orderRead.php?payMethod=B&orderNum=<?= $ou_orderNum ?>">무통장입금(B)</a>
                        </li>

                        <li class="ml10">- <a href="orderRead.php?payMethod=C&orderNum=<?= $ou_orderNum ?>">카드(C)</a>
                        </li>

                        <li class="ml10">- <a
                                        href="orderRead.php?payMethod=T&orderNum=<?= $ou_orderNum ?>">실시간계좌이체(T)</a>
                        </li>

                        <li class="ml10 mb20">- <a href="orderRead.php?payMethod=H&orderNum=<?= $ou_orderNum ?>">핸드폰결제(H)</a>
                        </li>

                        <li class="TitleLi1">배송정보</li>

                        <li class="ml10">- <a href="orderRead.php?delivery=N&orderNum=<?= $ou_orderNum ?>">입금대기중(N)</a>
                        </li>

                        <li class="ml10">- <a
                                        href="orderRead.php?delivery=D&orderNum=<?= $ou_orderNum ?>">결제완료/배송대기중(D)</a>
                        </li>

                        <li class="ml10">- <a href="orderRead.php?delivery=Y&orderNum=<?= $ou_orderNum ?>">배송중(Y)</a>
                        </li>

                        <li class="ml10">- <a href="orderRead.php?delivery=O&orderNum=<?= $ou_orderNum ?>">배송완료(O)</a>
                        </li>

                        <li class="ml10">- <a href="orderRead.php?delivery=R&orderNum=<?= $ou_orderNum ?>">반송중(R)</a>
                        </li>

                        <li class="ml10">- <a href="orderRead.php?delivery=C&orderNum=<?= $ou_orderNum ?>">주문취소(C)</a>
                        </li>

                </ul>

        </div>

        <div id="main">

                <div id="maninfo">

                        <form name="orderListForm" method="post"
                                action="orderListDelPost.php?page=<?= $page ?>&keyfield=<?= $keyfield ?>&key=<?= $key ?>"
                                target="action_frame">

                                <table align="center" width="100%" class="memberListTable" border="0" cellspacing="0"
                                        cellpadding="0">

                                        <tr class="menuTr">

                                                <th width="5%" height="30">선택</th>

                                                <th width="5%">번호</th>

                                                <th width="25%">상품명</th>

                                                <th width="15%">주문번호</th>

                                                <th width="4%">개수</th>

                                                <th width="8%">결제액</th>

                                                <th width="8%">결제현황</th>

                                                <th width="8%">결제방법</th>

                                                <th width="10%">주문일자</th>

                                                <th width="10%">결제일자</th>

                                        </tr>

                                        <?php

                                        $currentTime = time();

                                        //$query="SELECT id,v_oid,num,v_amount,payMethod,delivery,signdate,pDate,goods_code  FROM basket $addQuery ORDER BY v_oid DESC limit $first,$bnum_per_page";

                                        $query = "SELECT a.id,a.v_oid,a.num,a.v_amount,a.payMethod,a.delivery,a.signdate,a.pDate,a.goods_code,a.opValue1,a.opValue2,b.goods_name,c.ImageName

                                        FROM basket a,goods b,upload_simages c
                                        
                                        WHERE $addQuery2 and a.goods_code=b.goods_code and a.goods_code=c.goods_code
                                        
                                        ORDER BY a.v_oid DESC limit $first,$bnum_per_page";

                                        //echo $query;

                                        $result = mysql_query($query) or die($query);

                                        $article_num = $total_record - ($page - 1) * $bnum_per_page;

                                        $void = $_GET["void"];

                                        while ($row = mysql_fetch_assoc($result)) {

                                                $name = $row["id"];

                                                $v_oid = stripslashes($row["v_oid"]);

                                                $num = $row["num"];

                                                $ou_amount = $row["v_amount"];

                                                $ou_payMethod = $row["payMethod"];

                                                $ou_delivery = $row["delivery"];

                                                $ou_signdate = date("Y-m-d H:i:s", $row["signdate"]);

                                                if ($row["pDate"] == "0") {

                                                        $ou_pDate = "";

                                                } else {

                                                        $ou_pDate = date("Y-m-d H:i:s", $row["pDate"]);

                                                }

                                                $ou_goods_code = $row["goods_code"];

                                                $smImage = $row["ImageName"];

                                                //echo $smImage;

                                                if (strcmp($v_oid, $void)) {

                                                        ?>

                                                        <tr class="contentTr" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor=''">

                                                        <?php

                                                } else {

                                                        ?>

                                                        <tr class="contentTr" bgcolor="#ffff00" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor=''">

                                                        <?php

                                                }

                                                ?>

                                                <td align="center" height="30">

                                                        <?php

                                                        if ($ou_payMethod == "Y") {

                                                                ?>

                                                                --

                                                                <?php

                                                        } else {

                                                                ?>

                                                                <input type="checkbox" value="<?= $v_oid ?>"
                                                                        name="check[]"/>

                                                        <?php } ?>

                                                </td>

                                                <td align="center"><?= $article_num ?></td>

                                                <td>

                                                        <table border="0" cellpadding="2" cellspacing="0">

                                                                <tr>

                                                                        <td>

                                                                                <a href="orderRead.php?v_oid=<?= $v_oid ?>&page=<?= $page ?>&key=<?= $key ?>&keyfield=<?= $keyfield ?>&delivery=<?= $ou_delivery ?>">

                                                                                        <img src="<? echo $brandImagesWebDir . $smImage; ?>"
                                                                                                width="30"/>

                                                                                </a>

                                                                        </td>

                                                                        <td>

                                                                                <table border="0" cellspacing="0"
                                                                                        cellpadding="0">

                                                                                        <tr>

                                                                                                <td><?= $row["goods_name"] ?></td>

                                                                                        </tr>

                                                                                        <tr>

                                                                                                <td>
                                                                                                        색상:<?= $row["opValue1"] ?>
                                                                                                        싸이즈:<?= $row["opValue2"] ?> <?= $num ?>
                                                                                                        개
                                                                                                </td>

                                                                                        </tr>

                                                                                </table>

                                                                        </td>

                                                                </tr>

                                                        </table>

                                                </td>

                                                <td align="center"><?= $ou_orderNum ?></td>

                                                <td align="center"><?= $num ?></td>

                                                <td align="center"><?= number_format($ou_amount * $num) ?> 원</td>

                                                <td align="center">

                                                        <?

                                                        switch ($ou_delivery) {

                                                                case "N" :
                                                                        echo "입금대기";

                                                                        break;

                                                                case "D" :
                                                                        echo "결제완료/배송대기중";

                                                                        break;

                                                                case "Y" :
                                                                        echo "배송중";

                                                                        break;

                                                                case "O" :
                                                                        echo "배송완료";

                                                                        break;

                                                                case "R" :
                                                                        echo "반송중";

                                                                        break;

                                                                case "C" :
                                                                        echo "주문취소";

                                                                        break;

                                                        }

                                                        ?>

                                                </td>

                                                <td align="center">

                                                        <?

                                                        switch ($ou_payMethod) {

                                                                case "B":
                                                                        echo "무통장입금";

                                                                        break;

                                                                case "C":
                                                                        echo "카드결제";

                                                                        break;

                                                                case "T":
                                                                        echo "실시간계좌이체";

                                                                        break;

                                                                case "H":
                                                                        echo "핸드폰결제";

                                                                        break;

                                                        }

                                                        ?>

                                                </td>

                                                <td align="center"><?= $ou_signdate ?></td>

                                                <td align="center" id="pDateTd">

                                                        <?php

                                                        if ($ou_delivery != 'N') {

                                                                echo $ou_pDate;

                                                        } else {

                                                                echo '-';

                                                        }

                                                        ?>

                                                </td>

                                                </tr>

                                                <tr>
                                                        <td colspan="10"
                                                                style="height: 1px;background-color: #c0c0c0;"></td>
                                                </tr>

                                                <?php

                                                $article_num--;

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

                                echo("<a href='orderRead.php?code=$code&key=$key&keyfield=$keyfield&page=1'> <img src='images/ico_first.gif' class='ico_arr' alt='처음으로가기' /></a>");

                        }

                        if ($block > 1) {

                                $bPage = $first_page - 1;

                                echo "[<a href='orderRead.php?code=$code&key=$key&keyfield=$keyfield&page=$bPage'>[이전 " . $bpage_per_block . "개]</a>] ";

                        }

                        if ($page > 1) {

                                $bfPage = $page - 1;

                                echo("<a href='orderRead.php?code=$code&key=$key&keyfield=$keyfield&page=$bfPage'> <img src='images/ico_pre.gif' class='ico_arr' alt='이전페이지' /></a>");

                        }


                        for ($my_page = $first_page; $my_page <= $last_page; $my_page++) {

                                if ($page == $my_page) {

                                        echo(" [<b>" . $my_page . "</b>]");

                                } else {

                                        echo(" [<a href='orderRead.php?code=$code&key=$key&keyfield=$keyfield&page=$my_page'>" . $my_page . "</a>]");

                                }

                        }

                        if ($page < $total_page) {

                                $nxPage = $page + 1;

                                echo("<a href='orderRead.php?code=$code&key=$key&keyfield=$keyfield&page=$nxPage'> <img src='images/ico_next.gif' class='ico_arr' alt='다음페이지' /></a>");

                        }

                        if ($block < $total_block) {

                                $nPage = $last_page + 1;

                                echo "[<a href='orderRead.php?code=$code&key=$key&keyfield=$keyfield&page=$nPage'>[다음 " . $bpage_per_block . "개]</a>]";

                        }

                        if ($page < $total_page) {

                                echo("<a href='orderRead.php?code=$code&key=$key&keyfield=$keyfield&page=$total_page'> <img src='images/ico_last.gif' class='ico_arr' alt='마지막으로가기' /></a>");

                        }

                        ?>

                </div>

                <form name="searchForm" method="post" action="orderRead.php?orderNum=<?= $ou_orderNum ?>">

                        <ul class="memberBottom">

                                <li>

                                        <!--

                                        <input type="text" class="border2"  name="key" size="16" />

                                        <select name="keyfield" class="border3">

                                            <option value="id">이름</option>

                                            <option value="v_oid">주문번호</option>

                                        </select>

                                        <input type="submit" class="memEleB"  value="검색" />

                                        -->

                                        <input type="button" class="memEleB" value="삭제" name="delete"
                                                onclick="orderListDel(document.orderListForm)"/>

                                        <input type="button" class="memEleB" value="목록"
                                                onclick="location.href='orderList.php?page=<? $page ?>&key=<? $key ?>&keyfield=<? $keyfield ?>'"/>

                                </li>

                        </ul>

                </form>

        </div>

</div>

</body>

</html>

