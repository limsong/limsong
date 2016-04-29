<?
include("common/config.shop.php");
include("check.php");
$code = "tbl_bbs";
@$page = $_GET['page'];
if (!@$_POST['key']) {
    @$key = $_GET['key'];
} else {
    @$key = $_POST['key'];
}
if (!@$_POST['keyfield']) {
    @$keyfield = $_GET['keyfield'];
} else {
    @$keyfield = $_POST['keyfield'];
}
if (empty($page)) {
    $page = 1;
}
if (empty($key)) {
    $addQuery = " where";
} else {
    $addQuery = " where $keyfield like '%$key%'";
}
$bbs_code = $_GET["bbs_code"];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>AdminboardList</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css"/>
        <link rel="stylesheet" type="text/css" href="css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="css/orderList.css"/>
        <link rel="stylesheet" type="text/css" href="css/nv.css"/>
        <script type="text/javascript" src="common/common2.js"></script>
        <script src="http://libs.baidu.com/jquery/1.9.1/jquery.min.js"></script>
        <script type="text/javascript" src="layer/layer.js"></script>
    </head>
    <body>
        <div id="total">
            <? include("include/include.header.php"); ?>
            <div id="main" style="float: right;">
                <?php
                if($bbs_code == ""){
                    $bbs_code = "goods_qna";
                }
                switch ($bbs_code){
                    case "goods_qna":
                        $title = "상품문의";
                        $addQuery .= " qna_mod='0'";
                        $query = "select count(*) from $code ";
                        $result = mysql_query($query) or die($query);
                        $total_record = mysql_result($result, 0, 0);
                        if ($total_record == 0) {
                            $first = 1;
                        } else {
                            $first = ($page - 1) * $bnum_per_page;
                        }
                        include_once ("goods_qna.php");
                        break;
                    case "user_review":
                        $addQuery .= " qna_mod='2'";
                        $query = "select count(*) from $code ";
                        $result = mysql_query($query) or die($query);
                        $total_record = mysql_result($result, 0, 0);
                        if ($total_record == 0) {
                            $first = 1;
                        } else {
                            $first = ($page - 1) * $bnum_per_page;
                        }
                        include_once ("user_review.php");
                        break;
                    case "faq":
                        $addQuery .= " qna_mod='0'";
                        $query = "select count(*) from tbl_notice ";
                        $result = mysql_query($query) or die($query);
                        $total_record = mysql_result($result, 0, 0);
                        if ($total_record == 0) {
                            $first = 1;
                        } else {
                            $first = ($page - 1) * $bnum_per_page;
                        }
                        include_once ("faq.php");
                        break;
                    case "user_onetoone":
                        $title = "QNA";
                        $addQuery .= " qna_mod='1'";
                        $query = "select count(*) from $code ";
                        $result = mysql_query($query) or die($query);
                        $total_record = mysql_result($result, 0, 0);
                        if ($total_record == 0) {
                            $first = 1;
                        } else {
                            $first = ($page - 1) * $bnum_per_page;
                        }
                        include_once ("user_onetoone.php");
                        break;
                    case "notice":
                        $addQuery .= " qna_mod='01'";
                        $query = "select count(*) from tbl_notice ";
                        $result = mysql_query($query) or die($query);
                        $total_record = mysql_result($result, 0, 0);
                        if ($total_record == 0) {
                            $first = 1;
                        } else {
                            $first = ($page - 1) * $bnum_per_page;
                        }
                        include_once ("notice.php");
                        break;
                    case "":
                        include_once ("freeboard.php");
                        break;
                }
                ?>
            </div>
            <div id="left" style="float:left;">
                <ul id="x">
                    <li class="TitleLi1">상점 게시물 관리</li>

                    <li class="ml10">
                        <a <?php if ($bbs_code == "goods_qna") echo "class='active'"; ?>
                            href="boardList.php?bbs_code=goods_qna">상품문의
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($bbs_code == "user_review") echo "class='active'"; ?>
                            href="boardList.php?bbs_code=user_review">사용후기
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($bbs_code == "faq") echo "class='active'"; ?>
                            href="boardList.php?bbs_code=faq">FAQ
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($bbs_code == "user_onetoone") echo "class='active'"; ?>
                            href="boardList.php?bbs_code=user_onetoone">QNA
                        </a>
                    </li>

                    <li class="TitleLi1">일반 게시물 관리</li>

                    <li class="ml10">
                        <a <?php if ($bbs_code == "notice") echo "class='active'"; ?>
                            href="boardList.php?bbs_code=notice">공지사항
                        </a>
                    </li>
                    <li class="ml10">
                        <a <?php if ($bbs_code == "freeboard") echo "class='active'"; ?>
                            href="boardList.php?bbs_code=freeboard">자유게시판
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <script>
            ;
            !function () {
                layer.config({
                    extend: 'extend/layer.ext.js'
                });
                $(".ifDiv").click(function () {
                    var code = $(this).attr("data");
                    var url = 'http://sozo.bestvpn.net/shopadmin/boardRead.php?'+code;
                    layer.open({
                        type: 2,
                        title: '',
                        shadeClose: true,
                        shade: 0.8,
                        area: ['70%', '90%'],
                        content: url
                    });
                });
            }();
        </script>
    </body>
</html>
