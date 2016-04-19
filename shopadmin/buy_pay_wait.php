<div id="maninfo">
    <form name="orderListForm" method="post" action="orderListDelPost.php?page=<?= $page ?>&keyfield=<?= $keyfield ?>&key=<?= $key ?>" target="action_frame">
        <table align="center" width="100%" class="memberListTable" border="0" cellspacing="0" ellpadding="0">
            <tr class="menuTr">
                <th width="5%" height="30">
                    <input type="checkbox" onclick="CheckAll(this.checked)"/>
                </th>
                <!--<th width="23%"></th>-->
                <th width="14%">주문번호
                    <br>
                    주문일시
                </th>
                <th width="7%">주문인</th>
                <th width="7%">입금자</th>
                <th width="12%">결제금액/결제방법</th>
                <th width="6%">입금예정일</th>
                <th width="26%">입금계좌</th>
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
                $buy_seq = $row["buy_seq"];
                $ou_name = $row["buy_user_name"];
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
                $ou_oDate = $row["buy_date"];//주문날짜
                $ou_name = $row["buy_user_name"];//수령인
                $pay_online_name = $row["pay_online_name"];//입금인
                $pay_online_account = $row["pay_online_account"];//입금계좌
                $pay_pre_date = $row["pay_pre_date"];//입금예정일

                $shopmembersQuery = "SELECT name FROM shopmembers WHERE id='$user_id'";
                $shopmembersresult = mysql_query($shopmembersQuery) or die("error");
                $sname = mysql_result($shopmembersresult, 0, 0);//주문인
                ?>
                <tr class="contentTr" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor=''">

                    <td align="center" height="30">
                        <input type="checkbox" value="<?= $ou_orderNum ?>" name="check[]"/>
                    </td>
                    <!--<td align="center"></td>-->
                    <td align="center">
                        <a href="javascript:;" class="oid" data="goods"><?= $ou_orderNum ?></a>
                        <br><?= $ou_oDate ?>
                    </td>
                    <td align="center"><?= $sname ?></td>
                    <td align="center"><?= $pay_online_name ?></td>
                    <td align="center">
                        <?= number_format($ou_payPrice - $buy_instant_discount + $pay_dlv_fee) ?>
                        <span class="dlv_txt">(
                            <?
                            //결제수단 - 1:무통장, 2:카드, 4:적립금, 8:쿠폰, 16:휴대폰결제, 32:실시간 계좌이체, 64:가상계좌 무통장, 128:에스크로, 256:전액할인, 512:다날, 1024:모빌리언스, 2048:네이버 마일리지
                            switch ($ou_payMethod) {
                                case "1":
                                    echo "무통장입금";
                                    break;
                                case "2":
                                    echo "카드결제";
                                    break;
                                case "16":
                                    echo "휴대폰결제";
                                    break;
                                case "32":
                                    echo "실시간 계좌이체";
                                    break;
                                case "64":
                                    echo "가상계좌";
                                    break;
                                case "128":
                                    echo "에스크로";
                                    break;
                            }
                            ?>
                            )
                        </span>
                    </td>
                    <td align="center">
                        <? echo date("Y-m-d", strtotime("$pay_pre_date")); ?>
                    </td>
                    <td align="center">
                        <? echo $pay_online_account?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7" style="text-align: right;">
                    <input type="button" class="memEleB" value="입금완료">
                </td>
            </tr>
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
                <option value="id">주문인</option>
                <option value="id">수령인</option>
                <option value="v_oid">주문번호</option>
            </select>
            <input type="submit" class="memEleB" value="검색"/>
            <input type="button" class="memEleB" value="삭제" name="delete" onclick="orderListDel(document.orderListForm)"/>
        </li>
    </ul>
</form>
