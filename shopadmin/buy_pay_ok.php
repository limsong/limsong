<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 19
 * Time: 오후 1:09
 */
?>
<div id="maninfo"><!--target="action_frame"-->
    <form name="orderListForm" class="orderListForm"  method="post">
        <table align="center" width="100%" class="memberListTable" border="0" cellspacing="0" ellpadding="0">
            <tr class="menuTr">
                <th width="5%" height="30">
                    <input type="checkbox" onclick="CheckAll(this.checked)"/>
                </th>
                <th width="15%">주문일시</th>
                <th width="21%">주문번호(주문내역)</th>
                <th width="10%">주문인</th>
                <th width="15%">결제금액</th>
                <th width="21%">진행상태</th>
                <th width="18%">거래증빙</th>
                <!--
                <th width="13%">결제일자</th>
                -->
            </tr>
            <?php
            $currentTime = time();
            $query = "SELECT * FROM buy $addQuery ORDER BY buy_seq DESC limit $first,$bnum_per_page";

            $result = mysql_query($query) or die($query);
            while ($row = mysql_fetch_assoc($result)) {

                $buy_seq = $row["buy_seq"];
                $buy_user_name = $row["buy_user_name"];//주문인
                $buy_goods_code = $row["buy_goods_code"];
                $ou_payMethod = $row["pay_method"];//결제방법-카드(C)-무통장(B)-핸드폰(H)-실시간계좌이체(T)
                $ou_orderNum = $row["buy_code"];//주문번호
                //주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료,
                // 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료
                $ou_delivery = $row["buy_status"];
                $ou_payPrice = $row["buy_total_price"];//결제금액
                $buy_instant_discount = $row["buy_instant_discount"];//즉시할인금액
                $pay_dlv_fee = $row["pay_dlv_fee"];//배송비
                $user_id = $row["user_id"];
                $buy_date = date("Y-m-d H:i", strtotime($row["buy_date"]));//주문날짜
                $ou_name = $row["buy_user_name"];//수령인
                $buy_status = $row["buy_status"];
                $buy_bill_type = $row["buy_bill_type"];//영수증/증빙서류 종류(table:buy_bill) 0:미신청 1:현금영수증신청 2:세금계산서신청


                /*$shopmembersQuery = "SELECT name FROM shopmembers WHERE id='$user_id'";
                $shopmembersresult = mysql_query($shopmembersQuery) or die("error");
                $sname = mysql_result($shopmembersresult, 0, 0);//주문인*/
                ?>
                <tr class="contentTr" onmouseover="this.style.backgroundColor='#f0f0f0'"
                    onmouseout="this.style.backgroundColor=''">

                    <td align="center" height="30">
                        <input type="checkbox" class="check_item" value="<?= $buy_seq ?>" name="check[]"/>
                    </td>
                    <td align="center"><?= $buy_date ?></td>
                    <td align="center">
                        <a href="javascript:;" class="oid" data="goods"><?= $ou_orderNum ?></a>
                        <br>
                    </td>
                    <td align="center"><?= $buy_user_name ?></td>
                    <td align="center">
                        <?= number_format($ou_payPrice - $buy_instant_discount + $pay_dlv_fee) ?>
                    </td>
                    <td align="center"><?php echo paymethod($ou_payMethod); ?></td>
                    <td align="center"><?= bill_status($buy_bill_type) ?></td>

                </tr>
                <?php
            }
            ?>
            <style type="text/css">
                .ace-file-input input[type=file] {
                    width: 1px;
                    height: 1px;
                    overflow: hidden;
                    opacity: 0;
                    filter: alpha(opacity=0);
                }
                .ace-file-input .ace-file-container:before {
                    content: attr(data-title);
                }
                .memEleBDown{
                    background: #1d6fa6;
                    background-image: linear-gradient(to bottom, #267eb8 0%, #136194 100%);
                    border-color: #1d6fa6;
                    color:#fff;
                }
            </style>
            <tr>
                <td colspan="10" style="text-align: right;">
                    주문상태변경
                    <select class="buy_status_chg" name="buy_status_chg">
                        <option value="0">선택</option>
                        <option value="4">배송대기</option>
                        <option value="8">배송중</option>
                        <option value="16">배송완료</option>
                    </select>
                    <input type="button" class="memEleB btn_buy_status" value="확인">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <select class="pageNum" name="view_pageNum">
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="300">300</option>
                        <option value="400">400</option>
                        <option value="500">500</option>
                    </select>
                </td>
            </tr>
        </table>
    </form>
    <table width="100%" border="0" cellspacing="0" ellpadding="0">
        <tr>
            <td align="right" class="ace-file-input">
                <span class="ace-file-container memEleB memEleBDown exceldown" data-title="Excel 다운로드">
                    <span><i class="ace-icon fa fa-cloud-download bigger-200"></i></span>
                </span>
            </td>
        </tr>
    </table>
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
        echo("<a href='orderList.php?code=buy&delive=2&key=$key&keyfield=$keyfield&page=1'> <input type=\"button\" class=\"memEleB\" value=\"처음으로가기\"/></a>");
    }
    if ($block > 1) {
        $bPage = $first_page - 1;
        echo "[<a href='orderList.php?code=buy&delive=2&key=$key&keyfield=$keyfield&page=$bPage'>[이전 " . $bpage_per_block . "개]</a>] ";
    }
    if ($page > 1) {
        $bfPage = $page - 1;
        echo("<a href='orderList.php?code=buy&delive=2&key=$key&keyfield=$keyfield&page=$bfPage'> <input type=\"button\" class=\"memEleB\" value=\"이전페이지\"/></a>");
    }


    for ($my_page = $first_page; $my_page <= $last_page; $my_page++) {
        if ($page == $my_page) {
            echo(" [<b>" . $my_page . "</b>]");
        } else {
            echo(" [<a href='orderList.php?code=buy&delive=2&key=$key&keyfield=$keyfield&page=$my_page'>" . $my_page . "</a>]");
        }
    }
    if ($page < $total_page) {
        $nxPage = $page + 1;
        echo("<a href='orderList.php?code=buy&delive=2&key=$key&keyfield=$keyfield&page=$nxPage'> <input type=\"button\" class=\"memEleB\" value=\"다음페이지\"/></a>");
    }
    if ($block < $total_block) {
        $nPage = $last_page + 1;
        echo "[<a href='orderList.php?code=buy&delive=2&key=$key&keyfield=$keyfield&page=$nPage'>[다음 " . $bpage_per_block . "개]</a>]";
    }
    if ($page < $total_page) {
        echo("<a href='orderList.php?code=buy&delive=2&key=$key&keyfield=$keyfield&page=$total_page'>  <input type=\"button\" class=\"memEleB\" value=\"마지막으로가기\"/></a>");
    }
    ?>
</div>
<form name="searchForm" method="post" action="orderList.php">
    <ul class="memberBottom">
        <li>
            <input type="text" class="border2" name="key" size="16"/>
            <select name="keyfield" class="border3">
                <option value="buy_user_name">주문인</option>
                <option value="buy_code">주문번호</option>
            </select>
            <input type="submit" class="memEleB" value="검색"/>
        </li>
    </ul>
</form>
<iframe name="action_frame" width="600" height="300"  style="display:none"></iframe>
<script>
    $(document).ready(function () {
        $(".btn_buy_status").click(function () {
            if ($(".check_item:checked").length > 0) {
                var url = "payStatusPost.php";
                var mod = $(".buy_status_chg").val();
                if (mod == "0") {
                    alert("주문상태변경을 선택해 주세요.");
                    return false;
                }
                var dataCode = "";
                $(".check_item").each(function () {
                    if (this.checked) {
                        if (dataCode == "") {
                            dataCode = $(this).val();
                        } else {
                            dataCode += "," + $(this).val();
                        }
                    }
                });
                var buy_status_chg = $(".buy_status_chg").val();
                var form_data = {
                    code: dataCode,
                    buy_status_chg: buy_status_chg,
                    mod: mod
                };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form_data,
                    success: function (response) {
                        if (response == "success") {
                            alert("상태가 변경 되였습니다.");
                            location.reload();
                        } else {
                            alert("변경 실패");
                            return false;
                        }
                    }
                });
            } else {
                alert("변경할 상품을 선택해 주세요.");
                return false;
            }
        });
        $(".exceldown").on("click", function () {
            var mod = false;
            $(".check_item:checked").each(function () {
                mod = true;
            });
            if(mod == false){
                alert("출력할 상품을 선택해 주세요.");
                return false;
            }
            var r = confirm("주문내역을 다운로드 받으시겠습니까?");
            if (r == true) {
                $(".orderListForm").attr("action","damon.php");
                $(".orderListForm").submit();

            } else {
                return false;
            }
        });
        //change
        $("#id-input-file-2").on("change",function () {
            var r = confirm("송장번호를 업로드 하시겠습니까?");
            if (r == true) {
                $(".excelupbtn").trigger("click");
            } else {
                alert("송장번호 업로드를 취소하였습니다.");
                return false;
            }
        });
    });
</script>