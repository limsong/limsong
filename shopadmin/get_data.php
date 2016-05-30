<?php
/**
 * Created by PhpStorm.
 * User: limsong
 * Date: 2016. 4. 12.
 * Time: 오후 4:34
 */
include("common/config.shop.php");
include("check.php");
$mod = $_POST["mod"];
$ordernum = $_POST["ordernum"];
if ($mod == "goods") {
    //상품검색
    $query = "select * from buy where buy_code='$ordernum'";
    $result = mysql_query($query) or die($query);
    $row = mysql_fetch_array($result);
    $row_count = count($row);

    //'결제수단 - 1:무통장, 2:카드, 4:적립금, 8:쿠폰, 16:휴대폰결제, 32:실시간 계좌이체, 64:가상계좌, 128:에스크로, 256:전액할인, 512:다날, 1024:모빌리언스, 2048:네이버 마일리지',
    $pay_method = $row["pay_method"];
    $buy_seq = $row["buy_seq"];
    $buy_code = $row["buy_code"];
    //주문일
    $buy_date = $row["buy_date"];

    $buy_goods_query = "select * from buy_goods where buy_seq='$buy_seq'";
    $buy_goods_result = mysql_query($buy_goods_query) or die("get_data buy_goods_query");
    $buy_goods_row = mysql_fetch_array($buy_goods_result);
    $buy_goods_row_count = count($buy_goods_row);

    $goods_code = $buy_goods_row["goods_code"];
    $goods_query = "select * from goods where goods_code='$goods_code'";
    $goods_result = mysql_query($goods_query) or die("get_data goods_query");
    $goods_row = mysql_fetch_array($goods_result);
    $goods_name = $goods_row["goods_name"];

    $goods_timg_query = "select ImageName from upload_timages where goods_code='$goods_code' limit 0,1";
    $goods_timg_result = mysql_query($goods_timg_query) or die("get_data goods_timg_query");
    $goods_timg_row = mysql_fetch_array($goods_timg_result);
    $img_name = $goods_timg_row["ImageName"];

    if($img_name == ""){
        $goods_simg_query = "select ImageName from upload_simages where goods_code='$goods_code' limit 0,1";
        $goods_simg_result = mysql_query($goods_simg_query) or die("get_data goods_simg_query");
        $goods_simg_row = mysql_fetch_array($goods_simg_result);
        $img_name = $goods_simg_row["ImageName"];
    }

    $imgSrc = $brandImagesWebDir.$img_name;

    $html = '
            <div style="padding:0px 10px">
                <div>기본정보'.$goods_timg_query.'</div>
                <div>
                    <table class="memberListTable" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    주문번호 : <span class="fc_blue_b">'.$buy_code.'</span><br>		
                                </td>
                                <td>
                                    주문일시 : '.$buy_date.'		
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>주문내역</div>
                <div> 
                    <table align="center" width="100%" class="memberListTable" border="0" cellspacing="0" ellpadding="0">
                        <colgroup>
                            <col width="*">
                            <col width="45">
                            <col width="75">
                            <col width="75">
                            <col width="75">
                            <col width="140">
                            <col width="85">
                        </colgroup>
                        <thead>
                            <tr class="menuTr">
                                <th>상품정보</th>
                                <th>수량</th>
                                <th>상품금액</th>
                                <th>할인금액</th>
                                <th>주문금액</th>
                                <th>배송정보</th>
                                <th>진행상태</th>
                            </tr>
                        </thead>
                    
                        <tbody>	
                            <tr>
                                <!-- 상품명(상품코드) -->
                                <td align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tab-no-border">
                                        <tbody>
                                            <tr>
                                                <td width="55" rowspan="2"><img src="'.$imgSrc.'" onerror="Durian.imgDefault(this, \'/data/file/0008_02713_200.jpg\');" class="imgborder" width="50" height="50"></td>
                                                <td align="left">
                                                    <span style="color:gray;">&nbsp;G54F81247D2EC4<br></span>
                                                    &nbsp;<a href="/item_view.php?code=" target="_blank"><u>바지&amp;벨트</u></a>
                                                    <span style="color:gray;margin-left:5px;"><br>&nbsp;&nbsp;· 기본상품 / 사이즈 : S / 색상 : 연두 / 1개  (30,000원) </span>
                            
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:10px 0 0 10px;">
                                                    <!-- 별도배송 -->
                                                                            <!-- 착불 -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <!-- 수량 -->
                                <td align="center">
                                    1		
                                </td>
                                <!-- 상품금액 -->
                                <td align="right" style="padding-right:10px">
                                    30,000		
                                </td>
                                <!-- 할인금액 -->
                                <td align="right" style="padding-right:10px">
                                    -10,000		
                                </td>
                                <!-- 주문금액 -->
                                <td align="right" style="padding-right:10px">
                                    <span class="fc_red_b">20,000</span>
                                </td>
                                <!-- 배송정보 -->
                                <td align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tab-no-border">
                                        <tbody>
                                            <tr>
                                                <td style="word-break:break-all;">
                                                    DS1605307145481I01					
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="tdR" align="center">
                                    입금대기
                                </td>
                            </tr>
                        </tbody>    
                    </table>
                </div>
                <div>결제내역</div>
                <div>
                    <table cellpadding="0" cellspacing="0" border="0" class="tbstylea" width="100%">
                        <colgroup>
                            <col width="160">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td colspan="2" class="top3"></td>
                            </tr>
                            <tr>
                                <td class="label">총 주문금액</td>
                                <td class="box text">
                                    30,000원 
                                    (상품금액 30,000원 + 배송비 0원 
                                                    무료						)
                                </td>
                            </tr>
                            <tr>
                                <td class="label">할인액</td>
                                <td class="box text">
                                    <span class="fc_red">10,000원</span>
                                    (
                                                        회원할인가 할인: <span class="fc_red">0원</span>
                                        + 쿠폰 할인: <span class="fc_red">0원</span>
                                        + 적립금 할인: <span class="fc_red">0p</span>
                                    )
                                </td>
                            </tr>
                            <tr>
                                <td class="label">결제금액</td>
                                <td class="box text">
                                    <input type="hidden" id="pay_price_normal" name="pay_price_normal" value="20000">
                                    20,000원 
                                    <span class="fc_blue02_s">( 결제금액 = 총주문금액 - 할인액 )</span>
                                </td>
                            </tr>
                            <!--
                                -->
                            <tr>
                                <td class="label">관리자 할인(할증)금액</td>
                                <td class="box text">			
                                    <select name="buy_admin_price_symbol" id="buy_admin_price_symbol">
                                        <option value="-">할인(-)</option>
                                        <option value="+">할증(+)</option>
                                    </select>
                                    <input type="hidden" name="buy_admin_price_org" value="0">
                                    <input type="text" id="buy_admin_price" name="buy_admin_price" value="0" class="inputbox2 price_only" style="width:100px;">
                                    <input type="submit" class="memEleB" value="바로적용">
                                    <strong><span class="fc_blue02_s">* 관리자 할인(할증)금액 변경시 최종 결제금액이 조정됩니다.</span></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">최종 결제금액</td>
                                <td class="box text">
                                    <input type="hidden" id="pay_price_total" name="pay_price_total" value="20000">
                                    <span id="pay_price_total_span" class="fc_red_b">20,000원</span> 
                                    <span class="fc_blue02_s">(최종 결제금액 = 결제금액 - 관리자 할인(할증)금액 - 환불/교환비용)</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>결제처리</div>
                <div>
                    <table cellpadding="0" cellspacing="1" border="0" class="tbstylea" width="100%">
                        <colgroup>
                            <col width="126">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td colspan="2" class="top3"></td>
                            </tr>
                            <tr>
                                <td class="label">결제방법</td>
                                <td class="box text">무통장</td>
                            </tr>
                            <tr>
                                <td class="label">결제확인일</td>
                                <td class="box text">
                                                            2015.03.20 04:36							</td>
                            </tr>
                            <tr>
                                <td class="label">상세정보</td>
                                <td class="box text">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="tab-no-border">
                                        <colgroup>
                                            <col width="80">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td height="30" class="fs11 dotum ls1">입금인</td>
                                                <td>
                                                    <input type="text" id="pay_online_name" name="pay_online_name" value="후이즈몰2" class="inputbox" style="width:70px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30" class="fs11 dotum ls1">입금계좌</td>
                                                <td>
                                                    <select id="pay_online_account" name="pay_online_account" style="width:300px;">
                                                        <option value="">선택</option>
                                                        <option value="1" selected="">[여기여기요]HSBC은행:1234568768</option>
                                                    </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30" class="fs11 dotum ls1"> 입금예정일</td>
                                                <td>
                                                    <input type="text" id="pay_pre_date" name="pay_pre_date" value="2015-03-20" class="inputbox" style="width:68px;" readonly="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">거래증빙</td>
                                <td class="box text">
                                    <table cellpadding="0" cellspacing="0" border="0" class="tab-no-border">
                                        <colgroup>
                                            <col width="80">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td>현금영수증</td>
                                                <td height="30" class="fs11 dotum ls1">
                                                    발행가능&nbsp;&nbsp;
                                                    <input type="submit" class="memEleB" value="발행">	
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>세금계산서</td>
                                                <td height="30" class="fs11 dotum ls1">
                                                    전자세금계산서 발행 신청 가능&nbsp;&nbsp;
                                                    <input type="submit" class="memEleB" value="신청하기">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
                    <div class="alignCenter"><input type="submit" class="memEleB" value="적용"></div>
                </div>
                <div></div>
                <div>
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" class="memberListTable tab-no-border">
                        <colgroup>
                            <col width="49%">
                            <col width="2%">
                            <col width="49%">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td valign="top">
                                    <!--주문자 정보-->
                                    <div class="subtitle">주문자 정보</div>
                                    <table cellpadding="0" cellspacing="1" border="0" class="tbstylea" width="100%">
                                        <colgroup>
                                            <col width="126">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="top3"></td>
                                            </tr>
                                            <tr>
                                                <td class="label">주문자명(아이디)</td>
                                                <td class="box text"><strong><a href="#" ui_user="whoismall2">후이즈몰2(whoismall2)</a></strong></td>
                                            </tr>
                                            <tr>
                                                <td class="label">전화번호</td>
                                                <td class="box text">
                                                    <input type="text" id="buy_user_tel0" name="buy_user_tel[0]" value="032" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_user_tel1" name="buy_user_tel[1]" value="2352" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_user_tel2" name="buy_user_tel[2]" value="2352" class="inputbox" style="width:50px;">    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">휴대전화</td>
                                                <td class="box text">
                                                    <input type="text" id="buy_user_mobile0" name="buy_user_mobile[0]" value="010" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_user_mobile1" name="buy_user_mobile[1]" value="1111" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_user_mobile2" name="buy_user_mobile[2]" value="1111" class="inputbox" style="width:50px;"> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">이메일</td>
                                                <td class="box text">
                                                    <input type="text" id="buy_user_email0" name="buy_user_email[0]" value="56236236361361361" class="inputbox" style="width:75px;">@
                                                    <input type="text" id="buy_user_email1" name="buy_user_email[1]" value="hanmir.com" class="inputbox" style="width:110px;">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>	
                                </td>
                                <td></td>
                                <td valign="top">
                                    <!--수령인 정보-->
                                    <div class="subtitle">수령인 정보</div>
                                    <table cellpadding="0" cellspacing="1" border="0" class="tbstylea" width="100%">
                                        <colgroup>
                                            <col width="126">
                                            <col width="*">
                                        </colgroup>
                                        <tbody>
                                            <tr>
                                                <td colspan="2" class="top3"></td>
                                            </tr>
                                            <tr>
                                                <td class="label">수령인명</td>
                                                <td class="box text"><input type="text" id="buy_dlv_name" name="buy_dlv_name" value="후이즈몰2" class="inputbox" style="width:100px;"></td>
                                            </tr>
                                            <tr>
                                                <td class="label">전화번호</td>
                                                <td class="box text">
                                                    <input type="text" id="buy_dlv_tel0" name="buy_dlv_tel[0]" value="032" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_dlv_tel1" name="buy_dlv_tel[1]" value="2352" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_dlv_tel2" name="buy_dlv_tel[2]" value="2352" class="inputbox" style="width:50px;">    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">휴대전화</td>
                                                <td class="box text">
                                                    <input type="text" id="buy_dlv_mobile0" name="buy_dlv_mobile[0]" value="010" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_dlv_mobile1" name="buy_dlv_mobile[1]" value="1111" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" id="buy_dlv_mobile2" name="buy_dlv_mobile[2]" value="1111" class="inputbox" style="width:50px;"> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">배송지 주소</td>
                                                <td class="box text">
                                                    <input type="text" name="buy_dlv_zipcode1" value="152" class="inputbox" style="width:50px;" readonly="">
                                                    -
                                                    <input type="text" name="buy_dlv_zipcode2" value="050" class="inputbox" style="width:50px;" readonly="">
                                                    <span id="buy_dlv_zipcode_div">
                                                    <a href="#" id="find_zipcode1" mode="buy_dlv"><input type="submit" class="memEleB" value="우편번호찾기"></a>
                                                    </span>
                                                    <br>
                                                    <input type="text" name="buy_dlv_addr_base" value="서울특별시 구로구 구로동" class="inputbox" style="width:200px;" readonly="">
                                                    <br>
                                                    <input type="text" name="buy_dlv_addr_etc" value="13251361361361" class="inputbox" style="width:200px;">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>	
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alignCenter"><input type="submit" class="memEleB" value="적용"></div>
                </div>
                <div>배송 요청 정보</div>
                <div>
                    <table cellpadding="0" cellspacing="1" border="0" class="tbstylea" width="100%">
                        <colgroup>
                            <col width="126">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <td colspan="2" class="top3"></td>
                            </tr>
                            <tr>
                                <td class="label">배송 시 요청사항</td>
                                <td class="box text">
                                    <table id="buy_memo_all" width="100%" cellpadding="0" cellspacing="0" border="0" style="display: block;">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <textarea id="buy_memo" name="buy_memo" class="inputbox" style="width:700px; height:100px"></textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table id="buy_memo_part" width="100%" cellpadding="0" cellspacing="0" border="0" style="display: none;">
                                        <tbody>
                                            <tr>
                                                <td height="30"><a href="/?act=shop.goods_view&amp;GS=9" target="_blank"><strong>셀러입니다</strong></a> <a href="#" ui_buy_good="26"><img src="/admin/images/button/btn_option.gif" alt="&nbsp;&nbsp;· 기본상품 / 1개  (35,000원) "></a> <input type="text" id="buy_good_memo" name="buy_good_memo[26]" value="" class="inputbox" style="width:300px;"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">배송 희망일자</td>
                                <td class="box text">2015-03-23</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alignCenter"><input type="submit" class="memEleB" value="적용"></div>
                </div>
             </div>';
}
echo $html;
mysql_close($db);
?>