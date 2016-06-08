<?php
//header('Content-Type: text/html; charset=utf-8');
include("common/config.shop.php");
include("check.php");
$debug = false;
//option_type 상품 옵션타입* 0 ,1 ,2
//goods_opt_sel_type  -> option_type 이 2일대 0 : 단일서택 1: 분리선택
foreach ($_POST as $k => $v) {
        ${"in_" . $k} = addslashes($v);
}
$in_inputDate = date("Y-m-d H:i:s", time());
$query = "select goods_code  FROM goods WHERE goods_code like '$in_xcode$in_mcode$in_scode%' order by goods_code desc limit 0,1";
$result = mysql_query($query) or die($query);
$rows = mysql_num_rows($result);
if ($rows < 1) {
        $in_goods_code = $in_xcode . $in_mcode . $in_scode . "001";
} else {
        $ou_goods_code = mysql_result($result, 0, 0);
        $ou_goods_code++;
        $in_goods_code = substr("00" . $ou_goods_code, -9);
}
$i = 0;
foreach ($_POST["sp"] as $key => $value) {
        if ($i == 0) {
                $in_sp_option .= $value;
        } else {
                $in_sp_option .= "-".$value;
        }
        $i++;
}
//goods_dlv_special 배송정책 0 일반배송 1 별도배송
if ($in_goods_dlv_special == "0") {
        /*
         * goods_dlv_type
         * 1 판매자 기본 배송정책 적용
         * 2 무료
         * 3 고정금액(선불)
         */
        $query = "SELECT dShipping FROM settings";
        $result = mysql_query($query) or die("brandPost");
        $row = mysql_fetch_array($result);
        $dShipping = $row["dShipping"];

        if ($in_goods_dlv_type == "1") {
                $dlv_fee = $dShipping;
                $shipping = "Y";
        } elseif ($in_goods_dlv_type == "2") {
                $dlv_fee = "0";
                $shipping = "N";
        } else {
                $dlv_fee = $in_goods_dlv_fee;
                $shipping = "Y";
        }
} else {
        /*
         *   1 무료
             2 고정금액(선불)
             3 착불
             4 주문금액별 차등
             5 무게별 차등
             6 부피별 차등
             7 수량비례
         * */
        if ($in_goods_dlv_type == "1") {
                $dlv_fee = "0";
                $shipping = "N";
        } elseif ($in_goods_dlv_type == "2") {
                $dlv_fee = $in_goods_dlv_fee;
                $shipping = "Y";
        } elseif ($in_goods_dlv_type == "3") {
                $dlv_fee = $in_goods_dlv_fee;
                $shipping = "Y";
        } elseif ($in_goods_dlv_type == "4") {

        } elseif ($in_goods_dlv_type == "5") {

        } elseif ($in_goods_dlv_type == "6") {

        } else {

        }
}

$in_good_opt_reg_date = date("Y-m-d H:i:s", time());
//good_opt_use_stock 재고 qta
//good_opt_option_name1 옵션명 optionValue
//good_opt_option_price 시장가/정찰가 commonPrice
//good_opt_reg_date 옵션 등록일
//good_opt_option_label_price 판매가 sellPrice
if($in_option_type != "0"){
        $in_goods_stock = 0;
}else{
        $in_goods_stock = $in_qta;
}
$in_opName1Arr = explode("/", $in_opName1);
$in_opName2Arr = explode("/", $in_opName2);
if ($in_option_type == "0") {
        //goods 상품정보 추가
        $goodsQuery = "INSERT INTO
                    goods (goods_name,goods_code,commonPrice,sellPrice,sp_option,shipping,sb_sale,manufacture,orgin,summary,comment,goods_dlv_special,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_Num,goods_stock_type,goods_stock,inputDate,goods_tag,goods_display,goods_type)
                  VALUES
                    ('$in_goods_name','$in_goods_code','$in_commonPrice','$in_sellPrice','$in_sp_option','$shipping','$in_sb_sale','$in_manufacture','$in_orgin','$in_summary','$in_content','$in_goods_dlv_special','$in_goods_dlv_type','$dlv_fee','$in_option_type','$in_optNum','$in_goods_stock_type','$in_qta','$in_inputDate','$in_goods_tag','$in_goods_display','$in_goods_type')";
} elseif ($in_option_type == "1") {
        $in_sellPriceArr = explode("/", $in_sellPrice);
        $in_commonPriceArr = explode("/", $in_commonPrice);
        $in_qtaArr = explode("/", $in_qta);
        $in_sellPriceArr2 = explode(";", $in_sellPriceArr[0]);
        $in_commonPriceArr2 = explode(";", $in_commonPriceArr[0]);
        $in_commonPrice = $in_commonPriceArr2[0];
        $in_sellPrice = $in_sellPriceArr2[0];
        //goods 상품정보 추가
        $goodsQuery = "INSERT INTO
                    goods (goods_name,goods_code,commonPrice,sellPrice,sp_option,shipping,sb_sale,manufacture,orgin,summary,comment,goods_dlv_special,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_Num,goods_stock_type,goods_stock,inputDate,goods_tag,goods_display,goods_type)
                  VALUES
                    ('$in_goods_name','$in_goods_code','$in_commonPrice','$in_sellPrice','$in_sp_option','$shipping','$in_sb_sale','$in_manufacture','$in_orgin','$in_summary','$in_content','$in_goods_dlv_special','$in_goods_dlv_type','$dlv_fee','$in_option_type','$in_optNum','$in_goods_stock_type','$in_qta','$in_inputDate','$in_goods_tag','$in_goods_display','$in_goods_type')";

} else {
        $in_sellPriceArr = explode(";", $in_sellPrice);
        $in_commonPriceArr = explode(";", $in_commonPrice);
        $in_qtaArr = explode(";", $in_qta);
        $in_commonPrice = $in_commonPriceArr[0];
        $in_sellPrice = $in_sellPriceArr[0];
        //goods 상품정보 추가
        $goodsQuery = "INSERT INTO
                    goods (goods_name,goods_code,commonPrice,sellPrice,sp_option,shipping,sb_sale,manufacture,orgin,summary,comment,goods_dlv_special,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_Num,goods_stock_type,goods_stock,inputDate,goods_tag,goods_display,goods_type)
                  VALUES
                    ('$in_goods_name','$in_goods_code','$in_commonPrice','$in_sellPrice','$in_sp_option','$shipping','$in_sb_sale','$in_manufacture','$in_orgin','$in_summary','$in_content','$in_goods_dlv_special','$in_goods_dlv_type','$dlv_fee','$in_option_type','$in_optNum','$in_goods_stock_type','$in_qta','$in_inputDate','$in_goods_tag','$in_goods_display','$in_goods_type')";
}


if ($debug == true) {
        echo "<br>" . "$" . "goodsQuery = " . $goodsQuery . "<br>";
} else {
        mysql_query($goodsQuery) or die($goodsQuery);
}

// 일반옵션 가격선택옵션 goods_option_single
if ($in_option_type == "1") {
        $num = count($in_opName1Arr);
        $mod = false;
        for ($i = 0; $i < $num; $i++) {
                $in_opName2Arr2 = explode(";", $in_opName2Arr[$i]);
                $num2 = count($in_opName2Arr2);
                for($j=0;$j<$num2;$j++){
                        if ($mod == false) {
                                $option_single_name = "('$in_goods_code','$in_opName1Arr[$i]','$in_opName2Arr2[$j]')";
                                $mod = true;
                        } else {
                                $option_single_name .= ",('$in_goods_code','$in_opName1Arr[$i]','$in_opName2Arr2[$j]')";
                        }
                }
        }
        $goods_option_single_name_Query = "INSERT INTO goods_option_single_name (goods_code,opName1,opName2) VALUES $option_single_name";
        if ($debug == true) {
                echo "<br>" . "$" . "goods_option_single_name_Query = " . $goods_option_single_name_Query . "<br>";
        } else {
                mysql_query($goods_option_single_name_Query) or die($goods_option_single_name_Query);
        }

        $mod = false;
        $num = count($in_opName2Arr);
        for ($i = 0; $i < $num; $i++) {
                $in_opName2Arr2 = explode(";", $in_opName2Arr[$i]);
                $in_commonPriceArr2 = explode(";", $in_commonPriceArr[$i]);
                $in_sellPriceArr2 = explode(";", $in_sellPriceArr[$i]);
                $in_qtaArr2 = explode(";", $in_qtaArr[$i]);
                  $num2=count($in_qtaArr2);
                for ($j = 0; $j < $num2; $j++) {
                        if ($mod == false) {
                                $strVal = "('$in_goods_code','$in_opName1Arr[$i]','$in_opName2Arr2[$j]','$in_commonPriceArr2[$j]','$in_sellPriceArr2[$j]','$in_qtaArr2[$j]','$in_inputDate')";
                                $mod = true;
                        } else {
                                $strVal .= ",('$in_goods_code','$in_opName1Arr[$i]','$in_opName2Arr2[$j]','$in_commonPriceArr2[$j]','$in_sellPriceArr2[$j]','$in_qtaArr2[$j]','$in_inputDate')";
                        }
                }
        }

        $goods_option_value_Query = "INSERT INTO goods_option_single_value (goods_code,opName1,opName2,commonPrice,sellPrice,quantity,inputDate) VALUES $strVal";
        if ($debug == true) {
                echo "<br>" . "$" . "goods_option_value_Query = " . $goods_option_value_Query . "<br>";
        } else {
                mysql_query($goods_option_value_Query) or die($goods_option_value_Query);
        }
} elseif ($in_option_type == "2") {
        if ($in_optNum == "2") {
                $opName2_1 = explode(";", $in_opName2Arr[0]);
                $opName2_2 = explode(";", $in_opName2Arr[1]);
                $num = count($in_opName1Arr);
                $num0 = count($opName2_1);
                $num1 = count($opName2_2);
                $mod = false;
                //goods_option_grid_name
                for ($i = 0; $i < $num; $i++) {
                        $in_opName2Arr2 = explode(";",$in_opName2Arr[$i]);
                        $num2 = count($in_opName2Arr2);
                        for($j=0;$j<$num2;$j++){
                                if ($mod == false) {
                                        $grid_name = "('$in_goods_code','X','$in_opName1Arr[$i]','$in_opName2Arr2[$j]')";
                                        $mod = true;
                                } else {
                                        $grid_name .= ",('$in_goods_code','X','$in_opName1Arr[$i]','$in_opName2Arr2[$j]')";
                                }
                        }
                }
                $goods_option_grid_name_Query = "INSERT INTO goods_option_grid_name (goods_code,opType,opName1,opName2) VALUES $grid_name";
                if ($debug == true) {
                        echo "<br>" . "$" . "goods_option_grid_name_Query = " . $goods_option_grid_name_Query . "<br>";
                } else {
                        mysql_query($goods_option_grid_name_Query) or die($goods_option_grid_name_Query);
                }
                //goods_option_grid_value
                $n = 0;
                $mod = false;
                for ($i = 0; $i < $num0; $i++) {
                        for ($j = 0; $j < $num1; $j++) {
                                if ($mod == false) {
                                        $grid_value .= "('$in_goods_code','$opName2_1[$i]','$opName2_2[$j]','$in_commonPriceArr[$n]','$in_sellPriceArr[$n]','$in_qtaArr[$n]')";
                                        $mod = true;
                                } else {
                                        $grid_value .= ",('$in_goods_code','$opName2_1[$i]','$opName2_2[$j]','$in_commonPriceArr[$n]','$in_sellPriceArr[$n]','$in_qtaArr[$n]')";
                                }
                                $n++;
                        }
                }
                $goods_option_grid_value_Query = "INSERT INTO goods_option_grid_value (goods_code,opName1,opName2,opValue1,opValue2,opValue3) VALUES $grid_value";
                if ($debug == true) {
                        echo "<br>" . "$" . "goods_option_grid_value_Query = " . $goods_option_grid_value_Query . "<br>";
                } else {
                        mysql_query($goods_option_grid_value_Query) or die($goods_option_grid_value_Query);
                }
        } else if ($in_optNum == "3") {
                $opName2_1 = explode(";", $in_opName2Arr[0]);
                $opName2_2 = explode(";", $in_opName2Arr[1]);
                $opName2_3 = explode(";", $in_opName2Arr[2]);
                $num = count($in_opName1Arr);
                $num0 = count($opName2_1);
                $num1 = count($opName2_2);
                $num2 = count($opName2_3);
                $mod = false;
                //goods_option_grid_name
                for ($i = 0; $i < $num; $i++) {
                        $in_opName2Arr2 = explode(";",$in_opName2Arr[$i]);
                        $num2 = count($in_opName2Arr2);
                        for($j=0;$j<$num2;$j++){
                                if ($mod == false) {
                                        $grid_name = "('$in_goods_code','O','$in_opName1Arr[$i]','$in_opName2Arr2[$j]')";
                                        $mod = true;
                                } else {
                                        $grid_name .= ",('$in_goods_code','O','$in_opName1Arr[$i]','$in_opName2Arr2[$j]')";
                                }
                        }

                }
                $goods_option_grid_name_Query = "INSERT INTO goods_option_grid_name (goods_code,opType,opName1,opName2) VALUES $grid_name";
                if ($debug == true) {
                        echo "<br>" . "$" . "goods_option_grid_name_Query = " . $goods_option_grid_name_Query . "<br>";
                } else {
                        mysql_query($goods_option_grid_name_Query) or die($goods_option_grid_name_Query);
                }
                //goods_option_grid_value
                $n = 0;
                $mod = false;
                for ($i = 0; $i < $num0; $i++) {
                        for ($j = 0; $j < $num1; $j++) {
                                for ($k = 0; $k < $num2; $k++) {
                                        if ($mod == false) {
                                                $grid_value .= "('$in_goods_code','$opName2_1[$i]','$opName2_2[$j]','$opName2_3[$k]','$in_commonPriceArr[$n]','$in_sellPriceArr[$n]','$in_qtaArr[$n]')";
                                                $mod = true;
                                        } else {
                                                $grid_value .= ",('$in_goods_code','$opName2_1[$i]','$opName2_2[$j]','$opName2_3[$k]','$in_commonPriceArr[$n]','$in_sellPriceArr[$n]','$in_qtaArr[$n]')";
                                        }
                                        $n++;
                                }
                        }
                }
                $goods_option_grid_value_Query = "INSERT INTO goods_option_grid_value (goods_code,opName1,opName2,opName3,opValue1,opValue2,opValue3) VALUES $grid_value";
                if ($debug == true) {
                        echo "<br>" . "$" . "goods_option_grid_value_Query = " . $goods_option_grid_value_Query . "<br>";
                } else {
                        mysql_query($goods_option_grid_value_Query) or die($goods_option_grid_value_Query);
                }
        }
}


if ($in_opName3) {
        $opName3Arr = explode("/", $in_opName3);
        $arropName4 = explode("/", $in_opName4);
        $arropValue1 = explode("/", $in_opValue1);
        $arropValue2 = explode("/", $in_opValue2);
        $arrqt = explode("/", $in_qt);
        $num1 = count($opName3Arr);
        $mod = false;
        for ($i = 0; $i < $num1; $i++) {
                $arropName4_1 = explode(";", $arropName4[$i]);
                $arropValue1_1 = explode(";", $arropValue1[$i]);
                $arropValue2_2 = explode(";", $arropValue2[$i]);
                $arrqt1 = explode(";", $arrqt[$i]);
                $num2 = count($arropValue1_1);
                for ($k = 0; $k < $num2; $k++) {
                        if ($mod == false) {
                                $sql .= "('$in_goods_code','$opName3Arr[$i]','$arropName4_1[$k]','$arropValue1_1[$k]','$arropValue2_2[$k]','$arrqt1[$k]','$in_good_opt_reg_date')";
                                $mod = true;
                        } else {
                                $sql .= ",('$in_goods_code','$opName3Arr[$i]','$arropName4_1[$k]','$arropValue1_1[$k]','$arropValue2_2[$k]','$arrqt1[$k]','$in_good_opt_reg_date')";
                        }
                }
        }
        $sql = "INSERT INTO goods_option (goods_code,opName1,opName2,opValue1,opValue2,quantity,goods_opt_reg_date) VALUES $sql";
        if ($debug == "true") {
                echo "$" . "sql = " . $sql . "<br>";
        } else {
                mysql_query($sql) or die($sql);
        }

}

foreach ($_FILES as $k => $v) {
        for ($i = 0; $i < count($_FILES[$k]["name"]); $i++) {
                if ($_FILES[$k]["size"][$i] > 0) {
                        $fieldName = $k;
                        $arrUserSelectedFileName = explode(".", $_FILES[$k]["name"][$i]);
                        $imageExt = $arrUserSelectedFileName[count($arrUserSelectedFileName) - 1];
                        if (in_array($imageExt, $arr_allow_image_ext)) {
                                $arrFieldName[] = $fieldName;
                                $arrUploadedFile[] = $_FILES[$k]["tmp_name"][$i];
                                $arrImgExt[] = $imageExt;
                        } else {
                                echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
                                alertExit("상품 이미지에러");
                        }
                }
        }

        /*
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
        */
}
$addFields = "";
$addValues = "";
for ($i = 0; $i < count($arrFieldName); $i++) {
        $fileSource = $arrUploadedFile[$i];
        $insertFileName = $in_goods_code . $i . $arrFieldName[$i] . "." . $arrImgExt[$i];
        $dest = $brandImagesDir . $insertFileName;
        if ($debug == "true") {
                echo "$" . "fileSource = " . $fileSource . "<br>";
                echo "$" . "dest = " . $dest . "<br>";
        } else {
                if (!move_uploaded_file($fileSource, $dest)) {
                        echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
                        alertExit("파일 업로드 실패 관리자에게  문의해주세요.");
                }
        }
        $addFields .= "," . $arrFieldName[$i];
        $addValues .= ",'" . $insertFileName . "'";
        if ($arrFieldName[$i] == "smImage") {
                $query = "INSERT INTO upload_simages (goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$insertFileName','$in_inputDate')";
        } elseif ($arrFieldName[$i] == "mdImage") {
                $query = "INSERT INTO upload_mimages (goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$insertFileName','$in_inputDate')";
        } elseif ($arrFieldName[$i] == "bigImage") {
                $query = "INSERT INTO upload_bimages (goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$insertFileName','$in_inputDate')";
        } elseif ($arrFieldName[$i] == "thumImage") {
                $query = "INSERT INTO upload_timages (goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$insertFileName','$in_inputDate')";
        }

        if ($debug == true) {
                echo "<br>" . "$" . "query = " . $query . "<br>";
                echo "$" . "addFields = " . $addFields . "<br>";
                echo "$" . "addValues = " . $addValues . "<br>";
        } else {
                mysql_query($query) or die($query);
        }
}
if ($debug == "true") {
?>
        <script type="text/javascript">
                alert("입력되었습니다1.");
        </script>
<?
} else {
?>
        <script type="text/javascript">
                alert("입력되었습니다.");
                /*
                 var xcode=parent.document.brandForm.xcode.value=xcode;
                 var mcode=parent.document.brandForm.mcode.value=mcode;
                 var scode=parent.document.brandForm.scode.value=scode;
                 parent.document.brandForm.reset();
                 parent.document.brandForm.xcode.value=xcode;
                 parent.document.brandForm.mcode.value=mcode;
                 parent.document.brandForm.scode.value=scode;
                 */

                //var oEditor=parent.FCKeditorAPI.GetInstance('comment');
                //oEditor.SetHTML("");

                //setTimeout("parent.loadingMask('off')",parent.maskTime);
                //parent.location.reload();
                parent.location.href="brandList.php";
        </script>
<?
}
mysql_close($db);
?>