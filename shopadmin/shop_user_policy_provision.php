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
                <h4>회원약관 설정</h4>
                <table class="memberListTable">
                    <tbody>
                        <tr>
                            <td class="no-border-left">
                                <!-- 加载编辑器的容器 -->
                                <script id="container" name="content" type="text/plain"></script>
                                <!-- 配置文件 -->
                                <script type="text/javascript" src="ueditor/ueditor.config.js"></script>
                                <!-- 编辑器源码文件 -->
                                <script type="text/javascript" src="ueditor/ueditor.all.js"></script>
                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                                    var ue = UE.getEditor('container');
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td class="no-border-right no-border-left" align="center" style="padding:10px 0px;">
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
                    <li class="ml10"> <a href="shop_service_mile.php">적립금 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_provision.php" class="active">회원약관 설정</a> </li>
                    <li class="ml10"> <a href="shop_user_policy_privacy.php">개인정보취급방침</a> </li>

                </ul>
            </div>
        </div>
    </body>
</html>
