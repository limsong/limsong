<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 19
 * Time: 오후 1:09
 */
?>
<div id="maninfo">
      <form name="orderListForm" method="post" action="buyDlvPost.php?page=<?= $page ?>&keyfield=<?= $keyfield ?>&key=<?= $key ?>" target="action_frame">
            <input type="hidden" name="dlv_chg_mod" class="dlv_chg_mod">
            <input type="hidden" name="pay_buy_status" class="pay_buy_status">
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
                        <th width="7%">수령인</th>
                        <th width="12%">결제금액</th>
                        <th width="6%">주문내역</th>
                        <th width="26%">배송정보입력</th>
                        <!--
                        <th width="18%">결제방법</th>
                        <th width="13%">결제일자</th>
                        -->
                  </tr>
                  <?php
                  $query = "SELECT * FROM buy $addQuery ORDER BY buy_seq DESC limit $first,$bnum_per_page";

                  $result = mysql_query($query) or die($query);
                  $index = 1;
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
                        $buy_status = $row["buy_status"];

                        $shopmembersQuery = "SELECT name FROM shopmembers WHERE id='$user_id'";
                        $shopmembersresult = mysql_query($shopmembersQuery) or die("error");
                        $sname = mysql_result($shopmembersresult, 0, 0);//주문인


                        ?>
                        <tr class="contentTr" onmouseover="this.style.backgroundColor='#f0f0f0'" onmouseout="this.style.backgroundColor=''">

                              <td align="center" height="30">
                                    <input type="checkbox" class="check_item" value="<?= $buy_seq ?>" name="check[]"/>
                              </td>
                              <!--<td align="center"></td>-->
                              <td align="center">
                                    <a href="javascript:;" class="oid" data="goods"><?= $ou_orderNum ?></a>
                                    <br><?= $ou_oDate ?>
                              </td>
                              <td align="center"><?= $sname ?></td>
                              <td align="center"><?= $ou_name ?></td>
                              <td align="center">
                                    <?= number_format($ou_payPrice - $buy_instant_discount + $pay_dlv_fee) ?>
                                    <span class="dlv_txt">( <?php echo paymethod($ou_payMethod); ?> )</span>
                              </td>
                              <td align="center"><?php echo goods_status($buy_status); ?>
                              </td>
                              <?php
                              $buy_goods_query = "SELECT dlv_com_seq,buy_goods_dlv_tag_no FROM buy_goods WHERE buy_seq='$buy_seq' limit 0,1";
                              $buy_goods_result = mysql_query($buy_goods_query) or die("buy_dlv_wait");
                              $ou_dlv_com_seq = mysql_result($buy_goods_result,0,0);
                              $buy_goods_dlv_tag_no = mysql_result($buy_goods_result,0,1);
                              if($buy_goods_dlv_tag_no == ""){
                                    $sub_str = "등록";
                              }else{
                                    $sub_str = "변경";
                              }
                              ?>
                              <td>
                                    <?php
                                    //dlv_com_flag    택배사 사용여부 0:사용안함 1:사용함
                                    $delivery_company_query = "SELECT * FROM delivery_company WHERE dlv_com_flag='1'";
                                    $delivery_company_result = mysql_query($delivery_company_query) or die("delivery_company_query");
                                    ?>
                                    <select name="dlv_company<?= $buy_seq ?>" class="dlv_company">
                                          <?
                                          while ($delivery_company_row = mysql_fetch_array($delivery_company_result)) {
                                                $dlv_com_seq = $delivery_company_row["dlv_com_seq"];//택배사 일련번호
                                                $dlv_com_name = $delivery_company_row["dlv_com_name"];//택배사 이름
                                                $dlv_com_is_default = $delivery_company_row["dlv_com_is_default"];//기본배송업체 0:아님 1:맞을
                                                if($ou_dlv_com_seq == $dlv_com_seq){
                                                      $select = "selected";
                                                }else{
                                                      $select = "";
                                                }
                                                if ($dlv_com_is_default == "1") {
                                                      echo '<option value="' . $dlv_com_seq . '" '.$select.'>' . $dlv_com_name . '</option>';
                                                } else {
                                                      echo '<option value="' . $dlv_com_seq . '" '. $select .'>' . $dlv_com_name . '</option>';
                                                }
                                          }
                                          ?>
                                    </select>
                                    <input type="text" name="buy_good_dlv_tag_no<?= $buy_seq ?>" tabindex="<?=$index?>" class="buy_good_dlv_tag_no buy_good_dlv_tag_no<?= $buy_seq ?>" value="<?php echo $buy_goods_dlv_tag_no;?>">
                                    <input type="button" class="memEleB sub_one" data="<?= $buy_seq ?>" value="<?php echo $sub_str;?>" style="width:40px;">
                              </td>
                        </tr>
                        <?php
                        $index++;
                  }
                  ?>
                  <tr>
                        <td colspan="7" style="text-align: right;">
                              <input type="button" class="memEleB sub_all" value="운송장번호 일괄변경">
                        </td>
                  </tr>
                  <tr>
                        <td colspan="7" style="text-align: right;">
                              주문상태변경
                              <select class="buy_status_chg" name="buy_status_chg">
                                    <option value="0">선택</option>
                                    <option value="2">입금완료</option>
                                    <option value="4">배송대기</option>
                                    <option value="16">배송완료</option>
                              </select>
                              <input type="button" class="memEleB btn_buy_status" value="배송상태변경">
                        </td>
                  </tr>
            </table>
      </form>
      <iframe name="action_frame" width="500" height="100" style="display:none"></iframe>
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
<script>
      $(document).ready(function(){
            $(".btn_buy_status").click(function(){
                  $(".pay_buy_status").val("1");
                  var mod2 = false;
                  if($(".check_item:checked").length>0){
                        var mod = $(".buy_status_chg").val();
                        if(mod =="0"){
                              alert("주문상태변경을 선택해 주세요.");
                              return false;
                        }

                        $(".check_item").each(function(){
                              if (this.checked) {
                                    var buy_seq = $(this).val();
                                    var buy_good_dlv_tag_no = $(".buy_good_dlv_tag_no"+buy_seq).val();
                                    if(buy_good_dlv_tag_no == ""){
                                          mod2 = true;
                                    }
                              }
                        });
                        if(mod2 == true){
                              alert("운송장 번호를 입력해주세요.");
                              return false;
                        }
                        $("form[name='orderListForm']").submit();
                  }else{
                        alert("변경할 상품을 선택해 주세요.");
                        return false;
                  }
            });

            //
            $(".sub_all").click(function () {
                  $(".dlv_chg_mod").val("all");
                  var mod = false;
                  if($(".check_item:checked").length>0){
                        $(".check_item").each(function () {
                              if(this.checked){
                                    var buy_seq = $(this).val();
                                    var buy_good_dlv_tag_no = $(".buy_good_dlv_tag_no"+buy_seq).val();
                                    if(buy_good_dlv_tag_no == ""){
                                          mod = true;
                                    }
                              }
                        });
                        if(mod == true){
                              alert("운송장 번호를 입력해주세요.");
                              return false;
                        }
                        $("form[name='orderListForm']").submit();
                  }
            });
            $(".sub_one").click(function () {
                  $(".dlv_chg_mod").val("one");
                  var tData = $(this).attr("data");
                  $(".check_item").each(function () {
                        if($(this).val() == tData){
                              this.checked = true;
                        }
                  });
                  $("form[name='orderListForm']").submit();
            });
      });
</script>