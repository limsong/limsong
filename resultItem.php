<?php
include_once("include/config.php");
include_once("include/sqlcon.php");
include_once("session.php");
$basketuid = $_POST["code"];
$db->query("SELECT goods_code,sbid,sbnum,opid,opnum FROM basket WHERE uid='$basketuid'");
$dbdata = $db->loadRows();
$goods_code = $dbdata[0]["goods_code"];
$sbid = $dbdata[0]["sbid"];
$sbidArr = explode(",", $sbid);
$sbnum = $dbdata[0]["sbnum"];
$sbnumArr = explode(",", $sbnum);
$opid = $dbdata[0]["opid"];
$opidArr = explode(",", $opid);
$opnum = $dbdata[0]["opnum"];
$opnumArr = explode(",", $opnum);
$i = 0;
foreach ($sbidArr as $a => $b) {
        if ($i == 0) {
                $sbidQuery = "WHERE id='" . $b . "'";
        } else {
                $sbidQuery .= " or id='" . $b . "'";
        }
        $i++;
}
$i = 0;
foreach ($opidArr as $c => $d) {
        if ($i == 0) {
                $opidQuery = "WHERE id='" . $d . "'";
        } else {
                $opidQuery .= " or id='" . $d . "'";
        }
        $i++;
}
$html = '<div class="row"><div class="col-md-12 col-sm-12"><div style="width:75px;position: relative;float: left;">';
//imagename
$db->query("SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id ASC LIMIT 0,1");
$db_upload_timages = $db->loadRows();
$imgSrc = $brandImagesWebDir . $db_upload_timages[0]["ImageName"];
//goods
$db->query("SELECT goods_name,sb_sale,sellPrice,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$goods_code'");
$db_goodsArr = $db->loadRows();
$goods_name = $db_goodsArr[0]["goods_name"];
$goods_sellPrice = $db_goodsArr[0]["sellPrice"];
$goods_opt_type = $db_goodsArr[0]["goods_opt_type"];
$goods_opt_num = $db_goodsArr[0]["goods_opt_num"];
$sb_sale = $db_goodsArr[0]["sb_sale"];
$sb_sale = ((100-$sb_sale)/100);
$html .= '<img src="' . $imgSrc . '" width="75" height="75"></div>'
        . '<div class="col-sm-9 col-md-9" style="padding-top:10px;"><p style="margin:0px;">' . $goods_name . '</p><p class="free">무료배송</p></div>'
        . '<div class="col-sm-12 col-md-12">'
        . '<form name="itemchgform" method="POST" action="basketModify.php" class="itemchgform">'
        . '<input type="hidden" name="buc" value="' . $basketuid . '">'
        . '<div class="prod-list-detail" style="padding-left:0px;">'
        . '<div class="prod-info">'
        . '<h2 class="pro-name"></h2>'
        . '<div class="price-box">'
        . '<div class="price">'
        . '<input type="hidden" value="' . $goods_sellPrice . '" class="pric1">'
        . '<input type="hidden" value="' . $goods_code . '" class="code">'
        . '<input type="hidden" value="' . $goods_name . '" class="goods_name">'
        . '</div>'
        . '</div>'
        . '<div class="col-md-12" style="border-bottom:1px solid #aaa;margin:10px 0px;"></div>'
        . '<div class="col-md-12" style="max-height:450px;overflow: hidden;overflow-y:auto;">'
        . '<div class="col-md-12">'
        . '<div class="col-md-12" style="padding-right: 0px;">'
        . '<div class="country-select" style="margin-bottom:0px;">';
if($goods_opt_type != "0") {
        if($goods_opt_type == "1"){
                //일반옵션
                $db->query("SELECT * FROM goods_option_single_value WHERE goods_code='$goods_code' ORDER BY id asc");
                $goods_option_single_value_Query = $db->loadRows();
                $count = count($goods_option_single_value_Query);
                for ($i = 0; $i < $count; $i++) {
                        $goods_option_single_vlaue_opName1 = $goods_option_single_value_Query[$i]["opName1"];
                        $goods_option_single_vlaue_opName2 = $goods_option_single_value_Query[$i]["opName2"];
                        $goods_option_single_vlaue_sellPrice = $goods_option_single_value_Query[$i]["sellPrice"]*$sb_sale;
                        $goods_option_single_vlaue_quantity = $goods_option_single_value_Query[$i]["quantity"];
                        $goods_option_single_vlaue_id = $goods_option_single_value_Query[$i]["id"];
                        if ($i == 0) {
                                $goods_option_single_vlaue_opName1Tmp = $goods_option_single_vlaue_opName1;
                                $option = '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem"><option>' . $goods_option_single_vlaue_opName1 . '</option>';
                                if ($goods_option_single_vlaue_quantity == "0") {
                                        $option .= '<option disabled>' . $goods_option_single_vlaue_opName2 . ' 품절</option>';
                                } else {
                                        $option .= '<option  data="'.$goods_option_single_vlaue_id.'" value="'.$goods_option_single_vlaue_sellPrice.'" data1="'.$goods_option_single_vlaue_opName1.'" data2="'.$goods_option_single_vlaue_opName2.'">' . $goods_option_single_vlaue_opName2 . " (" . number_format($goods_option_single_vlaue_sellPrice) . '원)</option>';
                                }
                        } else {
                                if ($goods_option_single_vlaue_opName1Tmp != $goods_option_single_vlaue_opName1) {
                                        $goods_option_single_vlaue_opName1Tmp = $goods_option_single_vlaue_opName1;
                                        $option .= '</select>';
                                        $option .= '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem"><option>' . $goods_option_single_vlaue_opName1 . '</option>';
                                        if ($goods_option_single_vlaue_quantity == "0") {
                                                $option .= '<option disabled>' . $goods_option_single_vlaue_opName2 . ' 품절</option>';
                                        } else {
                                                $option .= '<option data="'.$goods_option_single_vlaue_id.'" value="'.$goods_option_single_vlaue_sellPrice.'"  data1="'.$goods_option_single_vlaue_opName1.'" data2="'.$goods_option_single_vlaue_opName2.'">' . $goods_option_single_vlaue_opName2 . " (" . number_format($goods_option_single_vlaue_sellPrice) . '원)</option>';
                                        }
                                } else {
                                        if ($goods_option_single_vlaue_quantity == "0") {
                                                $option .= '<option disabled>' . $goods_option_single_vlaue_opName2 . ' 품절</option>';
                                        } else {
                                                $option .= '<option data="'.$goods_option_single_vlaue_id.'" value="'.$goods_option_single_vlaue_sellPrice.'" data1="'.$goods_option_single_vlaue_opName1.'" data2="'.$goods_option_single_vlaue_opName2.'">' . $goods_option_single_vlaue_opName2 . " (" . number_format($goods_option_single_vlaue_sellPrice) . '원)</option>';
                                        }
                                }
                        }
                }
        }else{
                //가격선택옵션
                $db->query("SELECT * FROM goods_option_grid_name WHERE goods_code='$goods_code' ORDER BY id asc");
                $goods_option_nameQuery = $db->loadRows();
                $count = count($goods_option_nameQuery);
                $mod = false;
                $k = 1;
                for ($i = 0; $i < $count; $i++) {
                        $goods_opName1 = $goods_option_nameQuery[$i]["opName1"];
                        $goods_opName2 = $goods_option_nameQuery[$i]["opName2"];
                        if ($i == 0) {
                                $goods_opName1Tmp = $goods_opName1;
                                $option = '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem'.$k.'"><option>' . $goods_opName1 . '</option>';
                                $option .= '<option value="" data="">' . $goods_opName2 . '</option>';
                                $k++;
                        } else {
                                if ($goods_opName1Tmp != $goods_opName1) {
                                        $mod = true;
                                        $goods_opName1Tmp = $goods_opName1;
                                        $option .= '</select>';
                                        $option .= '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem'.$k.'"><option value="" data="">' . $goods_opName1 . '</option>';
                                        $k++;
                                } else {
                                        if ($mod == false) {
                                                $option .= '<option value="" data="">' . $goods_opName2 . '</option>';
                                        }
                                }
                        }
                }
        }
        $option = $option . "</select>";
        $html .= $option;

        //추가옵션 상품선택 폼
        $html .= '</div>'
                .'</div>'
                .'</div>'
                .'<div class="col-md-12" style="border-bottom:1px dotted #aaa;margin:5px 0px;"></div>'
                .'<div class="col-md-12" style="padding-right: 0px;">-추가구매를 원하시면 추가옵션을 선택하세요</div>'
                .'<div class="col-md-12" style="border-bottom:1px dotted #aaa;margin:5px 0px;"></div>'
                .'<div class="col-md-12 option">';
        $html .= '<div class="col-md-12" style="padding-right: 0px;">'
                .'<div class="country-select" style="margin-bottom:10px;">';

        $db->query("SELECT * FROM goods_option WHERE goods_code='$goods_code' ORDER BY id asc");
        $goods_optionQuery = $db->loadRows();
        $count = count($goods_optionQuery);
        for ($i = 0; $i < $count; $i++) {
                $option_opName1 = $goods_optionQuery[$i]["opName1"];//옵션명
                $option_opName2 = $goods_optionQuery[$i]["opName2"];//옵션 상품명
                $option_opValue2 = $goods_optionQuery[$i]["opValue2"];//판매가
                $option_opid = $goods_optionQuery[$i]["id"];
                if ($i == 0) {
                        $option_opName1Tmp = $option_opName1;
                        $option_select = '<select style="height:20px;font-size:12px;" name="bsoption[]" class="bsoption">';
                        $option_select .= '<option>' . $option_opName1 . '</option>';
                        $option_select .= '<option value="' . $option_opValue2 . '" data="' . $option_opid . '">' . $option_opName2 . ' +' . $option_opValue2 . '원 </option>';

                } else {
                        if ($option_opName1Tmp != $option_opName1) {
                                $option_opName1Tmp = $option_opName1;
                                $option_select .= "</select>";
                                $option_select .= '<select style="height:20px;font-size:12px;" name="bsoption[]" class="bsoption">';
                                $option_select .= '<option>' . $option_opName1 . '</option>';
                                $option_select .= '<option value="' . $option_opValue2 . '" data="' . $option_opid . '">' . $option_opName2 . ' +' . $option_opValue2 . '원 </option>';
                        } else {
                                $option_select .= '<option value="' . $option_opValue2 . '" data="' . $option_opid . '">' . $option_opName2 . ' +' . $option_opValue2 . '원 </option>';
                        }
                }
        }
        $option_select = $option_select . "</select>";
        $html .=$option_select;
        $html .='</div>'
                .'</div>';
}else{
        $html .='<div class="col-md-12 m-item">
                                <div class="col-md-12 cm12" style="padding:0px;margin-bottom: 30px;">
                                        <div class="col-md-12" style="margin:5px 0px;"></div>
                                        <input type="hidden" name="itemid[]" value="'.$sbid.'">
                                        <div class="col-md-6 cm12" style="padding:0px;line-height: 25px;">옵션없음11</div>
                                        <div class="col-md-3 cm6" style="padding:0px;">
                                                <div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">
                                                        <i class="fa fa-minus item-minus"></i>
                                                </div>
                                                <div class="col-md-4 cm4" style="padding:0px;text-align:center;">
                                                        <input type="text" name="itemnum[]" class="item_num" value="'.$sbnum.'">
                                                </div>
                                                <div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;">
                                                        <i class="fa fa-plus item-plus"></i>
                                                </div>
                                        </div>
                                        <div class="col-md-3 cm6" style="text-align:right;padding:0px;">
                                                <span data="'.$goods_sellPrice*$sb_sale.'" class="sub_pric">'.number_format($goods_sellPrice*$sb_sale).'</span>
                                                <span style="color:#e26a6a;">원</span>
                                        </div>
                                </div>
                        </div>';
        $sum = $goods_sellPrice*$sb_sale*$sbnumArr[0];
        $num = $sbnumArr[0];
}

//장바구니에 담긴 메인상품하고 옵션 상품을 출력한다
//메인상품 먼저 출력
$html .= '<!--PRODUCT INCREASE BUTTON START-->'
        .'</div>'
        .'<!--PRODUCT INCREASE BUTTON END-->'
        .'<div class="col-md-12" style="border-bottom:1px solid #aaa;margin:5px 0px;"></div>'
        .'<!-- 메인상품 추가 폼 시작-->'
        .'<div class="col-md-12 m-item">'
        .'<input type="hidden" name="goods_opt_type" value="'.$goods_opt_type.'">';


if($goods_opt_type == "1"){
        $db->query("SELECT id,opName1,opName2,sellPrice FROM goods_option_single_value $sbidQuery");
        $goods_valueQuery = $db->loadRows();
}elseif($goods_opt_type == "2"){
        $db->query("SELECT id,opName1,opName2,opName3,opValue2 FROM goods_option_grid_value $sbidQuery");
        $goods_valueQuery = $db->loadRows();
}
$sbcount = count($goods_valueQuery);
for ($i = 0; $i < $sbcount; $i++) {
        if ($goods_opt_type == "1") {
                $goods_id = $goods_valueQuery[$i]["id"];
                $goods_name = $goods_valueQuery[$i]["opName1"] . "_" . $goods_valueQuery[$i]["opName2"];
                $goods_sellPrice = $goods_valueQuery[$i]["sellPrice"] * $sb_sale;
        } else {
                $goods_id = $goods_valueQuery[$i]["id"];
                if ($goods_valueQuery[$i]["opName3"] == "") {
                        $goods_name = $goods_valueQuery[$i]["opName1"] . "_" . $goods_valueQuery[$i]["opName2"];
                } else {
                        $goods_name = $goods_valueQuery[$i]["opName1"] . "_" . $goods_valueQuery[$i]["opName2"] . "_" . $goods_valueQuery[$i]["opName3"];
                }
                $goods_sellPrice = $goods_valueQuery[$i]["opValue2"] * $sb_sale;
        }
        $sum += $goods_sellPrice*$sbnumArr[$i];
        $num += $sbnumArr[$i];
        $html .= '<div class="col-md-12" style="padding:0px;">'
                . '<div class="col-md-12" style="margin:5px 0px;"></div>'
                . '<input type="hidden" class="itemid" name="itemid[]" value="' . $goods_id . '">'
                . '<div class="col-md-7 cm12" style="line-height:25px;height:25px;">' . $goods_name . '</div>'
                . '<div class="col-md-2 cm6" style="padding:0px;">'
                . '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">'
                . '<i class="fa fa-minus item-minus"></i>'
                . '</div>'
                . '<div class="col-md-4 cm4" style="padding:0px;text-align:center;">'
                . '<input type="text" name="itemnum[]" class="item_num" value="' . $sbnumArr[$i] . '">'
                . '</div>'
                . '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">'
                . '<i class="fa fa-plus item-plus"></i>'
                . '</div>'
                . '</div>'
                . '<div class="col-md-3 cm6" style="line-height:25px;height:25px;text-align:right;padding:0px;">'
                . '<span data="' . $goods_sellPrice . '" class="sub_pric">' . number_format($goods_sellPrice) . '</span>'
                . '<span style="color:#e26a6a;">원</span>'
                . '<i class="fa fa-trash-o"></i>'
                . '</div>'
                . '</div>';
}
$html .= '</div>';

//추가옵션 출력
$html .='<div class="col-md-12 s-item">';
if($goods_opt_type !="0"){
        $db->query("SELECT * FROM goods_option $opidQuery");
        $option_valueQuery = $db->loadRows();
        $count = count($option_valueQuery);
        for($i=0;$i<$count;$i++) {
                $option_id = $option_valueQuery[$i]["id"];
                $option_name = $option_valueQuery[$i]["opName1"]."_".$option_valueQuery[$i]["opName2"];
                $option_sellPrice = $option_valueQuery[$i]["opValue2"];
                $sum +=$option_sellPrice*$opnumArr[$i];
                $num +=$opnumArr[$i];
                $html .= '<div class="col-md-12" style="padding:0px;">'
                        . '<div class="col-md-12" style="margin:5px 0px;"></div>'
                        . '<input type="hidden" name="optionid[]" value="' . $option_id . '">'
                        . '<div class="col-md-7 cm12" style="line-height:25px;height:25px;">' . $option_name . '</div>'
                        . '<div class="col-md-2 cm6" style="padding:0px;">'
                        . '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">'
                        . '<i class="fa fa-minus item-minus"></i>'
                        . '</div>'
                        . '<div class="col-md-4 cm4" style="padding:0px;text-align:center;">'
                        . '<input type="text" name="opnum[]" class="item_num" value="' . $opnumArr[$i] . '">'
                        . '</div>'
                        . '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">'
                        . '<i class="fa fa-plus item-plus"></i>'
                        . '</div>'
                        . '</div>'
                        . '<div class="col-md-3 cm6" style="line-height:25px;height:25px;text-align:right;padding:0px;">'
                        . '<span data="' . $option_sellPrice . '" class="sub_pric">' . number_format($option_sellPrice) . '</span>'
                        . '<span style="color:#e26a6a;">원</span>'
                        . '<i class="fa fa-trash-o"></i>'
                        . '</div>'
                        . '</div>';
        }
}
//토탈 금액 출력
$html .= '</div>'
        .'<!-- 서브상품 추가 폼 끝-->'
        .'<div class="col-md-12" style="margin:5px 0px 0px 0px;"></div>'
        .'<!-- 토탈 폼 시작-->'
        .'</div>'
        .'<div class="col-md-12 total" style="display:block;">'
        .'<div class="col-md-8 cm6">'
        .'<span style="font-size:12px;font-weight:bold;color:#333;">총 합계금액</span>'
        .'<span style="font-size:12px;color:#000;">(수량)</span>'
        .'</div>'
        .'<div class="col-md-4 cm6" style="text-align:right;">'
        .'<span class="totalSum" data="' . $sum . '" style="font-size:17px;color:#e26a6a;font-weight:bold;">' . number_format($sum) . '</span>'
        .'<span style="color:#e26a6a;">원(<span class="totalNum">' .$num. '</span>개)</span>'
        .'</div>'
        .'</div>'
        .'<!-- 토탈폼 끝-->'
        .'</div>'
        .'</div>'
        .'</form>'
        .'</div>'
        .'</div>'
        .'</div>';




echo $html;
$db->disconnect();
?>