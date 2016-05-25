<style>
        .price-box .price {
                font-size: 12px;
        }

        .zxx_text_overflow_6 {
                width: 100%;
                font-size: 12px;
        }

        .single-product h2.pro-name {
                width: 100%;
        }

        .show-img, .hide-img {
                text-align: center;
                min-height:120px;
        }

        .single-product .product-image img {
                height: auto !important;
        }

        @media (max-width: 767px) {
                .small-cat-menu {
                        margin-bottom: 15px;
                }
        }
</style>
<section class="category-area-two control-car mar-bottom">
        <div class="container-fluid">
                <div class="row">
                        <div class="cat-area-heading">
                                <?
                                $sortName = $dbdata_sortCode_sortName[1]["sortName"];
                                $sortName_first = substr($sortName, 0, 1);
                                $sortName_last = substr($sortName, 1);
                                ?>
                                <h4><strong><?= $sortName_first ?></strong><?= $sortName_last ?></h4>
                        </div>
                        <div class="col-md-3 col-lg-2">
                                <div class="small-cat-menu">
                                        <h2>
                                                <a href="m_shop.php?code1=02&name1=<?= urlencode($sortName) ?>"><?= $sortName ?></a>
                                        </h2>
                                        <ul class="cat-menu-ul">
                                                <?
                                                $db->connect();
                                                $db->query("SELECT sortName,sortCode FROM sortCodes WHERE uxCode='02' and umCode='00' ORDER BY sortOrder ASC");
                                                $db_sortCodes = $db->loadRows();
                                                foreach ($db_sortCodes as $key => $value) {
                                                        $sortCode = $value["sortCode"];
                                                        $code1 = "02";
                                                        $code2 = $sortCode;
                                                        ?>
                                                        <li class="cat-menu-li">
                                                                <a href="m_shop.php?code1=<?= $code1 ?>&code2=<?= $code2 ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>&name2=<?= urlencode($value["sortName"]) ?>"><?= $value["sortName"] ?></a>
                                                        </li>
                                                        <?
                                                }
                                                ?>
                                        </ul>
                                </div>
                        </div>
                        <div class="col-md-9 col-lg-10 no-padding">
                                <div class="hidden-xs hidden-md hidden-sm col-lg-3">
                                        <div class="single-banner">
                                                <div class="overlay"></div>
                                                <p>
                                                        <a href="m_shop.php?code1=02&name1=<?= urlencode($sortName_first . $sortName_last) ?>">
                                                                <img src="<? echo $brandImagesWebDir . $dbdata[11]["imgName"] ?>" alt="">
                                                        </a>
                                                </p>
                                        </div>
                                </div>
                                <div class="col-md-12 col-lg-9">
                                        <div class="cat-carousel-area">
                                                <!--SINGLE CAROUSEL-->
                                                <?
                                                foreach ($dbdata_goods_FASHION as $key => $value) {
                                                        ?>
                                                        <div class="cm4 no-padding" style="padding:0px 1px;">
                                                                <div class="single-product">
                                                                        <!--
                                                                        <span >
                                                                            <a class="quick-view" href="#" data-toggle="tooltip" title="Quick View"><i class="fa fa-external-link"></i></a>
                                                                        </span>
                                                                        -->
                                                                        <?
                                                                        $db->query("SELECT imageName FROM upload_simages WHERE goods_code='$value[goods_code]' ORDER BY id ASC");
                                                                        $db_upload_simages = $db->loadRows();
                                                                        ?>
                                                                        <div class="show-img">
                                                                                <a href="item_view.php?code=<?= $value["goods_code"] ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>">
                                                                                        <img src="<? echo $brandImagesWebDir . $db_upload_simages[0]["imageName"]; ?>" style="height:100px !important;" alt="">
                                                                                </a>
                                                                        </div>
                                                                        <?
                                                                        if ($db_upload_simages[0]["imageName"] != "") {
                                                                                ?>
                                                                                <div class="hide-img">
                                                                                        <a href="item_view.php?code=<?= $value["goods_code"] ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>">
                                                                                                <img src="<? echo $brandImagesWebDir . $db_upload_simages[1]["imageName"]; ?>" style="height:100px !important;" alt="">
                                                                                        </a>
                                                                                </div>
                                                                                <?
                                                                        }
                                                                        ?>
                                                                        <div class="prod-info">
                                                                                <h2 class="pro-name">
                                                                                        <a href="item_view.php?code=<?= $value["goods_code"] ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>">
                                                                                                <div class="zxx_text_overflow_6"><?= $value["goods_name"] ?></div>
                                                                                        </a>
                                                                                </h2>

                                                                                <div class="price-box">
                                                                                        <div class="price">
                                                                                                <i class="fa fa-krw"></i>
                                                                                                <span style="font-size;"><?= number_format($value["sellPrice"] * (100 - $value["sb_sale"]) / 100) ?></span>
                                                                                        </div>
                                                                                </div>

                                                                        </div>
                                                                </div>
                                                        </div>
                                                        <?
                                                }
                                                ?>

                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</section>