<? include_once("doctype.php")?>
    <body class="home-2">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <? include_once("head.php") ?>
    <!--CLEAR BOTH CLASS-->
    <div class="clear"></div>
    <?
    //slider.php banner.php bottom_bannert.php category_one two three four five
    $db->connect();
    $db->query("SELECT imgName FROM banner order by id asc");
    $dbdata = $db->loadRows();
    $db->query("SELECT goods_code,goods_name,sellPrice,sb_sale,shipping FROM goods WHERE goods_code LIKE '01%' ORDER BY id ASC LIMIT 0,10");
    $dbdata_goods_ELECTRONICS = $db->loadRows();
    $db->query("SELECT goods_code,goods_name,sellPrice,sb_sale,shipping FROM goods WHERE goods_code LIKE '02%' ORDER BY id ASC LIMIT 0,10");
    $dbdata_goods_FASHION = $db->loadRows();
    $db->query("SELECT goods_code,goods_name,sellPrice,sb_sale,shipping FROM goods WHERE goods_code LIKE '03%' ORDER BY id ASC LIMIT 0,10");
    $dbdata_goods_HEALTHBEAUTY = $db->loadRows();
    $db->query("SELECT goods_code,goods_name,sellPrice,sb_sale,shipping FROM goods WHERE goods_code LIKE '04%' ORDER BY id ASC LIMIT 0,10");
    $dbdata_goods_FURNITURE = $db->loadRows();
    $db->query("SELECT goods_code,goods_name,sellPrice,sb_sale,shipping FROM goods WHERE goods_code LIKE '05%' ORDER BY id ASC LIMIT 0,10");
    $dbdata_goods_TOYSGIFTS = $db->loadRows();
    $db->query("SELECT sortName FROM sortCodes WHERE uxCode='00' and umCode='00' ORDER BY sortCode ASC");
    $dbdata_sortCode_sortName = $db->loadRows();
    $db->disconnect();
    ?>
    <!--SLIDER AREA START-->
    <? include_once("slider.php") ?>
    <!--SLIDER AREA END-->
    <div class="clear"></div><!--CLEAR BOTH CLASS-->
    <!-- BANNER AREA START-->
    <? include_once("banner.php") ?>
    <!-- BANNER AREA END-->
    <!--TAB AREA START-->
    <? include_once("tab.php") ?>
    <!--TAB AREA END-->
    <!--BOTTOM BANNER AREA START-->
    <? include_once("bottom_banner.php") ?>
    <!--BOTTOM BANNER AREA END-->
    <!--CATEGORY ONE AREA START-->
    <? include_once("category_one.php") ?>
    <!--CATEGORY ONE AREA END-->
    <!--CATEGORY TWO AREA START-->
    <? include_once("category_two.php") ?>
    <!--CATEGORY TWO AREA END-->
    <!--CATEGORY THREE AREA START-->
    <? include_once("category_three.php") ?>
    <!--CATEGORY THREE AREA END-->
    <!--CATEGORY FOUR AREA START-->
    <? include_once("category_four.php") ?>
    <!--CATEGORY FOUR AREA END-->
    <!--CATEGORY FIVE AREA START-->
    <? include_once("category_five.php") ?>
    <!--CATEGORY FIVE AREA END-->
    <!--LATEST POST AREA START-->
    <? include_once("latest_post.php") ?>
    <!--LATEST POST AREA END-->
    <!--FOOTER AREA START-->
    <? include_once("footer.php") ?>
    <!--FOOTER AREA END-->
    <!-- JS START-->
    <? include_once("js.php") ?>
    <!-- JS END -->
    </body>
</html>
