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
                            <td class="no-border-left td-info">e-mail</td>
                            <td class="no-border-right td-val"><input type="text" style="width:50%;" name="shop_help_email"/></td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">전화번호</td>
                            <td class="no-border-right td-val">
                                <select name="shop_help_tel1">
                                    <option value="">선택</option>
                                    <option value="02">02</option>
                                    <option value="031">031</option>
                                    <option value="032">032</option>
                                    <option value="033">033</option>
                                    <option value="041">041</option>
                                    <option value="042">042</option>
                                    <option value="043">043</option>
                                    <option value="044">044</option>
                                    <option value="050">050</option>
                                    <option value="051">051</option>
                                    <option value="052">052</option>
                                    <option value="053">053</option>
                                    <option value="054">054</option>
                                    <option value="055">055</option>
                                    <option value="060">060</option>
                                    <option value="061">061</option>
                                    <option value="062">062</option>
                                    <option value="063">063</option>
                                    <option value="064">064</option>
                                    <option value="070">070</option>
                                    <option value="010">010</option>
                                    <option value="011">011</option>
                                    <option value="016">016</option>
                                    <option value="017">017</option>
                                    <option value="018">018</option>
                                    <option value="019">019</option>
                                </select>
                                -
                                <input type="text" name="shop_help_tel2"/>
                                -
                                <input type="text" name="shop_help_tel3"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">팩스번호</td>
                            <td class="no-border-right td-val">
                                <select name="shop_help_fax1">
                                    <option value="">선택</option>
                                    <option value="02">02</option>
                                    <option value="031">031</option>
                                    <option value="032">032</option>
                                    <option value="033">033</option>
                                    <option value="041">041</option>
                                    <option value="042">042</option>
                                    <option value="043">043</option>
                                    <option value="044">044</option>
                                    <option value="050">050</option>
                                    <option value="051">051</option>
                                    <option value="052">052</option>
                                    <option value="053">053</option>
                                    <option value="054">054</option>
                                    <option value="055">055</option>
                                    <option value="060">060</option>
                                    <option value="061">061</option>
                                    <option value="062">062</option>
                                    <option value="063">063</option>
                                    <option value="064">064</option>
                                    <option value="070">070</option>
                                </select>
                                -
                                <input type="text" name="shop_help_fax2"/>
                                -
                                <input type="text" name="shop_help_fax3"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">고객 센터 주소</td>
                            <td class="no-border-right td-val">
                                <input type="text" name="shop_help_zipcode" value="152" size="10" class="inputbox2" readonly="">
                                <input type="submit" class="memEleB" value="우편번호찾기"><br>
                                <input type="text" style="width:50%;" name="shop_help_addr_base"/><br>
                                <input type="text" style="width:50%;" name="shop_help_addr_etc"/>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-left td-info">상담센터 운영시간</td>
                            <td class="no-border-right td-val">
                                <textarea name="shop_help_work_time" style="width:99.3%;height:100px;">월~금 : 오전 9시부터 오후 6시까지
                                    토요일은 오후 1시까지
                                </textarea>
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
                    <li class="ml10"> <a href="shop_info.php" class="active">고객 상담 안내</a> </li>
                    <li class="ml10"> <a href="shop_buy_setup_modify.php">주문기본정보 설정</a> </li>
                    <li class="ml10"> <a href="shop_service_mile.php">적립금 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_provision.php">회원약관 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_privacy.php">개인정보취급방침</a> </li>

                </ul>
            </div>
        </div>
    </body>
</html>
