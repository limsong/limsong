<?
include_once("doctype.php");
$ou_itemid = $_POST["chkitem"];
$count = count($ou_itemid);

for($i=0;$i<$count;$i++){
        if($i==$count-1){
                $addQuery .= " uid='".$ou_itemid[$i]." '";
        }else{
                $addQuery .= " uid='".$ou_itemid[$i]."' OR ";
        }
}
?>
<link href="css/shoppingcart.css" rel='stylesheet' type='text/css'>
<body class="home-1 shop-page cart-page">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
        your browser</a> to improve your experience.</p>
<![endif]-->
<!--HEADER AREA SART-->
<!--HEADER AREA END-->
<!--BREADCRUMB AREA START-->
<!--BREADCRUMB AREA END-->
<!--CART AREA START-->
<section class="cart-area-wrapper">
        <form name="cart_form" method="post" action="cart_order.php">
                <div class="container-fluid">
                        <div class="row cart-top">
                                <div class="col-md-12">
                                        <h1 class="sin-page-title"><a href="index.php" style="font-size:20px;">BLUE
                                                        START</a>  주문/결제</h1>
                                        <div class="table-responsive">
                                                <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                                <td colspan="5">상품/옵션정보</td>
                                                                <td>상품금액</td>
                                                                <td>배송비</td>
                                                        </tr>
                                                        </thead>
                                                        <?
                                                        $db->query("SELECT dShipping FROM settings");
                                                        $dbsettings = $db->loadRows();
                                                        $dShipping = $dbsettings[0][dShipping];
                                                        $db->query("SELECT uid,v_oid,goods_name,goods_code,sbid,sbnum,opid,opnum,v_amount,delivery,shipping,signdate FROM basket WHERE id='$uname' AND delivery='N' AND $addQuery ORDER BY uid DESC");
                                                        $dbdata = $db->loadRows();
                                                        foreach ($dbdata as $k => $v) {
                                                                $sbid = $v[sbid];
                                                                $sbidArr = explode(",", $sbid);
                                                                $sbnum = $v[sbnum];
                                                                $sbnumArr = explode(",", $sbnum);
                                                                $goods_code = $v[goods_code];
                                                                $shipping = $v[shipping];
                                                                if ($shipping == "N") {
                                                                        $inShipping = 0;
                                                                } else {
                                                                        $inShipping = $dShipping;
                                                                }
                                                                $basketuid = $v[uid];
                                                                $db->query("SELECT sb_sale FROM goods WHERE goods_code='$goods_code'");
                                                                $dbgoods = $db->loadRows();
                                                                $sb_sale = $dbgoods[0][sb_sale];
                                                                $sb_sale = $sb_sale / 100;
                                                                $i = 0;
                                                                foreach ($sbidArr as $a => $b) {
                                                                        if ($i == 0) {
                                                                                $sbidQuery = "WHERE id='" . $b . "'";
                                                                        } else {
                                                                                $sbidQuery .= " or id='" . $b . "'";
                                                                        }
                                                                        $i++;
                                                                }
                                                                $opid = $v[opid];
                                                                $opidArr = explode(",", $opid);
                                                                $opnum = $v[opnum];
                                                                $opnumArr = explode(",", $opnum);
                                                                $i = 0;
                                                                foreach ($opidArr as $c => $d) {
                                                                        if ($i == 0) {
                                                                                $opidQuery = "WHERE id='" . $d . "'";
                                                                        } else {
                                                                                $opidQuery .= " or id='" . $d . "'";
                                                                        }
                                                                        $i++;
                                                                }
                                                                $db->query("SELECT imageName FROM upload_timages WHERE goods_code='$goods_code' order by id asc limit 0,1");
                                                                $dbdata = $db->loadRows();
                                                                $imgScc = $brandImagesWebDir . $dbdata[0]["imageName"];
                                                                $db->query("SELECT id,goods_name,goods_code,sellPrice FROM goods_option $sbidQuery");
                                                                $dbgoods_option = $db->loadRows();
                                                                $dbgoods_optionCount = count($dbgoods_option);
                                                                $db->query("SELECT opValue1,opValue2 FROM optionValue $opidQuery");
                                                                $dboptionValue = $db->loadRows();
                                                                $dboptionValueCount = count($dboptionValue);
                                                                $rowspan = $dbgoods_optionCount + $dboptionValueCount + 1;
                                                                ?>
                                                                <tbody>
                                                                <tr>
                                                                        <td style="text-align:left;" colspan="4">
											<span style="display: inline-block;vertical-align: middle;">
												<img title="blandit blandit"
                                                                                                     width="50"
                                                                                                     height="50" alt=""
                                                                                                     src="<?= $imgScc ?>">
											</span>
											<span style="display: inline-block;vertical-align: middle;">
												<a href="item_view.php?code=<?= $goods_code ?>"><?= $v[goods_name] ?></a>
											</span>
                                                                        </td>
                                                                        <td></td>
                                                                        <td class="cross Tprice"
                                                                            rowspan="<?= $rowspan ?>"
                                                                            data-price="<?= $v[v_amount] ?>">
                                                                                <?= number_format($v[v_amount]) ?>
                                                                                원
                                                                        </td>
                                                                        <td class="cross shipping"
                                                                            data-shipping="<?= $inShipping ?>"
                                                                            rowspan="<?= $rowspan ?>">
                                                                                <?
                                                                                if ($shipping == "N") {
                                                                                        echo "0 원";
                                                                                        $total_dShipping = $total_dShipping + 0;
                                                                                } else {
                                                                                        echo number_format($inShipping) . " 원";
                                                                                        $total_dShipping = $total_dShipping + $inShipping;
                                                                                }
                                                                                ?>
                                                                        </td>
                                                                </tr>
                                                                <?
                                                                $i = 0;
                                                                foreach ($dbgoods_option as $e => $f) {
                                                                        $tmp_num += $sbnumArr[$i];
                                                                        ?>
                                                                        <tr>
                                                                                <td class="col-md-7"
                                                                                    style="text-align:left;">
                                                                                        <div class="cm7">옵션명
                                                                                                : <?= $f[goods_name] ?></div>
                                                                                </td>
                                                                                <td><?= number_format($f[sellPrice]) ?>
                                                                                        원
                                                                                </td>
                                                                                <td class="u-d">
                                                                                        <?= $sbnumArr[$i] ?>
                                                                                </td>
                                                                                <td><span class="price"
                                                                                          data-num="<?= $sbnumArr[$i] ?>"
                                                                                          data-price="<?= $f[sellPrice] ?>"
                                                                                          style="font-weight:bold;"><?= number_format($f[sellPrice] * $sbnumArr[$i]) ?>
                                                                                                원</span></td>
                                                                                <td>
                                                                                </td>
                                                                        </tr>
                                                                        <?
                                                                        $i++;
                                                                }
                                                                ?>
                                                                <?
                                                                $i = 0;
                                                                foreach ($dboptionValue as $g => $h) {
                                                                        $tmp_num += $opnumArr[$i];
                                                                        ?>
                                                                        <tr>
                                                                                <td class="col-md-7"
                                                                                    style="text-align:left;">
                                                                                        <div class="cm7">옵션명
                                                                                                : <?= $h[opValue1] ?></div>
                                                                                </td>
                                                                                <td><?= number_format($h[opValue2]) ?>
                                                                                        원
                                                                                </td>
                                                                                <td class="u-d">
                                                                                        <?= $opnumArr[$i] ?>
                                                                                </td>
                                                                                <td><span class="price"
                                                                                          data-num="<?= $opnumArr[$i] ?>"
                                                                                          data-price="<?= $h[opValue2] ?>"
                                                                                          style="font-weight:bold;"><?= number_format($h[opValue2] * $opnumArr[$i]) ?>
                                                                                                원</span></td>
                                                                                <td></td>
                                                                        </tr>
                                                                        <?
                                                                        $i++;
                                                                }
                                                                ?>
                                                                </tbody>
                                                                <?
                                                                $total_amount = $total_amount + $v[v_amount] - $v[v_amount] * $sb_sale;
                                                                $tmp_num = 0;
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
                                                                        <td style="color: #E26A6A;"><i
                                                                                        class="fa fa-krw"><i><span
                                                                                                        class="total-num"
                                                                                                        data-total="<?= $total_amount ?>"><?= number_format($total_amount) ?></span>
                                                                        </td>
                                                                </tr>
                                                                <tr class="cart-shipping">
                                                                        <td>총 배송비</td>
                                                                        <td><span></span></td>
                                                                        <td style="color: #E26A6A;">
                                                                                <i class="fa fa-krw"></i>
                                                                                <span class="ship-amount"
                                                                                      data-total="<?= $total_dShipping ?>"> <?= number_format($total_dShipping) ?>
                                                                                        원</span>
                                                                        </td>
                                                                </tr>
                                                                <tr class="order-total">
                                                                        <td>결제예정금액</td>
                                                                        <td></td>
                                                                        <td class="cart-total"><i
                                                                                        class="fa fa-krw"><i><span
                                                                                                        class="cart-totalNum"><?= number_format($total_amount + $total_dShipping) ?></span>
                                                                        </td>
                                                                </tr>
                                                        </table>
                                                        <div class="com-md-12 buttons-cart">
                                                                <input type="button" value="쇼핑 계속하기"
                                                                       class="btn btn-blue" onclick="location.href='/'">
                                                                <input type="submit" value="주문결제" class="btn btn-red">
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>
        </form>

        <!-- Modal -->
        <button type="button" style="display:none;" class="btn btn-primary btn-lg" data-toggle="modal"
                data-target="#myModal">Launch demo modal
        </button>
        <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog"
             aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
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
<? include_once("footer.php"); ?>
<!--FOOTER AREA END-->

<!-- JS -->
<? include_once("js.php"); ?>
</body>
</html>