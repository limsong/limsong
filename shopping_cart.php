<?php
    include_once ("session.php");
    include_once ("include/check.php");
    include_once("doctype.php");
    include_once("include/Mobile_Detect.php");
    $detect = new Mobile_Detect;
    if($detect->isMobile()){
        $action = "checkout_mobile.php";
    }elseif($detect->isTablet()){
        $action = "checkout_mobile.php";
    }else{
        $action = "checkout.php";
    }
?>
<link href="css/shoppingcart.css" rel='stylesheet' type='text/css'>
<body class="home-1 shop-page cart-page">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong>
        browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a>
        to improve your experience.
    </p><![endif]-->
    <!--HEADER AREA SART-->
    <!--HEADER AREA END-->
    <!--breadcrumb area start-->
    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bread-crumb">
                        <h1 class="sin-page-title" style="text-align:left;">
                            <a href="index.php" style="font-size:20px;">BLUE START</a>
                            장바구니
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumb area end-->
    <!--CART AREA START-->
    <section class="cart-area-wrapper">
        <form name="cart_form" method="post" action="<?=$action?>" class="cart_form">
            <div class="container-fluid">
                <div class="row cart-top">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="chkAllitem" checked="true">
                                        </td>
                                        <td colspan="5">상품/옵션정보</td>
                                        <td>상품금액</td>
                                        <td>배송비</td>
                                    </tr>
                                </thead>
                                <?php
                                $db->query("SELECT uid,v_oid,goods_code,sbid,sbnum,opid,opnum,signdate FROM basket WHERE id='$uname' ORDER BY uid ASC");
                                $dbdata = $db->loadRows();
                                foreach ($dbdata as $k => $v) {
                                    $sbid = $v["sbid"];
                                    $sbidArr = explode(",", $sbid);
                                    $sbnum = $v["sbnum"];
                                    $sbnumArr = explode(",", $sbnum);
                                    $goods_code = $v["goods_code"];
                                    $basketuid = $v["uid"];
                                    $i = 0;
                                    $sbidQuery = "";
                                    foreach ($sbidArr as $a => $b) {
                                        if ($b != "") {
                                            if ($i == 0) {
                                                $sbidQuery = "WHERE id IN (" . $b . "";
                                            } else {
                                                $sbidQuery .= "," . $b . "";
                                            }
                                            $i++;
                                        }
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
                                                $opidQuery .= " ," . $d . "";
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
                                    $goods_dlv_type = $goods_value_query[0]["goods_dlv_type"];//배송유형 1:
                                    $goods_dlv_fee = $goods_value_query[0]["goods_dlv_fee"];//배송비
                                    $goods_opt_type = $goods_value_query[0]["goods_opt_type"];
                                    $goods_opt_num = $goods_value_query[0]["goods_opt_num"];
                                    $goods_sellPrice = $goods_value_query[0]["sellPrice"];
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
                                            $sum += $goods_value_query[$i]["opValue2"] * $sbnumArr[$i] * $sb_sale;
                                        } else {
                                            $sum += $goods_value_query[$i]["sellPrice"] * $sbnumArr[$i] * $sb_sale;
                                        }
                                    }
                                    $goods_option = "";
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
                                    ?>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="chkitem[]" value="<?= $basketuid ?>" data-price="<?= $sum ?>" class="chkitem" checked="true">
                                            </td>
                                            <td style="text-align:left;" colspan="4">
                                                <span style="display: inline-block;vertical-align: middle;">
                                                    <img title="blandit blandit" width="50" height="50" alt="BlueStartImages" src="<?= $imgSrc ?>">
                                                </span>
                                                <?
                                                if ($goods_opt_type != "0") {
                                                    ?>
                                                    <span style="display: inline-block;vertical-align: middle;">
                                                        <a href="item_view.php?code=<?= $goods_code ?>"><?= $goods_name ?></a>
                                                        <a class="chgops" data-id="<?= $basketuid ?>" href="javascript:void(0);">선택/옵션변경
                                                        </a>
                                                    </span>
                                                    <?
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" style="font-size:15px;" class="delitem" data="<?= $basketuid ?>,all">
                                                    <i class="fa fa-times-circle"></i>
                                                </a>
                                            </td>

                                            <td class="cross Tprice" rowspan="<?= $rowspan ?>" data-price="<?= $sum ?>">
                                                <?= number_format($sum) ?>
                                                원
                                            </td>
                                            <td class="cross shipping" data-shipping="<?=$goods_dlv_fee?>" rowspan="<?= $rowspan ?>">
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
                                                $goods_sellPrice = $f["opValue2"] * $sb_sale;
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
                                                    <?= number_format($goods_sellPrice) ?> 원
                                                </td>
                                                <td class="u-d">
                                                    <div class="u-d-div">
                                                        <div class="u-d-minus">
                                                            <i data-id="<?= $basketuid ?>" class="fa fa-minus item-minus"></i>
                                                        </div>
                                                        <div class="u-d-inp-div">
                                                            <input type="text" name="itemnum[]" readonly="readonly" class="item_num" value="<?= $sbnumArr[$i] ?>">
                                                        </div>
                                                        <div class="u-d-plus">
                                                            <i data-id="<?= $basketuid ?>" class="fa fa-plus item-plus"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="price" data-num="<?= $sbnumArr[$i] ?>" data-price="<?= $goods_sellPrice ?>" style="font-weight:bold;"><?php echo number_format($goods_sellPrice * $sbnumArr[$i]); ?>
                                                        원
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" style="font-size:15px;" class="delitem" data="<?= $v['v_oid'] ?>,one,<?= $sbnumArr[$i] ?>,sb">
                                                        <i class="fa fa-times-circle"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                        $i = 0;
                                        if ($goods_opt_type != "0") {
                                            foreach ($goods_option as $oe => $of) {
                                                $goods_option_name = $of["opName1"] . "_" . $of["opName2"];
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <td class="col-md-7" style="text-align:left;">
                                                        <div class="cm7">
                                                            추가 옵션명 : <?= $goods_option_name ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?= number_format($of["opValue2"]) ?>
                                                        원
                                                    </td>
                                                    <td class="u-d">
                                                        <div class="u-d-div">
                                                            <div class="u-d-minus">
                                                                <i data-id="<?= $basketuid ?>" class="fa fa-minus item-minus"></i>
                                                            </div>
                                                            <div class="u-d-inp-div">
                                                                <input type="text" name="itemnum[]" readonly="readonly" class="item_num" value="<?= $opnumArr[$i] ?>">
                                                            </div>
                                                            <div class="u-d-plus">
                                                                <i data-id="<?= $basketuid ?>" class="fa fa-plus item-plus"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="price" data-num="<?= $opnumArr[$i] ?>" data-price="<?= $of['opValue2'] ?>" style="font-weight:bold;"><?= number_format($of['opValue2'] * $opnumArr[$i]) ?>
                                                            원
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0);" style="font-size:15px;" class="delitem" data="<?= $v['v_oid'] ?>,one,<?= $opidArr[$i] ?>,op">
                                                            <i class="fa fa-times-circle"></i>
                                                        </a>
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
                                $db->disconnect();
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row cart--bottom">
                    <div class="col-md-12">
                        <div class="col-md-4 " style="float:right;">
                            <div class="cart-total-area">
                                <h3 class="pull-right">cart-totals</h3>
                                <table style="width:100%">
                                    <tr class="cart-subtotal">
                                        <td>총 상품금액</td>
                                        <td></td>
                                        <td style="color: #E26A6A;">
                                            <i class="fa fa-krw">
                                                <i>
                                                    <span class="total-num" data-total="<?= $total_sum ?>"><?= number_format($total_sum) ?></span>
                                        </td>
                                    </tr>
                                    <tr class="cart-shipping">
                                        <td>총 배송비</td>
                                        <td>
                                            <span></span>
                                        </td>
                                        <td style="color: #E26A6A;">
                                            <i class="fa fa-krw"></i>
                                            <span class="ship-amount" data-total="<?= $total_dShipping ?>"> <?= number_format($total_dShipping) ?></span>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <td>결제예정금액</td>
                                        <td></td>
                                        <td class="cart-total">
                                            <i class="fa fa-krw">
                                                <i>
                                                    <span class="cart-totalNum"><?= number_format($total_sum + $total_dShipping) ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <div class="com-md-12 buttons-cart">
                                    <input type="button" value="쇼핑 계속하기" class="btn btn-blue" onclick="location.href='/'">
                                    <input type="button" value="주문결제" class="btn btn-red sub-go">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Modal -->
        <button type="button" style="display:none;z-index:5000;" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Launch demo modal
        </button>
        <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">선택/옵션변경</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                        <button type="button" class="btn btn-red submit">변경하기</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--CART AREA END-->
    <!--FOOTER AREA START-->

    <!--FOOTER AREA END-->

    <!-- JS -->
    <?php include_once("js.php"); ?>
    <script src="js/shoppingcart.js"></script>
</body></html>