<?php
include_once("session.php");
include_once("doctype.php");
$goods_code = $_GET["code"];
$name1 = $_GET["name1"];
$name2 = $_GET["name2"];
?>
<body class="home-1 shop-page sin-product-page">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an
                <strong>outdated</strong>
                browser. Please
                <a href="http://browsehappy.com/">upgrade your browser
                </a>
                to improve your experience.
        </p><![endif]-->
        <!--HEADER AREA START-->
        <?php include_once("sub_head.php") ?>
        <!--HEADER AREA END-->
        <!--BREADCRUMB AREA START-->
        <div class="breadcrumb-area">
                <div class="container-fluid">
                        <div class="row">
                                <div class="col-md-12">
                                        <div class="bread-crumb">
                                                <ul>
                                                        <?php
                                                        /* 네비게이션 */
                                                        $code1 = substr($goods_code, 0, 2);
                                                        $code2 = substr($goods_code, 2, 2);
                                                        if ($name2 == "") {
                                                                $db->query("SELECT sortName FROM sortCodes WHERE uxCode='$code1' and sortCode='$code2'");
                                                                $db_sortCode = $db->loadRows();
                                                                $name2 = $db_sortCode[0]["sortName"];
                                                        }
                                                        ?>
                                                        <li class="bc-home">
                                                                <a href="index.php">Home</a>
                                                        </li>
                                                        <?php
                                                        if ($name2 == "") {
                                                                echo '<li>' . $name1 . '</li>';
                                                        } else {
                                                                echo '<li class="bc-home"><a href="shop.php?code1=' . $code1 . '&name1=' . $name1 . '&name2=">' . $name1 . '</a></li>';
                                                                echo '<li>' . $name2 . '</li>';
                                                        }
                                                        ?>
                                                </ul>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        <!--BREADCRUMB AREA END-->
        <!--SINGLE PRODUCT AREA START-->
        <section class="single-product-area">
                <div class="container-fluid">
                        <div class="row">
                                <div class="col-md-9 col-sm-12">
                                        <div class="col-sm-5 col-md-5 no-padding">
                                                <div class="zoomWrapper">
                                                        <div id="img-1" class="zoomWrapper single-zoom">
                                                                <?php
                                                                /* 상품 이미지 시작 */
                                                                $db->query("SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id asc");
                                                                $db_upload_timagesArr = $db->loadRows();
                                                                $db->query("SELECT ImageName FROM upload_simages WHERE goods_code='$goods_code' ORDER BY id asc");
                                                                $db_upload_simagesArr = $db->loadRows();
                                                                $db->query("SELECT ImageName FROM upload_mimages WHERE goods_code='$goods_code' ORDER BY id asc");
                                                                $db_upload_mimagesArr = $db->loadRows();
                                                                $db->query("SELECT ImageName FROM upload_bimages WHERE goods_code='$goods_code' ORDER BY id asc");
                                                                $db_upload_bimagesArr = $db->loadRows();
                                                                ?>
                                                                <a href="javascript:void(0);">
                                                                        <img id="zoom1" src="<?= $brandImagesWebDir . $db_upload_mimagesArr[0]["ImageName"] ?>" width="600" height="600" data-zoom-image="<?= $brandImagesWebDir . $db_upload_bimagesArr[0]["ImageName"] ?>" alt="big-6">
                                                                </a>
                                                        </div>
                                                        <div class="single-zoom-thumb">
                                                                <ul class="zoom-slider" id="gallery_01">
                                                                        <?php
                                                                        $count = count($db_upload_timagesArr);
                                                                        for ($i = 0; $i < $count; $i++) {
                                                                                ?>
                                                                                <li>
                                                                                        <a href="#" class="elevatezoom-gallery active" data-update="" data-image="<?= $brandImagesWebDir . $db_upload_mimagesArr[$i]["ImageName"] ?>" data-zoom-image="<?= $brandImagesWebDir . $db_upload_bimagesArr[$i]["ImageName"] ?>">
                                                                                                <img src="<?= $brandImagesWebDir . $db_upload_timagesArr[$i]["ImageName"] ?>" alt="zo-th-<?= $i ?>" />
                                                                                        </a>
                                                                                </li>
                                                                                <?php
                                                                        }
                                                                        ?>
                                                                </ul>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="col-sm-7 col-md-7">
                                                <form name="itemviewform" action="checkout.php" method="POST" class="itemviewform">
                                                        <?php
                                                        /*
                                                        *상품 정보 추가goods 시작
                                                         * 옵션종류 (0:단일옵션, 1:가격선택옵션, 2:필수구성옵션, 4:추가구성옵션, 5:입력형옵션) bit연산
                                                         * goods_opt_type
                                                         * 별도배송상품 여부
                                                         * goods_dlv_special
                                                         * 배송정책 - 1:무료, 2:고정금액, 3:착불, 4:주문금액별차등, 5:무게별차등, 6:부피별차등, 7:수량비례
                                                         * goods_dlv_type
                                                         * 배송비
                                                         * goods_dlv_fee
                                                         * 배송상세유형의 단위
                                                         * goods_dlv_unit
                                                         * 배송상세유형의 부가정보(부피,무게)
                                                         * goods_dlv_value
                                                         *적립금
                                                         * goods_mile
                                                         *적립금형태 (mileage type) - 0:% ,1:원
                                                         * goods_mile_flag
                                                         */
                                                        $db->query("SELECT id,goods_code,goods_opt_Num,goods_name,commonPrice,sellPrice,sb_sale,summary,comment,goods_opt_type,goods_dlv_special,goods_dlv_type,goods_dlv_fee,goods_dlv_unit,goods_dlv_value,goods_mile,goods_mile_flag FROM goods WHERE goods_code='$goods_code'");
                                                        $db_goodsArr = $db->loadRows();
                                                        $goods_dlv_special = $db_goodsArr[0]["goods_dlv_special"];
                                                        $goods_dlv_fee = $db_goodsArr[0]["goods_dlv_fee"];//배송비
                                                        $goods_dlv_type = $db_goodsArr[0]["goods_dlv_type"];//배송정책
                                                        $goods_mile = $db_goodsArr[0]["goods_mile"];//적립금
                                                        $goods_mile_flag = $db_goodsArr[0]["goods_mile_flag"];//적립금형태 (mileage type) - 0:% ,1:원
                                                        $sb_sale = (100 - $db_goodsArr[0]["sb_sale"]) / 100;
                                                        if ($goods_mile_flag == "0") {
                                                                $goods_mile_flag = "%";
                                                        } else {
                                                                $goods_mile_flag = "P";
                                                        }
                                                        if ($goods_dlv_special == "0") {
                                                                $goods_dlv_special = "일반배송";
                                                                if ($goods_dlv_fee == "0") {
                                                                        $goods_dlv = "무료";
                                                                } else {
                                                                        $goods_dlv = "고정금액(선불) " . number_format($goods_dlv_fee);
                                                                }
                                                        } else {
                                                                $goods_dlv_special = "별도배송";
                                                                switch ($goods_dlv_type) {
                                                                        case 0:
                                                                                $goods_dlv = "무료";
                                                                                break;
                                                                        case 1:
                                                                                $goods_dlv = "고정금액(선불) " . number_format($goods_dlv_fee) . "원";
                                                                                break;
                                                                        case 2:
                                                                                $goods_dlv = "착불 (" . number_format($goods_dlv_fee) . "원)";
                                                                                break;
                                                                        case 3:
                                                                                $goods_dlv = "주문금액별 차등 (" . number_format($goods_dlv_fee) . "원)";
                                                                                break;
                                                                        case 4:
                                                                                $goods_dlv = "무게별 차등 (" . number_format($goods_dlv_fee) . "원)";
                                                                                break;
                                                                        case 5:
                                                                                $goods_dlv = "부피별 차등 (" . number_format($goods_dlv_fee) . "원)";
                                                                                break;
                                                                        case 6:
                                                                                $goods_dlv = "수량비례 적용 (" . number_format($goods_dlv_fee) . "원)";
                                                                                break;
                                                                }
                                                        }
                                                        ?>
                                                        <input type="hidden" value="<?= $db_goodsArr[0]["sellPrice"] ?>" class="pric1">
                                                        <input type="hidden" value="<?= $goods_code ?>" class="code">
                                                        <input type="hidden" value="<?= $db_goodsArr[0]["goods_name"] ?>" class="goods_name">
                                                        <input type="hidden" value="<?= $db_goodsArr[0]["goods_opt_type"] ?>" class="goods_opt_type">
                                                        <input type="hidden" name="goods_code" value="<?= $db_goodsArr[0]["goods_code"] ?>" class="goods_code">
                                                        <input type="hidden" value="<?= $db_goodsArr[0]["goods_opt_Num"] ?>" class="optNum">
                                                        <div class="prod-list-detail">
                                                                <div class="prod-info">
                                                                        <h2 class="pro-name"><?= $db_goodsArr[0]["goods_name"] ?></h2>
                                                                        <div class="price-box">
                                                                                <div class="price">
                                                                                        <span> 판매가 ₩
                                                                                                <span class="pric2"><?= number_format($db_goodsArr[0]["sellPrice"] * $sb_sale) ?></span>
                                                                                        </span>
                                                                                </div>
                                                                                <div class="old-price">
                                                                                        <span> 시중가 ₩<?= number_format($db_goodsArr[0]["commonPrice"]) ?></span>
                                                                                </div>
                                                                        </div>
                                                                        <div class="rating">
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star-half-o"></i>
                                                                                <i class="fa fa-star-half-o"></i>
                                                                        </div>
                                                                        <div class="col-xs-12 col-md-12 blog no-padding">
                                                                                <div class="sin-post-info" style="padding:0px;margin:0px;">
                                                                                        <div class="blog-meta-small no-margin">
                                                                                                <div class="blog-post-date">
                                                                                                        구매혀택
                                                                                                </div>
                                                                                                <span class="author">적립금 <?= number_format($goods_mile) . $goods_mile_flag ?></span>
                                                                                        </div>
                                                                                        <div class="blog-meta-small no-margin no-border-top">
                                                                                                <div class="blog-post-date">
                                                                                                        배송정책
                                                                                                </div>
                                                                                                <span class="author"><?= $goods_dlv_special ?></span>
                                                                                        </div>
                                                                                        <div class="blog-meta-small no-margin no-border-top">
                                                                                                <div class="blog-post-date">
                                                                                                        배송비
                                                                                                </div>
                                                                                                <span class="author"><?= $goods_dlv ?></span>
                                                                                        </div>
                                                                                        <div class="blog-meta-small no-margin no-border-top">
                                                                                                <div class="blog-post-date">
                                                                                                        판매자
                                                                                                </div>
                                                                                                <span class="author">블루스타</span>
                                                                                        </div>
                                                                                        <div class="blog-meta-small no-margin no-border-top">
                                                                                                <div class="blog-post-date">
                                                                                                        상품코드
                                                                                                </div>
                                                                                                <span class="author"><?= $db_goodsArr[0]["goods_code"] ?></span>
                                                                                        </div>
                                                                                        <div class="blog-summary bd_bottom" style="margin-bottom:5px;">
                                                                                                <p><?= $db_goodsArr[0]["summary"] ?></p>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <?
                                                                        if ($db_goodsArr[0]["goods_opt_type"] != "0") {
                                                                                ?>
                                                                                <div class="col-md-12" style="padding:0px;">
                                                                                        <div class="country-select" style="margin-bottom:0px;">
                                                                                                <?php
                                                                                                //일반옵션
                                                                                                if ($db_goodsArr[0]["goods_opt_type"] == "1") {
                                                                                                        $db->query("SELECT * FROM goods_option_single_value WHERE goods_code='$goods_code' ORDER BY id asc");
                                                                                                        $goods_option_single_value_Query = $db->loadRows();
                                                                                                        $count = count($goods_option_single_value_Query);
                                                                                                        for ($i = 0; $i < $count; $i++) {
                                                                                                                $goods_option_single_vlaue_opName1 = $goods_option_single_value_Query[$i]["opName1"];
                                                                                                                $goods_option_single_vlaue_opName2 = $goods_option_single_value_Query[$i]["opName2"];
                                                                                                                $goods_option_single_vlaue_sellPrice = $goods_option_single_value_Query[$i]["sellPrice"] * $sb_sale;
                                                                                                                $goods_option_single_vlaue_quantity = $goods_option_single_value_Query[$i]["quantity"];
                                                                                                                $goods_option_single_vlaue_id = $goods_option_single_value_Query[$i]["id"];
                                                                                                                if ($i == 0) {
                                                                                                                        $goods_option_single_vlaue_opName1Tmp = $goods_option_single_vlaue_opName1;
                                                                                                                        $option = '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem"><option>' . $goods_option_single_vlaue_opName1 . '</option>';
                                                                                                                        if ($goods_option_single_vlaue_quantity == "0") {
                                                                                                                                $option .= '<option disabled>' . $goods_option_single_vlaue_opName2 . ' 품절</option>';
                                                                                                                        } else {
                                                                                                                                $option .= '<option  data="' . $goods_option_single_vlaue_id . '" value="' . $goods_option_single_vlaue_sellPrice . '" data1="' . $goods_option_single_vlaue_opName1 . '" data2="' . $goods_option_single_vlaue_opName2 . '">' . $goods_option_single_vlaue_opName2 . " (" . number_format($goods_option_single_vlaue_sellPrice) . '원)</option>';
                                                                                                                        }
                                                                                                                } else {
                                                                                                                        if ($goods_option_single_vlaue_opName1Tmp != $goods_option_single_vlaue_opName1) {
                                                                                                                                $goods_option_single_vlaue_opName1Tmp = $goods_option_single_vlaue_opName1;
                                                                                                                                $option .= '</select>';
                                                                                                                                $option .= '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem"><option>' . $goods_option_single_vlaue_opName1 . '</option>';
                                                                                                                                if ($goods_option_single_vlaue_quantity == "0") {
                                                                                                                                        $option .= '<option disabled>' . $goods_option_single_vlaue_opName2 . ' 품절</option>';
                                                                                                                                } else {
                                                                                                                                        $option .= '<option data="' . $goods_option_single_vlaue_id . '" value="' . $goods_option_single_vlaue_sellPrice . '"  data1="' . $goods_option_single_vlaue_opName1 . '" data2="' . $goods_option_single_vlaue_opName2 . '">' . $goods_option_single_vlaue_opName2 . " (" . number_format($goods_option_single_vlaue_sellPrice) . '원)</option>';
                                                                                                                                }
                                                                                                                        } else {
                                                                                                                                if ($goods_option_single_vlaue_quantity == "0") {
                                                                                                                                        $option .= '<option disabled>' . $goods_option_single_vlaue_opName2 . ' 품절</option>';
                                                                                                                                } else {
                                                                                                                                        $option .= '<option data="' . $goods_option_single_vlaue_id . '" value="' . $goods_option_single_vlaue_sellPrice . '" data1="' . $goods_option_single_vlaue_opName1 . '" data2="' . $goods_option_single_vlaue_opName2 . '">' . $goods_option_single_vlaue_opName2 . " (" . number_format($goods_option_single_vlaue_sellPrice) . '원)</option>';
                                                                                                                                }
                                                                                                                        }
                                                                                                                }
                                                                                                        }
                                                                                                        echo $option . "</select>";
                                                                                                } else {
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
                                                                                                                        $option = '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem' . $k . '"><option>' . $goods_opName1 . '</option>';
                                                                                                                        $option .= '<option value="" data="">' . $goods_opName2 . '</option>';
                                                                                                                        $k++;
                                                                                                                } else {
                                                                                                                        if ($goods_opName1Tmp != $goods_opName1) {
                                                                                                                                $mod = true;
                                                                                                                                $goods_opName1Tmp = $goods_opName1;
                                                                                                                                $option .= '</select>';
                                                                                                                                $option .= '<select style="height:20px;font-size:12px;" name="bsitem" class="bsitem' . $k . '"><option value="" data="">' . $goods_opName1 . '</option>';
                                                                                                                                $k++;
                                                                                                                        } else {
                                                                                                                                if ($mod == false) {
                                                                                                                                        $option .= '<option value="" data="">' . $goods_opName2 . '</option>';
                                                                                                                                }
                                                                                                                        }
                                                                                                                }
                                                                                                        }
                                                                                                        echo $option . "</select>";
                                                                                                }
                                                                                                ?>

                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-12" style="border-bottom:1px dotted #aaa;margin:5px 0px;"></div>
                                                                                <div class="col-md-12" style="padding: 0px;">
                                                                                        -추가구매를 원하시면 추가옵션을 선택하세요
                                                                                </div>
                                                                                <div class="col-md-12" style="border-bottom:1px dotted #aaa;margin:5px 0px;"></div>
                                                                                <div class="col-md-12" style="padding:0px;">
                                                                                        <?
                                                                                        /* 추가옵션 시작 */
                                                                                        ?>
                                                                                        <div class="col-md-12" style="padding: 0px;">
                                                                                                <div class="country-select" style="margin-bottom:10px;">
                                                                                                        <?php
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
                                                                                                        echo $option_select . "</select>"
                                                                                                        ?>
                                                                                                </div>
                                                                                        </div>
                                                                                        <?php
                                                                                        //}
                                                                                        ?>
                                                                                        <!--PRODUCT INCREASE BUTTON START-->
                                                                                </div><!--PRODUCT INCREASE BUTTON END-->
                                                                                <div class="col-md-12" style="border-bottom:1px dotted #aaa;margin:5px 0px 15px 0px;"></div><!-- 메인상품 추가 폼 시작-->
                                                                                <div class="col-md-12 m-item"></div><!-- 메인상품 추가 폼 끝--><!-- 서브상품 추가 폼 시작-->
                                                                                <div class="s-item"></div><!-- 서브상품 추가 폼 끝-->
                                                                                <div class="col-md-12" style="margin:5px 0px 0px 0px;"></div><!-- 토탈 폼 시작-->
                                                                                <div class="col-md-12 total">
                                                                                        <div class="col-md-6 cm6">
                                                                                                <span style="font-size:12px;font-weight:bold;color:#333;">총 합계금액</span>
                                                                                                <span style="font-size:12px;color:#000;">(수량)</span>
                                                                                        </div>
                                                                                        <div class="col-md-6 cm6" style="text-align:right;">
                                                                                                <span class="totalSum" data="0" style="font-size:17px;color:#e26a6a;font-weight:bold;">0
                                                                                                </span>
                                                                                                <span style="color:#e26a6a;">원(
                                                                                                        <span class="totalNum">0</span>
                                                                                                        개)
                                                                                                </span>
                                                                                        </div>
                                                                                </div><!-- 토탈폼 끝-->
                                                                                <div class="col-md-12" style="margin:0px 0px 35px 0px;"></div>

                                                                                <div class="actions" style="text-align: right;">
                                                                                        <span class="pro-add-to-cart">
                                                                                                <button type="button" class="addbasket btn btn-danger waves-effect waves-light" data="item_<?php echo $goods_code ?>">Add To Cart
                                                                                                </button>
                                                                                        </span>
                                                                                        <span class="pro-buy-no">
                                                                                                <button type="button" class="buynow btn btn-purple waves-effect waves-light">Buy Now
                                                                                                </button>
                                                                                        </span>
                                                                                </div>
                                                                                <?
                                                                        }
                                                                        if ($db_goodsArr[0]["goods_opt_type"] == "0") {
                                                                                ?>
                                                                                <div class="col-md-12 m-item">
                                                                                        <div class="col-md-12 cm12 option_box">
                                                                                                <div class="col-md-12" style="margin:5px 0px;"></div>
                                                                                                <input type="hidden" name="itemid" value="<?php echo $db_goodsArr[0]["id"] ?>">
                                                                                                <div class="col-md-6 cm12" style="padding:0px;"></div>
                                                                                                <div class="col-md-3 cm6" style="padding:0px;">
                                                                                                        <div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">
                                                                                                                <i class="fa fa-minus item-minus"></i>
                                                                                                        </div>
                                                                                                        <div class="col-md-4 cm4" style="padding:0px;text-align:center;">
                                                                                                                <input type="text" name="itemnum" class="item_num" value="1">
                                                                                                        </div>
                                                                                                        <div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;">
                                                                                                                <i class="fa fa-plus item-plus"></i>
                                                                                                        </div>
                                                                                                </div>
                                                                                                <div class="col-md-3 cm6" style="text-align:right;padding:0px;">
                                                                                                        <span data="<?= $db_goodsArr[0]["sellPrice"] * $sb_sale ?>" class="sub_pric"><?= number_format($db_goodsArr[0]["sellPrice"] * $sb_sale) ?></span>
                                                                                                        <span style="color:#e26a6a;">원</span>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>

                                                                                <div class="col-xs-12 col-md-12 total" style="display: inline;">
                                                                                        <div class="col-md-6 cm6">
                                                                                                <span style="font-size:12px;font-weight:bold;color:#333;">총 합계금액</span>
                                                                                                <span style="font-size:12px;color:#000;">(수량)</span>
                                                                                        </div>
                                                                                        <div class="col-md-6 cm6" style="text-align:right;">
                                                                                                <span class="totalSum" data="<?= $db_goodsArr[0]["sellPrice"] * $sb_sale ?>" style="font-size:17px;color:#e26a6a;font-weight:bold;"><?= number_format($db_goodsArr[0]["sellPrice"] * $sb_sale) ?></span>
                                                                                                <span style="color:#e26a6a;">원(
                                                                                                        <span class="totalNum">1</span>
                                                                                                        개)
                                                                                                </span>
                                                                                        </div>
                                                                                </div>

                                                                                <div class="actions" style="text-align: right;">
                                                                                        <span class="pro-add-to-cart">
                                                                                                <button type="button" class="addbasket btn btn-danger waves-effect waves-light" data="item_<?= $goods_code ?>">Add To Cart
                                                                                                </button>
                                                                                        </span>
                                                                                        <span class="pro-buy-no">
                                                                                                <button type="button" class="buynow btn btn-purple waves-effect waves-light">Buy Now</button>
                                                                                        </span>
                                                                                </div>
                                                                                <?
                                                                        }
                                                                        ?>
                                                                        <div class="actions product-wish-compare" style="text-align: right;">
                                                                                <span>
                                                                                        <a href="#" data-toggle="tooltip" title="Add to wishlist">
                                                                                                <i class="fa fa-heart-o"></i>
                                                                                                <span>add to wishlist</span>
                                                                                        </a>
                                                                                </span>
                                                                        </div>
                                                                        <span class="prod-meta">
                                                                                <strong>CATEGORY :</strong>
                                                                                <a href="#"> Health and Beauty</a>
                                                                        </span>
                                                                        <div class="social-icon">
                                                                                <img src="img/social.jpg" alt="">
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </form>
                                        </div>
                                </div>
                                <? include_once("itemViewRight.php") ?>
                        </div>
                </div>
        </section>
        <!--SINGLE PRODUCT AREA END-->
        <!--PRODUCT REVIEW AREA START-->
        <div class="product-review-area">
                <div class="container-fluid">
                        <div class="row">
                                <div class="col-md-12">
                                        <div class="review-wrapper">
                                                <ul class="review-menu">
                                                        <li class="active">
                                                                <a data-toggle="tab" href="#pr-description">상품상세정보</a>
                                                        </li>
                                                        <li>
                                                                <?php
                                                                $db->query("SElECT * FROM tbl_bbs WHERE qna_mod='2' AND goods_code='$goods_code'");
                                                                $db_tbl_qna_query = $db->loadRows();
                                                                $count = count($db_tbl_qna_query);
                                                                ?>
                                                                <a data-toggle="tab" href="#pr-reviews">리뷰어(<?=$count?>)</a>
                                                        </li>
                                                </ul>
                                                <div class="con tab-content">
                                                        <!-- 상품 상세정보 -->
                                                        <div id="pr-description" class="tab-pane fade in active">
                                                                <?= $db_goodsArr[0]["comment"] ?>
                                                        </div>
                                                        <div id="pr-reviews" class="tab-pane fade">
                                                                <!-- 유저 리뷰어 -->
                                                                <div class="product-comment">
                                                                        <?php
                                                                        for($i=0;$i<$count;$i++){
                                                                                $bbs_ext1 = $db_tbl_qna_query[$i]["bbs_ext1"];
                                                                                $user_id = $db_tbl_qna_query[$i]["user_id"];
                                                                                $comment = $db_tbl_qna_query[$i]["comment"];
                                                                                $qna_reg_date = date("Y.m.d",strtotime($db_tbl_qna_query[$i]["qna_reg_date"]));
                                                                        ?>
                                                                        <div class="comment-a">
                                                                                <img src="img/user-1.jpg" alt="">
                                                                                <div class="comment-text">
                                                                                        <div class="rating">
                                                                                                <?php
                                                                                                for($j=0;$j<$bbs_ext1;$j++){
                                                                                                        echo '<i class="fa fa-star"></i>';
                                                                                                }
                                                                                                ?>
                                                                                        </div>
                                                                                        <p class="meta">
                                                                                                <strong><?=$user_id?></strong> &ndash; <?=$qna_reg_date?>
                                                                                        </p>
                                                                                        <div class="pro-com-des">
                                                                                                <p>
                                                                                                        <?=nl2br($comment)?>
                                                                                                </p>
                                                                                        </div>
                                                                                </div>
                                                                        </div>
                                                                        <?
                                                                        }
                                                                        ?>
                                                                        <div class="add-review">
                                                                                <form name="form-review" method="post" class="form-review" action="goodsReview.php" target="action_frame">
                                                                                        <input type="hidden" name="goods_code" value="<?=$goods_code?>">
                                                                                        <p class="comment-form-rating">
                                                                                        <fieldset class="rating">
                                                                                                <input type="radio" id="star5" name="rating" value="5" />
                                                                                                <label for="star5" title="Rocks!"></label>
                                                                                                <input type="radio" id="star4" name="rating" value="4" />
                                                                                                <label for="star4" title="Pretty good"></label>
                                                                                                <input type="radio" id="star3" name="rating" value="3" />
                                                                                                <label for="star3" title="Meh"></label>
                                                                                                <input type="radio" id="star2" name="rating" value="2" />
                                                                                                <label for="star2" title="Kinda bad"></label>
                                                                                                <input type="radio" id="star1" name="rating" value="1" checked />
                                                                                                <label for="star1" title="Sucks big time"></label>
                                                                                        </fieldset>
                                                                                        </p>
                                                                                        <p class="product-form-comment">
                                                                                                <textarea aria-required="true"  name="review_com" class="review_com"></textarea>
                                                                                        </p>
                                                                                        <p class="form-submit">
                                                                                                <input value="등록 " type="button" class="submit btn_review">
                                                                                        </p>
                                                                                </form>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
        <iframe name="action_frame" width="600" height="300" style="display: none;" ></iframe>
        <!--PRODUCT REVIEW AREA END-->
        <!--FOOTER AREA START-->
        <? include_once("footer.php") ?>
        <!--FOOTER AREA END-->
        <!-- JS START-->
        <? include_once("js.php") ?>
        <!-- JS END -->
        <script type="text/javascript">
                $(document).ready(function () {
                        /* 추가옵션 토탈추가 시작 */
                        $(".bsoption").on('change', function () {
                                var selVal = $(this, 'option:selected').val();
                                total_sum = $(".totalSum").attr("data");
                                if (!selVal) {
                                        return false;
                                }
                                var data = $(this).find("option:selected").attr("data");
                                var itemName = $(this).find("option:selected").text();
                                for (var i = 0; i < addOPItemArr.length; i++) {
                                        if (addOPItemArr[i] == data) {
                                                alert("이미 추가된 상품 입니다.");
                                                $(".bsoption").get(i).selectedIndex = 0;
                                                return false;
                                        }
                                }
                                if (total == false) {
                                        $(".total").css("display", "block");
                                        total = true;
                                }
                                addOPItemArr.unshift(data);//unshift      데이터를 배열 첫번째에 넣어준다.
                                opnumArr.unshift("1");//옵션 상품 구매개수
                                total_num = $(".totalNum").text();
                                total_num = parseInt(total_num) + 1;
                                total_sum = parseInt(selVal) + parseInt(total_sum);
                                $(".totalSum").text(formatNumber(total_sum));
                                $(".totalSum").attr("data", total_sum);
                                $(".totalNum").text(total_num);
                                var rHtm = '<div class="col-md-12 cm12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div>' +
                                        '<input type="hidden" name="opid[]" value="' + data + '">' +
                                        '<div class="col-md-6 cm12" style="padding:0px;">' + itemName + '</div>' +
                                        '<div class="col-md-3 cm6"  style="padding:0px;">' +
                                        '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;"><i class="fa fa-minus item-minus"></i></div>' +
                                        '<div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="opnum[]" class="item_num" value="1"></div>' +
                                        '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;"><i class="fa fa-plus item-plus"></i></div>' +
                                        '</div>' +
                                        '<div class="col-md-3 cm6"  style="text-align:right;padding:0px;">' +
                                        '<span data="' + selVal + '" class="sub_pric">' + formatNumber(selVal) + '</span>' +
                                        '<span style="color:#e26a6a;">원</span>' +
                                        '<i data-toggle="tooltip" data-original-title="삭제" class="fa fa-trash-o"></i>' +
                                        '</div>' +
                                        '</div>';

                                $(".s-item").append(rHtm);
                                $('.s-item').on('click', '.fa-trash-o', function (e) {
                                        var id = $(this).parent().parent().find("input:first").val();
                                        if (id == "no") {
                                                return false;
                                        }
                                        $(this).parent().parent().find("input:first").val("no");
                                        var total_sum = $(".totalSum").attr("data");
                                        var sub_pric = $(this).parent().parent().find(".sub_pric").attr("data");
                                        var sub_str = $(this).parent().parent().find(".item_num").val();
                                        $(this).parent().parent().remove();
                                        for (var i = 0; i < addOPItemArr.length; i++) {
                                                if (addOPItemArr[i] == id) {
                                                        addOPItemArr.splice(i, 1);
                                                        opnumArr.splice(i, 1);
                                                }
                                        }
                                        total_sum = parseInt(total_sum);
                                        total_num = addItemArr.length + addOPItemArr.length;
                                        var total_fsum = total_sum - parseInt(sub_pric) * parseInt(sub_str);
                                        $(".totalSum").text(formatNumber(total_fsum));
                                        $(".totalSum").attr("data", total_fsum);
                                        $(".totalNum").text(total_num);
                                        if (total_num == 0) {
                                                $(".total").css("display", "none");
                                                total = false;
                                        }

                                });
                        });
                        $(".s-item").on('click', '.item-plus', function () {
                                var id = $(this).parent().parent().parent().find("input:first").val();
                                var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
                                var total_sum = $(".totalSum").attr("data");
                                var total_sum_tmp = parseInt(total_sum);
                                var obj = $(this).parent().parent().find(".item_num");
                                var str = obj.val();
                                var sub_pric_tmp = parseInt(sub_pric);
                                var str2 = 0;
                                var str3 = 0;
                                str = parseInt(str) + 1;
                                obj.val(str);
                                $(".s-item").find(".item_num").each(function (i) {
                                        str2 = parseInt(str2) + parseInt($(this).val());
                                });
                                $(".m-item").find(".item_num").each(function (i) {
                                        str3 = parseInt(str3) + parseInt($(this).val());
                                });
                                $(".totalNum").text(parseInt(str2) + parseInt(str3));
                                for (var i = 0; i < addOPItemArr.length; i++) {
                                        if (addOPItemArr[i] == id) {
                                                opnumArr.splice(i, 1, str);
                                        }
                                }
                                sub_pric = parseInt(sub_pric);
                                total_sum = parseInt(total_sum) + sub_pric_tmp;
                                $(".totalSum").text(formatNumber(total_sum));
                                $(".totalSum").attr("data", total_sum);

                        });
                        $(".s-item").on('click', '.item-minus', function () {
                                var id = $(this).parent().parent().parent().find("input:first").val();
                                var str = $(this).parent().parent().find(".item_num").val();
                                var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
                                var total_sum = $(".totalSum").attr("data");
                                var str2 = 0;
                                var str3 = 0;
                                if (parseInt(str) > 1) {
                                        str = parseInt(str) - 1;
                                        $(this).parent().parent().find(".item_num").val(str);
                                        sub_pric = parseInt(sub_pric);
                                        total_sum = parseInt(total_sum) - sub_pric;
                                        $(".totalSum").text(formatNumber(total_sum));
                                        $(".totalSum").attr("data", total_sum);
                                        $(".s-item").find(".item_num").each(function (i) {
                                                str2 = parseInt(str2) + parseInt($(this).val());
                                        });
                                        $(".m-item").find(".item_num").each(function (i) {
                                                str3 = parseInt(str3) + parseInt($(this).val());
                                        });
                                        $(".totalNum").text(parseInt(str2) + parseInt(str3));
                                        for (var i = 0; i < addOPItemArr.length; i++) {
                                                if (addOPItemArr[i] == id) {
                                                        opnumArr.splice(i, 1, str);
                                                }
                                        }
                                } else {
                                        $(this).parent().parent().find(".item_num").val("1");
                                        for (var i = 0; i < addOPItemArr.length; i++) {
                                                if (addOPItemArr[i] == id) {
                                                        opnumArr.splice(i, 1, "1");
                                                }
                                        }
                                }
                        });
                        /* 추가옵션 토탈추가  끝 */

                        /* 메인상품 토탈추가 시작 */
                        $("select[name=bsitem]").on("change", function () {
                                var goods_opt_type = $(".goods_opt_type").val();
                                var goods_code = $(".goods_code").val();
                                var optNum = $(".optNum").val();
                                if (goods_opt_type == "1") {
                                        //일반옵션
                                        var mod = $(this)[0].selectedIndex;
                                        var selVal = $(this, 'option:selected').val();
                                        if (mod != 0) {
                                                var data1 = $(this).find("option:selected").attr("data");
                                                var data2 = $(this).find("option:selected").attr("data1");
                                                var data3 = $(this).find("option:selected").attr("data2");
                                        } else {
                                                return false;
                                        }
                                } else {
                                        //가격선택옵션
                                        var optNum = $(".optNum").val();
                                        var cls = $(this).attr("class");
                                        var mod = $(this)[0].selectedIndex;
                                        if (optNum == "2") {
                                                //가격선택옵션2
                                                if (mod != 0) {
                                                        if (cls == "bsitem1") {
                                                                var opVal = $(".bsitem2 option:eq(0)").text();
                                                                var opName = $(".bsitem1 option:selected").text();
                                                                var url = "item_viewPost.php";
                                                                var form_data = {
                                                                        goods_code: goods_code,
                                                                        optNum: optNum,
                                                                        opname1: opName,
                                                                        opVal: opVal
                                                                };
                                                                $.ajax({
                                                                        type: "POST",
                                                                        url: url,
                                                                        data: form_data,
                                                                        error: function () {
                                                                                alert("상품 선택 실패하였습니다.관리자에게 문의해주세요.");
                                                                        },
                                                                        success: function (response) {
                                                                                $(".bsitem2").empty();
                                                                                $(".bsitem2").append(response);
                                                                        }
                                                                });
                                                                return false;
                                                        } else {
                                                                var data = $(this).find("option:selected").attr("data");
                                                                var mod = $(this)[0].selectedIndex;
                                                                var selVal = $(this, 'option:selected').val();
                                                                if (mod != 0) {
                                                                        var data1 = $(this).find("option:selected").attr("data");
                                                                        var data2 = $(this).find("option:selected").attr("data1");
                                                                        var data3 = $(this).find("option:selected").attr("data2");
                                                                }
                                                        }
                                                } else {
                                                        var opVal = $(".bsitem2 option:eq(0)").text();
                                                        $(".bsitem2").empty();
                                                        var option = '<option>' + opVal + '</option>';
                                                        $(".bsitem2").append(option);
                                                        return false;
                                                }
                                        } else {
                                                //가격선택옵션3
                                                var mod = $(this)[0].selectedIndex;
                                                if (mod != 0) {
                                                        if (cls == "bsitem1") {
                                                                var i = 0;
                                                                var opVal = $(".bsitem2 option:eq(0)").text();
                                                                var opVal2 = $(".bsitem3 option:eq(0)").text();
                                                                var opName = $(".bsitem1 option:selected").text();
                                                                var url = "item_viewPost.php";
                                                                var form_data = {
                                                                        goods_code: goods_code,
                                                                        optNum: optNum,
                                                                        opname1: opName,
                                                                        opVal: opVal
                                                                };
                                                                $.ajax({
                                                                        type: "POST",
                                                                        url: url,
                                                                        data: form_data,
                                                                        error: function () {
                                                                                alert("상품 선택 실패하였습니다.관리자에게 문의해주세요.");
                                                                        },
                                                                        success: function (response) {
                                                                                $(".bsitem2").empty();//2번 옵션 비움
                                                                                $(".bsitem3").empty();//3번옵션 비움
                                                                                $(".bsitem2").append(response);
                                                                                var option = '<option>' + opVal2 + '</option>';
                                                                                $(".bsitem3").append(option);//3번 옵션 초기화
                                                                        }
                                                                });
                                                                return false;
                                                        } else if (cls == "bsitem2") {
                                                                var opVal = $(".bsitem3 option:eq(0)").text();
                                                                var opName = $(".bsitem1 option:selected").text();
                                                                var opName1 = $(".bsitem2 option:selected").text();
                                                                var url = "item_viewPost.php";
                                                                var form_data = {
                                                                        goods_code: goods_code,
                                                                        optNum: optNum,
                                                                        opname1: opName,
                                                                        opname2: opName1,
                                                                        opVal: opVal
                                                                };
                                                                $.ajax({
                                                                        type: "POST",
                                                                        url: url,
                                                                        data: form_data,
                                                                        error: function () {
                                                                                alert("상품 선택 실패하였습니다.관리자에게 문의해주세요.");
                                                                        },
                                                                        success: function (response) {
                                                                                $(".bsitem3").empty();
                                                                                $(".bsitem3").append(response);
                                                                        }
                                                                });
                                                                return false;
                                                        } else {
                                                                var data = $(this).find("option:selected").attr("data");
                                                                var mod = $(this)[0].selectedIndex;
                                                                var selVal = $(this, 'option:selected').val();
                                                                if (mod != 0) {
                                                                        var data1 = $(this).find("option:selected").attr("data");
                                                                        var data2 = $(this).find("option:selected").attr("data1");
                                                                        var data3 = $(this).find("option:selected").attr("data2");
                                                                        var data4 = $(this).find("option:selected").attr("data3");
                                                                }
                                                        }
                                                } else {
                                                        var opVal1 = $(".bsitem2 option:eq(0)").text();
                                                        var opVal2 = $(".bsitem3 option:eq(0)").text();
                                                        $(".bsitem2").empty();
                                                        $(".bsitem3").empty();
                                                        var option = '<option>' + opVal1 + '</option>';
                                                        $(".bsitem2").append(option);
                                                        var option = '<option>' + opVal2 + '</option>';
                                                        $(".bsitem3").append(option);//3번 옵션 초기화
                                                        return false;
                                                }
                                        }
                                }

                                if (goods_opt_type == "1") {
                                        var cv = goods_code + "_" + data1 + "_" + data2;
                                } else if (goods_opt_type = "2") {
                                        if (optNum == "2") {
                                                var cv = goods_code + "_" + data1 + "_" + data2;
                                        } else {
                                                var cv = goods_code + "_" + data1 + "_" + data2 + "_" + data3;
                                        }
                                }
                                total_sum = $(".totalSum").attr("data");
                                if (!selVal) {
                                        return false;
                                }
                                if (total == false) {
                                        $(".total").css("display", "block");
                                        total = true;
                                }
                                if (data4 == undefined) {
                                        data4 = "";
                                }
                                var data = $(this).find("option:selected").attr("data");
                                if (data4 == "") {
                                        var itemName = data2 + " - " + data3;
                                } else {
                                        var itemName = data2 + " - " + data3 + "-" + data4;
                                }

                                for (var i = 0; i < addItemArr.length; i++) {
                                        if (addItemArr[i] == data) {
                                                alert("이미 추가된 상품 입니다.");
                                                return false;
                                        }
                                }
                                addItemArr.unshift(data);//unshift      데이터를 배열 첫번째에 넣어준다.
                                itemnumArr.unshift("1");//메인상품 구매 개수
                                total_sum = parseInt(selVal) + parseInt(total_sum);
                                total_num = $(".totalNum").text();
                                total_num = parseInt(total_num) + 1;
                                $(".totalSum").text(formatNumber(total_sum));
                                $(".totalSum").attr("data", total_sum);
                                $(".totalNum").text(total_num);
                                var rHtm = '<div class="col-md-12 cm12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div>' +
                                        '<input type="hidden" name="itemid[]" value="' + data + '" data="' + cv + '">' +
                                        '<div class="col-md-6 cm12" style="padding:0px;">' + itemName + '</div>' +
                                        '<div class="col-md-3 cm6"  style="padding:0px;">' +
                                        '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-minus item-minus"></i></div>' +
                                        '<div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="itemnum[]" class="item_num" value="1"></div>' +
                                        '<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;"><i class="fa fa-plus item-plus"></i></div>' +
                                        '</div>' +
                                        '<div class="col-md-3 cm6"  style="text-align:right;padding:0px;">' +
                                        '<span data="' + selVal + '" class="sub_pric">' + formatNumber(selVal) + '</span>' +
                                        '<span style="color:#e26a6a;">원</span>' +
                                        '<i data-toggle="tooltip" data-original-title="삭제" class="fa fa-trash-o"></i>' +
                                        '</div>' +
                                        '</div>';
                                $(".m-item").append(rHtm);

                                $('.m-item').on('click', '.fa-trash-o', function (e) {
                                        var id = $(this).parent().parent().find("input:first").val();
                                        if (id == "no") {
                                                return false;
                                        }
                                        $(this).parent().parent().find("input:first").val("no");
                                        for (var i = 0; i < addItemArr.length; i++) {
                                                if (addItemArr[i] == id) {
                                                        addItemArr.splice(i, 1);
                                                        itemnumArr.splice(i, 1);
                                                }
                                        }
                                        var total_sum = $(".totalSum").attr("data");
                                        var sub_pric = $(this).parent().parent().find(".sub_pric").attr("data");
                                        var sub_str = $(this).parent().parent().find(".item_num").val();
                                        total_sum = parseInt(total_sum);
                                        total_num = addItemArr.length + addOPItemArr.length;
                                        var total_fsum = total_sum - parseInt(sub_pric) * parseInt(sub_str);
                                        $(".totalSum").text(formatNumber(total_fsum));
                                        $(".totalSum").attr("data", total_fsum);
                                        $(".totalNum").text(total_num);
                                        if (total_num == 0) {
                                                $(".total").css("display", "none");
                                                total = false;
                                        }
                                        $(this).parent().parent().remove();
                                });
                        });
                        $(".m-item").on('click', '.item-plus', function () {
                                var id = $(this).parent().parent().parent().find("input:first").val();
                                var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
                                var total_sum = $(".totalSum").attr("data");
                                var obj = $(this).parent().parent().find(".item_num");
                                var str = obj.val();
                                sub_pric = parseInt(sub_pric);
                                var str2 = 0;
                                var str3 = 0;
                                str = parseInt(str) + 1;
                                obj.val(str);
                                $(".s-item").find(".item_num").each(function (i) {
                                        str2 = parseInt(str2) + parseInt($(this).val());
                                });
                                $(".m-item").find(".item_num").each(function (i) {
                                        str3 = parseInt(str3) + parseInt($(this).val());
                                });
                                $(".totalNum").text(parseInt(str2) + parseInt(str3));
                                for (var i = 0; i < addItemArr.length; i++) {
                                        if (addItemArr[i] == id) {
                                                itemnumArr.splice(i, 1, str);
                                        }
                                }
                                if (total_sum == undefined) {
                                        total_sum = 0;
                                }
                                total_sum = parseInt(total_sum) + sub_pric;
                                $(".totalSum").text(formatNumber(total_sum));
                                $(".totalSum").attr("data", total_sum);
                        });
                        $(".m-item").on('click', '.item-minus', function () {
                                var id = $(this).parent().parent().parent().find("input:first").val();
                                var str = $(this).parent().parent().find(".item_num").val();
                                var sub_pric = $(this).parent().parent().parent().find(".sub_pric").attr("data");
                                var total_sum = $(".totalSum").attr("data");
                                var str2 = 0;
                                var str3 = 0;
                                if (parseInt(str) > 1) {
                                        str = parseInt(str) - 1;
                                        $(this).parent().parent().find(".item_num").val(str);
                                        sub_pric = parseInt(sub_pric);
                                        total_sum = parseInt(total_sum) - sub_pric;
                                        $(".totalSum").text(formatNumber(total_sum));
                                        $(".totalSum").attr("data", total_sum);
                                        $(".s-item").find(".item_num").each(function (i) {
                                                str2 = parseInt(str2) + parseInt($(this).val());
                                        });
                                        $(".m-item").find(".item_num").each(function (i) {
                                                str3 = parseInt(str3) + parseInt($(this).val());
                                        });
                                        $(".totalNum").text(parseInt(str2) + parseInt(str3));
                                        for (var i = 0; i < addItemArr.length; i++) {
                                                if (addItemArr[i] == id) {
                                                        itemnumArr.splice(i, 1, str);
                                                }
                                        }
                                } else {
                                        $(this).parent().parent().find(".item_num").val("1");
                                        for (var i = 0; i < addItemArr.length; i++) {
                                                if (addItemArr[i] == id) {
                                                        itemnumArr.splice(i, 1, "1");
                                                }
                                        }
                                }
                        });
                        /* 메인상품 토탈추가 끝 */
                        $(".buynow").click(function () {
                                var idlen = $(".m-item").find("input[type=hidden]").length;
                                var goods_opt_type = $(".goods_opt_type").val();
                                if (parseInt(goods_opt_type) > 0) {
                                        if (idlen >= 1) {
                                                $(".itemviewform").submit();
                                        } else {
                                                alert("아이템을 선택해 주세요.");
                                                return false;
                                        }
                                } else {
                                        $(".itemviewform").submit();
                                }
                        });

                        /* 숫자 포맷  */
                        function formatNumber(num, precision, separator) {
                                var parts;
                                // 判断是否为数字
                                if (!isNaN(parseFloat(num)) && isFinite(num)) {
                                        // 把类似 .5, 5. 之类的数据转化成0.5, 5, 为数据精度处理做准, 至于为什么
                                        // 不在判断中直接写 if (!isNaN(num = parseFloat(num)) && isFinite(num))
                                        // 是因为parseFloat有一个奇怪的精度问题, 比如 parseFloat(12312312.1234567119)
                                        // 的值变成了 12312312.123456713
                                        num = Number(num);
                                        // 处理小数点位数
                                        num = (typeof precision !== 'undefined' ? num.toFixed(precision) : num).toString();
                                        // 分离数字的小数部分和整数部分
                                        parts = num.split('.');
                                        // 整数部分加[separator]分隔, 借用一个著名的正则表达式
                                        parts[0] = parts[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1' + (separator || ','));
                                        return parts.join('.');
                                }
                                return NaN;
                        }

                        $(".btn_review").click(function () {
                                if ($(".review_com").val().trim() == "") {
                                        alert("리뷰어 내용이 비였습니다.");
                                        return false;
                                }
                                $(".form-review").submit();
                        });
                });
        </script>
</body></html>