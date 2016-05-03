<?
include("common/config.shop.php");
$goods_code = $_GET["goods_code"];
$page = $_GET["page"];
$xcode = $_GET["xcode"];
$mcode = $_GET["mcode"];
$scode = $_GET["scode"];
$key = $_GET["key"];
$keyfield = $_GET["keyfield"];
$vXcode = substr($goods_code, 0, 2);
$vMcode = substr($goods_code, 2, 2);
$vScode = substr($goods_code, 4, 2);
if ($vXcode != '00') {
    $query = "select sortName from sortCodes where uxCode='00' and umCode='00' and sortCode='$vXcode'";
    $result = mysql_query($query) or die($query);
    $xcodeName = mysql_result($result, 0, 0);
    $sortText = $xcodeName . "[" . $vXcode . "]";
}
if ($vMcode != '00') {
    $query = "select sortName from sortCodes where uxCode='$vXcode' and umCode='00' and sortCode='$vMcode'";
    $result = mysql_query($query) or die($query);
    $mcodeName = mysql_result($result, 0, 0);
    $sortText .= " -> " . $mcodeName . "[" . $vMcode . "]";
}
if ($vScode != '00') {
    $query = "select sortName from sortCodes where uxCode='$vXcode' and umCode='$vMcode' and sortCode='$vScode'";
    $result = mysql_query($query) or die($query);
    $scodeName = mysql_result($result, 0, 0);
    $sortText .= " -> " . $scodeName . "[" . $vScode . "]";
}
$query = "SELECT * FROM goods WHERE goods_code='$goods_code'";
$result = mysql_query($query) or die($query);
$row = mysql_fetch_assoc($result);
foreach ($row as $k => $v) {
    ${"ou_" . $k} = stripslashes($v);
}
if ($ou_sp_option != "") {
    $ou_sp_optionArr = explode("-", $ou_sp_option);
}
if ($ou_goods_opt_type == "0") {
    $goods_option_value_commonPrice = $ou_commonPrice;
    $goods_option_value_sellPrice = $ou_sellPrice;
    $goods_option_value_quantity = $ou_goods_stock;
} elseif ($ou_goods_opt_type == "1") {
    $show = "show";
    $readonly = "readonly";
    $goods_option_single_name_Query = "SELECT * FROM goods_option_single_name WHERE goods_code='$ou_goods_code'";
    $goods_option_single_name_Reslult = mysql_query($goods_option_single_name_Query) or die($goods_option_single_name_Query);
    $i = 0;
    while ($goods_option_single_name_Rows = mysql_fetch_array($goods_option_single_name_Reslult)) {
        if ($i == 0) {
            $goods_option_name_opName1Tmp = $goods_option_single_name_Rows["opName1"];
            $goods_option_name_opName1 = $goods_option_single_name_Rows["opName1"];
            $goods_option_name_opName2 = $goods_option_single_name_Rows["opName2"];
            $i++;
        } else {
            if ($goods_option_name_opName1Tmp == $goods_option_single_name_Rows["opName1"]) {
                $goods_option_name_opName2 .= ";" . $goods_option_single_name_Rows["opName2"];
            } else {
                $goods_option_name_opName1Tmp = $goods_option_single_name_Rows["opName1"];
                $goods_option_name_opName1 .= "/" . $goods_option_single_name_Rows["opName1"];
                $goods_option_name_opName2 .= "/" . $goods_option_single_name_Rows["opName2"];
            }

        }
    }
    $goods_option_single_value_Query = "SELECT * FROM goods_option_single_value WHERE goods_code='$ou_goods_code'";
    $goods_option_single_value_Result = mysql_query($goods_option_single_value_Query) or die($goods_option_single_value_Query);
    $i = 0;
    while ($goods_option_single_value_Rows = mysql_fetch_array($goods_option_single_value_Result)) {
        if ($i == 0) {
            $goods_option_single_value_opName1 = $goods_option_single_value_Rows["opName1"];
            $goods_option_value_commonPrice = $goods_option_single_value_Rows["commonPrice"];
            $goods_option_value_sellPrice = $goods_option_single_value_Rows["sellPrice"];
            $goods_option_value_quantity = $goods_option_single_value_Rows["quantity"];
            $i++;
        } else {
            if ($goods_option_single_value_opName1 == $goods_option_single_value_Rows["opName1"]) {
                $goods_option_single_value_opName1 = $goods_option_single_value_Rows["opName1"];
                $goods_option_value_commonPrice .= ";" . $goods_option_single_value_Rows["commonPrice"];
                $goods_option_value_sellPrice .= ";" . $goods_option_single_value_Rows["sellPrice"];
                $goods_option_value_quantity .= ";" . $goods_option_single_value_Rows["quantity"];
            } else {
                $goods_option_single_value_opName1 = $goods_option_single_value_Rows["opName1"];
                $goods_option_value_commonPrice .= "/" . $goods_option_single_value_Rows["commonPrice"];
                $goods_option_value_sellPrice .= "/" . $goods_option_single_value_Rows["sellPrice"];
                $goods_option_value_quantity .= "/" . $goods_option_single_value_Rows["quantity"];
            }
        }
    }
} else if ($ou_goods_opt_type == "2") {
    $show = "show";
    $readonly = "readonly";
    $goods_option_grid_name_Query = "SELECT * FROM goods_option_grid_name WHERE goods_code = '$ou_goods_code'";
    $goods_option_grid_name_Result = mysql_query($goods_option_grid_name_Query) or die($goods_option_grid_name_Query);
    $i = 0;
    while ($goods_option_grid_name_Rows = mysql_fetch_array($goods_option_grid_name_Result)) {
        if ($i == 0) {
            $goods_option_name_opName1 = $goods_option_grid_name_Rows["opName1"];
            $opName1Tmp = $goods_option_name_opName1;
            $goods_option_name_opName2 = $goods_option_grid_name_Rows["opName2"];
            $goods_option_grid_name_opType = $goods_option_grid_name_Rows["opType"];
            $i++;
        } else {
            if ($opName1Tmp != $goods_option_grid_name_Rows["opName1"]) {
                $opName1Tmp = $goods_option_grid_name_Rows["opName1"];
                $goods_option_name_opName1 .= "/" . $goods_option_grid_name_Rows["opName1"];
                $goods_option_name_opName2 .= "/" . $goods_option_grid_name_Rows["opName2"];
            } else {
                $goods_option_name_opName2 .= ";" . $goods_option_grid_name_Rows["opName2"];
            }
        }
    }
    $goods_option_grid_value_Query = "SELECT * FROM goods_option_grid_value WHERE goods_code='$ou_goods_code'";
    $goods_option_grid_value_Result = mysql_query($goods_option_grid_value_Query) or die($goods_option_grid_value_Query);
    $i = 0;
    while ($goods_option_grid_value_Rows = mysql_fetch_array($goods_option_grid_value_Result)) {
        if ($i == 0) {
            $goods_option_value_commonPrice = $goods_option_grid_value_Rows["opValue1"];
            $goods_option_value_sellPrice = $goods_option_grid_value_Rows["opValue2"];
            $goods_option_value_quantity = $goods_option_grid_value_Rows["opValue3"];
        } else {
            $goods_option_value_commonPrice .= ";" . $goods_option_grid_value_Rows["opValue1"];
            $goods_option_value_sellPrice .= ";" . $goods_option_grid_value_Rows["opValue2"];
            $goods_option_value_quantity .= ";" . $goods_option_grid_value_Rows["opValue3"];
        }
        $i++;
    }
} else {
    $show = "";
    $readonly = "";
}

$goods_option_Query = "SELECT opName1,opName2,opValue1,opValue2,quantity  FROM goods_option WHERE goods_code = '$ou_goods_code'";
$goods_option_Result = mysql_query($goods_option_Query) or die($goods_option_Result);
$i = 0;
while ($goods_option_Rows = mysql_fetch_array($goods_option_Result)) {

    if ($i == 0) {
        $goods_option_opName1 = $goods_option_Rows["opName1"];
        $goods_option_opName1Tmp = $goods_option_opName1;
        $goods_option_opName2 = $goods_option_Rows["opName2"];
        $goods_option_opValue1 = $goods_option_Rows["opValue1"];
        $goods_option_opValue2 = $goods_option_Rows["opValue2"];
        $goods_option_quantity = $goods_option_Rows["quantity"];
    } else {
        if ($goods_option_opName1Tmp != $goods_option_Rows["opName1"]) {
            $goods_option_opName1Tmp = $goods_option_Rows["opName1"];
            $goods_option_opName1 .= "/" . $goods_option_Rows["opName1"];
            $goods_option_opName2 .= "/" . $goods_option_Rows["opName2"];
            $goods_option_opValue1 .= "/" . $goods_option_Rows["opValue1"];
            $goods_option_opValue2 .= "/" . $goods_option_Rows["opValue2"];
            $goods_option_quantity .= "/" . $goods_option_Rows["quantity"];
        } else {
            $goods_option_opName2 .= ";" . $goods_option_Rows["opName2"];
            $goods_option_opValue1 .= ";" . $goods_option_Rows["opValue1"];
            $goods_option_opValue2 .= ";" . $goods_option_Rows["opValue2"];
            $goods_option_quantity .= ";" . $goods_option_Rows["quantity"];
        }
    }
    $i++;
}

//echo (count($goods_option)-count($goods_option[0]));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>brandRead</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css"/>
        <link rel="stylesheet" type="text/css" href="css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsSortManageBrand.css"/>
        <link rel="stylesheet" type="text/css" href="css/brandWrite.css"/>
        <link rel="stylesheet" type="text/css" href="css/mask.css"/>
        <!--
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="ckfinder/ckfinder.js"></script>
        -->
        <style type="text/css">
            #light{
                border:1px solid #ccc;
                background-color: #ddd;
                z-index: 10000;
            }
            #light img{
                padding:5px;
            }
        </style>
    </head>
    <body>
        <div id="total">
            <? include("include/include.header.php"); ?>
            <div id="main" style="width:100%;">
                <div id="loading-mask" style="background-color: #191919;"></div>
                <div id="loading" style="top:65%;">
                    <img src="img/extanim32.gif" width="32" height="32"
                         style="margin-right:8px;float:left;vertical-align:top;"/>
                </div>
                <h4 id="mainTitle">상품 정보 읽기</h4>
                <form name="brandForm" id="brandForm" method="post" target="action_frame"
                      action="brandChangePost.php?xcode=<?= $xcode ?>&mcode=<?= $mcode ?>&scode=<?= $scode ?>&key=<?= $key ?>&keyfield=<?= $keyfield ?>"
                      enctype="multipart/form-data">
                    <?
                    // 아이티 input 출력
                    //echo $spou_id;
                    //echo $ou_opNameid;
                    //echo $ou_opValueid;
                    ?>
                    <input type="hidden" name="xcode" value="<?= $xcode ?>"/>
                    <input type="hidden" name="mcode" value="<?= $mcode ?>"/>
                    <input type="hidden" name="scode" value="<?= $scode ?>"/>
                    <input type="hidden" name="mode"/>
                    <input type="hidden" name="optNum" value="<?= $ou_goods_opt_Num ?>"/>
                    <dl id="readContent" class="readContent">
                        <dt style="background-color:#3a5795;color:white;">분류</dt>
                        <dd class="textDd"
                            style="background-color: #3a5795;padding-left:9px;height:17px;color:white;"><?= $sortText ?></dd>
                        <dt>옵션타입
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <label>
                                <input type="radio" class="op_type0" value="0"
                                       name="option_type" <? if ($ou_goods_opt_type == "0") echo "checked"; else echo "disabled" ?> >
                                옵션없음
                            </label>
                            <label>
                                <input type="radio" class="op_type1" value="1"
                                       name="option_type" <? if ($ou_goods_opt_type == "1") echo "checked"; else echo "disabled" ?>>
                                일반옵션
                            </label>
                            <label>
                                <input type="radio" class="op_type2" value="2"
                                       name="option_type" <? if ($ou_goods_opt_type == "2") echo "checked"; else echo "disabled" ?>>
                                가격선택옵션
                            </label>
                        </dd>
                        <dt>상품명
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="goods_name" value="<?= @$ou_goods_name ?>" id="goods_name"
                                   class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt class="option_name <?= @$show ?>">옵션명1
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd option_name <?= @$show ?>">
                            <input type="text" name="opName1" value="<?= @$goods_option_name_opName1 ?>" id="opName1"
                                   class="inputItem goods_option_inp" style="width:100%;" <?= @$readonly ?> />
                        </dd>
                        <dt class="option_name <?= @$show ?>">옵션명2
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd option_name <?= @$show ?>">
                            <input type="text" name="opName2" value="<?= @$goods_option_name_opName2 ?>" id="opName2"
                                   class="inputItem goods_option_inp" style="width:100%;" <?= @$readonly ?> />
                        </dd>
                        <dt>시장가/정찰가
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="commonPrice" value="<?= @$goods_option_value_commonPrice ?>"
                                   id="commonPrice" class="inputItem goods_option_inp"
                                   style="width:100%;" <?= @$readonly ?> />
                        </dd>
                        <dt>판매가격
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="sellPrice" value="<?= @$goods_option_value_sellPrice ?>"
                                   id="sellPrice" class="inputItem goods_option_inp"
                                   style="width:100%;" <?= @$readonly ?> />
                        </dd>
                        <dt>재고
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="qta" value="<?= @$goods_option_value_quantity ?>" id="qta"
                                   class="inputItem goods_option_inp" style="width:91%;" <?= @$readonly ?> />
                            <input type="Button" class="memEleB DateBoxa <?= @$show ?>" data="option1" value="상품 입력"/>
                            <div id="qtBoxa"></div>
                        </dd>
                        <dt>배송정책</dt>
                        <dd class="inputDd">
                            <label>
                                <INPUT type="radio" value="0" class="dlv_special"
                                       name="goods_dlv_special" <? if ($ou_goods_dlv_special == "0") {
                                    echo 'checked';
                                } ?>>
                                일반배송
                            </label>
                            <label>
                                <INPUT type="radio" value="1" class="dlv_special"
                                       name="goods_dlv_special" <? if ($ou_goods_dlv_special == "1") {
                                    echo 'checked';
                                } ?>>
                                별도배송
                            </label>
                        </dd>
                        <dt>배송비정책</dt>
                        <dd class="inputDd dlv_dd" style="height: 70px;">
                            <div style="width:100%;float:left;">
                                <ul class="goods_dlv_special0">
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="1"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "0" && $ou_goods_dlv_type == "1") {
                                                echo 'checked';
                                            } ?>>
                                            판매자 기본 배송정책 적용
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="2"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "0" && $ou_goods_dlv_type == "2") {
                                                echo 'checked';
                                            } ?>>
                                            무료
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="3"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "0" && $ou_goods_dlv_type == "3") {
                                                echo 'checked';
                                            } ?>>
                                            고정금액(선불)
                                        </label>
                                    </li>
                                </ul>
                                <ul class="goods_dlv_special1">
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="1"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "1" && $ou_goods_dlv_type == "1") {
                                                echo 'checked';
                                            } ?>>
                                            무료
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="2"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "1" && $ou_goods_dlv_type == "2") {
                                                echo 'checked';
                                            } ?>>
                                            고정금액(선불)
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="3"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "1" && $ou_goods_dlv_type == "3") {
                                                echo 'checked';
                                            } ?>>
                                            착불
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="4"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "1" && $ou_goods_dlv_type == "4") {
                                                echo 'checked';
                                            } ?>>
                                            주문금액별 차등
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="5"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "1" && $ou_goods_dlv_type == "5") {
                                                echo 'checked';
                                            } ?>>
                                            무게별 차등
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="6"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "1" && $ou_goods_dlv_type == "6") {
                                                echo 'checked';
                                            } ?>>
                                            부피별 차등
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="7"
                                                   name="goods_dlv_type" <? if ($ou_goods_dlv_special == "1" && $ou_goods_dlv_type == "7") {
                                                echo 'checked';
                                            } ?>>
                                            수량비례
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </dd>
                        <dt>배송비</dt>
                        <dd class="inputDd">
                            <label>
                                <span class="dlv_txt">판매자 기본 배송정책 적용: 고정금액(선불) / 배송료 : 2500원 / 지역할증 : 있음</span>
                                <input type="text" name="goods_dlv_fee" class="inputItem dlv_fee">
                                <span class="dlv_won">원</span>
                            </label>
                        </dd>
                        <dt>세일</dt>
                        <dd class="inputDd">
                            <input type="text" name="sb_sale" value="<?= $ou_sb_sale ?>" id="sb_sale" class="inputItem"
                                   style="width:100%;"/>
                        </dd>
                        <dt>간략설명</dt>
                        <dd class="inputDd">
                            <input type="text" name="summary" value="<?= $ou_summary ?>" id="summary" class="inputItem"
                                   style="width:100%;"/>
                        </dd>
                        <dt>제조사</dt>
                        <dd class="inputDd">
                            <input type="text" name="manufacture" value="<?= $ou_manufacture ?>" class="inputItem"
                                   style="width:100%;"/>
                        </dd>
                        <dt>원산지</dt>
                        <dd class="inputDd">
                            <input type="text" name="orgin" value="<?= $ou_orgin ?>" id="orgin" class="inputItem"
                                   style="width:100%;"/>
                        </dd>
                        <dt>상품코드</dt>
                        <dd class="inputDd">
                            <input type="text" name="goods_code" id="goods_code" class="inputItem wd100" readonly
                                   value="<?= $ou_goods_code ?>"/>
                        </dd>
                    </dl>
                    <dl class="readContent">
                        <dt style="background-color:#3a5795;color:white;">특수코드</dt>
                        <dd class="inputDd"
                            style="background-color: #3a5795;padding-left:9px;height:17px;color:white;"></dd>
                        <?
                        $i = 0;
                        $query = "SELECT name,img FROM sp";
                        $result = mysql_query($query) or die($query);
                        while ($rows = mysql_fetch_assoc($result)) {
                            ?>
                            <dt>특수코드</dt>
                            <dd class="inputDd">
                                <?
                                if (@$ou_sp_optionArr[$i] == $rows["name"]) {
                                    $i++;
                                    echo '<input type="checkbox" name="sp[]" checked="checked" value="' . $rows['name'] . '" />';
                                } else {
                                    echo '<input type="checkbox" name="sp[]" value="' . $rows['name'] . '" />';
                                }
                                ?>
                                <img style="float:left;margin-right:10px;"
                                     src="<? echo $brandImagesWebDir . $rows['img']; ?>"/>
                            </dd>
                            <?
                        }
                        ?>
                    </dl>
                    <dl class="readContent dlbimg">
                        <dt style="background-color:#3a5795;color:white;">이미지</dt>
                        <dd class="inputDd"
                            style="background-color: #3a5795;padding-left:9px;height:17px;color:white;"></dd>
                        <dt>대이미지
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addbigImage" data="dlbimg"/>
                            </a>
                        </dd>
                        <?
                        $bimgQuery = "SELECT id,ImageName FROM upload_bimages WHERE goods_code='$goods_code' order by id asc";
                        $bimgResult = mysql_query($bimgQuery) or die("error_simgQuery");
                        $i = 1;
                        while ($bimgRow = mysql_fetch_array($bimgResult)) {
                            $bImage = $bimgRow["ImageName"];
                            $arrImg = @getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$bImage);
                            $img_width = $arrImg[0];
                            $img_height = $arrImg[1];
                            $img_src = $brandImagesWebDir . $bImage;
                            $img_id = $bimgRow["id"];
                            ?>
                            <dt></dt>
                            <dd class="inputDd">
                                <?
                                /*
                                if($i==1)
                                                echo '<a href="#" style="float:left;padding-top:2px;padding-right:3px;">'.
                                                                 '<img src="images/i_add.gif" class="addbigImage" data="dlbimg" /></a>';
                                */
                                if ($i >= 1) {
                                    echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="' . $bImage . '" />';
                                } else {
                                    echo '<span><input type="file" name="bigImage[]" id="bigImage" class="inputItem fileHeight" /></span>';
                                }
                                ?>
                                <input type="button" value="취소" class="fileClear memEleB"/>
                                <input type="hidden" name="bimg_id[]" value="<?= $img_id ?>"/>
                                <input type="button" value="이미지보기" imgwid="<?= $img_width ?>"
                                       imghei="<?= $img_height ?>" imgsrc="<?= $img_src ?>" class="memEleB"
                                       onmouseover="addEvent(this,'click',showBrandImage)"/>
                            </dd>
                            <?
                            $i++;
                        }
                        if ($i == 1) {
                            echo '<dt></dt>' .
                                '<dd class="inputDd">' .
                                '<a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addbigImage" data="dlbimg" /></a>' .
                                '<input type="file" name="bigImage[]" id="bigImage" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" /></dd>';
                        }
                        ?>
                    </dl>
                    <dl class="readContent dlmimg">
                        <dt>중이미지
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addmdImage" data="dlmimg"/>
                            </a>
                        </dd>
                        <?
                        $mimgQuery = "SELECT id,ImageName FROM upload_mimages WHERE goods_code='$goods_code' order by id asc";
                        $mimgResult = mysql_query($mimgQuery) or die("error_simgQuery");
                        $i = 1;
                        while ($mimgRow = mysql_fetch_array($mimgResult)) {
                            ?>
                            <dt>
                                <span class="fontCol"></span>
                            </dt>
                            <dd class="inputDd">
                                <?
                                $mImage = $mimgRow["ImageName"];
                                $arrImg = @getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$mImage);
                                $img_width = $arrImg[0];
                                $img_height = $arrImg[1];
                                $img_src = $brandImagesWebDir . $mImage;
                                $img_id = $mimgRow["id"];
                                /*
                                if($i==1)
                                                echo '<a href="#" style="float:left;padding-top:2px;padding-right:3px;">'.
                                                                 '<img src="images/i_add.gif" class="addmdImage" data="dlmimg" /></a>';
                                 */
                                if ($i >= 1) {
                                    echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="' . $mImage . '" />';
                                } else {
                                    echo '<span><input type="file" name="mdImage[]" id="mdImage" class="inputItem fileHeight" /></span>';
                                }
                                ?>
                                <input type="button" value="취소" class="fileClear memEleB"/>
                                <input type="hidden" name="mimg_id[]" value="<?= $img_id ?>"/>
                                <input type="button" value="이미지보기" imgwid="<?= $img_width ?>"
                                       imghei="<?= $img_height ?>" imgsrc="<?= $img_src ?>" class="memEleB"
                                       onmouseover="addEvent(this,'click',showBrandImage)"/>
                            </dd>
                            <?
                            $i++;
                        }
                        if ($i == 1) {
                            echo '<dt><span class="fontCol"></span></dt>' .
                                '<dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addmdImage" data="dlmimg" /></a>' .
                                '<span><input type="file" name="mdImage[]" id="mdImage" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" /></dd>';
                        }
                        ?>
                    </dl>
                    <dl class="readContent dlsimg">
                        <dt>소이미지
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addsmImage" data="dlsimg"/>
                            </a>
                        </dd>
                        <?
                        $simgQuery = "SELECT id,ImageName FROM upload_simages WHERE goods_code='$goods_code' order by id asc";
                        $simgResult = mysql_query($simgQuery) or die("error_simgQuery");
                        $i = 1;
                        while ($simgRow = mysql_fetch_array($simgResult)) {
                        ?>
                        <dt></dt>
                        <dd class="inputDd">
                            <?
                            $sImage = $simgRow["ImageName"];
                            $arrImg = @getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$sImage);
                            $img_width = $arrImg[0];
                            $img_height = $arrImg[1];
                            $img_src = $brandImagesWebDir . $sImage;
                            $img_id = $simgRow["id"];
                            /*
                            if($i==1)
                                            echo '<a href="#" style="float:left;padding-top:2px;padding-right:3px;">'.
                                                             '<img src="images/i_add.gif" class="addsmImage" data="dlsimg" /></a>';
                             */
                            if ($i >= 1) {
                                echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="' . $sImage . '" />';
                            } else {
                                echo '<span><input type="file" name="smImage[]" id="smImage" class="inputItem fileHeight" /></span>';
                            }
                            ?>
                            <input type="button" value="취소" class="fileClear memEleB"/>
                            <input type="hidden" name="simg_id[]" value="<?= $img_id ?>"/>
                            <input type="button" value="이미지보기" imgwid="<?= $img_width ?>" imghei="<?= $img_height ?>"
                                   imgsrc="<?= $img_src ?>" class="memEleB"
                                   onmouseover="addEvent(this,'click',showBrandImage)"/>
                            <?
                            $i++;
                            }
                            if ($i == 1) {
                                echo '<dt><span class="fontCol"></span></dt>' .
                                    '<dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addsmImage" data="dlsimg" /></a>' .
                                    '<span><input type="file" name="smImage[]" id="smImage" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" /></dd>';
                            }
                            ?>
                        </dd>
                    </dl>
                    <dl class="readContent dltimg">
                        <dt>썸네일 이미지</dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addthumImage" data="dltimg"/>
                            </a>
                        </dd>
                        <?
                        $timgQuery = "SELECT id,ImageName FROM upload_timages WHERE goods_code='$goods_code' order by id asc";
                        $timgResult = mysql_query($timgQuery) or die("error_simgQuery");
                        $i = 1;
                        while ($timgRow = mysql_fetch_array($timgResult)) {
                            ?>
                            <dt></dt>
                            <dd class="inputDd">
                                <?
                                $tImage = $timgRow["ImageName"];
                                $arrImg = @getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$tImage);
                                $img_width = $arrImg[0];
                                $img_height = $arrImg[1];
                                $img_src = $brandImagesWebDir . $tImage;
                                $img_id = $timgRow["id"];

                                if ($i >= 1) {
                                    echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="' . $tImage . '" />';
                                } else {
                                    echo '<span><input type="file" name="thumImage[]" id="tImage" class="inputItem fileHeight" /></span>';
                                }
                                ?>
                                <input type="button" value="취소" class="fileClear memEleB"/>
                                <input type="button" value="이미지보기" imgwid="<?= $img_width ?>"
                                       imghei="<?= $img_height ?>" imgsrc="<?= $img_src ?>" class="memEleB"
                                       onmouseover="addEvent(this,'click',showBrandImage)"/>
                                <input type="hidden" name="timg_id[]" value="<?= $img_id ?>"/>
                            </dd>
                            <?
                            $i++;
                        }
                        if ($i == 1) {
                            echo '<dt></dt>' .
                                '<dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addthumImage" data="dltimg" /></a>' .
                                '<span><input type="file" name="thumImage[]" id="tImage" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" /></dd>';
                        }
                        ?>
                    </dl>
                    <dl class="readContent">
                        <dt style="background-color:#3a5795;color:white;">추가옵션</dt>
                        <dd class="inputDd" style="background-color: #3a5795;padding-left:9px;height:17px;"></dd>
                        <dt>옵션명1
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="opName3" value="<?= $goods_option_opName1 ?>" id="opName3" readonly
                                   class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>옵션명2
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="opName4" value="<?= $goods_option_opName2 ?>" id="opName4" readonly
                                   class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>옵션값1
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="opValue1" value="<?= $goods_option_opValue1 ?>" id="opValue1"
                                   readonly class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>옵션값2
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="opValue2" value="<?= $goods_option_opValue2 ?>" id="opValue2"
                                   readonly class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>재고
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="qt" value="<?= $goods_option_quantity ?>" id="qt" class="inputItem"
                                   readonly style="width:91%;"/>
                            <input type="Button" class="memEleB DateBox" data="option2" style="display: inline;"
                                   value="상품 입력"/>
                            <div id="qtBox"></div>
                        </dd>
                        <dt>상세정보</dt>
                        <dd class="contentDd"></dd>
                    </dl>
                    <div style="width:100%;float:left;">
                        <!--
                                <textarea name="comment" id="editor" rows="10" cols="80"><?= $ou_comment ?></textarea>
                                <script type="text/javascript">
                                        if (typeof CKEDITOR == 'undefined') {
                                                document.write('Load CKEditor error!!');
                                        } else {
                                                var editorContent = CKEDITOR.replace('editor');
                                                editorContent.config.width = '100%';
                                                editorContent.config.height = 500;
                                                CKFinder.setupCKEditor(editorContent, 'ckfinder/');
                                        }
                                </script>
                                -->
                        <!-- 加载编辑器的容器 -->
                        <script id="container" name="comment" type="text/plain"><?= $ou_comment ?></script>
                        <!-- 配置文件 -->
                        <script type="text/javascript" src="ueditor/ueditor.config.js"></script>
                        <!-- 编辑器源码文件 -->
                        <script type="text/javascript" src="ueditor/ueditor.all.js"></script>
                        <!-- 实例化编辑器 -->
                        <script type="text/javascript">
                            var ue = UE.getEditor('container');
                        </script>
                    </div>
                    <div class="buttonBox">
                        <input type="button" value=" 수정 " class="memEleB" onclick="subButton('수정')"/>
                        <input type="button" value=" 삭제 " class="memEleB" onclick="subButton('삭제')"/>
                        <input type="button" value=" 목록 " class="memEleB"
                               onclick="location.href='brandList.php?key=<?= $key ?>&xcode=<?= $xcode ?>&mcode=<?= $mcode ?>&scode=<?= $scode ?>&keyfield=<?= $keyfield ?>'"/>
                    </div>
                </form>
                <iframe name="action_frame" width="99%" height="200" style="display:none;"></iframe>
            </div>
        </div>
        <div id="light" class="white_content" onclick="closeBox()">asdadsa</div>
        <div id="fade" class="black_overlay"></div>
        <script type="text/javascript" src="assets/plugins/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="common/jslb_ajax.js"></script>
        <script type="text/javascript" src="common/brandWrite.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                jQuery.fn.center = function () {
                    this.css("position", "absolute");
                    this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
                    this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
                    return this;
                }
                $(".fileClear").click(function () {
                    var file = $(this).prev();
                    file.after(file.clone().val(""));
                    file.remove();
                });
                // Add new input with associated 'remove' link when 'add' button is clicked.
                $('.addthumImage').click(function (e) {
                    e.preventDefault();
                    var cls = $(this).attr("data");
                    $("." + cls).append(
                        '<dt style="background-color:white;"></dt>'
                        + '<dd class="inputDd">'
                        + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                        + '<input type="file" name="thumImage[]" class="inputItem fileHeight" />'
                        + '</dd>');
                });
                // Remove parent of 'remove' link when link is clicked.
                $('.dltimg').on('click', '.remove_project_file', function (e) {
                    var bimgName = $(this).attr("data_id");
                    $.ajax({
                        url: 'img_del.php',
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            imgname: bimgName,
                            imgtype: "timg"
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                alert("이미지를 삭제 하였습니다.");
                            }
                        }
                    });
                    e.preventDefault();
                    $(this).parent().prev().remove();
                    $(this).parent().remove();
                });


                $('.addsmImage').click(function (e) {
                    e.preventDefault();
                    var cls = $(this).attr("data");
                    $("." + cls).append(
                        '<dt style="background-color:white;"></dt>'
                        + '<dd class="inputDd">'
                        + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                        + '<input type="file" name="smImage[]" class="inputItem fileHeight" />'
                        + '</dd>');
                });
                $('.dlsimg').on('click', '.remove_project_file', function (e) {
                    var bimgName = $(this).attr("data_id");
                    $.ajax({
                        url: 'img_del.php',
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            imgname: bimgName,
                            imgtype: "simg"
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                alert("이미지를 삭제 하였습니다.");
                            }
                        }
                    });
                    e.preventDefault();
                    $(this).parent().prev().remove();
                    $(this).parent().remove();
                });


                $('.addmdImage').click(function (e) {
                    e.preventDefault();
                    var cls = $(this).attr("data");
                    $("." + cls).append(
                        '<dt style="background-color:white;"></dt>'
                        + '<dd class="inputDd">'
                        + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                        + '<input type="file" name="mdImage[]" class="inputItem fileHeight" />'
                        + '</dd>');
                });
                $('.dlmimg').on('click', '.remove_project_file', function (e) {
                    var bimgName = $(this).attr("data_id");
                    $.ajax({
                        url: 'img_del.php',
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            imgname: bimgName,
                            imgtype: "mimg"
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                alert("이미지를 삭제 하였습니다.");
                            }
                        }
                    });
                    e.preventDefault();
                    $(this).parent().prev().remove();
                    $(this).parent().remove();
                });
                $('.addbigImage').click(function (e) {
                    e.preventDefault();
                    var cls = $(this).attr("data");
                    $("." + cls).append(
                        '<dt style="background-color:white;"></dt>'
                        + '<dd class="inputDd">'
                        + '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
                        + '<input type="file" name="bigImage[]" class="inputItem fileHeight" />'
                        + '</dd>');
                });
                $('.dlbimg').on('click', '.remove_project_file', function (e) {
                    var bimgName = $(this).attr("data_id");
                    $.ajax({
                        url: 'img_del.php',
                        type: 'POST',
                        dataType: "JSON",
                        data: {
                            imgname: bimgName,
                            imgtype: "bimg"
                        },
                        success: function (response) {
                            if (response.status == "success") {
                                alert("이미지를 삭제 하였습니다.");
                            }
                        }
                    });
                    e.preventDefault();
                    $(this).parent().prev().remove();
                    $(this).parent().remove();
                });
                //option_type 일반옵션 가격선택옵션.
                var strVal =<?=$ou_goods_opt_type?>;
                var c = 0;
                var cc = 0;
                var people;

                $("input[name=option_type]").click(function () {
                    strVal = $(this).val();
                    $("#qtBoxa").empty();
                    if (strVal == "1" || strVal == "2") {
                        $(".DateBoxa").css("display", "inline");
                        $(".option_name").css("display", "inline");
                        $(".goods_option_inp").each(function () {
                            $(this).attr("readonly", true);
                            $(this).css("background-color", "#eee");
                        });
                    } else {
                        $(".DateBoxa").css("display", "none");
                        $(".option_name").css("display", "none");
                        $(".goods_option_inp").each(function () {
                            $(this).attr("readonly", false);
                            $(this).css("background-color", "#fff");
                        });
                        $("#opName1").val("");
                        $("#opName2").val("");
                        $("#commonPrice").val("");
                        $("#sellPrice").val("");
                        $("#qta").val("");
                    }
                });

                $(".DateBoxa").click(function () {
                    qtbox("a");
                    var Fnum = $(".optNum").val();
                    goods_opt_grid(Fnum);
                });
                $(".DateBox").click(function () {
                    qtbox("b");
                });
                function qtbox(mod) {
                    var moda = false;
                    if (mod == "a") {
                        var str = "a";
                        var opName1 = $("#opName1").val();
                        var opName2 = $("#opName2").val();
                        var commonPrice = $("#commonPrice").val();
                        var sellPrice = $("#sellPrice").val();
                        var qta = $("#qta").val();
                    } else if (mod == "b") {
                        var str = "";
                        var opName1 = $("#opName3").val();
                        var opName2 = $("#opName4").val();
                        var commonPrice = $("#opValue1").val();
                        var sellPrice = $("#opValue2").val();
                        var qta = $("#qt").val();
                    }

                    if (opName1 == "") {
                        if (mod == "a") {
                            cc = 0;
                        } else {
                            c = 0;
                        }
                        create_box(str);
                    } else {
                        //데이터 읽어들이기
                        create_box(str);
                        var opName1Arr = new Array();
                        var opName2Arr = new Array();
                        var commonPriceArr = new Array();
                        var sellPriceArr = new Array();
                        var qtaArr = new Array();

                        var opName2Arr2 = new Array();
                        var commonPriceArr2 = new Array();
                        var sellPriceArr2 = new Array();
                        var qtaArr2 = new Array();

                        opName1Arr = opName1.split("/");
                        opName2Arr = opName2.split("/");
                        commonPriceArr = commonPrice.split("/");
                        sellPriceArr = sellPrice.split("/");
                        qtaArr = qta.split("/");
                        var itemLen = opName1Arr.length;
                        var ins_htm = "";
                        cc = 0;
                        c = 0;
                        if (mod == "a") {
                            var num = cc;
                        } else {
                            var num = c;
                        }
                        if (mod == "a" && strVal == "2") {

                        } else {
                            for (var i = 0; i < itemLen; i++) {
                                opName2Arr2 = opName2Arr[i].split(";");
                                commonPriceArr2 = commonPriceArr[i].split(";");
                                sellPriceArr2 = sellPriceArr[i].split(";");
                                qtaArr2 = qtaArr[i].split(";");
                                var itemLen2 = qtaArr2.length;

                                for (var j = 0; j < itemLen2; j++) {
                                    if (j == 0) {
                                        ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                            '<td>' + (i + 1) + '</td>' +
                                            '<td><input class="border opName1' + str + i + '" style="width:99%;background-color:#3a5795;color:white;" value="' + opName1Arr[i] + '"></td>' +
                                            '<td><input class="border opName2' + str + i + '" style="width:99%;background-color:#3a5795;color:white;" value="' + opName2Arr2[j] + '"></td>' +
                                            '<td><input class="border opValue1' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + commonPriceArr2[j] + '"></td>' +
                                            '<td><input class="border opValue2' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + sellPriceArr2[j] + '"></td>' +
                                            '<td><input class="border opN' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + qtaArr2[j] + '"></td>' +
                                            '<td><span class="del_single_op" data="all"> 삭제 </span></td>' +
                                            '</tr>';
                                    } else {
                                        ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                            '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                            '<td><input class="border opName2' + str + i + '" style="width:99%;background-color:#3a5795;color:white;" value="' + opName2Arr2[j] + '"></td>' +
                                            '<td><input class="border opValue1' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + commonPriceArr2[j] + '"></td>' +
                                            '<td><input class="border opValue2' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + sellPriceArr2[j] + '"></td>' +
                                            '<td><input class="border opN' + str + i + '" style="width:97%;background-color:#3a5795;color:white;" value="' + qtaArr2[j] + '"></td>' +
                                            '<td><span class="del_single_op" data="one"> 삭제 </span></td>' +
                                            '</tr>';
                                    }
                                }

                                ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                    '<td colspan="7"><span class="option add_option' + str + num + '" data="op_box' + str + num + '"> + 옵션추가</span></td></tr>';
                                $("#DateBox" + str + "_add thead").append(ins_htm).find("span.add_option" + str + num).bind("click", function () {
                                    var strData = $(this).attr("data");
                                    var num = strData.split("op_box" + str);
                                    var ins_htm = '<tr style="background-color:#3a5795">' +
                                        '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                        '<td><input class="border opName2' + str + num[1] + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                        '<td><input class="border opValue1' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                        '<td><input class="border opValue2' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                        '<td><input class="border opN' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                        '<td><span class="del_single_op"> 삭제 </span></td>' +
                                        '</tr>';
                                    $(this).parent().parent().before(ins_htm);
                                    $(".del_single_op").click(function () {
                                        $(this).parent().parent().remove();
                                    });
                                });
                                $(".del_single_op").click(function () {
                                    if (moda == false) {
                                        var mod = $(this).attr("data");
                                        if (mod == "all") {
                                            var del_box = $(this).parent().parent().attr("class");
                                            $("." + del_box).remove();
                                        } else {
                                            $(this).parent().parent().remove();
                                        }
                                        if (mod == "a") {
                                            $(".transQna").trigger("click");
                                            $(".DateBoxa").trigger("click");
                                        } else {
                                            $(".transQn").trigger("click");
                                            $(".DateBox").trigger("click");
                                        }
                                        moda = true;
                                    }
                                });
                                ins_htm = "";
                                if (mod == "a") {
                                    cc++;
                                } else {
                                    c++;
                                }
                                num++;
                            }
                        }
                    }
                }

                function create_box(str) {
                    var resHtml = "";
                    //메인 top 옵션 열추가
                    //head
                    if (str == "a" && strVal == "2") {
                        resHtml += '<div style="width:100%;float:left;background-color:#3a5795"><span style="float:right;color:white;line-height: 35px;;padding:0px 10px;">옵션갯수 : <select class="optNum"><option>옵션갯수선택</option><option value="2">2</option><option value="3">3</option></select></span><span class="add_box' + str + '" style="width:170px;vertical-align: middle;padding: 7px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:right;text-align:center;display: none;;"> + 열추가</span></div>';
                        resHtml += '<div style="width:970px;">';
                        resHtml += '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;" id="DateBox' + str + '_add">';
                        resHtml += '<thead><tr style="background-color:#bfc4dd;font-weight:bold;font-size:12px;color:#333;">' +
                            '<td width="26">#</td>' +
                            '<td width="405" height="25">옵션명1</td>' +
                            '<td width="435" height="25">옵션명2</td>' +
                            '<td width="60">삭제</td>' +
                            '</tr></thead>';
                        resHtml += '</table></div>' +
                            '<div style="width:100%;float:left;background-color:#3a5795;">' +
                            '<input type="button" value="확인" style="margin-left:400px;" class="memEleB grid_box" />' +
                            ' <input type="button" value="닫기" class="memEleB closeQn' + str + '" />' +
                            '</div>';
                    } else {
                        resHtml += '<div style="width:100%;float:left;background-color:#3a5795"><span class="add_box' + str + '" style="width:170px;vertical-align: middle;padding: 7px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:right;text-align:center;"> + 열추가</span></div>';
                        resHtml += '<div style="width:970px;">';
                        resHtml += '<table width="100%" border="0" cellspacing="1" cellpadding="3" style="background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;" id="DateBox' + str + '_add">';
                        resHtml += '<thead><tr style="background-color:#bfc4dd;font-weight:bold;font-size:12px;color:#333;">' +
                            '<td width="26">#</td>' +
                            '<td width="195" height="25">옵션명1</td>' +
                            '<td width="195" height="25">옵션명2</td>' +
                            '<td width="170">시장가/정찰가</td>' +
                            '<td width="170">판매가</td>' +
                            '<td width="70">재고</td>' +
                            '<td width="80">삭제</td>' +
                            '</tr></thead>';
                        resHtml += '</table></div>' +
                            '<div style="width:100%;float:left;background-color:#3a5795;text-align: center;">' +
                            '<input type="button" value="확인" style="margin-left:400px;" class="memEleB transQn' + str + '" />' +
                            ' <input type="button" value="닫기" class="memEleB closeQn' + str + '" />' +
                            '</div>';
                    }
                    var pObj = $("#qtBox" + str);
                    pObj.html(resHtml);
                    pObj.css("display", "inline");
                    //닫기
                    $(".closeQn" + str).click(function () {
                        $("#qtBox" + str).css("display", "none");
                    });
                    //확인
                    $(".transQn" + str).click(function () {
                        var opName1 = "";
                        var opName2 = "";
                        var commonPrice = "";
                        var sellPrice = "";
                        var sellPriceTmp = "";
                        var qta = "";
                        if ($("#DateBoxa_add tr").length == 1) {
                            $("#opName1").val("");
                            $("#opName2").val("");
                            $("#commonPrice").val("");
                            $("#sellPrice").val("");
                            $("#qta").val("");
                        }
                        if (str == "a") {
                            var num = cc;
                        } else {
                            var num = c;
                        }
                        var mod = false;
                        for (var i = 0; i < num; i++) {
                            var opName1Tmp = "";
                            var opName2Tmp = "";
                            var commonPriceTmp = "";
                            var qtaTmp = "";
                            var k = 0;
                            $("#DateBox" + str + "_add").find(".opName1" + str + i).each(function () {
                                if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                        opName1Tmp = $(this).val();
                                    } else {
                                        opName1Tmp += ";" + $(this).val();
                                    }
                                    k++;
                                } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                                }
                            });
                            k = 0;
                            $("#DateBox" + str + "_add").find(".opName2" + str + i).each(function () {
                                if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                        opName2Tmp = $(this).val();
                                    } else {
                                        opName2Tmp += ";" + $(this).val();
                                    }
                                    k++;
                                } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                                }
                            });
                            k = 0;
                            $("#DateBox" + str + "_add").find(".opValue1" + str + i).each(function () {
                                if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                        commonPriceTmp = $(this).val();
                                    } else {
                                        commonPriceTmp += ";" + $(this).val();
                                    }
                                    k++;
                                } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                                }
                            });
                            k = 0;
                            $("#DateBox" + str + "_add").find(".opValue2" + str + i).each(function () {
                                if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                        sellPriceTmp = $(this).val();
                                    } else {
                                        sellPriceTmp += ";" + $(this).val();
                                    }
                                    k++;
                                } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                                }
                            });

                            k = 0;
                            $("#DateBox" + str + "_add").find(".opN" + str + i).each(function () {
                                if ($(this).val().trim() != "") {
                                    if (k == 0) {
                                        qtaTmp = $(this).val();
                                    } else {
                                        qtaTmp += ";" + $(this).val();
                                    }
                                    k++;
                                } else {
                                    mod = true;
                                    $(this).focus();
                                    return false;
                                }
                            });
                            if (mod == true) {
                                alert("빈상품란을 입력해주세요.");
                                break;
                            }
                            if (opName1Tmp.trim() != "") {
                                if (opName1 == "") {
                                    opName1 = opName1Tmp;//옵션명1
                                    opName2 = opName2Tmp;
                                    commonPrice = commonPriceTmp;
                                    sellPrice = sellPriceTmp;
                                    qta = qtaTmp;
                                } else {
                                    opName1 += "/" + opName1Tmp;//옵션명1
                                    opName2 += "/" + opName2Tmp;
                                    commonPrice += "/" + commonPriceTmp;
                                    sellPrice += "/" + sellPriceTmp;
                                    qta += "/" + qtaTmp;
                                }
                            }

                        }
                        if (opName1 != "") {
                            if (str == "a") {
                                $("#opName1").val(opName1);//옵션명1
                                $("#opName2").val(opName2);//옵션명2
                                $("#commonPrice").val(commonPrice);//시정가/정찰가
                                $("#sellPrice").val(sellPrice);//판매가
                                $("#qta").val(qta);//재고
                            } else {
                                $("#opName3").val(opName1);//옵션명1
                                $("#opName4").val(opName2);//옵션명2
                                $("#opValue1").val(commonPrice);//시정가/정찰가
                                $("#opValue2").val(sellPrice);//판매가
                                $("#qt").val(qta);//재고
                            }
                        }
                        if (mod == false) {
                            $("#qtBox" + str).css("display", "none");
                        }
                    });
                    $(".optNum").change(function () {
                        var val = $(this).val();
                        $("input[name=optNum]").val(val);
                        $(".optNum").attr("disabled", "disabled");
                        for (var i = 0; i < val; i++) {
                            $(".add_box" + str).trigger("click");
                        }
                    });

                    var i = 0;
                    $(".add_box" + str).click(function () {
                        if (str == "a") {
                            var num = cc;
                        } else {
                            var num = c;
                        }

                        var ins_htm = '<tr style="background-color:#3a5795" class="op_box' + str + num + '">';
                        if (str == "a" && strVal == "2") {
                            ins_htm += '<td>' + (num + 1) + '</td>' +
                                '<td><input class="border opName1' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                '<td><input class="border opName2' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>'
                            '</tr>';
                            ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                '<td colspan="4"><span class="option add_option' + str + num + '" data="op_box' + str + num + '"> + 옵션추가</span></td></tr>';
                        } else {
                            ins_htm += '<td>' + (num + 1) + '</td>' +
                                '<td><input class="border opName1' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                '<td><input class="border opName2' + str + num + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                '<td><input class="border opValue1' + str + num + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                '<td><input class="border opValue2' + str + num + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                '<td><input class="border opN' + str + num + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                '<td><span class="del_single_op" data="op_box' + str + num + '"> 삭제 </span></td>' +
                                '</tr>';
                            ins_htm += '<tr style="background-color:#3a5795" class="op_box' + str + num + '">' +
                                '<td colspan="7"><span class="option add_option' + str + num + '" data="op_box' + str + num + '"> + 옵션추가</span></td></tr>';
                        }
                        $("#DateBox" + str + "_add thead").append(ins_htm).find("span.add_option" + str + num).bind("click", function () {
                            var strData = $(this).attr("data");
                            var num = strData.split("op_box" + str);
                            var data_num = $("." + $(this).attr("data")).length - 1;
                            var ins_htm = '<tr style="background-color:#3a5795" class="' + $(this).attr("data") + '">';
                            if (str == "a" && strVal == "2") {
                                ins_htm += '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                    '<td><input class="border opName2' + str + num[1] + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><span class="del_op" data-row="' + num[1] + '" data-num="' + data_num + '"> 삭제 </span></td>' +
                                    '</tr>';
                                $(".grid_div_box").empty();
                            } else {
                                ins_htm += '<td colspan="2" style="background-color:#4A74BC;"></td>' +
                                    '<td><input class="border opName2' + str + num[1] + '" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><input class="border opValue1' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><input class="border opValue2' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><input class="border opN' + str + num[1] + '" style="width:97%;background-color:#3a5795;color:white;"></td>' +
                                    '<td><span class="del_op"> 삭제 </span></td>' +
                                    '</tr>';
                            }
                            $(this).parent().parent().before(ins_htm);
                            $(".del_op").on("click", function () {
                                $(this).parent().parent().remove();
                            });
                        });
                        if (str == "a") {
                            cc++;
                        } else {
                            c++;
                        }
                        $(".del_single_op").click(function () {
                            var del_box = $(this).attr("data");
                            $("." + del_box).remove();
                        });
                    });

                    $(".grid_box").click(function () {
                        var mod = false;
                        var Fnum = $(".optNum").val();
                        if (Fnum == 2) {
                            if ($(".opName1a0").val().trim() == "" || $(".opName1a1").val().trim() == "") {
                                if ($(".opName1a0").val().trim() == "") {
                                    $(".opName1a0").focus();
                                } else {
                                    $(".opName1a1").focus();
                                }
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            var Len1 = $(".opName2a0").length;
                            var Len2 = $(".opName2a1").length;
                            var opName1Arr = new Array();
                            var opName2Arr = new Array();
                            var k = 0;
                            $(".opName2a0").each(function () {
                                if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                                }
                                opName1Arr[k] = $(this).val();
                                k++;
                            });
                            if (mod == true) {
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            k = 0;
                            $(".opName2a1").each(function () {
                                if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                                }
                                opName2Arr[k] = $(this).val();
                                k++;
                            });
                            if (mod == true) {
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            $(".grid_div_box").remove();
                            k = 1;
                            var tr_html = "";

                            for (var i = 0; i < Len1; i++) {
                                for (var j = 0; j < Len2; j++) {
                                    tr_html += '<tr style="background-color:#3a5795">';
                                    tr_html += '<td>' + k + '</td>';
                                    if (j == 0) {
                                        tr_html += '<td rowspan="' + Len2 + '">' + opName1Arr[i] + '</td>';
                                    }
                                    tr_html += '<td>' + opName2Arr[j] + '</td>';
                                    tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                        '<td><input class="border op_sellPrice op_sellPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                        '<td><input class="border op_qta op_qta' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>';
                                    k++;
                                    tr_html += '</tr>';
                                }

                            }
                            tr_html += '<tr style="background-color:#3a5795">' +
                                '<td colspan="3">' +
                                '<span class="op_ok"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 확인 </span>' +
                                '</td>' +
                                '<td colspan="3">' +
                                '<span class="op_cancel"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 취소 </span>' +
                                '</td>' +
                                '</tr>';
                        } else {
                            if ($(".opName1a0").val().trim() == "" || $(".opName1a1").val().trim() == "" || $(".opName1a2").val().trim() == "") {
                                if ($(".opName1a0").val() == "") {
                                    $(".opName1a0").focus();
                                } else if ($(".opName1a1").val() == "") {
                                    $(".opName1a1").focus();
                                } else {
                                    $(".opName1a2").focus();
                                }
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            var Len1 = $(".opName2a0").length;
                            var Len2 = $(".opName2a1").length;
                            var Len3 = $(".opName2a2").length;
                            var opName1Arr = new Array();
                            var opName2Arr = new Array();
                            var opName3Arr = new Array();
                            var k = 0;
                            $(".opName2a0").each(function () {
                                if ($(this).val().trim() == "") {
                                    $(this).focus();
                                    mod = true;
                                } else {
                                    opName1Arr[k] = $(this).val();
                                    k++;
                                }
                            });
                            if (mod == true) {
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            k = 0;
                            $(".opName2a1").each(function () {
                                if ($(this).val().trim() == "") {
                                    $(this).focus();
                                    mod = true;
                                    return false;
                                } else {
                                    opName2Arr[k] = $(this).val();
                                    k++;
                                }
                            });
                            if (mod == true) {
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            k = 0;
                            $(".opName2a2").each(function () {
                                if ($(this).val().trim() == "") {
                                    $(this).focus();
                                    mod = true;
                                    return false;
                                } else {
                                    opName3Arr[k] = $(this).val();
                                    k++;
                                }
                            });
                            if (mod == true) {
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            $(".grid_div_box").remove();
                            k = 1;
                            var tr_html = "";

                            for (var i = 0; i < Len1; i++) {
                                for (var j = 0; j < Len2; j++) {
                                    for (var n = 0; n < Len3; n++) {
                                        tr_html += '<tr style="background-color:#3a5795">';
                                        tr_html += '<td>' + k + '</td>';
                                        if (j == 0 && n == 0) {
                                            tr_html += '<td rowspan="' + Len2 * Len3 + '">' + opName1Arr[i] + '</td>';
                                        }
                                        if (n == 0) {
                                            tr_html += '<td rowspan="' + Len3 + '">' + opName2Arr[j] + '</td>';
                                        }
                                        tr_html += '<td>' + opName3Arr[n] + '</td>';

                                        if (people != undefined) {
                                            var TrHtml = json_each("3", opName1Arr[i], opName2Arr[j], opName3Arr[n], k);
                                            if (TrHtml == "") {
                                                tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                    '<td><input class="border op_sellPrice op_sellPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                    '<td><input class="border op_qta op_qta' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>';
                                            } else {
                                                tr_html += TrHtml;
                                            }
                                        } else {
                                            tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                '<td><input class="border op_sellPrice op_sellPrice' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>' +
                                                '<td><input class="border op_qta op_qta' + k + '" style="width:99%;background-color:#3a5795;color:white;" type="text"></td>';
                                        }
                                        k++;
                                        tr_html += '</tr>';
                                    }
                                }
                            }
                            tr_html += '<tr style="background-color:#3a5795">' +
                                '<td colspan="4">' +
                                '<span class="op_ok"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 확인 </span>' +
                                '</td>' +
                                '<td colspan="3">' +
                                '<span class="op_cancel"  style="width:100%;vertical-align: middle;padding: 3px 0px;background-color:#4A74BC;cursor: pointer;color:white;font-size:12px;float:left;"> 취소 </span>' +
                                '</td>' +
                                '</tr>';
                        }
                        var in_html = '<div style="width:100%;float:left;background-color:#3a5795;" class="grid_div_box">';
                        in_html += '<table border="0" cellspacing="1" cellpadding="3" style="width:100%;background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;">' +
                            '<tr>' +
                            '<td>시장가/정찰가</td>' +
                            '<td><input type="text" class="border commonPriceAll" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                            '<td>판매가</td>' +
                            '<td><input type="text" class="border sellPriceAll" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                            '<td>재고</td>' +
                            '<td><input type="text" class="border qtaAll" style="width:99%;background-color:#3a5795;color:white;"></td>' +
                            '<td><span class="option AllPrice_check">일괄입력 </span></td>' +
                            '</tr>' +
                            '</table>';
                        in_html += '<table border="0" cellspacing="1" cellpadding="3" style="background-color:#4A74BC;text-align:center;box-shadow: 10px 10px 5px #888;color:white;" id="DateBoxb_add">' + '' +
                            '<thead>' +
                            '<tr style="background-color:#bfc4dd;font-weight:bold;font-size:12px;color:#333;">' +
                            '<td width="26">#</td>';
                        for (var i = 0; i < Fnum; i++) {
                            var opName = $(".opName1a" + i).val();
                            in_html += '<td width="' + (390 / parseInt(Fnum)) + '" height="25">' + opName + '</td>';
                        }
                        in_html += '<td width="170">시장가/정찰가</td>' +
                            '<td width="170">판매가</td>' +
                            '<td width="170">재고</td>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                            tr_html +
                            '</tbody>' +
                            '</table>';
                        in_html += '</div>';
                        $(this).parent().after(in_html);


                        $(".AllPrice_check").click(function () {
                            $(".op_commonPrice").each(function () {
                                $(this).val($(".commonPriceAll").val());
                            });
                            $(".op_sellPrice").each(function () {
                                $(this).val($(".sellPriceAll").val());
                            });
                            $(".op_qta").each(function () {
                                $(this).val($(".qtaAll").val());
                            });
                        });

                        //op취소qtBoxa 내용 비움
                        $(".op_cancel").click(function () {
                            $("#qtBoxa").empty();
                        });
                        $(".op_ok").click(function () {
                            //가격선택옵션 갯수
                            var Fnum = $(".optNum").val();
                            var mod = false;
                            var opName1 = "";//옵션명1
                            var opName2 = "";//옵션명2
                            var opName3 = "";//옵션명3
                            var op_commonPrice = "";//시장가/정찰가
                            var op_sellPrice = "";//판매가
                            var op_qta = "";//재고

                            //옵션명1
                            for (var i = 0; i < Fnum; i++) {
                                if (i == 0) {
                                    opName1 = $(".opName1a" + i).val();
                                } else {
                                    opName1 += "/" + $(".opName1a" + i).val();
                                }
                            }
                            var k = 0;
                            $(".opName2a0").each(function () {
                                if (k == 0) {
                                    opName2 = $(this).val();
                                } else {
                                    opName2 += ";" + $(this).val();
                                }
                                k++;
                            });
                            k = 0;
                            $(".opName2a1").each(function () {
                                if (k == 0) {
                                    opName2 += "/" + $(this).val();
                                } else {
                                    opName2 += ";" + $(this).val();
                                }
                                k++;
                            });
                            if (Fnum == "3") {
                                k = 0;
                                $(".opName2a2").each(function () {
                                    if (k == 0) {
                                        opName2 += "/" + $(this).val();
                                    } else {
                                        opName2 += ";" + $(this).val();
                                    }
                                    k++;
                                });
                            }

                            k = 0;
                            $(".op_commonPrice").each(function () {
                                if (k == 0) {
                                    op_commonPrice = $(this).val();
                                } else {

                                    op_commonPrice += ";" + $(this).val();
                                }
                                if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                                }
                                k++;
                            });
                            k = 0;
                            $(".op_sellPrice").each(function () {
                                if (k == 0) {
                                    op_sellPrice = $(this).val();
                                } else {
                                    op_sellPrice += ";" + $(this).val();
                                }
                                if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                                }
                                k++;
                            });
                            k = 0;
                            $(".op_qta").each(function () {
                                if (k == 0) {
                                    op_qta = $(this).val();
                                } else {
                                    op_qta += ";" + $(this).val();
                                }
                                if ($(this).val().trim() == "") {
                                    mod = true;
                                    $(this).focus();
                                }
                                k++;
                            });
                            if (mod == true) {
                                alert("빈 내용을 전부 입력해 주세요.");
                                return false;
                            }
                            $("#opName1").val(opName1);
                            $("#opName2").val(opName2);
                            $("#commonPrice").val(op_commonPrice);
                            $("#sellPrice").val(op_sellPrice);
                            $("#qta").val(op_qta);
                            $("#qtBoxa").empty();
                        });
                    });

                    if (str == "a" && strVal == "2") {
                        var opName1 = $("#opName1").val();
                        if (opName1 != "") {
                            var opName1Arr = opName1.split("/");
                            var commonPrice = $("#commonPrice").val();
                            var sellPrice = $("#sellPrice").val();
                            var qta = $("#qta").val();
                            var commonPriceArr = commonPrice.split(";");
                            var sellPriceArr = sellPrice.split(";");
                            var qtaArr = qta.split(";");
                            cc = 0;
                            //$(".optNum").selectedIndex;
                            //alert(opName1Arr.length - 1);
                            $(".optNum").prop('selectedIndex', opName1Arr.length - 1);
                            $(".optNum").attr("disabled", "disabled");
                            for (var i = 0; i < opName1Arr.length; i++) {
                                $(".add_box" + str).trigger("click");
                                var opName2 = $("#opName2").val();
                                var opName2Arr = opName2.split("/");
                                for (var j = 0; j < opName2Arr.length; j++) {
                                    var opName2Arr2 = opName2Arr[i];
                                    var opName2Arr3 = opName2Arr2.split(";");
                                }
                                for (var n = 0; n < opName2Arr3.length - 1; n++) {
                                    $(".add_option" + str + i).trigger("click");
                                }
                                $(".opName1a" + i).val(opName1Arr[i]);
                                var k = 0;
                                $(".opName2a" + i).each(function () {
                                    $(this).val(opName2Arr3[k]);
                                    k++;
                                });
                            }
                            $(".grid_box").trigger("click");
                            k = 0;
                            $(".op_commonPrice").each(function () {
                                $(this).val(commonPriceArr[k]);
                                k++;
                            });
                            k = 0;
                            $(".op_sellPrice").each(function () {
                                $(this).val(sellPriceArr[k]);
                                k++;
                            });
                            k = 0;
                            $(".op_qta").each(function () {
                                $(this).val(qtaArr[k]);
                                k++;
                            });
                        }
                    }
                }


                //0일반배송  1별도배송
                var chkVal;
                $(".dlv_special").click(function () {
                    $(this).each(function () {
                        if ($(this).attr("checked") == "checked") {
                            chkVal = $(this).val();
                            if (chkVal == "0") {
                                $(".goods_dlv_special0").show();
                                $(".goods_dlv_special1").hide();
                                $(".goods_dlv_special0 input[value=1]").attr("checked", true);
                                $(".dlv_txt").text("판매자 기본 배송정책 적용: 고정금액(선불) / 배송료 : 2500원 / 지역할증 : 있음");
                                $(".dlv_fee").hide();
                                $(".dlv_dd").css("height", "70px");
                            } else {
                                $(".goods_dlv_special1").show();
                                $(".goods_dlv_special0").hide();
                                $(".goods_dlv_special1 input[value=2]").attr("checked", true);
                                $(".dlv_dd").css("height", "170px");
                            }
                        }
                    });
                });
                $("input[name=goods_dlv_type]").click(function () {
                    //goods_dlv_type val
                    var dlv_type_val;
                    $(this).each(function () {
                        if ($(this).attr("checked") == "checked") {
                            dlv_type_val = $(this).val();
                        }
                        if (chkVal == undefined) {
                            chkVal = "0";
                        }
                    });
                    if (chkVal == "0") {
                        if (dlv_type_val == "1") {
                            $(".dlv_txt").text("판매자 기본 배송정책 적용: 고정금액(선불) / 배송료 : 2500원 / 지역할증 : 있음");
                            $(".dlv_fee").hide();
                        } else if (dlv_type_val == "2") {
                            $(".dlv_txt").text("배송비 무료");
                            $(".dlv_fee").hide();
                        } else if (dlv_type_val == "3") {
                            $(".dlv_txt").text("고정금액");
                            $(".dlv_fee").show();
                            $(".dlv_won").show();
                        }
                    } else {

                    }
                });

                function goods_opt_grid_del(num) {
                    //delete json.SEX;
                    if (num == 1) {

                    } else if (num == 2) {

                    } else {

                    }
                }

                function goods_opt_grid(Fnum) {
                    if (Fnum == "2") {
                        var len1 = $(".opName2a0").length;
                        var len2 = $(".opName2a1").length;
                        people = '{';
                        var n = 1;
                        for (var i = 0; i < len1; i++) {
                            people += '"_' + $(".opName2a0")[i].value + '": [';
                            people += '{ ';
                            for (var j = 0; j < len2; j++) {
                                people += '"_' + $(".opName2a1")[i].value + '": [';
                                people += '{"_시장가":"' + $(".op_commonPrice" + n).val() + '","_판매가":"' + $(".op_sellPrice" + n).val() + '","_재고":"' + $(".op_qta" + n).val() + '"}';
                                if (j == len2 - 1) {
                                    people += ']';
                                } else {
                                    people += '],';
                                }
                            }
                            people += '}';
                            if (i == len1 - 1) {
                                people += ']';
                            } else {
                                people += '],';
                            }
                        }
                        people += '}';
                        var objTEST = eval("(" + people + ")");
                    } else if (Fnum == "3") {
                        var len1 = $(".opName2a0").length;
                        var len2 = $(".opName2a1").length;
                        var len3 = $(".opName2a2").length;
                        var n = 1;
                        people = '{';
                        for (var i = 0; i < len1; i++) {
                            people += '"_' + $(".opName2a0")[i].value + '": [';
                            people += '{ ';
                            for (var j = 0; j < len2; j++) {
                                people += '"_' + $(".opName2a1")[j].value + '": [';
                                people += '{';
                                for (var k = 0; k < len3; k++) {
                                    people += '"_' + $(".opName2a2")[k].value + '": [';
                                    people += '{"opValue1":"' + $(".op_commonPrice" + n).val() + '","opValue2":"' + $(".op_sellPrice" + n).val() + '","qta":"' + $(".op_qta" + n).val() + '"}';
                                    if (k == len3 - 1) {
                                        people += ']';
                                    } else {
                                        people += '],';
                                    }
                                    n++;
                                }
                                people += '}';
                                if (j == len2 - 1) {
                                    people += ']';
                                } else {
                                    people += '],';
                                }
                            }
                            people += '}';
                            if (i == len1 - 1) {
                                people += ']';
                            } else {
                                people += '],';
                            }
                        }
                        people += '}';
                        $("#editor2").html(people);
                        //var objTEST = eval("(" + people + ")");
                        //alert(objTEST._아디다스[0]._블루[0]._255[0].qta);
                    }
                }

                function json_each(Fnum, name1, name2, name3, k7) {
                    var objjson = eval("(" + people + ")");
                    name1 = "_" + name1;
                    name2 = "_" + name2;
                    name3 = "_" + name3;
                    var tr_html = "";
                    if (Fnum == "2") {

                    } else {
                        $.each(objjson, function (k, v) {
                            var opName1 = k;
                            $.each(v, function (k1, v1) {
                                $.each(v1, function (k2, v2) {
                                    var opName2 = k2;
                                    $.each(v2, function (k3, v3) {
                                        $.each(v3, function (k4, v4) {
                                            var opName3 = k4;
                                            $.each(v4, function (k5, v5) {
                                                var i = 0;
                                                $.each(v5, function (k6, v6) {
                                                    if (opName1 == name1 && opName2 == name2 && opName3 == name3 && v6 != undefined) {
                                                        if (i == 0) {
                                                            tr_html += '<td><input class="border op_commonPrice op_commonPrice' + k7 + '" style="width:99%;background-color:#3a5795;color:white;" type="text" value="' + v6 + '"></td>';
                                                        } else if (i == 1) {
                                                            tr_html += '<td><input class="border op_sellPrice op_sellPrice' + k7 + '" style="width:99%;background-color:#3a5795;color:white;" type="text" value="' + v6 + '"></td>';
                                                        } else {
                                                            tr_html += '<td><input class="border op_qta op_qta' + k7 + '" style="width:99%;background-color:#3a5795;color:white;" type="text" value="' + v6 + '"></td>';
                                                        }
                                                    }
                                                    i++;
                                                    //alert(k6 + ' ' + v6 + '  ' + n);
                                                });
                                            });
                                        });
                                    });
                                });
                            });
                        });
                    }
                    //alert(tr_html);
                    return tr_html;
                }

                if (strVal == "1") {
                    $(".op_type1").trigger("click");
                } else if (strVal == "2") {
                    $(".op_type2").trigger("click");
                }
            });
        </script>
        <?
        mysql_close($db);
        $goods_option_grid_value_opName1 = "";
        $goods_option_grid_value_opName2 = "";
        $goods_option_grid_value_opName3 = "";
        $goods_option_grid_value_opValue1 = "";
        $goods_option_grid_value_opValue2 = "";
        $goods_option_grid_value_opValue3 = "";
        $goods_option_grid_name_opName1 = "";
        $goods_option_grid_name_opName2 = "";
        $goods_option_grid_name_opType = "";
        ?>
    </body>
</html>