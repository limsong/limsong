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
    //'결제수단 - 1:무통장, 2:카드, 4:적립금, 8:쿠폰, 16:휴대폰결제, 32:실시간 계좌이체, 64:가상계좌, 128:에스크로, 256:전액할인, 512:다날, 1024:모빌리언스, 2048:네이버 마일리지',
    $pay_method = $row["pay_method"];
    $pay_method_txt = paymethod($pay_method);
    $pay_date = $row["pay_date"];//입금확인일
    if($pay_date=="0000-00-00 00:00:00"){
        $pay_data_btn = '<button type="button" class="buy_ok">입금확인</button>';
    }else{
        $pay_data_btn = $pay_date;
    }

    $buy_memo = $row["buy_memo"];//배송시 요청사항

    $pay_online_name = $row["pay_online_name"];//입금인
    $pay_online_account = $row["pay_online_account"];//입금계좌
    $pay_pre_date = $row["pay_pre_date"];//입금예정일
    //주문자 정보
    $buy_user_name = $row["buy_user_name"];//주문자 아이디;
    $db_shopmembers_query = "select name from shopmembers where id='$buy_user_name'";
    $db_shopmembers_result = mysql_query($db_shopmembers_query) or die("get_data db_shopmembers_query");
    $buy_user_id = mysql_result($db_shopmembers_result, 0,0);
    $buy_user_tel = $row["buy_user_tel"];//일반전화
    $buy_user_telArr = explode("-", $buy_user_tel);
    $buy_user_mobile = $row["buy_user_mobile"];//핸드폰번호
    $buy_user_mobileArr = explode("-", $buy_user_mobile);
    $buy_user_email = $row["buy_user_email"];//이메일주소
    $buy_user_emailArr = explode("@", $buy_user_email);
    //수령인 정보
    $buy_dlv_name = $row["buy_dlv_name"];//이름
    $buy_dlv_tel = $row["buy_dlv_tel"];//일반전화
    $buy_dlv_telArr = explode("-", $buy_dlv_tel);
    $buy_dlv_mobile = $row["buy_dlv_mobile"];//핸드폰번호
    $buy_dlv_mobileArr = explode("-", $buy_dlv_mobile);
    $buy_dlv_zipcode = $row["buy_dlv_zipcode"];
    $buy_dlv_zipcodeArr = explode("-", $buy_dlv_zipcode);
    $buy_dlv_addr_base = $row["buy_dlv_addr_base"];
    $buy_dlv_addr_etc = $row["buy_dlv_addr_etc"];



    $buy_seq = $row["buy_seq"];
    $buy_code = $row["buy_code"];

    $buy_date = $row["buy_date"];//주문일
    $pay_dlv_fee = $row["pay_dlv_fee"];//배송비
    $buy_status = $row["buy_status"];//진행상태 '주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료, 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료',
    $buy_status = goods_status($buy_status);
    $buy_total_price = $row["buy_total_price"];//결제예정 총 상품금액
    $buy_admin_price = $row["buy_admin_price"];//관리자할인(-)/할증(+)
    if($buy_admin_price>0){
        $admin_price_plus = "selected";
    }else{
        $admin_price_minece = "selected";
    }
    $admin_price = $buy_admin_price;
    $buy_admin_price = substr($buy_admin_price,1);
    $html = '<style>
                .inp ,textarea{
                    border:1px solid #aaa;
                }
            </style>
            <div style="padding:0px 10px">
                <div>기본정보</div>
                <div>
                    <table class="memberListTable" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    주문번호 : <span class="fc_blue_b">'.$ordernum.'</span><br>
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
                            <col width="180">
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
                        <tbody>';
                    $buy_goods_query = "select buy_goods_code from buy_goods where buy_seq='$buy_seq'";
                    $buy_goods_result = mysql_query($buy_goods_query) or die("get_data buy_goods_query");
                    //$buy_goods_row_count = mysql_num_rows($buy_goods_result);
                    while($buy_goods_row=mysql_fetch_array($buy_goods_result)){
                        $goods_code=$buy_goods_row["buy_goods_code"];

                        $goods_query = "select * from goods where goods_code='$goods_code'";
                        $goods_result = mysql_query($goods_query) or die("get_data goods_query");
                        $goods_row = mysql_fetch_array($goods_result);
                        $goods_name = $goods_row["goods_name"];
                        $goods_opt_type = $goods_row["goods_opt_type"];//상품 유형  0:옵션업슴 1:일반옵션 2:가격선택옵션
                        $goods_opt_Num = $goods_row["goods_opt_Num"];

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


                        if($tmp_goods_code == "" || $tmp_goods_code!=$goods_code){
                            $tmp_goods_code = $goods_code;
                            $html .= '<tr>
                                <!-- 상품명(상품코드) -->
                                <td align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tab-no-border">
                                        <tbody>
                                            <tr>
                                                <td width="55" rowspan="2"><img src="' . $imgSrc . '" class="imgborder" width="50" height="50"></td>
                                                <td align="left">
                                                    <span style="color:gray;">&nbsp;' . $ordernum . '<br></span>
                                                    &nbsp;<a href="/item_view.php?code=" target="_blank"><u>' . $goods_name . '</u></a>';
                                                    $buy_goods_query2="select * from buy_goods where buy_goods_code='$goods_code' and buy_seq='$buy_seq'";
                                                    $buy_goods_result2 = mysql_query($buy_goods_query2) or die("get_data buy_goods_query2");
                                                    $total_buy_count="";
                                                    $total_buy_goods_price="";//총 상품금액 개수포함
                                                    $total_buy_goods_sale = "";//총 할인금액 개수포함
                                                    while ($buy_goods_row2=mysql_fetch_array($buy_goods_result2)) {
                                                        $buy_goods_code = $buy_goods_row2["buy_goods_code"];
                                                        $buy_goods_count = $buy_goods_row2["buy_goods_count"];//구매상품 개수
                                                        if($total_buy_count==""){
                                                            $total_buy_count = $buy_goods_count;
                                                        }else{
                                                            $total_buy_count += $buy_goods_count;
                                                        }
                                                        $buy_goods_price = $buy_goods_row2["buy_goods_price"];//할인전 상품금액
                                                        $buy_goods_price_total = $buy_goods_row2["buy_goods_price_total"];//할인후 상품금액

                                                        if ($goods_opt_type == "0") {
                                                            //옵션없음
                                                            //기본상품 / 사이즈 : S / 색상 : 연두 / 1개(30, 000원
                                                            $goods_info = "기본상품 ".$buy_goods_count."개 (".number_format($buy_goods_price)."원)";
                                                            $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                                                            $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
                                                        }elseif($goods_opt_type=="1"){
                                                            //일반옵션
                                                            $buy_goods_name = $buy_goods_row2["buy_goods_name"];
                                                            $buy_goods_prefix = $buy_goods_row2["buy_goods_prefix"];
                                                            $goods_info = "기본상품 / $buy_goods_name : $buy_goods_prefix ".$buy_goods_count."개 (".number_format($buy_goods_price)."원)";
                                                            $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                                                            $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
                                                        }elseif($goods_opt_type=="2"){
                                                            //가격선택옵션
                                                            if($goods_opt_Num=="2"){
                                                                //가격선택옵션2
                                                                $buy_goods_name = $buy_goods_row2["buy_goods_name"];
                                                                $buy_goods_prefix = $buy_goods_row2["buy_goods_prefix"];
                                                                $db_goods_grid_name_query = "select opName1 from goods_option_grid_name where opName2='$buy_goods_name'";
                                                                $db_goods_grid_name_result = mysql_query($db_goods_grid_name_query) or die("get_data db_goods_grid_name_query");
                                                                $opName1 = mysql_result($db_goods_grid_name_result,0,0);

                                                                $db_goods_grid_name_query = "select opName1 from goods_option_grid_name where opName2='$buy_goods_prefix'";
                                                                $db_goods_grid_name_result = mysql_query($db_goods_grid_name_query) or die("get_data db_goods_grid_name_query");
                                                                $opName2 = mysql_result($db_goods_grid_name_result,0,0);
                                                                $goods_info = "기본상품 / $opName1 : $buy_goods_name / $opName2 : $buy_goods_prefix ".$buy_goods_count."개 (".number_format($buy_goods_price)."원)";
                                                                $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                                                                $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
                                                            }elseif($goods_opt_Num=="3"){
                                                                //가격선택옵션3
                                                                $buy_goods_name = $buy_goods_row2["buy_goods_name"];
                                                                $buy_goods_prefix = $buy_goods_row2["buy_goods_prefix"];
                                                                $buy_goods_suffix = $buy_goods_row2["buy_goods_suffix"];
                                                                $db_goods_grid_name_query = "select opName1 from goods_option_grid_name where opName2='$buy_goods_name'";
                                                                $db_goods_grid_name_result = mysql_query($db_goods_grid_name_query) or die("get_data db_goods_grid_name_query");
                                                                $opName1 = mysql_result($db_goods_grid_name_result,0,0);

                                                                $db_goods_grid_name_query = "select opName1 from goods_option_grid_name where opName2='$buy_goods_prefix'";
                                                                $db_goods_grid_name_result = mysql_query($db_goods_grid_name_query) or die("get_data db_goods_grid_name_query");
                                                                $opName2 = mysql_result($db_goods_grid_name_result,0,0);

                                                                $db_goods_grid_name_query = "select opName1 from goods_option_grid_name where opName2='$buy_goods_suffix'";
                                                                $db_goods_grid_name_result = mysql_query($db_goods_grid_name_query) or die("get_data db_goods_grid_name_query");
                                                                $opName3 = mysql_result($db_goods_grid_name_result,0,0);

                                                                $goods_info = "기본상품 / $opName1 : $buy_goods_name / $opName2 : $buy_goods_prefix / $opName3 : $buy_goods_suffix ".$buy_goods_count."개 (".number_format($buy_goods_price)."원)";
                                                                $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                                                                $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
                                                            }
                                                        }
                                                        $html.='<span style = "color:gray;margin-left:5px;" ><br >&nbsp;&nbsp;· '.$goods_info.' </span >';
                                                    }
                                                    $total_price += ($total_buy_goods_price+$total_buy_goods_sale);//할인전 전체 상품금액
                                                    $total_price_sale += $total_buy_goods_sale;
                                                $html.='</td>
                                            </tr>
                                            <tr><td align="left" style="padding:10px 0 0 10px;"><!-- 별도배송 --><!-- 착불 --></td></tr>
                                        </tbody>
                                    </table>
                                </td>
                                <!-- 수량 -->
                                <td align="center">
                                    '.$total_buy_count.'
                                </td>
                                <!-- 상품금액 -->
                                <td align="center" style="padding-right:10px">
                                    '.number_format($total_buy_goods_price+$total_buy_goods_sale).'
                                </td>
                                <!-- 할인금액 -->
                                <td align="center" style="padding-right:10px">
                                    '.number_format($total_buy_goods_sale).'
                                </td>
                                <!-- 주문금액 -->
                                <td align="center" style="padding-right:10px">
                                    <span class="fc_red_b">
                                        '.number_format($total_buy_goods_price).'
                                    </span>
                                </td>
                                <!-- 배송정보 -->
                                <td align="center">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="tab-no-border">
                                        <tbody>
                                            <tr>
                                                <td align="center" style="word-break:break-all;">
                                                    '.$ordernum.'
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="tdR" align="center">
                                    '.$buy_status.'
                                </td>
                            </tr>';
                        }
                    }
                    $html .= '</tbody>    
                    </table>
                </div>
                <div style="margin-top:40px;"></div>
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
                                    '.number_format($buy_total_price).'원 
                                    (상품금액 '.number_format($total_price).'원 + 배송비 '.number_format($pay_dlv_fee).'원 )
                                </td>
                            </tr>
                            <tr>
                                <td class="label">할인액</td>
                                <td class="box text">
                                    <span class="fc_red">'.number_format($total_price_sale).'원</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">결제금액</td>
                                <td class="box text">
                                    <input type="hidden" id="pay_price_normal" name="pay_price_normal" value="'.$buy_total_price.'">
                                    '.number_format($buy_total_price-$total_price_sale).'원
                                    <span class="fc_blue02_s">( 결제금액 = 총주문금액 - 할인액 )</span>
                                </td>
                            </tr>
                            <!--
                                -->
                            <tr>
                                <td class="label">관리자 할인(할증)금액</td>
                                <td class="box text">			
                                    <select name="buy_admin_price_symbol" id="buy_admin_price_symbol">
                                        <option value="-" '.$admin_price_minece.'>할인(-)</option>
                                        <option value="+" '.$admin_price_plus.'>할증(+)</option>
                                    </select>
                                    <input type="hidden" name="buy_admin_price_org" value="'.$buy_admin_price.'">
                                    <input type="text" class="inp" id="buy_admin_price" name="buy_admin_price" value="'.$buy_admin_price.'" class="inputbox2 price_only" style="width:100px;">
                                    <input type="submit" class="memEleB" value="바로적용">
                                    <strong><span class="fc_blue02_s">* 관리자 할인(할증)금액 변경시 최종 결제금액이 조정됩니다.</span></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">최종 결제금액</td>
                                <td class="box text">
                                    <input type="hidden" id="pay_price_total" name="pay_price_total" value="20000">
                                    <span id="pay_price_total_span" class="fc_red_b">'.number_format($buy_total_price-$total_price_sale+$admin_price).'원</span> 
                                    <span class="fc_blue02_s">(최종 결제금액 = 결제금액 - 관리자 할인(할증)금액 - 환불/교환비용)</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="alignCenter"><input type="submit" class="memEleB" value="적용"></div>
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
                                <td class="box text">'.$pay_method_txt.'</td>
                            </tr>
                            <tr>
                                <td class="label">결제확인일</td>
                                <td class="box text">'.$pay_data_btn.'</td>
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
                                                    <input type="text" class="inp" id="pay_online_name" name="pay_online_name" value="'.$pay_online_name.'" class="inputbox" style="width:70px;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30" class="fs11 dotum ls1">입금계좌</td>
                                                <td>
                                                    <select id="pay_online_account" name="pay_online_account" style="width:300px;">
                                                        <option value="">선택</option>
                                                        <option value="1" selected="">'.$pay_online_account.'</option>
                                                    </select> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30" class="fs11 dotum ls1"> 입금예정일</td>
                                                <td>
                                                    <input type="text" class="inp" id="pay_pre_date" name="pay_pre_date" value="'.$pay_pre_date.'" class="inputbox" style="width:68px;" readonly="">
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
                                                <td class="box text"><strong><a href="#" ui_user="whoismall2">'.$buy_user_id.'( '.$buy_user_name.' )'.'</a></strong></td>
                                            </tr>
                                            <tr>
                                                <td class="label">전화번호</td>
                                                <td class="box text">
                                                    <input type="text" class="inp" id="buy_user_tel0" name="buy_user_tel[0]" value="'.$buy_user_telArr[0].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_user_tel1" name="buy_user_tel[1]" value="'.$buy_user_telArr[1].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_user_tel2" name="buy_user_tel[2]" value="'.$buy_user_telArr[2].'" class="inputbox" style="width:50px;">    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">휴대전화</td>
                                                <td class="box text">
                                                    <input type="text" class="inp" id="buy_user_mobile0" name="buy_user_mobile[0]" value="'.$buy_user_mobileArr[0].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_user_mobile1" name="buy_user_mobile[1]" value="'.$buy_user_mobileArr[1].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_user_mobile2" name="buy_user_mobile[2]" value="'.$buy_user_mobileArr[2].'" class="inputbox" style="width:50px;"> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">이메일</td>
                                                <td class="box text">
                                                    <input type="text" class="inp" id="buy_user_email0" name="buy_user_email[0]" value="'.$buy_user_emailArr[0].'" class="inputbox" style="width:75px;">@
                                                    <input type="text" class="inp" id="buy_user_email1" name="buy_user_email[1]" value="'.$buy_user_emailArr[1].'" class="inputbox" style="width:110px;">
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
                                                <td class="box text"><input type="text" class="inp" id="buy_dlv_name" name="buy_dlv_name" value="'.$buy_dlv_name.'" class="inputbox" style="width:100px;"></td>
                                            </tr>
                                            <tr>
                                                <td class="label">전화번호</td>
                                                <td class="box text">
                                                    <input type="text" class="inp" id="buy_dlv_tel0" name="buy_dlv_tel[0]" value="'.$buy_dlv_telArr[0].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_dlv_tel1" name="buy_dlv_tel[1]" value="'.$buy_dlv_telArr[1].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_dlv_tel2" name="buy_dlv_tel[2]" value="'.$buy_dlv_telArr[2].'" class="inputbox" style="width:50px;">    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">휴대전화</td>
                                                <td class="box text">
                                                    <input type="text" class="inp" id="buy_dlv_mobile0" name="buy_dlv_mobile[0]" value="'.$buy_dlv_mobileArr[0].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_dlv_mobile1" name="buy_dlv_mobile[1]" value="'.$buy_dlv_mobileArr[1].'" class="inputbox" style="width:50px;">
                                                    -
                                                    <input type="text" class="inp" id="buy_dlv_mobile2" name="buy_dlv_mobile[2]" value="'.$buy_dlv_mobileArr[2].'" class="inputbox" style="width:50px;"> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">배송지 주소</td>
                                                <td class="box text">
                                                    <input type="text" class="inp" name="buy_dlv_zipcode1" value="'.$buy_dlv_zipcode.'" class="inputbox" style="width:100px;" readonly="">
                                                    <span id="buy_dlv_zipcode_div">
                                                    <a href="#" id="find_zipcode1" mode="buy_dlv"><input type="submit" class="memEleB" value="우편번호찾기"></a>
                                                    </span>
                                                    <br>
                                                    <input type="text" class="inp" name="buy_dlv_addr_base" value="'.$buy_dlv_addr_base .'" class="inputbox" style="width:200px;" readonly="">
                                                    <br>
                                                    <input type="text" class="inp" name="buy_dlv_addr_etc" value="'.$buy_dlv_addr_etc  .'" class="inputbox" style="width:200px;">
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
                                                    <textarea id="buy_memo" name="buy_memo" class="inputbox" style="width:700px; height:100px">'.$buy_memo.'</textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table id="buy_memo_part" width="100%" cellpadding="0" cellspacing="0" border="0" style="display: none;">
                                        <tbody>
                                            <tr>
                                                <td height="30"><a href="/?act=shop.goods_view&amp;GS=9" target="_blank">
                                                    <strong>셀러입니다</strong></a>
                                                    <a href="#" ui_buy_good="26">
                                                        <img src="/admin/images/button/btn_option.gif" alt="&nbsp;&nbsp;· 기본상품 / 1개  (35,000원) ">
                                                    </a>
                                                    <input type="text" class="inp" id="buy_good_memo" name="buy_good_memo[26]" value="" class="inputbox" style="width:300px;">
                                                </td>
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