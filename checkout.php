<?php
include_once("session.php");
include_once("include/check.php");
include_once("doctype.php");
/*이니시스 설정 시작*/
require_once('libs/INIStdPayUtil.php');
$SignatureUtil = new INIStdPayUtil();
/*
  //*** 위변조 방지체크를 signature 생성 ***

  oid, price, timestamp 3개의 키와 값을

  key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값

  ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004


 * key기준 알파벳 정렬

 * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그대로 사용하여야함
 */

//############################################
// 1.전문 필드 값 설정(***가맹점 개발수정***)
//############################################
// 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
$mid = "INIpayTest";  // 가맹점 ID(가맹점 수정후 고정)
//인증

$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

$orderNumber = $mid . "_" . $SignatureUtil->getTimestamp(); // 가맹점 주문번호(가맹점에서 직접 설정)


$cardNoInterestQuota = "11-2:3:,34-5:12,14-6:12:24,12-12:36,06-9:12,01-3:4";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
//###################################
// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
//###################################
$mKey = $SignatureUtil->makeHash($signKey, "sha256");


/* 기타 */
$siteDomain = $mid_url; //가맹점 도메인 입력
// 페이지 URL에서 고정된 부분을 적는다.
// Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
//                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.
/*이니시스 설정 끝*/


$db->query("SELECT name,phone,hPost,hAddr1,hAddr2,hAddr3,email FROM shopMembers WHERE id='$uname'");
$dbshopMembers = $db->loadRows();
$name = $dbshopMembers[0]["name"];
$phone = $dbshopMembers[0]["phone"];
$hPost = $dbshopMembers[0]["hPost"];
$hAddr1 = $dbshopMembers[0]["hAddr1"];
$hAddr2 = $dbshopMembers[0]["hAddr2"];
$hAddr3 = $dbshopMembers[0]["hAddr3"];
$email = $dbshopMembers[0]["email"];

$db->query("SELECT * FROM user_address WHERE user_id='$uname' ORDER BY id DESC LIMIT 0,1");
$db_user_address_query = $db->loadRows();
$oname = $db_user_address_query[0]["user_name"];
$ophone = $db_user_address_query[0]["phone"];
$opost = $db_user_address_query[0]["zipcode"];
$oaddr1 = $db_user_address_query[0]["addr1"];
$oaddr2 = $db_user_address_query[0]["addr2"];
$oaddr3 = $db_user_address_query[0]["addr3"];

if ($oname == "") {
    $oname = $name;
    $ophone = $phone;
    $opost = $hPost;
    $oaddr1 = $hAddr1;
    $oaddr2 = $hAddr2;
    $oaddr3 = $hAddr3;
    $ophoneArr = explode("-", $phone);
    $ophone1 = $ophoneArr[0];
    $ophone2 = $ophoneArr[1];
    $ophone3 = $ophoneArr[2];
}else{
    $ophoneArr = explode("-", $ophone);
    $ophone1 = $ophoneArr[0];
    $ophone2 = $ophoneArr[1];
    $ophone3 = $ophoneArr[2];
}
?>
<body class="home-1 checkout-page cart-page">
    <style type="text/css">

    </style>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong>
        browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a>
        to improve your experience.
    </p><![endif]-->
    <!--header area start-->
    <!--header area end-->
    <!--breadcrumb area start-->
    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bread-crumb">
                        <h1 class="sin-page-title" style="text-align:left;">
                            <a href="index.php" style="font-size:20px;">BLUE START</a>
                            체크아웃
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb area end-->
    <!-- checkout-area start -->
    <div class="checkout-area">
        <form id="SendPayForm_id" name="" method="POST">
            <input type="hidden" name="hname" class="hname" value="<?= $name ?>">
            <input type="hidden" name="hphone" class="hphone" value="<?= $phone ?>">
            <input type="hidden" name="hPost" class="hPost" value="<?= $hPost ?>">
            <input type="hidden" name="hAddr1" class="hAddr1" value="<?= $hAddr1 ?>">
            <input type="hidden" name="hAddr2" class="hAddr2" value="<?= $hAddr2 ?>">
            <input type="hidden" name="hAddr3" class="hAddr3" value="<?= $hAddr3 ?>">

            <input type="hidden" name="oname" class="oname" value="<?= $oname ?>">
            <input type="hidden" name="ophone" class="ophone" value="<?= $ophone ?>">
            <input type="hidden" name="oPost" class="oPost" value="<?= $opost ?>">
            <input type="hidden" name="oAddr1" class="oAddr1" value="<?= $oaddr1 ?>">
            <input type="hidden" name="oAddr2" class="oAddr2" value="<?= $oaddr2 ?>">
            <input type="hidden" name="oAddr3" class="oAddr3" value="<?= $oaddr3 ?>">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="your-order">
                            <h3 style="margin:0px;">주문상품</h3>
                            <div class="container-fluid no-padding">
                                <div class="row cart-top">
                                    <div class="col-md-12">
                                        <div class="table-responsive cart-area-wrapper">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <td colspan="5">
                                                            상품/옵션정보
                                                        </td>
                                                        <td>상품금액</td>
                                                        <td>배송비</td>
                                                    </tr>
                                                </thead>
                                                <?php
                                                $chkitem = $_POST["chkitem"];
                                                if ($chkitem == "") {
                                                    //바로구매
                                                    $sbidArr = $_POST["itemid"];
                                                    if ($sbidArr == "") {
                                                        echo "<script language='javascript'>window.top.document.location.href='/';</script>";
                                                        header("Location: /");
                                                    }
                                                    $sbnumArr = $_POST["itemnum"];
                                                    $opidArr = $_POST["opid"];
                                                    $opnumArr = $_POST["opnum"];
                                                    $goods_code = $_POST["goods_code"];
                                                    $_SESSION[$orderNumber . "_goods_code"] = $goods_code;
                                                    /*
                                                    $_SESSION["sbnum"]="";
                                                    $_SESSION["sbid"] = "";
                                                    $_SESSION["opid"] = "";
                                                    $_SESSION["opnum"] = "";
                                                    */
                                                    $i = 0;
                                                    $sbidQuery = "";
                                                    foreach ($sbidArr as $a => $b) {
                                                        if ($i == 0) {
                                                            $sbidQuery = "WHERE id IN (" . $b . "";
                                                        } else {
                                                            $sbidQuery .= "," . $b . "";
                                                        }
                                                        $i++;
                                                    }
                                                    $sbidQuery .= ")";

                                                    for ($i = 0; $i < count($sbidArr); $i++) {
                                                        if ($i == 0) {
                                                            $_SESSION[$orderNumber . "_sbid"] = $sbidArr[$i];
                                                        } else {
                                                            $_SESSION[$orderNumber . "_sbid"] .= "," . $sbidArr[$i];
                                                        }
                                                    }


                                                    for ($i = 0; $i < count($sbnumArr); $i++) {
                                                        if ($i == 0) {
                                                            $_SESSION[$orderNumber . "_sbnum"] = $sbnumArr[$i];
                                                        } else {
                                                            $_SESSION[$orderNumber . "_sbnum"] .= "," . $sbnumArr[$i];
                                                        }
                                                    }

                                                    $i = 0;
                                                    $opidQuery = "";
                                                    foreach ($opidArr as $c => $d) {
                                                        if ($d != "") {
                                                            if ($i == 0) {
                                                                $opidQuery = "WHERE id IN (" . $d . "";
                                                            } else {
                                                                $opidQuery .= "," . $d . "";
                                                            }
                                                            $i++;
                                                        }
                                                    }
                                                    if ($opidQuery != "") {
                                                        $opidQuery .= ")";
                                                    }

                                                    for ($i = 0; $i < count($opnumArr); $i++) {
                                                        if ($i == 0) {
                                                            $_SESSION[$orderNumber . "_opid"] = $opidArr[$i];
                                                        } else {
                                                            $_SESSION[$orderNumber . "_opid"] .= "," . $opidArr[$i];
                                                        }
                                                    }

                                                    for ($i = 0; $i < count($opnumArr); $i++) {
                                                        if ($i == 0) {
                                                            $_SESSION[$orderNumber . "_opnum"] = $opnumArr[$i];
                                                        } else {
                                                            $_SESSION[$orderNumber . "_opnum"] .= "," . $opnumArr[$i];
                                                        }
                                                    }

                                                    $db->query("SELECT goods_name,sb_sale,sellPrice,goods_type,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$goods_code'");
                                                    $goods_value_query = $db->loadRows();
                                                    $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
                                                    $goods_name = $goods_value_query[0]["goods_name"];
                                                    $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];
                                                    $goods_opt_type = $goods_value_query[0]["goods_opt_type"];
                                                    $goods_opt_num = $goods_value_query[0]["goods_opt_num"];
                                                    $goods_sellPrice = $goods_value_query[0]["sellPrice"];
                                                    $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];
                                                    $goods_type = $goods_value_query[0]["goods_type"];

                                                    if($goods_type == "0"){
                                                        //일반상품
                                                        $total_dShipping = $goods_dlv_fee;
                                                    }else if($goods_dlv_type == "8"){
                                                        //구매대행
                                                        $total_dShipping += $goods_dlv_fee;
                                                    }

                                                    $db->query("SELECT imageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id ASC limit 0,1");
                                                    $dbdata = $db->loadRows();
                                                    $imgSrc = $brandImagesWebDir . $dbdata[0]["imageName"];

                                                    if ($goods_opt_type == "0") {
                                                        // 옵션없음
                                                        $goods_count = count($goods_value_query);
                                                    } else if ($goods_opt_type == "1") {
                                                        //일반옵션
                                                        $db->query("SELECT opName1,opName2,sellPrice,quantity FROM goods_option_single_value $sbidQuery ORDER BY id ASC");
                                                        $goods_value_query = $db->loadRows();
                                                        $goods_count = count($goods_value_query);
                                                    } else {
                                                        //가격선택옵션 opValue2 판매가
                                                        $db->query("SELECT opName1,opName2,opName3,opValue2,opValue3 FROM goods_option_grid_value $sbidQuery ORDER BY id ASC");
                                                        $goods_value_query = $db->loadRows();
                                                        $goods_count = count($goods_value_query);
                                                    }
                                                    $sum = 0;
                                                    for ($i = 0; $i < $goods_count; $i++) {
                                                        if ($goods_opt_type == "2") {
                                                            $sum += $goods_value_query[$i]["opValue2"] * $sbnumArr[$i];
                                                        } else {
                                                            $sum += $goods_value_query[$i]["sellPrice"] * $sbnumArr[$i];
                                                        }
                                                    }
                                                    $sum2 = 0;
                                                    if ($goods_opt_type != "0") {
                                                        if ($opidQuery != "") {
                                                            $db->query("SELECT id,opName1,opName2,opValue2,quantity FROM goods_option $opidQuery ");
                                                            $goods_option = $db->loadRows();
                                                            $goods_optionCount = count($goods_option);
                                                            $rowspan = $goods_count + $goods_optionCount + 1;
                                                            for ($i = 0; $i < $goods_optionCount; $i++) {
                                                                $sum += $goods_option[$i]["opValue2"] * $opnumArr[$i];
                                                            }
                                                        } else {
                                                            $rowspan = $goods_count + 3;
                                                        }
                                                    } else {
                                                        $rowspan = $goods_count + 3;
                                                    }
                                                    $total_sum += $sum;
                                                    $total_sum2 += $sum2;
                                                    ?>
                                                    <tbody>
                                                        <tr>
                                                            <td style="text-align:left;background-color:#ddd;"
                                                                colspan="5">
                                                                <span
                                                                    style="display: inline-block;vertical-align: middle;">
                                                                    <img title="blandit blandit" width="50" height="50"
                                                                         alt="BlueStartImages" src="<?= $imgSrc ?>">
                                                                </span>
                                                                <span
                                                                    style="display: inline-block;vertical-align: middle;">
                                                                    <a href="item_view.php?code=<?= $goods_code ?>"><?= $goods_name ?></a>
                                                                </span>
                                                            </td>

                                                            <td class="cross Tprice" rowspan="<?= $rowspan ?>"
                                                                data-price="<?= $sum * $sb_sale + $sum2 ?>">
                                                                <?= number_format($sum * $sb_sale + $sum2) ?>
                                                                원
                                                            </td>
                                                            <td class="cross shipping"
                                                                data-shipping="<?=$goods_dlv_fee?>" rowspan="<?= $rowspan ?>">
                                                                <?=number_format($goods_dlv_fee)?> 원
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $i = 0;
                                                        foreach ($goods_value_query as $e => $f) {
                                                            if ($goods_opt_type == "1") {
                                                                $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                            } elseif ($goods_opt_type == "2") {
                                                                if ($goods_opt_num == "2") {
                                                                    $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                                } else {
                                                                    $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"] . "_" . $goods_value_query[$i]["opName3"];
                                                                }
                                                            }
                                                            if ($goods_opt_type != "2") {
                                                                $goods_sellPrice = $f["sellPrice"] * $sb_sale;
                                                            } else {
                                                                $goods_sellPrice = $f["opValue2"];
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td></td>
                                                                <td class="col-md-7" style="text-align:left;">
                                                                    <div class="cm7">
                                                                        옵션명 : <?= $goods_name ?>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <?= number_format($goods_sellPrice) ?>
                                                                    원
                                                                </td>
                                                                <td class="u-d">
                                                                    <?= $sbnumArr[$i] . "개" ?>
                                                                </td>
                                                                <td>
                                                                    <span class="price" data-num="<?= $sbnumArr[$i] ?>"
                                                                          data-price="<?= $goods_sellPrice ?>"
                                                                          style="font-weight:bold;"><?php echo number_format($goods_sellPrice * $sbnumArr[$i]); ?>
                                                                        원
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        if ($goods_opt_type != "0") {
                                                            $i = 0;
                                                            foreach ($goods_option as $e => $f) {
                                                                $goods_option_name = $f["opName1"] . "_" . $f["opName2"];
                                                                ?>
                                                                <tr>
                                                                    <td></td>
                                                                    <td class="col-md-7" style="text-align:left;">
                                                                        <div class="cm7">
                                                                            추가 옵션명 : <?= $goods_option_name ?>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?= number_format($f["opValue2"]) ?>
                                                                        원
                                                                    </td>
                                                                    <td class="u-d">
                                                                        <?= $opnumArr[$i] . "개" ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="price"
                                                                              data-num="<?= $opnumArr[$i] ?>"
                                                                              data-price="<?= $f['opValue2'] ?>"
                                                                              style="font-weight:bold;"><?= number_format($f['opValue2'] * $opnumArr[$i]) ?>
                                                                            원
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <?php


                                                } else {
                                                    //장바구니에서 상품가죠옴
                                                    $count = count($chkitem);
                                                    if ($count == "") {
                                                        if ($sbidArr == "") {
                                                            echo "<script language='javascript'>window.top.document.location.href='/';</script>";
                                                            header("Location: /");
                                                        }
                                                    }
                                                    for ($i = 0; $i < $count; $i++) {
                                                        $basketid = $chkitem[$i];
                                                        if ($i == 0) {
                                                            $basketWhere = " WHERE uid IN ($basketid";
                                                        } else {
                                                            $basketWhere .= ",$basketid";
                                                        }
                                                    }
                                                    $basketWhere .= ")";
                                                    $db->query("SELECT uid,v_oid,goods_code,sbid,sbnum,opid,opnum,signdate FROM basket $basketWhere AND id='$uname' ORDER BY uid ASC");
                                                    $dbdata = $db->loadRows();
                                                    foreach ($dbdata as $k => $v) {
                                                        $sbid = $v["sbid"];
                                                        $sbidArr = explode(",", $sbid);
                                                        $sbnum = $v["sbnum"];
                                                        $sbnumArr = explode(",", $sbnum);
                                                        $goods_code = $v["goods_code"];
                                                        $basketuid = $v["uid"];
                                                        if ($basketvoid == "") {
                                                            $basketvoid = $v["v_oid"];
                                                        } else {
                                                            $basketvoid .= "_" . $v["v_oid"];
                                                        }

                                                        $pay_goods_name .= $v["goods_name"];
                                                        $i = 0;
                                                        $sbidQuery == "";
                                                        foreach ($sbidArr as $a => $b) {
                                                            if ($i == 0) {
                                                                $sbidQuery = "WHERE id IN (" . $b . "";
                                                            } else {
                                                                $sbidQuery .= "," . $b . "";
                                                            }
                                                            $i++;
                                                        }
                                                        $sbidQuery .= ")";
                                                        $opid = $v["opid"];
                                                        $opidArr = explode(",", $opid);
                                                        $opnum = $v["opnum"];
                                                        $opnumArr = explode(",", $opnum);
                                                        $i = 0;
                                                        $opidQuery = "";
                                                        foreach ($opidArr as $c => $d) {
                                                            if ($d != "") {
                                                                if ($i == 0) {
                                                                    $opidQuery = "WHERE id IN (" . $d . "";
                                                                } else {
                                                                    $opidQuery .= "," . $d . "";
                                                                }
                                                                $i++;
                                                            }
                                                        }
                                                        if ($opidQuery != "") {
                                                            $opidQuery .= ")";
                                                        }


                                                        $db->query("SELECT goods_name,sb_sale,sellPrice,goods_type,goods_dlv_type,goods_dlv_fee,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$goods_code'");
                                                        $goods_value_query = $db->loadRows();
                                                        $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;

                                                        $goods_name = $goods_value_query[0]["goods_name"];
                                                        $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];
                                                        $goods_opt_type = $goods_value_query[0]["goods_opt_type"];
                                                        $goods_opt_num = $goods_value_query[0]["goods_opt_num"];
                                                        $goods_sellPrice = $goods_value_query[0]["sellPrice"];
                                                        $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];
                                                        $goods_type = $goods_value_query[0]["goods_type"];

                                                        if($goods_type == "0"){
                                                            //일반상품
                                                            $total_dShipping = $goods_dlv_fee;
                                                        }else if($goods_dlv_type == "8"){
                                                            //구매대행
                                                            $total_dShipping += $goods_dlv_fee;
                                                        }

                                                        $db->query("SELECT imageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id ASC limit 0,1");
                                                        $dbdata = $db->loadRows();
                                                        $imgSrc = $brandImagesWebDir . $dbdata[0]["imageName"];

                                                        if ($goods_opt_type == "0") {
                                                            // 옵션없음
                                                            $goods_count = count($goods_value_query);
                                                        } else if ($goods_opt_type == "1") {
                                                            //일반옵션
                                                            $db->query("SELECT opName1,opName2,sellPrice,quantity FROM goods_option_single_value $sbidQuery ORDER BY id ASC");
                                                            $goods_value_query = $db->loadRows();
                                                            $goods_count = count($goods_value_query);
                                                        } else {
                                                            //가격선택옵션 opValue2 판매가
                                                            $db->query("SELECT opName1,opName2,opName3,opValue2,opValue3 FROM goods_option_grid_value $sbidQuery ORDER BY id ASC");
                                                            $goods_value_query = $db->loadRows();
                                                            $goods_count = count($goods_value_query);
                                                        }
                                                        $sum = 0;
                                                        for ($i = 0; $i < $goods_count; $i++) {
                                                            if ($goods_opt_type == "2") {
                                                                $sum += $goods_value_query[$i]["opValue2"] * $sbnumArr[$i];
                                                            } else {
                                                                $sum += $goods_value_query[$i]["sellPrice"] * $sbnumArr[$i];
                                                            }
                                                        }
                                                        $sum2 = 0;
                                                        if ($goods_opt_type != "0") {
                                                            if ($opidQuery != "") {
                                                                $db->query("SELECT id,opName1,opName2,opValue2,quantity FROM goods_option $opidQuery ");
                                                                $goods_option = $db->loadRows();
                                                                $goods_optionCount = count($goods_option);
                                                                $rowspan = $goods_count + $goods_optionCount + 1;
                                                                for ($i = 0; $i < $goods_optionCount; $i++) {
                                                                    $sum2 += $goods_option[$i]["opValue2"] * $opnumArr[$i];
                                                                }
                                                            } else {
                                                                $rowspan = $goods_count + 3;
                                                            }
                                                        } else {
                                                            $rowspan = $goods_count + 3;
                                                        }
                                                        $total_sum += $sum;
                                                        $total_sum2 += $sum2;
                                                        ?>
                                                        <tbody>
                                                            <tr>
                                                                <td style="text-align:left;background-color:#ddd;"
                                                                    colspan="5">
                                                                    <span
                                                                        style="display: inline-block;vertical-align: middle;">
                                                                        <img title="blandit blandit" width="50"
                                                                             height="50" alt="BlueStartImages"
                                                                             src="<?= $imgSrc ?>">
                                                                    </span>
                                                                    <span
                                                                        style="display: inline-block;vertical-align: middle;">
                                                                        <a href="item_view.php?code=<?= $goods_code ?>"><?= $goods_name ?></a>
                                                                    </span>
                                                                </td>

                                                                <td class="cross Tprice" rowspan="<?= $rowspan ?>"
                                                                    data-price="<?= $sum * $sb_sale + $sum2 ?>">
                                                                    <?= number_format($sum * $sb_sale + $sum2) ?>
                                                                    원
                                                                </td>
                                                                <td class="cross shipping"
                                                                    data-shipping="<?=$goods_dlv_fee?>" rowspan="<?= $rowspan ?>">
                                                                    <?=number_format($goods_dlv_fee)?> 원
                                                                </td>
                                                            </tr>
                                                            <?php
                                                            $i = 0;
                                                            foreach ($goods_value_query as $e => $f) {
                                                                if ($goods_opt_type == "1") {
                                                                    $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                                } elseif ($goods_opt_type == "2") {
                                                                    if ($goods_opt_num == "2") {
                                                                        $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"];
                                                                    } else {
                                                                        $goods_name = $goods_value_query[$i]["opName1"] . "_" . $goods_value_query[$i]["opName2"] . "_" . $goods_value_query[$i]["opName3"];
                                                                    }
                                                                }
                                                                if ($goods_opt_type != "2") {
                                                                    $goods_sellPrice = $f["sellPrice"] * $sb_sale;
                                                                } else {
                                                                    $goods_sellPrice = $f["opValue2"];
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td></td>
                                                                    <td class="col-md-7" style="text-align:left;">
                                                                        <div class="cm7">
                                                                            옵션명 : <?= $goods_name ?>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <?= number_format($goods_sellPrice) ?>
                                                                        원
                                                                    </td>
                                                                    <td class="u-d">
                                                                        <?= $sbnumArr[$i] . "개" ?>
                                                                    </td>
                                                                    <td>
                                                                        <span class="price"
                                                                              data-num="<?= $sbnumArr[$i] ?>"
                                                                              data-price="<?= $goods_sellPrice ?>"
                                                                              style="font-weight:bold;"><?php echo number_format($goods_sellPrice * $sbnumArr[$i]); ?>
                                                                            원
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                <?php
                                                                $i++;
                                                            }
                                                            if ($goods_opt_type != "0") {
                                                                $i = 0;
                                                                foreach ($goods_option as $e => $f) {
                                                                    $goods_option_name = $f["opName1"] . "_" . $f["opName2"];
                                                                    ?>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td class="col-md-7" style="text-align:left;">
                                                                            <div class="cm7">
                                                                                추가 옵션명 : <?= $goods_option_name ?>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <?= number_format($f["opValue2"]) ?>
                                                                            원
                                                                        </td>
                                                                        <td class="u-d">
                                                                            <?= $opnumArr[$i] . "개" ?>
                                                                        </td>
                                                                        <td>
                                                                            <span class="price"
                                                                                  data-num="<?= $opnumArr[$i] ?>"
                                                                                  data-price="<?= $f['opValue2'] ?>"
                                                                                  style="font-weight:bold;"><?= number_format($f['opValue2'] * $opnumArr[$i]) ?>
                                                                                원
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                    $i++;
                                                                }
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="checkbox-form">
                            <h3 style="margin:0px;margin-top:20px;border-bottom:none;">구매자정보</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table borderless user-info">
                                        <tr>
                                            <input type="hidden" name="oname" value="<?= $name ?>">
                                            <input type="hidden" name="ophone" value="<?= $phone ?>">
                                            <input type="hidden" name="oemail" value="<?= $email ?>">
                                            <th class="col-md-3" style="width:122px;">주문자</th>
                                            <td><?= $name ?></td>
                                        </tr>
                                        <tr>
                                            <th>휴대폰</th>
                                            <td><?= $phone ?></td>
                                        </tr>
                                        <tr>
                                            <th>이메일</th>
                                            <td><?= $email ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <h3 class="col-md-12"
                                style="margin:0px;padding-left:0px;border-bottom:none;margin-top:20px;">
                                <div class="col-md-3" style="padding:0px;">받는사람 정보</div>
                                <div style="font-size:12px;" class="col-md-9">
                                    <input type="radio" name="addr_type" class="addr_type" id="addr_type0"
                                           style="margin-left:10px;">
                                    <label for="addr_type0" style="margin-right:10px;padding-left:3px;">기본 배송지</label>
                                    <input type="radio" name="addr_type" id="addr_type1"
                                           checked="checked">
                                    <label for="addr_type1" style="margin-right:10px;padding-left:3px;">최근 배송지</label>
                                    <input type="radio" name="addr_type" class="addr_type" id="addr_type2">
                                    <label for="addr_type2" style="padding-left:3px;">새로운 배송지</label>
                                </div>
                            </h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table borderless user-info">
                                        <tr>
                                            <th class="col-lg-3 col-md-3" style="width:122px;">이름</th>
                                            <td>
                                                <div class="checkout-form-list">
                                                    <div class="col-md-12">
                                                        <input type="text" name="user_id" value="<?= $oname ?>"
                                                               class="user_id">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>휴대폰</th>
                                            <td>
                                                <div class="col-md-12 checkout-form-list">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-default"
                                                                            data-toggle="dropdown" aria-expanded="false"
                                                                            style="border-right: none;">
                                                                        <span
                                                                            class="dropdown-txt"><?= $ophone1 ?></span>
                                                                        <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu" role="menu">
                                                                        <li>
                                                                            <a href="javascript:void(0);"
                                                                               class="dropdown-menu-txt">010
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0);"
                                                                               class="dropdown-menu-txt">011
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0);"
                                                                               class="dropdown-menu-txt">016
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0);"
                                                                               class="dropdown-menu-txt">017
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0);"
                                                                               class="dropdown-menu-txt">018
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="javascript:void(0);"
                                                                               class="dropdown-menu-txt">019
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <!-- /btn-group -->
                                                                <input type="hidden" name="phone1"
                                                                       value="<?= $ophone1 ?>" class="phone1">
                                                                <input type="text" name="phone2" value="<?= $ophone2 ?>"
                                                                       class="form-control phone2"
                                                                       style="margin:0px;width:50%;border-right:none;">
                                                                <input type="text" name="phone3" value="<?= $ophone3 ?>"
                                                                       class="form-control phone3"
                                                                       style="margin:0px;width:50%;">
                                                            </div>
                                                            <!-- /input-group -->
                                                        </div>
                                                        <!-- /.col-lg-6 -->
                                                    </div><!-- /.row -->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>주소</th>
                                            <td>
                                                <div class="checkout-form-list">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <input type="text" class="form-control"
                                                                           readonly="readonly" name="zipcode"
                                                                           value="<?= $opost ?>" id="zipcode"
                                                                           style="margin:0px;">
                                                                    <span class="input-group-btn">
                                                                        <button type="button" class="btn btn-red"
                                                                                onclick="javascript:DaumPostcode('zipcode','add1','add2');">
                                                                            우편번호찾기
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                                <!-- /input-group -->
                                                            </div>
                                                        </div>
                                                        <!-- /.row -->
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:10px;"></div>
                                                    <div class="col-md-12">
                                                        <strong>구주소</strong>
                                                        <input type="text" readonly="readonly" name="add1"
                                                               value="<?= $oaddr1 ?>" id="add1">
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:10px;"></div>
                                                    <div class="col-md-12">
                                                        <strong>새주소(도로명)</strong>
                                                        <input type="text" readonly="readonly" name="add2"
                                                               value="<?= $oaddr2 ?>" id="add2">
                                                    </div>
                                                    <div class="col-md-12" style="margin-top:10px;"></div>
                                                    <div class="col-md-12">
                                                        <strong>나머지 주소</strong>
                                                        <input type="text" name="add3" value="<?= $oaddr3 ?>" id="add3">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>배송메시지</th>
                                            <td>
                                                <div class="checkout-form-list">
                                                    <div class="col-md-12">
                                                        <input type="text" name="ship_message" class="ship_message"
                                                               type="hidden">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="your-order">
                            <h3 style="margin:0px;margin-top:20px;">결제정보</h3>
                            <div class="your-order-table table-responsive">
                                <table class="table checkout-table checkout" style="border-top:2px solid #666;">
                                    <thead>
                                        <th class="cross">주문금액</th>
                                        <th class="cross">배송비</th>
                                        <th class="cross">할인금액</th>
                                        <th>
                                            <span class="checkout-price">결제 예정금액</span>
                                        </th>
                                    </thead>
                                    <tbody>
                                        <td><?= number_format($total_sum + $total_sum2) ?>
                                            <span class="won">원</span>
                                        </td>
                                        <td class="cross">
                                            <i class="fa fa-plus-square"></i> <?= number_format($total_dShipping) ?>
                                            <span class="won">원
                                            </span>
                                        </td>
                                        <td class="cross">
                                            <i class="fa fa-minus-square"></i> <?= number_format($total_sum - $total_sum * $sb_sale) ?>
                                            <span class="won">원</span>
                                        </td>
                                        <td>
                                            <span
                                                class="checkout-price"><?= number_format($total_sum * $sb_sale + $total_sum2 + $total_dShipping) ?></span>
                                            <span class="won2">원
                                            </span>
                                        </td>
                                    </tbody>
                                </table>
                            </div>
                            <!--<div class="col-md-12" style="padding:0px;margin:20px 0px;">
                                    <div class="row">
                                            <div class="col-md-12">
                                                    <div class="input-group">
                                                            <div class="checkout-form-list">
                                                                    <input type="text" class="form-control cupon-inp-txt" aria-label="..." style="margin:0px;">
                                                            </div>
                                                            <div class="input-group-btn">
                                                                    <button type="button" class="btn btn-red" data-toggle="dropdown" aria-expanded="false">쿠폰 / 포인트 적용
                                                                            <span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                                                            <li>
                                                                                    <a href="javascript:void(0);">쿠폰</a>
                                                                            </li>
                                                                            <li class="divider"></li>
                                                                            <li>
                                                                                    <a href="javascript:void(0);">포인트 ( 보유포인트 : 10,000 )</a>
                                                                            </li>
                                                                    </ul>
                                                            </div><!-- /btn-group -->
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->
                </div><!-- /.row -->
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="your-order">
                    <h3 style="margin:0px;">결제방법</h3>
                    <div class="your-order-table table-responsive">
                        <table class="table borderless user-info" style="border-top:2px solid #666;">
                            <tbody>
                                <tr>
                                    <th style="width:150px !important;font-weight:bold;" rowspan="2">
                                        사용하실 결제수단
                                    </th>
                                    <td>
                                        <label style="padding:0px 5px;" for="bank">무통장입금</label>
                                        <input type="radio" name="paymethod" value="1" checked="checked" id="bank"
                                               style="padding:0px 5px;">
                                        <label style="padding:0px 5px;" for="card">카드결제</label>
                                        <input type="radio" name="paymethod" value="Card" id="card" style="padding:0px 5px;">
                                        <label style="padding:0px 5px;" for="vbank">가상계좌</label>
                                        <input type="radio" name="paymethod" value="VBank" id="vbank" style="padding:0px 5px;">
                                        <label style="padding:0px 5px;" for="dbank">실시간계좌이체</label>
                                        <input type="radio" name="paymethod" value="DirectBank" id="dbank">
                                        <!--<label style="padding:0px 5px;" for="hpp">핸드폰 결제</label>
                                        <input type="radio" name="paymethod" value="HPP" id="hpp">-->
                                        <?
                                        /*
                                         * 결제수단코드 gopaymethod
                                         *
                                         *      Card                                    신용카드
                                                DirectBank                          실시간게좌이체
                                                OCBPoint                                OKCashbag포인트
                                                HPP                                     핸드폰
                                                VBank                                   무통장입금(가상계좌)
                                                PhoneBill                               폰빌,전화결제
                                                Culture                                 문화상품권결제
                                                DGCL                                    스마트문상 결제
                                                TeenCash                                틴캐시
                                                Bcsh                                    도서문화상품권
                                                HPMN                                해피머니상품권
                                                YPAY                                   엘로페이
                                                Kpay                                    케이펭
                                                Paypin                                  해피머니상품권
                                                EasyPay                                  엘로페이
                                                EWallet                                 전자지갑
                                                POINT                                   포인트
                                                GiftCard                                상품권
                                         *
                                         * */
                                        ?>
                                    </td>
                                </tr>
                                <tr class="payment_option_type" style="display: block;">
                                    <td style="display: block;">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <colgroup>
                                                <col width="15%">
                                                <col width="75%">
                                            </colgroup>
                                            <tbody>
                                                <tr>
                                                    <td>입금인 성명</td>
                                                    <td style="border-bottom:0px;">
                                                        <div class="checkout-form-list" style="padding:0px;">
                                                            <div class="col-md-12" style="padding:0px;">
                                                                <input type="text" name="pay_online_name"
                                                                       class="pay_online_name">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>입금 계좌</td>
                                                    <td>
                                                        <select id="pay_online_account" name="pay_online_account">
                                                            <option value="신한은행|110-450-713612"> 신한은행 110-450-713612</option>
                                                            <option value="NH농협은행|302-9691-9190-81"> NH농협은행 302-9691-9190-81
                                                            </option>
                                                            <option value="우리은행|1005-802-973145"> 우리은행 1005-802-973145</option>
                                                            <option value="하나은행|1005-802-973145"> 하나은행 810-810810-88607</option>
                                                            <option value="외환은행|1005-802-973145"> 외환은행 630-010490-258</option>
                                                            <option value="KB국민은행|1005-802-973145"> KB국민은행 996-919190-49
                                                            </option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td scope="row" style="border-bottom:0px;">예상 입금일</td>
                                                    <td style="border-bottom:0px;">
                                                        <input id="txt_pay_pre_date" type="text" name="pay_pre_date"
                                                               value="<?= date("Y-m-d", time()) ?>" size="10"
                                                               class="input_date">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-12 payment-method no-padding">
                        <div class="col-md-9"></div>
                        <div class="col-md-3 order-button-payment no-padding">
                            <input type="button" value="결제하기" onclick="pay()">
                        </div>
                    </div>
                    <?php
                    $price = $total_sum * $sb_sale + $total_sum2 + $total_dShipping;        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)
                    $price = "1000";
                    $params = array(
                        "oid" => $orderNumber,
                        "price" => $price,
                        "timestamp" => $timestamp
                    );
                    $sign = $SignatureUtil->makeSignature($params, "sha256");
                    $offer_date = date("Ymd", time());
                    $offer_date_last = date("Ymd", strtotime("$offer_date + 7 day"));
                    ?>
                    <input type="hidden" name="version" value="1.0">
                    <input type="hidden" name="mid" value="<?php echo $mid ?>">
                    <input type="hidden" name="goodname" value="<?php echo $goods_name; ?>">
                    <input type="hidden" name="oid" class="oid" value="<?php echo $orderNumber ?>">
                    <input type="hidden" name="price" value="<?php echo $price ?>">
                    <input type="hidden" name="currency" value="WON">
                    <input type="hidden" name="buyername" value="<?php echo $name; ?>">
                    <input type="hidden" name="buyertel" value="<?php echo $phone; ?>">
                    <input type="hidden" name="buyeremail" value="<?php echo $email; ?>">
                    <input type="hidden" name="timestamp" value="<?php echo $timestamp ?>">
                    <input type="hidden" name="signature" value="<?php echo $sign ?>">
                    <input type="hidden" name="returnUrl" value="<?php echo $siteDomain ?>/orderReturn.php">
                    <input type="hidden" name="mKey" value="<?php echo $mKey ?>">
                    <input type="hidden" name="gopaymethod" value="Card">
                    <input type="hidden" name="offerPeriod" value="<?php echo $offer_date ?>-<?php echo $offer_date_last ?>">
                    <input type="hidden" name="acceptmethod"
                           value="SKIN(#E26A6A):HPP(1):no_receipt:va_receipt:vbanknoreg(0):vbank(<?= $offer_date_last ?>):below1000">
                    <input type="hidden" name="languageView" value="">
                    <input type="hidden" name="charset" value="">
                    <input type="hidden" name="payViewType" value="">
                    <input type="hidden" name="closeUrl" value="<?php echo $siteDomain ?>/close.php">
                    <input type="hidden" name="popupUrl" value="<?php echo $siteDomain ?>/popup.php">
                    <input type="hidden" name="quotabase" value="<?php echo $cardQuotaBase ?>">
                    <input type="hidden" name="vbankRegNo" value="">
                    <input type="hidden" name="merchantData" value="">
                    <input type="hidden" name="bid" class="bid" value="<?php echo $basketvoid; ?>">
                    <input type="hidden" name="goods_code" value="<?php echo $goods_code; ?>">
                    <input type="hidden" name="sbid" value="<?= $_SESSION[$orderNumber . "_sbid"] ?>">
                    <input type="hidden" name="sbnum" value="<?= $_SESSION[$orderNumber . "_sbnum"] ?>">
                    <input type="hidden" name="opid" value="<?= $_SESSION[$orderNumber . "_opid"] ?>">
                    <input type="hidden" name="opnum" value="<?= $_SESSION[$orderNumber . "_opnum"] ?>">
                    <input type="hidden" name="goods_dlv_type" value="<?= $goods_dlv_type ?>">
                    <input type="hidden" name="goods_opt_type" value="<?= $goods_opt_type ?>">
                    <input type="hidden" name="goods_opt_num" value="<?= $goods_opt_num ?>">
                    <?php
                    $_SESSION[$orderNumber . "_buy_instant_discount"] = "";//상품 즉시할인 금액(총 할인금액)
                    $_SESSION[$orderNumber . "_buy_total_price"] = "";//총상품총액(할인전금액)
                    $_SESSION[$orderNumber . "_pay_dlv_fee"] = "";//결제한 배송비

                    $_SESSION[$orderNumber . "_buy_instant_discount"] = $total_sum - $total_sum * $sb_sale;//상품 즉시할인 금액(총 할인금액)
                    $_SESSION[$orderNumber . "_buy_total_price"] = $total_sum + $total_sum2;//총상품총액(할인전금액)
                    $_SESSION[$orderNumber . "_pay_dlv_fee"] = $total_dShipping;
                    $_SESSION[$orderNumber . "_buy_goods_type"] = $goods_type;
                    $buy_total_price = $total_sum + $total_sum2;
                    $buy_instant_discount = $total_sum - $total_sum * $sb_sale;
                    $db->query("UPDATE basket SET buy_user_tel='$phone',buy_user_mobile='$phone',buy_user_email='$email',pay_dlv_fee='$total_dShipping',goods_type='$goods_type',buy_total_price='$buy_total_price',buy_instant_discount='$buy_instant_discount' $basketWhere");

                    ?>
                </div>
            </div>
        </form>
    </div>
    <style>
        .modal-header .close {
            margin-top: -10px;
        }
        .close {
            font-size: 60px;
            font-weight: normal;
        }
        th td {
            text-align: center !important;
        }
        .modal-header , .modal-footer{
            border:none;
        }
        .modal-body .table > tbody > tr > th{
            border-top:1px solid #333;
            border-bottom: 1px solid #aaa;
            color: #393939;
            font-size: 12px;
            font-family: '돋움',dotum,sans-serif;
            font-style: normal;
            font-weight: normal;
            background-color: #f4f4f4;
            background: -webkit-linear-gradient(#fff, #f9f9fa);
            background: -o-linear-gradient(#fff, #f9f9fa);
            background: -moz-linear-gradient(#fff,#f9f9fa);
            background: linear-gradient(#fff,#f9f9fa);
        }
        .modal-header {
            padding-bottom: 0px;
        }
        .modal-body {
            padding-top: 0px;
        }
        .modal-title {
            padding-top:10px;
        }
    </style>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLargeModalLabel">최근배송지<a class="anchorjs-link" href="#myLargeModalLabel"><span class="anchorjs-icon"></span></a></h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <div class="col-md-12">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-red btn_addr">
                                확인
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                                취소
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- checkout-area end -->
    <!--footer area start-->

    <!--footer area end-->

    <!-- JS -->
    <?php include_once("js.php"); ?>
    <!-- 다움 주소검색 스크립트 -->
    <script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
    <!-- 이니시스 웹표준 결제 스크립트 -->
    <script language="javascript" type="text/javascript" src="https://stgstdpay.inicis.com/stdjs/INIStdPay.js"
            charset="UTF-8"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("input[name='paymethod']").click(function () {
                var strVal = $(this).val();
                $("input[name='gopaymethod']").val(strVal);
            });
        });
        //폰번호 앞자리
        $(".dropdown-menu-txt").click(function () {
            var str = $(this).text();
            $(".dropdown-txt").text(str);
            $(".phone1").val(str);
        });
        $(".addr_type").click(function () {
            var addr_type = $(this).attr("id");
            var phone = $(".hphone").val();
            var phoneArr = phone.split("-");
            var zipcode = $(".hPost").val();
            var add1 = $(".hAddr1").val();
            var add2 = $(".hAddr2").val();
            var add3 = $(".hAddr3").val();
            if (addr_type == "addr_type0") {
                $(".user_id").val($(".hname").val());
                $(".dropdown-txt").text(phoneArr[0]);
                $(".phone1").val(phoneArr[0]);
                $(".phone2").val(phoneArr[1]);
                $(".phone3").val(phoneArr[2]);
                $("#zipcode").val(zipcode);
                $("#add1").val(add1);
                $("#add2").val(add2);
                $("#add3").val(add3);
            } else if (addr_type == "addr_type2") {
                $(".user_id").val("");
                $(".dropdown-txt").text("010");
                $(".phone1").val("010");
                $(".phone2").val("");
                $(".phone3").val("");
                $("#zipcode").val("");
                $("#add1").val("");
                $("#add2").val("");
                $("#add3").val("");
            }
        });
        function DaumPostcode(zipcode, addr1, addr2) {
            new daum.Postcode({
                oncomplete: function (data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var fullAddr = ''; // 최종 주소 변수
                    var extraAddr = ''; // 조합형 주소 변수
                    // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    // if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    fullAddr = data.roadAddress;
                    // } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    fullAddr2 = data.jibunAddress;
                    //  }
                    // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                    if (data.userSelectedType === 'R') {
                        //법정동명이 있을 경우 추가한다.
                        if (data.bname !== '') {
                            extraAddr += data.bname;
                        }
                        // 건물명이 있을 경우 추가한다.
                        if (data.buildingName !== '') {
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                        fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
                    }
                    var postcode = data.postcode1 + "" + data.postcode2;
                    var zonecode = data.zonecode;// 새우편번호
                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    $('#' + zipcode).val(zonecode);
                    $('#' + addr1).val(fullAddr2);
                    $('#' + addr2).val(fullAddr);
                    //$('#etc_a34').val(data.addressEnglish);
                    // 커서를 상세주소 필드로 이동한다.
                }
            }).open();
        }
        function pay() {
            var phone2 = $(".phone2").val();
            var phone3 = $(".phone3").val();
            var zipcode = $("#zipcode").val();
            var add1 = $("#add1").val();
            var add2 = $("#add2").val();
            var add3 = $("#add3").val();
            var bid = $(".bid").val();
            var ordernum = $(".oid").val();
            var user_id = $(".user_id").val();//배송받는사람
            var phone = $(".phone1").val() + "-" + $(".phone2").val() + "-" + $(".phone3").val();//배송받는사람 전화
            var ship_message = $(".ship_message").val();//배송 메세지
            var pay_mod = $("input[name='paymethod']:checked").val();
            var addr_type = $(".addr_type").val();
            if (pay_mod == "1") {
                var pay_online_name = $(".pay_online_name").val();
                var pay_online_account = $("#pay_online_account").val();
                var txt_pay_pre_date = $("#txt_pay_pre_date").val();
                if (!pay_online_name) {
                    alert("입금인 이름을 입력해주세요.");
                    return false;
                }
                if (!txt_pay_pre_date) {
                    alert("예상 입금일을 입력해주세요.");
                    return false;
                }
            }

            if (!user_id) {
                alert("받는사람 이름을 입력해주세요.");
                return false;
            }
            if (!phone2 || !phone3) {
                alert("받는사람 휴대폰 번호를 입력해주세요.");
                return false;
            }
            if (!zipcode) {
                alert("우편번호를 입력해주세요.");
                return false;
            }
            if (!add1 || !add2 || !add3) {
                alert("주소를 입력해주세요.");
                return false;
            }
            if (pay_mod == "1") {
                $("#SendPayForm_id").attr("action", "buy_end.php");
                $("#SendPayForm_id").submit();
                return false;
            }
            $.ajax({
                url: 'upcheck.php',
                type: 'POST',
                data: {
                    bid: bid,
                    ordernum: ordernum,
                    user_id: user_id,
                    phone: phone,
                    zipcode: zipcode,
                    oldadd: add1,
                    newadd: add2,
                    alladd: add3,
                    ship_message: ship_message,
                    addr_type: addr_type
                },
                success: function (response) {
                    if (response == "success") {
                        if (pay_mod != "1") {
                            INIStdPay.pay('SendPayForm_id');
                        } else {
                            location.href = "buy_end.php";
                        }
                    } else {
                        alert("결제 실패 하였습니다.잠시후 다시 시도해 주세요.")
                    }
                }
            });
        }
        $("input[name=paymethod]").click(function () {
            var attr_id = $(this).attr("id");
            if (attr_id == "bank") {
                $(".payment_option_type").css("display", "block");
            } else {
                $(".payment_option_type").css("display", "none");
            }
        });
        $("#addr_type1").on("click",function(){
            $.ajax({
                url: 'get_address.php',
                success: function (response) {
                    add_html(response);
                }
            });
        });
        function add_html(obj){
            $(".modal-body").html(obj);
            $(".modal.bs-example-modal-lg").modal("show");
            $(".del_addr").on("click",function () {
                var no = $(this).attr("data-no");
                var tobj = $(this);
                $.ajax({
                    url: 'del_address.php',
                    type: "POST",
                    data: { no: no},
                    success: function (response) {
                        if(response == "ok"){
                            alert("선택하신 주소를 삭제하였습니다.");
                            tobj.parent().parent().html("");
                        }
                    }

                });
            });
        }
        $(".btn_addr").on("click",function () {
            var user_name =$(".get_add:checked").attr("data-name");
            var zipcode = $(".get_add:checked").attr("data-zipcode");
            var addr1 = $(".get_add:checked").attr("data-addr1");
            var addr2 = $(".get_add:checked").attr("data-addr2");
            var addr3 = $(".get_add:checked").attr("data-addr3");
            var phone = $(".get_add:checked").attr("data-phone");
            $(".user_id").val(user_name);
            $("#zipcode").val(zipcode);
            var phoneArr = phone.split("-");
            $(".dropdown-txt").val(phoneArr[0]);
            $(".phone1").val(phoneArr[0]);
            $(".phone2").val(phoneArr[1]);
            $(".phone3").val(phoneArr[2]);
            $("#add1").val(addr1);
            $("#add2").val(addr2);
            $("#add3").val(addr3);
            $(".modal.bs-example-modal-lg").modal("hide");
        });

    </script>
</body>
</html>