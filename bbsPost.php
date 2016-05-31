<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 28
 * Time: 오후 3:00
 */
header("Content-Type: text/html; charset=UTF-8");
include_once ("include/config.php");
include_once ("session.php");
include_once ("include/check.php");
include_once ("include/sqlcon.php");

$mod=$_POST["mod"];
if($mod == "buy_goods"){
    $qna_mod = "0";
}elseif($mod == "buy_option"){
    $qna_mod = "1";
}else{
    $qna_mod = "2";
}
$tdata=$_POST["tdata"];
$goods_seq=$_POST["goods_seq"];
$buy_goods_seq=$_POST["buy_goods_seq"];
$bbs_title=$_POST["bbs_title"];
$bbs_name=$_POST["bbs_name"];//user_id
$comment=$_POST["comment"];
$bbs_secret=$_POST["bbs_secret"];//공개 비공개
$mod = $_POST["mod"];//goods_qna,goods_option_qna,my_qna
$cate_code = $_POST["cate_code"];//카테고리
$goods_code = $_POST["goods_code"];

if($bbs_secret==""){
    $bbs_secret = "0";
}
$ipinfo = get_real_ip();
$qna_reg_date = date("Y-m-d H:i:s",time());
if($mod=="my_qna"){
    $db->query("INSERT INTO tbl_bbs (buy_goods_seq,goods_seq,goods_code,user_id,title,comment,cate_code,qna_mod,bbs_secret,qna_reg_date,ipinfo)
            VALUES ('','','$goods_code','$uname','$bbs_title','$comment','$cate_code','1','0','$qna_reg_date','$ipinfo')");
}else {
    $db->query("INSERT INTO tbl_bbs (buy_goods_seq,goods_seq,goods_code,user_id,title,comment,qna_mod,bbs_secret,qna_reg_date,ipinfo)
            VALUES ('$buy_goods_seq','$goods_seq','$goods_code','$uname','$bbs_title','$comment','$qna_mod','$bbs_secret','$qna_reg_date','$ipinfo')");
}
$db->disconnect();
?>
<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]>
<html lang="en" class="ie6">    <![endif]-->
<!--[if IE 7 ]>
<html lang="en" class="ie7">    <![endif]-->
<!--[if IE 8 ]>
<html lang="en" class="ie8">    <![endif]-->
<!--[if IE 9 ]>
<html lang="en" class="ie9">    <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <script language="javascript">
            alert("문의글이 등록 되였습니다.");
            window.top.document.location.href="/mypage.php";
        </script>
    </body>
</html>

