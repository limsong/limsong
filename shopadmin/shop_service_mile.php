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
            .fc_blue {
                color: #09a0f7;
            }
        </style>
    </head>
    <body>
        <div id="total">
            <? include("include/include.header.php"); ?>
            <div id="main" style="float: right;">
                <h4>적립금 기본 설정</h4>
                <table class="memberListTable">
                    <colgroup>
                        <col width="200">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <td class="no-border-left td-info">사용여부</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" name="milep_use" value="1"> 사용함</label></p>
                                <p><label><input type="radio" name="milep_use" value="0"> 사용안함</label></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">적립금 표시 단위</td>
                            <td class="no-border-right td-val">
                                <p><input type="text" name="milep_unit" value="p" class="inputbox" maxlength="15" size="8"></p>
                                <p>
                                    <span class="fc_s">
                                        <span class="fc_blue"> 적립금 뒤에 표시될 단위를 설정합니다. (1,000 <strong>P</strong>, 1,000 <strong>포인트</strong>, 1,000 <strong>원</strong>) </span>
                                    </span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">가입축하 적립금</td>
                            <td class="no-border-right td-val">
                                <p>시 적립금 <input type="text" name="joinp_new_mile_amount" value="0" class="inputbox2 number_only" style="width:50px"> 을 추가로 지급합니다.</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">상품구매시 적립금</td>
                            <td class="no-border-right td-val">
                                <p>
                                    <label>
                                        <input type="radio" name="milep_buy_method" value="0"> 상품구매 금액의 <input type="text" name="milep_buy_rate" value="10" size="4" maxlength="4" class="inputbox2 number_only"> % 를 적립금으로 지급.
                                        <span class="fc_s">
                                            <span class="fc_blue">(상품 등록시 별도 지정도 가능)</span>
                                        </span>
                                    </label>
                                </p>
                                <p>
                                    <label><input type="radio" name="milep_buy_method" value="1"> 1회 구매시 <input type="text" name="milep_buy_amount" value="0" size="6" maxlength="6" class="inputbox2 number_only">
                                        <select name="milep_buy_method_buy_type" style="width:40px;">
                                            <option value="0">p</option>
                                            <option value="1">%</option>
                                        </select> 를 적립금으로 지급합니다.
                                    </label>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">구매 적립금 지급제한</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" name="milep_buy_limit_method" value="0"> 결제시 적립금 사용해도 적립금을 지급합니다.</label></p>
                                <p><label><input type="radio" name="milep_buy_limit_method" value="1"> 결제시 적립금 사용하면 적립금을 지급하지 않습니다.</label></p>
                                <p><span class="fc_s"><span class="fc_blue"> - 일반적으로 적립금을 사용하여 결제시 적립금은 지급이 안 되며, 이용 약관에 표기하는 것이 좋습니다.</span></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">구매 적립금 지급날짜</td>
                            <td class="no-border-right td-val">
                                <p>시 즉시 지급됩니다.</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">적립금 총액 제한</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="checkbox" name="milep_use_board_amount_limit" value="1"> 사용함</label>  한 회원을 대상으로 최대 <input type="text" name="milep_board_amount_limit" class="inputbox2 number_only" value="0" size="6" maxlength="6"> p 까지만 적립금을 지급합니다. (1일 기준)</p>
                                <p><span class="fc_s fc_blue"> - 한 회원에게 지급할 수 있는 게시판 적립금 지급총액을 제한합니다.(1일 기준)</span></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">글(또는 댓글) 삭제 시 회수여부</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" name="milep_board_refund" value="1"> 게시글(또는 댓글) 삭제 시 지급한 적립금을 회수합니다.</label></p>
                                <p><label><input type="radio" name="milep_board_refund" value="0"> 게시글(또는 댓글) 삭제 시 지급한 적립금을 회수하지 않습니다.</label></p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">사용가능 적립금액</td>
                            <td class="no-border-right td-val">
                                <p>적립금이 <input type="text" name="milep_min_use" value="0" size="8" maxlength="10" class="inputbox2 number_only"> 이상이면 결제 시 적립금 사용 가능</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">사용가능 최소 구매가</td>
                            <td class="no-border-right td-val">
                                <p>계금액이 <input type="text" name="milep_buy_min" value="0" size="8" maxlength="10" class="inputbox2 number_only"> 이상이면 결제 시 적립금 사용 가능</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">사용가능 적립금 제한</td>
                            <td class="no-border-right td-val">
                                <p><label><input type="radio" name="milep_use_limit_method" value="0"> 제한없음</label></p>
                                <p><label><input type="radio" name="milep_use_limit_method" value="1"> 1회 구매시 최대 <input type="text" name="milep_max_use" value="0" size="6" maxlength="8" class="inputbox2 number_only"> 까지만 적립금으로 결제할 수 있습니다.</label></p>
                                <p><label><input type="radio" name="milep_use_limit_method" value="2"> 1회 구매시 주문 합계금액의 <input type="text" name="milep_max_use_rate" value="0" size="4" maxlength="4" class="inputbox2 number_only"> % 까지만 적립금으로 결제할 수 있습니다.</label></p>
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
                    <li class="ml10"> <a href="shop_buy_setup_modify.php">주문기본정보 설정</a> </li>
                    <li class="ml10"> <a href="shop_service_mile.php" class="active">적립금 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_provision.php">회원약관 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_privacy.php">개인정보취급방침</a> </li>

                </ul>
            </div>
        </div>
    </body>
</html>
