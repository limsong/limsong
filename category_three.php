<section class="category-area-three control-car mar-bottom">
    <div class="container-fluid">
        <div class="row">
            <div class="cat-area-heading">
                <?
                $sortName = $dbdata_sortCode_sortName[2]["sortName"];
                $sortName_first = substr($sortName, 0, 1);
                $sortName_last = substr($sortName, 1);
                ?>
                <h4>
                    <strong><?= $sortName_first ?></strong><?= $sortName_last ?></h4>
            </div>
            <div class="col-md-3 col-lg-2">
                <div class="small-cat-menu">
                    <h2>
                        <a href="shop.php?code1=03&name1=<?= urlencode($sortName) ?>"><?= $sortName ?></a>
                    </h2>
                    <ul class="cat-menu-ul">
                        <?
                        $db->connect();
                        $db->query("SELECT sortName,sortOrder FROM sortCodes WHERE uxCode='03' and umCode='00' ORDER BY sortOrder ASC");
                        $db_sortCodes = $db->loadRows();
                        foreach ($db_sortCodes as $key => $value) {
                            $sortOrder = $value["sortOrder"];
                            $code1 = "03";
                            $code2 = $sortOrder;
                            ?>
                            <li class="cat-menu-li">
                                <a href="shop.php?code1=<?= $code1 ?>&code2=<?= $code2 ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>&name2=<?= urlencode($value["sortName"]) ?>"><?= $value["sortName"] ?></a>
                            </li>
                            <?
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 col-lg-10 no-padding">
                <div class="hidden-xs hidden-sm hidden-md col-lg-3">
                    <div class="single-banner">
                        <div class="overlay"></div>
                        <p>
                            <a href="shop.php?code1=03&name1=<?= urlencode($sortName_first . $sortName_last) ?>">
                                <img src="<? echo $brandImagesWebDir . $dbdata[12]["imgName"] ?>" alt="">
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 no-padding">
                    <div class="cat-carousel-area">
                        <div class="cat-carousel">
                            <!--SINGLE CAROUSEL-->
                            <?
                            foreach ($dbdata_goods_HEALTHBEAUTY as $key => $value) {
                                ?>
                                <div class="col-md-12 ">
                                    <div class="single-product">
                                        <!--
                                        <span >
                                                <a class="quick-view" href="#" data-toggle="tooltip" title="Quick View"><i class="fa fa-external-link"></i></a>
                                        </span>
                                        -->
                                        <div class="product-image">
                                            <?
                                            $db->query("SELECT imageName FROM upload_simages WHERE goods_code='$value[goods_code]' ORDER BY id ASC");
                                            $db_upload_simages = $db->loadRows();
                                            //echo $db_upload_simages[0]["imageName"];
                                            //echo $db_upload_simages[1]["imageName"];
                                            ?>
                                            <div class="show-img">
                                                <a href="item_view.php?code=<?= $value["goods_code"] ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>">
                                                    <img src="<? echo $brandImagesWebDir . $db_upload_simages[0]["imageName"]; ?>" alt="">
                                                </a>
                                            </div>
                                            <?
                                            if ($db_upload_simages[0]["imageName"] != "") {
                                                ?>
                                                <div class="hide-img">
                                                    <a href="item_view.php?code=<?= $value["goods_code"] ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>">
                                                        <img src="<? echo $brandImagesWebDir . $db_upload_simages[0]["imageName"]; ?>" alt="">
                                                    </a>
                                                </div>
                                                <?
                                            }
                                            ?>
                                        </div>
                                        <div class="prod-info">
                                            <h2 class="pro-name">
                                                <div class="zxx_text_overflow_6">
                                                    <a href="item_view.php?code=<?= $value["goods_code"] ?>&name1=<?= urlencode($sortName_first . $sortName_last) ?>" style="float:left;width:100%;"><?= $value["goods_name"] ?></a>
                                                </div>
                                            </h2>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="price-box">
                                                <div class="price">
                                                    <i class="fa fa-krw"></i>
                                                    <span><?= number_format($value["sellPrice"] * (100 - $value["sb_sale"]) / 100) ?></span>
                                                </div>
                                            </div>
                                            <div class="actions">
                                                <span>
                                                    <?
                                                    if ($value["shipping"] == "Y") {
                                                        echo '<a href="#" data-toggle="tooltip" title="유료배송"><i class="fa fa-truck"></i><span> 유료배송</span></a>';
                                                    } else {
                                                        echo '<a href="#" data-toggle="tooltip" title="무료배송"><i class="fa fa-truck"></i><span> 무료배송</span></a>';
                                                    }
                                                    ?>
                                                </span>
                                                <span class="new-pro-wish">
                                                    <a href="#" data-toggle="tooltip" title="Add to wishlist">
                                                        <i class="fa fa-heart-o"></i>
                                                    </a>
                                                </span>
                                                <!--
                                                <span class="new-pro-compaire">
                                                        <a href="#" data-toggle="tooltip" title="Add to compare"><i class="fa fa-bar-chart"></i></a>
                                                </span>
                                                -->
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
    </div>
</section>