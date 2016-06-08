<?
header('Content-Type: text/html; charset=utf-8');
include("common/config.shop.php");
include("check.php");
$debug = false;
foreach ($_POST as $k => $v) {
    ${"in_" . $k} = addslashes($v);
}
$in_inputDate = date("Y-m-d H:i:s", time());

/*====== 수정 시작 ======*/
if ($in_mode == 'modify') {
    $i = 0;
    foreach ($_POST["sp"] as $key => $value) {
        # code...
        if ($i == 0) {
            $in_sp_option = $value;
        } else {
            $in_sp_option .= "-" . $value;
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
        if($in_goods_dlv_type == "0"){
            //판매자 기본배송정책 적용
            $query = "SELECT dShipping FROM settings";
            $result = mysql_query($query) or die($query);
            $dShipping = mysql_result($result,0,0);
            $in_goods_dlv_fee = $dShipping;
        }
        if($in_goods_dlv_type == "1"){
            //무료배송
            $in_goods_dlv_fee = "0";
        }elseif ($in_goods_dlv_type == "2") {
            //고정금액
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
        } elseif ($in_goods_dlv_type == "2") {
            $dlv_fee = $in_goods_dlv_fee;
        } elseif ($in_goods_dlv_type == "3") {
            $dlv_fee = $in_goods_dlv_fee;
        } elseif ($in_goods_dlv_type == "4") {

        } elseif ($in_goods_dlv_type == "5") {

        } elseif ($in_goods_dlv_type == "6") {

        } else {

        }
    }
    $query = "DELETE FROM goods_option WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_grid_name WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:blue;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_grid_name", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_grid_value WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_grid_value", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_single_name WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_single_name", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_single_value WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_single_value", $query);
        mysql_query($query) or die($query);
    }

    $in_good_opt_reg_date = date("Y-m-d H:i:s", time());
    $in_opName1Arr = explode("/", $in_opName1);
    $in_opName2Arr = explode("/", $in_opName2);
    if ($in_option_type == "0") {
        //goods 상품정보 추가
        $goodsQuery = "UPDATE goods SET
                        goods_name='$in_goods_name',commonPrice='$in_commonPrice',sellPrice='$in_sellPrice',sp_option='$in_sp_option',sb_sale='$in_sb_sale',
                        manufacture='$in_manufacture',orgin='$in_orgin',summary='$in_summary',comment='$in_comment',goods_dlv_special='$in_goods_dlv_special',
                        goods_dlv_type='$in_goods_dlv_type',goods_dlv_fee='$in_goods_dlv_fee',goods_opt_type='$in_option_type',goods_opt_Num='$in_optNum',
                        goods_stock='$in_qta',inputDate='$in_inputDate' ,goods_type='$in_goods_type',goods_stock_type='$in_goods_stock_type',goods_tag='$in_goods_tag',
                        goods_display='$in_goods_display'
                        WHERE goods_code='$in_goods_code'";
    } elseif ($in_option_type == "1") {
        $in_sellPriceArr = explode("/", $in_sellPrice);
        $in_commonPriceArr = explode("/", $in_commonPrice);
        $in_qtaArr = explode("/", $in_qta);
        $in_sellPriceArr2 = explode(";", $in_sellPriceArr[0]);
        $in_commonPriceArr2 = explode(";", $in_commonPriceArr[0]);
        $in_commonPrice = $in_commonPriceArr2[0];
        $in_sellPrice = $in_sellPriceArr2[0];
        //goods 상품정보 추가
        $goodsQuery = "UPDATE goods SET
                        goods_name='$in_goods_name',commonPrice='$in_commonPrice',sellPrice='$in_sellPrice',sp_option='$in_sp_option',sb_sale='$in_sb_sale',
                        manufacture='$in_manufacture',orgin='$in_orgin',summary='$in_summary',comment='$in_comment',goods_dlv_special='$in_goods_dlv_special',
                        goods_dlv_type='$in_goods_dlv_type',goods_dlv_fee='$in_goods_dlv_fee',goods_opt_type='$in_option_type',goods_opt_Num='$in_optNum',
                        goods_stock='$in_qta',inputDate='$in_inputDate',goods_type='$in_goods_type',goods_stock_type='$in_goods_stock_type',goods_tag='$in_goods_tag',
                        goods_display='$in_goods_display'
                        WHERE goods_code='$in_goods_code'";
    } else {
        $in_sellPriceArr = explode(";", $in_sellPrice);
        $in_commonPriceArr = explode(";", $in_commonPrice);
        $in_qtaArr = explode(";", $in_qta);
        $in_commonPrice = $in_commonPriceArr[0];
        $in_sellPrice = $in_sellPriceArr[0];
        //goods 상품정보 추가
        $goodsQuery = "UPDATE goods SET
                        goods_name='$in_goods_name',commonPrice='$in_commonPrice',sellPrice='$in_sellPrice',sp_option='$in_sp_option',sb_sale='$in_sb_sale',
                        manufacture='$in_manufacture',orgin='$in_orgin',summary='$in_summary',comment='$in_comment',goods_dlv_special='$in_goods_dlv_special',
                        goods_dlv_type='$in_goods_dlv_type',goods_dlv_fee='$in_goods_dlv_fee',goods_opt_type='$in_option_type',goods_opt_Num='$in_optNum',
                        goods_stock='$in_qta',inputDate='$in_inputDate',goods_type='$in_goods_type',goods_stock_type='$in_goods_stock_type',goods_tag='$in_goods_tag',
                        goods_display='$in_goods_display'
                        WHERE goods_code='$in_goods_code'";
    }
    if ($debug == true) {
        echo "<br>" . "$" . "goodsQuery = " . $goodsQuery . "<br>";
    } else {
        mysql_query($goodsQuery) or die($goodsQuery);
    }

    /*------ goods 수정 끝 ------*/
    /*------ goods_option_grid , goods_option_single 수정 시작 ------*/
    // 일반옵션 가격선택옵션 goods_option_single
    if ($in_option_type == "1") {
        $num = count($in_opName1Arr);
        $mod = false;
        for ($i = 0; $i < $num; $i++) {
            $in_opName2Arr2 = explode(";", $in_opName2Arr[$i]);
            $num2 = count($in_opName2Arr2);
            for ($j = 0; $j < $num2; $j++) {
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
            @$in_opName2Arr2 = explode(";", $in_opName2Arr[$i]);
            @$in_commonPriceArr2 = explode(";", $in_commonPriceArr[$i]);
            @$in_sellPriceArr2 = explode(";", $in_sellPriceArr[$i]);
            @$in_qtaArr2 = explode(";", $in_qtaArr[$i]);
            $num2 = count($in_qtaArr2);
            for ($j = 0; $j < $num2; $j++) {
                if ($mod == false) {
                    $strVal="('$in_goods_code','$in_opName1Arr[$i]','$in_opName2Arr2[$j]','$in_commonPriceArr2[$j]','$in_sellPriceArr2[$j]','$in_qtaArr2[$j]','$in_inputDate')";
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
                $in_opName2Arr2 = explode(";", $in_opName2Arr[$i]);
                $num2 = count($in_opName2Arr2);
                for ($j = 0; $j < $num2; $j++) {
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
                        $grid_value = "('$in_goods_code','$opName2_1[$i]','$opName2_2[$j]','$in_commonPriceArr[$n]','$in_sellPriceArr[$n]','$in_qtaArr[$n]')";
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
                $in_opName2Arr2 = explode(";", $in_opName2Arr[$i]);
                $num2 = count($in_opName2Arr2);
                for ($j = 0; $j < $num2; $j++) {
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
                    @$sql = "('$in_goods_code','$opName3Arr[$i]','$arropName4_1[$k]','$arropValue1_1[$k]','$arropValue2_2[$k]','$arrqt1[$k]','$in_good_opt_reg_date')";
                    $mod = true;
                } else {
                    $sql .=",('$in_goods_code','$opName3Arr[$i]','$arropName4_1[$k]','$arropValue1_1[$k]','$arropValue2_2[$k]','$arrqt1[$k]','$in_good_opt_reg_date')";
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

    /*------- 이미지 수정 시작 ----------*/
    function inup_img($timgidArr, $upload_tables, $fileSource, $dest, $insertFileName, $in_inputDate, $imageExt, $in_goods_code)
    {
        if ($timgidArr != "") {
            $query = "SELECT ImageName FROM $upload_tables WHERE id='$timgidArr'";
            $result = mysql_query($query) or die($query);
            $in_imgName = mysql_result($result, 0, 0);
            //$imgdelDir = $brandImagesDir.$in_imgName;
            if (move_file_to_trash($in_imgName)) {
                if (!move_uploaded_file($fileSource, $dest)) {
                    echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
                    alertExit("파일 업로드 실패 관리자에게 문의해주세요.");
                } else {
                    $query = "UPDATE $upload_tables SET ImageName='$insertFileName',inputDate='$in_inputDate'  WHERE id='$timgidArr'";
                    query("update_img", "upload_images", $query, $in_imgName);
                    if ($debug == "true") {
                        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
                    } else {
                        query("update", $upload_tables, $query);
                        mysql_query($query) or die($query);
                    }
                }
            } else {
                echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
                alertExit("파일 업로드 실패 관리자에게 문의해주세요.");
            }
        } else {
            if (!move_uploaded_file($fileSource, $dest)) {
                echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
                alertExit("파일 업로드 실패 관리자에게 문의해주세요.");
            } else {
                $query = "INSERT INTO $upload_tables (goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$insertFileName','$in_inputDate')";
                if ($debug == "true") {
                    echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
                } else {
                    query("insert", $upload_tables, $query);
                    mysql_query($query) or die($query);
                }
            }
        }
    }

    foreach ($_FILES as $k => $v) {
        for ($i = 0; $i < count($_FILES[$k]["name"]); $i++) {
            if ($_FILES[$k]["size"][$i] > 0) {
                $fieldName = $k;
                $arrUserSelectedFileName = explode(".", $_FILES[$k]["name"][$i]);
                $imageExt = $arrUserSelectedFileName[count($arrUserSelectedFileName) - 1];
                if (in_array($imageExt, $arr_allow_image_ext)) {
                    //$arrFieldName[]=$fieldName;
                    //$arrUploadedFile[]=$_FILES[$k]["tmp_name"][$i];
                    $fileSource = $_FILES[$k]["tmp_name"][$i];
                    $insertFileName = $in_goods_code . generate_password() . $fieldName . "." . $imageExt;
                    $dest = $brandImagesDir . $insertFileName;
                    //$arrImgExt[]=$imageExt;
                    if ($fieldName == "thumImage") {
                        inup_img($timgidArr[$i], "upload_timages", $fileSource, $dest, $insertFileName, $in_inputDate, $imageExt, $in_goods_code);
                    } elseif ($fieldName == "smImage") {
                        inup_img($simgidArr[$i], "upload_simages", $fileSource, $dest, $insertFileName, $in_inputDate, $imageExt, $in_goods_code);
                    } elseif ($fieldName == "mdImage") {
                        inup_img($mimgidArr[$i], "upload_mimages", $fileSource, $dest, $insertFileName, $in_inputDate, $imageExt, $in_goods_code);
                    } elseif ($fieldName == "bigImage") {
                        inup_img($bimgidArr[$i], "upload_bimages", $fileSource, $dest, $insertFileName, $in_inputDate, $imageExt, $in_goods_code);
                    }
                } else {
                    echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
                    alertExit("상품 이미지에러 관리자에게 문의해주세요1.");
                }
            }
        }

        /*
        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
        */
    }
    /*------- 이미지 수정 끝 ----------*/
    ?>
    <script type="text/javascript">
        alert("수정 되었습니다.");
        setTimeout("parent.loadingMask('off')", parent.maskTime);
        parent.location.href = "brandList.php?xcode=<?=$in_xcode?>&mcode=<?=$in_mcode?>&scode=<?=$in_scode?>&key=<?=$in_key?>&keyfield=<?=$in_keyfield?>";
    </script>
    <?
    /*====== 삭제 시작 ======*/
} else if ($in_mode == "delete") {
    $tabArr = array("upload_timages", "upload_simages", "upload_mimages", "upload_bimages");
    $tabcount = count($tabArr);
    for ($i = 0; $i < $tabcount; $i++) {
        $query = "SELECT imageName FROM $tabArr[$i] WHERE goods_code='$in_goods_code'";
        $result = mysql_query($query) or die($query);
        while ($rows = mysql_fetch_assoc($result)) {
            $imageName = $rows["imageName"];
            move_file_to_trash($imageName);
            $query = "delete from $tabArr[$i] where imageName='$imageName'";
            if ($debug == "true") {
                echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
            } else {
                query("delete", $tabArr[$i], $query);
                mysql_query($query) or die($query);
            }
        }
    }
    $query = "DELETE FROM goods WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_grid_name WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:blue;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_grid_name", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_grid_value WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_grid_value", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_single_name WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_single_name", $query);
        mysql_query($query) or die($query);
    }
    $query = "DELETE FROM goods_option_single_value WHERE goods_code='$in_goods_code'";
    if ($debug == "true") {
        echo "<span style='color:red;font-weight:600;'>$" . "query = </span>" . $query . "<br>";
    } else {
        query("delete", "goods_option_single_value", $query);
        mysql_query($query) or die($query);
    }

    ?>
    <script type="text/javascript">
        alert("삭제 되었습니다.");
        parent.location.href = "brandList.php?xcode=<?=$in_xcode?>&mcode=<?=$in_mcode?>&scode=<?=$in_scode?>&key=<?=$in_key?>&keyfield=<?=$in_keyfield?>";
    </script>
    <?
}
?>