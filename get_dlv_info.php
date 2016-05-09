<?php
include_once ("session.php");
include_once ("include/check.php");
include_once ("include/config.php");
include_once ("include/sqlcon.php");
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 20
 * Time: 오후 4:02
 * getcancelprodInfoajax.php
 */
$goods_seq=$_POST["data_seq"];

$db->query("SELECT * FROM buy_goods WHERE buy_goods_seq='$goods_seq'");
$db_buy_goods_query = $db->loadRows();
$buy_goods_dlv_tag_no = $db_buy_goods_query[0]["buy_goods_dlv_tag_no"];
$dlv_com_seq = $db_buy_goods_query[0]["dlv_com_seq"];
$db->query("SELECT * FROM delivery_company WHERE dlv_com_seq='$dlv_com_seq'");
$db_dlv_company_query = $db->loadRows();
$dlv_com_link = $db_dlv_company_query[0]["dlv_com_link"];

$dlv_com_seq = dlv_company($dlv_com_seq);
$buy_goods_name = $db_buy_goods_query[0]["buy_goods_name"];
$buy_goods_dlv_sdate = $db_buy_goods_query[0]["buy_goods_dlv_sdate"];
$buy_goods_prefix = $db_buy_goods_query[0]["buy_goods_prefix"];
if($buy_goods_prefix != ""){
      $goodsName = $buy_goods_name."_".$buy_goods_prefix;
}
$sum=$sum2=0;
$html ='<div class="cart-area-wrapper table-responsive">
        <table class="table table-bordered">';


$html .='<tbody>';
$html .='<tr>';
$html .='<td>상품명</td>';
$html .='<td>'.$goodsName.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>배송업체 정보</td>';
$html .='<td>'.$dlv_com_seq.'</td>';
$html .='</tr>';

$html .='<tr>';
$html .='<td>배송정보</td>';
$html .='<td>배송시작일 : '.$buy_goods_dlv_sdate.'<br>송장번호 : '.$buy_goods_dlv_tag_no.' <a class="btn btn-xs btn-default waves-effect waves-light" href="'.$dlv_com_link.'" target="_blank">배송추적</a></td>';
$html .='</tr>';
echo $html;
$db->disconnect();
?>
