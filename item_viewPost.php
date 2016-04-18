<?php
/**
 * Created by PhpStorm.
 * User: limsong
 * Date: 2016. 3. 25.
 * Time: 오후 2:57
 * 가격서낵옵션하고 일반옵션 옵션값을 ajax요청을 반환한다.
 */
include_once("include/config.php");
include_once("include/sqlcon.php");
include_once("session.php");
$goods_code = $_POST["goods_code"];
$goods_optNum = $_POST["optNum"];
$goods_opName1 = $_POST["opname1"];
$goods_opName2 = $_POST["opname2"];
$option_text = $_POST["opVal"];

if ($goods_optNum == "2") {
        $db->query("SELECT * FROM goods_option_grid_value WHERE goods_code='$goods_code' AND opName1='$goods_opName1' ORDER BY id asc");
} else {
        if ($goods_opName2 == "") {
                $db->query("SELECT opName2 FROM goods_option_grid_name WHERE goods_code='$goods_code' AND opName1='$option_text' ORDER BY id asc");
        } else {
                $db->query("SELECT * FROM goods_option_grid_value WHERE goods_code='$goods_code' AND opName1='$goods_opName1' AND opName2='$goods_opName2' ORDER BY id asc");
        }

}

$goods_option_Query = $db->loadRows();
$count = count($goods_option_Query);

if ($goods_optNum == "2") {
        //optNum 2일때
        $db->query("SELECT sb_sale,sellPrice FROM goods WHERE goods_code='$goods_code'");
        $goods_Query = $db->loadRows();
        $goods_sellPrice = $goods_Query[0]["sellPrice"];
        $sb_sale = (100-$goods_Query[0]["sb_sale"])/100;
        for ($i = 0; $i < $count; $i++) {
                $goods_option_grid_opName = $goods_option_Query[$i]["opName2"];//상품 옵션2
                $goods_option_grid_sellPrice = $goods_option_Query[$i]["opValue2"];//판매가
                $goods_option_grid_qta = $goods_option_Query[$i]["opValue3"];//재고
                $goods_option_grid_id = $goods_option_Query[$i]["id"];
                $sellPrice = ($goods_option_grid_sellPrice - $goods_sellPrice)*$sb_sale;// 상품 최저가에서 옵션에 붙는 금액 차액
                if($sellPrice>=0){
                        $sellPrice = "+".number_format($sellPrice);
                }else{
                        $sellPrice = number_format($sellPrice);
                }
                if($i == 0){
                        $option = '<option>' . $option_text . '</option>';
                }
                if($goods_option_grid_qta == "0"){
                        $option .= '<option disabled>' . $goods_option_grid_opName . ' ( 품절 )</option>';
                }else{
                        $option .= '<option value="'.$goods_option_grid_sellPrice*$sb_sale.'" data="'.$goods_option_grid_id.'" data1="'.$goods_opName1.'" data2="'.$goods_option_grid_opName.'">' . $goods_option_grid_opName . ' ('.$sellPrice.'원)</option>';
                }
        }
} else {
        //optNum 3일때
        if ($goods_opName2 == "") {
                for ($i = 0; $i < $count; $i++) {
                        $goods_option_grid_opName = $goods_option_Query[$i]["opName2"];
                        if($i == 0){
                                $option = '<option>' . $option_text . '</option>';
                        }
                        $option .= '<option>' . $goods_option_grid_opName . '</option>';
                }
        } else {
                $db->query("SELECT sb_sale,sellPrice FROM goods WHERE goods_code='$goods_code'");
                $goods_Query = $db->loadRows();
                $goods_sellPrice = $goods_Query[0]["sellPrice"];
                $sb_sale = (100-$goods_Query[0]["sb_sale"])/100;
                for ($i = 0; $i < $count; $i++) {
                        $goods_option_grid_opName = $goods_option_Query[$i]["opName3"];
                        $goods_option_grid_opValue2 = $goods_option_Query[$i]["opValue2"];//판매가
                        $goods_option_grid_opValue3 = $goods_option_Query[$i]["opValue3"];//재고
                        $goods_option_grid_id = $goods_option_Query[$i]["id"];
                        $sellPrice = ($goods_option_grid_opValue2 - $goods_sellPrice)*$sb_sale;
                        if($sellPrice>=0){
                                $sellPrice = "+".number_format($sellPrice);
                        }else{
                                $sellPrice = number_format($sellPrice);
                        }
                        if($i == 0){
                                $option = '<option>' . $option_text . '</option>';
                        }
                        if ($goods_option_grid_opValue3 == "0") {
                                $option .= '<option disabled>' . $goods_option_grid_opName . ' ( 품절 )</option>';
                        }
                        $option .= '<option value="' . $goods_option_grid_opValue2*$sb_sale . '" data="' . $goods_option_grid_id . '" data1="'.$goods_opName1.'" data2="'.$goods_opName2.'" data3="'.$goods_option_grid_opName.'">' . $goods_option_grid_opName . ' (' . $sellPrice . '원)</option>';
                }
        }
}
echo $option;
$db->disconnect();
?>