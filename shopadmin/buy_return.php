<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 19
 * Time: 오후 1:09
 */
?>
<div id="maninfo">
      <form name="orderListForm" action="">
            <table align="center" width="100%" class="memberListTable" border="0" cellspacing="0" ellpadding="0">
                  <tr class="menuTr">
                        <th width="5%" height="30">
                              <input type="checkbox" onclick="CheckAll(this.checked)" />
                        </th>
                        <!--<th width="23%"></th>-->
                          <th width="12%">신청시각</th>
                          <th width="7%">주문인</th>
                          <th width="20%">주문번호</th>
                          <th width="20%">취소상품</th>
                          <th width="5%">수량</th>
                          <th width="10%">상품금액</th>
                          <th width="15%">결제방법</th>
                          <th width="7%">교환/환불</th>
                  </tr>
                  <?php
                  $currentTime = time();
                  $query = "SELECT * FROM buy_claim  where buy_claim_status >='512' AND buy_claim_status <='4096' AND buy_claim_status_before='2' ORDER BY buy_seq DESC limit $first,$bnum_per_page";
                  $result = mysql_query($query) or die($query);
                  while ($row = mysql_fetch_assoc($result)) {
                        $buy_claim_sdate = date("Y-m-d H:i",strtotime($row["buy_claim_sdate"]));
                        $buy_claim_code = $row["buy_claim_code"];//주문 클레임 코드 - C, R, T, E (ex) C11111
                        $buy_claim_is_all = $row["buy_claim_is_all"];//주문 전체/부분여부 - 0:부분, 1:전체
                        $buy_seq = $row["buy_seq"];
                        $user_id = $row["user_id"];//'신청자 ID
                        $buy_claim_officer_id = $row["buy_claim_officer_id"];//처리자 ID
                        $buy_claim_type = $row["buy_claim_type"];//클레임 처리유형 - 1:고객, 2: 관리자, 3: 자동
                        $buy_claim_seq = $row["buy_claim_seq"];
                        $buy_claim_type = $row["buy_claim_type"];
                        $buy_claim_status = $row["buy_claim_status"];
                        if($buy_claim_status == "512"){
                              $str = '<input type="button" class="memEleB" value="반품">';
                        }


                        $buy_claim_goods_query = "SELECT * FROM buy_claim_goods WHERE buy_claim_seq='$buy_claim_seq'";
                        $buy_claim_goods_result = mysql_query($buy_claim_goods_query) or die("buy_cancel");
                        $i = 0;
                        echo  '<tbody>';
                        while($buy_claim_goods_row=mysql_fetch_array($buy_claim_goods_result)) {
                              $rowspan =count($buy_claim_goods_row);
                              $buy_goods_new_count = $buy_claim_goods_row["buy_goods_new_count"];
                              $buy_goods_req_seq = $buy_claim_goods_row["buy_goods_req_seq"];



                                $buy_goods_query = "SELECT buy_goods_price_total,buy_goods_name,buy_goods_prefix,buy_goods_option FROM buy_goods WHERE buy_goods_seq='$buy_goods_req_seq'";
                                $buy_goods_result = mysql_query($buy_goods_query) or die("buy_cancel");
                                $buy_goods_row = mysql_fetch_array($buy_goods_result);
                                $buy_goods_price_total = $buy_goods_row["buy_goods_price_total"];
                                $godosName = $buy_goods_row["buy_goods_name"]."_".$buy_goods_row["buy_goods_prefix"];
                                $buy_goods_option = $buy_goods_row["buy_goods_option"];


                              $buy_query = "SELECT buy_date,buy_code,pay_method FROM buy WHERE buy_seq='$buy_seq'";
                              $buy_result = mysql_query($buy_query) or die("buy_cancel");
                              $buy_row = mysql_fetch_array($buy_result);
                              $buy_date = $buy_row["buy_date"];//주문날짜
                              $buy_code = $buy_row["buy_code"];
                              $pay_method = paymethod($buy_row["pay_method"]);


                              $shopmembersQuery = "SELECT name FROM shopmembers WHERE id='$user_id'";
                              $shopmembersresult = mysql_query($shopmembersQuery) or die("error");
                              $sname = mysql_result($shopmembersresult, 0, 0);//주문인
                                if($i ==0) {
                                        ?>
                                        <tr class="contentTr" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor=''">
                                                <td align="center" rowspan="<?= $rowspan ?>" height="30" ><input type="checkbox" class="check_item" value="<?= $buy_seq ?>" name="check[]"/></td>
                                                <td align="center" rowspan="<?= $rowspan ?>"><?= $buy_claim_sdate ?></td>
                                                <td align="center" rowspan="<?= $rowspan ?>"><?= $sname ?></td>
                                                <td align="center" rowspan="<?= $rowspan ?>"> <a href="javascript:;" class="oid" data="goods"><?= $buy_code ?></a></td>
                                                <td style="padding:0px 5px;" height="30"><? if($buy_goods_option=="0") echo "삼품명 : ";else echo "옵션명 : " ?><?=$godosName?></td>
                                                <td align="center"><?=$buy_goods_new_count?></td>
                                                <td align="center"><?=number_format($buy_goods_price_total*$buy_goods_new_count)?></td>
                                                <td align="center"><?=$pay_method?></td>
                                                <td align="center" rowspan="<?= $rowspan ?>"><?=$str?></td>
                                        </tr>
                                        <?php
                                }else{
                                        ?>
                                        <tr>
                                                <td style="padding:0px 5px;" height="30"><? if($buy_goods_option=="0") echo "삼품명 : ";else echo "옵션명 : " ?><?=$godosName?></td>
                                                <td align="center"><?=$buy_goods_new_count?></td>
                                                <td align="center"><?=number_format($buy_goods_price_total*$buy_goods_new_count)?></td>
                                                <td align="center"><?=$pay_method?></td>
                                        </tr>
                                        <?php
                                }
                                $i++;
                        }
                        echo '</tbody>';
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
                  <input type="text" class="border2" name="key" size="16" />
                  <select name="keyfield" class="border3">
                        <option value="id">주문인</option>
                        <option value="id">수령인</option>
                        <option value="v_oid">주문번호</option>
                  </select>
                  <input type="submit" class="memEleB" value="검색" />
                  <input type="button" class="memEleB" value="삭제" name="delete" onclick="orderListDel(document.orderListForm)" />
            </li>
      </ul>
</form>
<script>
      $(document).ready(function(){
            $(".btn_buy_status").click(function(){
                  if($(".check_item:checked").length>0){
                        var url = "payStatusPost.php";
                        var mod = $(".buy_status_chg").val();
                        if(mod =="0"){
                              alert("주문상태변경을 선택해 주세요.");
                              return false;
                        }
                        var dataCode = "";
                        $(".check_item").each(function(){
                              if (this.checked) {
                                    if(dataCode==""){
                                          dataCode = $(this).val();
                                    }else{
                                          dataCode += ","+$(this).val();
                                    }
                              }
                        });
                        var form_data = {
                              code: dataCode,
                              mod: mod
                        };
                        $.ajax({
                              type: "POST",
                              url: url,
                              data: form_data,
                              success: function (response) {
                                    if(response == "success"){
                                          alert("상태가 변경 되였습니다.");
                                          location.reload();
                                    }else{
                                          alert("변경 실패");
                                          return false;
                                    }
                              }
                        });
                  }else{
                        alert("변경할 상품을 선택해 주세요.");
                        return false;
                  }
            });
      });
</script>