<?
include("common/config.shop.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>AdminboardList</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css"/>
        <link rel="stylesheet" type="text/css" href="css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="css/orderList.css"/>
        <link rel="stylesheet" type="text/css" href="css/brandList.css"/>
        <link rel="stylesheet" type="text/css" href="css/nv.css"/>
        <style type="text/css">
            h4 {
                margin:10px 0px;
            }
            .no-border-left{
                border-left:0px !important;
            }
            .no-border-right{
                border-right:0px !important;
            }
            .td-info{
                background-color:#eee;
                padding:10px;
            }
            .td-val{
                background-color:#fff;
                padding:10px;
            }
            p {
                margin:5px 0px 5px 0px;
            }
        </style>
    </head>
    <body>
        <div id="total">
            <? include("include/include.header.php"); ?>
            <div id="main" style="float: right;">
                <h4>개고객 상담 안내</h4>
                <table class="memberListTable">
                    <colgroup>
                        <col width="200">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td class="no-border-left td-info">미입금 주문 자동 취소</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" id="shopp_buy_auto_cancel_flag1" name="shopp_buy_auto_cancel_flag" value="1"> 주문이후</label>
                                <select id="shopp_buy_auto_cancel_term" name="shopp_buy_auto_cancel_term" style="width:40px;">
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                </select>
                                <label for="shopp_buy_auto_cancel_flag1">일 동안 입금하지 않으면 자동으로 주문을 취소</label></p>

                                <p><label><input type="radio" id="shopp_buy_auto_cancel_flag2" name="shopp_buy_auto_cancel_flag" value="0"> 사용안함(수동으로 상태 변경)</label></p>

                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">배송완료 상태 자동변경</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" id="shopp_buy_dlv_auto_flag1" name="shopp_buy_dlv_auto_flag" value="1"> 배송중 상태에서</label>
                                <select id="shopp_buy_dlv_auto_term" name="shopp_buy_dlv_auto_term" style="width:40px;">
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                </select> <label for="shopp_buy_dlv_auto_flag1">일 경과 후 배송완료로 상태 변경</label></p>

                                <p><label><input type="radio" id="shopp_buy_dlv_auto_flag2" name="shopp_buy_dlv_auto_flag" value="0"> 사용 안 함(수동으로 상태 변경)</label></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">주문자 주문취소 설정
                                (배송조회 화면에서
                                주문자가 직접 주문취소를
                                할 수 있습니다.)</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" id="shopp_buy_cancel_type1" name="shopp_buy_cancel_type" value="0"> 사용 안 함(주문자는 주문취소를 할 수 없음)</label></p>

                                <p><label><input type="radio" id="shopp_buy_cancel_type2" name="shopp_buy_cancel_type" value="1"> 입금전 상태에서만 주문취소 할 수 있음</label></p>

                                <p><label><input type="radio" id="shopp_buy_cancel_type3" name="shopp_buy_cancel_type" value="2"> 입금확인 단계까지만 주문취소를 할 수 있음(배송준비 상태부터 주문취소 사용 불가)</label></p>

                                <p><label><input type="radio" id="shopp_buy_cancel_type4" name="shopp_buy_cancel_type" value="3"> 배송준비 상태까지만 주문취소 할 수 있음(배송이 시작되면 주문취소 사용 불가)</label></p>

                                <p><label><input type="radio" id="shopp_buy_cancel_type5" name="shopp_buy_cancel_type" value="4"> 결제(입금) 후</label>
                                <select id="shopp_buy_cancel_term" name="shopp_buy_cancel_term" style="width:60px;">
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="48">48</option>
                                    <option value="72">72</option>
                                </select> <label for="shopp_buy_cancel_type5">시간 이내에만 주문취소 가능</label></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">매출 산정 기준 설정</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" id="shopp_buy_stat_date_type1" name="shopp_buy_stat_date_type" value="0"> 주문일 기준</label></p>
                                <p><label><input type="radio" id="shopp_buy_stat_date_type2" name="shopp_buy_stat_date_type" value="1"> 입금완료 기준</label></p>
                                <p><label><input type="radio" id="shopp_buy_stat_date_type3" name="shopp_buy_stat_date_type" value="2"> 배송완료 기준</label></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">상품 구매시 재고 감소 시점</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" id="shopp_buy_stock_minus_time2" name="shopp_buy_stock_minus_time" value="1"> 주문신청 시</label></p>
                                <p><label><input type="radio" id="shopp_buy_stock_minus_time3" name="shopp_buy_stock_minus_time" value="2"> 입금완료 시</label></p>
                                <p><label><input type="radio" id="shopp_buy_stock_minus_time4" name="shopp_buy_stock_minus_time" value="3"> 배송완료 시</label></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">취소/환불/반품 시 재고 수량 복구</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" id="shopp_buy_stock_restore_type1" name="shopp_buy_stock_restore_type" value="1"> 수량 복구 됨</label></p>
                                <p><label><input type="radio" id="shopp_buy_stock_restore_type2" name="shopp_buy_stock_restore_type" value="2"> 수량 복구 안 함</label></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="no-border-right no-border-left" align="center" style="padding:10px 0px;">
                                <input type="submit" class="memEleB" value="적용">
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div id="left" style="float:left;">
                <ul id="x">
                    <li class="TitleLi1">기본설정</li>

                    <li class="ml10"> <a href="shop.php">쇼핑몰 기본정보</a> </li>
                    <li class="ml10"> <a href="shop_biz.php">사업자 정보</a> </li>
                    <li class="ml10"> <a href="shop_info.php">고객 상담 안내</a> </li>
                    <li class="ml10"> <a href="shop_buy_setup_modify.php" class="active">주문기본정보 설정</a> </li>
                    <li class="ml10"> <a href="shop_service_mile.php">적립금 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_provision.php">회원약관 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_privacy.php">개인정보취급방침</a> </li>

                </ul>
            </div>
        </div>
    </body>
</html>
