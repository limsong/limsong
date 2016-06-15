<?php
include_once("include/Mobile_Detect.php");
$detect = new Mobile_Detect;
if ($detect->isMobile()) {
    $ismobile = "true";
    $shop = "m_shop.php";
} elseif ($detect->isTablet()) {
    $shop = "m_shop.php";
} else {
    $shop = "shop.php";
}
?>
<section class="header-area">
    <div class="header-top hidden-sm hidden-xs hidden-md">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
                    <div class="top-message">
                        <h4>Deal : of the day
                            <span>newns ?</span>
                        </h4>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
                    <div class="top-timer">
                        <i class="fa fa-clock-o"></i>
                        <div class="count-down">
                            <div data-countdown="2016/09/17"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="header-middle hidden-sm hidden-xs hidden-md">-->
    <div class="header-middle">
        <div class="container-fluid">
            <div class="row">
                <?
                /*
                 * <div class=" col-lg-2">
                    <div class="left-category-menu hidden-sm  hidden-xs hidden-md">
                        <div class="left-product-cat">
                            <div class="category-heading">
                                <span>category</span>
                                <div class="cat-align">
                                    <i class="fa fa-align-left"></i>
                                </div>
                            </div>
                            <!-- CATEGORY-MENU-LIST START -->
                            <div class="category-menu-list">
                                <ul>
                                    <!--SINGLE MENU START-->
                                    <li class="arrow-plus">
                                        <span class="cat-thumb">
                                            <i class="fa fa-television"></i>
                                        </span>
                                        <a  href="#">electronic</a>
                                        <!-- MEGA MENU START -->
                                        <div class="cat-left-drop-menu  layer-one">
                                            <div class="cat-left-drop-menu-left">
                                                <ul>
                                                    <li class="arrow-plus"><a href="#">television</a>
                                                        <div class="cat-left-drop-menu  layer-two">
                                                            <div class="cat-left-drop-menu-left">
                                                                <ul>
                                                                    <li><a href="#">LCD TV</a></li>
                                                                    <li><a href="#">LED TV</a></li>
                                                                    <li><a href="#">curved TV</a></li>
                                                                    <li><a href="#">plazma TV</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="arrow-plus"><a href="#">refrigeretor</a>
                                                        <div class="cat-left-drop-menu  layer-two">
                                                            <div class="cat-left-drop-menu-left">
                                                                <ul>
                                                                    <li><a href="#">LG</a></li>
                                                                    <li><a href="#">toshiba</a></li>
                                                                    <li><a href="#">panasonic</a></li>
                                                                    <li><a href="#">samsung</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li class="arrow-plus"><a href="#">air conditioners</a>
                                                        <div class="cat-left-drop-menu  layer-two">
                                                            <div class="cat-left-drop-menu-left">
                                                                <ul>
                                                                    <li><a href="#">samsung</a></li>
                                                                    <li><a href="#">sanaky</a></li>
                                                                    <li><a href="#">panasonic</a></li>
                                                                    <li><a href="#">samsung</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--  MEGA MENU END -->
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li class="arrow-plus">
                                        <span class="cat-thumb">
                                            <i class="fa fa-female"></i>
                                        </span>
                                        <a  href="#">fashion &amp; beauty</a>
                                        <!-- MEGA MENU START -->
                                        <div class="cat-left-drop-menu layer-one">
                                            <div class="cat-left-drop-menu-left">
                                                <ul>
                                                    <li><a href="#">health &amp; beauty</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--  MEGA MENU END -->
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li class="arrow-plus">
                                        <span class="cat-thumb">
                                            <i class="fa fa-camera"></i>
                                        </span>
                                        <a  href="#">Camera &amp; Photo</a>
                                        <!-- MEGA MENU START -->
                                        <div class="cat-left-drop-menu layer-one">
                                            <div class="cat-left-drop-menu-left">
                                                <ul>
                                                    <li><a href="#">apple</a></li>
                                                    <li><a href="#">lg</a></li>
                                                    <li><a href="#">samsung</a></li>
                                                    <li><a href="#">sony</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--  MEGA MENU END -->
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li class="arrow-plus">
                                        <span class="cat-thumb">
                                            <i class="fa fa-laptop"></i>
                                        </span>
                                        <a  href="shop.html">Smartphone &amp; laptop</a>
                                        <!-- MEGA MENU START -->
                                        <div class="cat-left-drop-menu layer-one">
                                            <div class="cat-left-drop-menu-left">
                                                <ul>
                                                    <li><a href="#">apple</a></li>
                                                    <li><a href="#">lg</a></li>
                                                    <li><a href="#">samsung</a></li>
                                                    <li><a href="#">sony</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!--  MEGA MENU END -->
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-futbol-o"></i>
                                        </span>
                                        <a  href="#">sports &amp; outdoor</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-motorcycle"></i>
                                        </span>
                                        <a  href="#">automotive &amp; motorcycle</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-cogs"></i>
                                        </span>
                                        <a  href="#">washing machine</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-laptop"></i>
                                        </span>
                                        <a  href="#">toshiba</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-sun-o"></i>
                                        </span>
                                        <a  href="#">samsung</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-cube"></i>
                                        </span>
                                        <a  href="#">sanyo</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-hdd-o"></i>
                                        </span>
                                        <a  href="#">LG</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--SINGLE MENU START-->
                                    <li>
                                        <span class="cat-thumb">
                                            <i class="fa fa-clock-o"></i>
                                        </span>
                                        <a  href="#">jewellery &amp; watches</a>
                                    </li>
                                    <!--SINGLE MENU END-->
                                    <!--MENU ACCORDION START-->
                                    <li class="rx-child">
                                        <a href="shop.html">
                                        <span class="cat-thumb"></span>
                                        phones &amp; pades
                                        </a>
                                    </li>
                                    <li class=" rx-child">
                                        <a href="shop.html">
                                        <span class="cat-thumb"></span>
                                        clothing
                                        </a>
                                    </li>
                                    <li class=" rx-parent">
                                        <a class="rx-default">
                                            <span class="cat-thumb  fa fa-plus"></span>
                                            More categories
                                        </a>
                                        <a class="rx-show">
                                            <span class="cat-thumb  fa fa-minus"></span>
                                            close menu
                                        </a>
                                    </li>
                                      <!--MENU ACCORDION END-->
                                </ul>
                            </div>
                        <!-- CATEGORY-MENU-LIST END -->
                    </div>
                </div>
                </div>
                 * */
                ?>
                <div class="col-xs-6 col-sm-6 col-md-8 col-lg-9 no-padding">
                    <!--Logo start-->
                    <div class="logo" style="text-align: center;padding-top:17px;padding-left:0px;">
                        <a href="index.php">NEWNS</a>
                    </div>
                    <!--MAIN MENU START-->
                    <div class="main-menu hidden-sm hidden-xs hidden-md">
                        <nav>
                            <ul>
                                <?php
                                $db->query("SELECT * FROM sortCodes WHERE uxCode='00' and umCode='00' ORDER BY sortOrder ASC");
                                $db_sortCode = $db->loadRows();
                                $db_sortCode_count = count($db_sortCode);
                                for ($i = 0; $i < $db_sortCode_count; $i++) {
                                    $uxName = $db_sortCode[$i]["sortName"];
                                    $uxCode = $db_sortCode[$i]["sortCode"];
                                    ?>
                                    <li>
                                        <a href="javascript:;"><?= $uxName ?></a>
                                        <ul class="sub-menu">
                                            <?php
                                            $db->query("SELECT sortName,sortCode FROM sortCodes WHERE uxCode='$uxCode' and umCode='00' ORDER BY sortOrder ASC");
                                            $db_sortCodes = $db->loadRows();
                                            foreach ($db_sortCodes as $key => $value) {
                                                $umCode = $value["sortCode"];
                                                ?>
                                                <li>
                                                    <a href="<?= $shop ?>?code1=<?= $uxCode ?>&code2=<?= $umCode ?>&name1=<?= urlencode($uxName) ?>&name2=<?= urlencode($value["sortName"]) ?>"><?= $value["sortName"] ?></a>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </li>
                                    <?php
                                }
                                /*<li><a href="shop.html">Shop</a>
                                    <div class="mega-menu">
                                        <div class="mega-catagory">
                                            <h4><a href="#">Shop Layout</a></h4>
                                            <a href="shop.html">shop grid view</a>
                                            <a href="shop-list.html">shop List View</a>
                                            <a href="shop-box.html">shop grid view box</a>
                                            <a href="shop-list-box.html">shop List View box</a>
                                        </div>
                                        <div class="mega-catagory">
                                            <h4><a href="">Shop Pages</a></h4>
                                            <a href="product.html">product page</a>
                                            <a href="cart.html">Shopping Cart</a>
                                            <a href="checkout.php">Checkout</a>
                                            <a href="product-box.html">product page box</a>
                                            <a href="cart-box.html">Shopping Cart box</a>
                                            <a href="checkout-box.html">Checkout box</a>
                                        </div>
                                        <div class="mega-catagory">
                                            <h4><a href="product.html">Product types</a></h4>
                                            <a href="product.html">simple product</a>
                                            <a href="product.html">variable product</a>
                                            <a href="product.html">grouped product</a>
                                            <a href="product.html">external product</a>
                                            <a href="product.html">downloadable</a>
                                            <a href="product.html">virtual product</a>
                                        </div>
                                    </div>
                                </li>
                                <li><a href="blog.html">Blog</a>
                                    <div class="mega-menu ">
                                        <div class="mega-catagory">
                                            <h4><a href="#">Blog Full Width</a></h4>
                                            <a href="blog.html">non sidebar</a>
                                            <a href="blog-left-sidebar.html">Sidebar Left</a>
                                            <a href="blog-right-sidebar.html">Sidebar Right</a>
                                        </div>
                                        <div class="mega-catagory">
                                            <h4><a href="">Blog Box Layout</a></h4>
                                            <a href="blog-box.html">non sidebar box</a>
                                            <a href="blog-left-sidebar-box.html">Sidebar Left box</a>
                                            <a href="blog-right-sidebar-box.html">Sidebar Right box</a>
                                        </div>
                                        <div class="mega-catagory">
                                            <h4><a href="">Post Format</a></h4>
                                            <a href="single-post.html">image Product</a>
                                            <a href="single-post-video.html">video Product</a>
                                            <a href="single-post-gallery.html">gallery Product</a>
                                            <a href="single-post-audio.html">audio Product</a>
                                        </div>
                                    </div>
                                </li>*/
                                ?>
                            </ul>
                        </nav>
                    </div>
                    <!--MAIN MENU END-->
                </div>
                <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                    <div class="top-right-menu-wrapper">
                        <div class="plus-account">
                            <div class="plus-icon">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="plus-menu">
                                <ul>
                                    <?
                                    if ($uname != "") {
                                        ?>
                                        <li>
                                            <a href="mypage.php">my account</a>
                                        </li>
                                        <li>
                                            <a href="shopping_cart.php">shopping cart</a>
                                        </li>
                                        <li>
                                            <a href="notice.php">notice</a>
                                        </li>
                                        <li>
                                            <a href="logout.php">logout</a>
                                        </li>
                                        <?
                                    } else {
                                        ?>
                                        <li>
                                            <a href="login.php">로그인</a>
                                        </li>
                                        <li>
                                            <a href="join_step1.php">회원가입</a>
                                        </li>
                                        <?
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="cart-wrapper">
                            <div class="cart">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="cart-drop">
                                <div class="cart-drop-box"></div>
                                <div class="cart-sub-total">
                                    <p>sub total
                                        <span data-sum="0">₩0</span>
                                    </p>
                                </div>
                                <div class="cart-checkout">
                                    <a href="shopping_cart.php">장바구니</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--MOBILE MENU START-->
    <div class="mobile-menu ">
        <nav class="mobile-menu-start">
            <ul>
                <?php
                $db->query("SELECT * FROM sortCodes WHERE uxCode='00' and umCode='00' ORDER BY sortOrder ASC");
                $db_sortCode = $db->loadRows();
                $db_sortCode_count = count($db_sortCode);
                for ($i = 0; $i < $db_sortCode_count; $i++) {
                    $uxName = $db_sortCode[$i]["sortName"];
                    $uxCode = $db_sortCode[$i]["sortCode"];
                    ?>
                    <li>
                        <a href="javascript:;"><?= $uxName ?></a>
                        <ul>
                            <?php
                            $db->query("SELECT sortName,sortCode FROM sortCodes WHERE uxCode='$uxCode' and umCode='00' ORDER BY sortOrder ASC");
                            $db_sortCodes = $db->loadRows();
                            foreach ($db_sortCodes as $key => $value) {
                                $umCode = $value["sortCode"];
                                ?>
                                <li>
                                    <a href="<?= $shop ?>?code1=<?= $uxCode ?>&code2=<?= $umCode ?>&name1=<?= urlencode($uxName) ?>&name2=<?= urlencode($value["sortName"]) ?>"><?= $value["sortName"] ?></a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div class="table-responsive mobile-menu2">
                <table class="table" style="margin-bottom: 0px;">
                    <tr>
                        <?php
                        for ($i = 0; $i < $db_sortCode_count; $i++) {
                            $uxName = $db_sortCode[$i]["sortName"];
                            $uxCode = $db_sortCode[$i]["sortCode"];
                            ?>
                            <td><a href="<?= $shop ?>?code1=<?= $uxCode ?>&code2=&name1=<?= urlencode($uxName) ?>"><?= $uxName ?></a></td>
                            <?php
                        }
                        ?>
                    </tr>
                </table>
            </div>
        </nav>
    </div>
    <!--MOBILE MENU END-->
    <div class="header-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="categorys-product-search">
                        <form action="<?= $shop ?>" method="post" class="search-form">
                            <input type="hidden" name="code1" value="<?= $code1 ?>">
                            <input type="hidden" name="code2" value="<?= $code2 ?>">
                            <div class="search-product form-group">
                                <?php
                                /*<select name="catsearch" class="cat-search ">
                                    <option value="">All Categories</option>
                                    <option value="2">--Women</option>
                                    <option value="3">---T-Shirts</option>
                                    <option value="4">--Men</option>
                                    <option value="5">----Shoose</option>
                                    <option value="6">--Dress</option>
                                    <option value="7">----Tops</option>
                                    <option value="8">---Casual</option>
                                    <option value="9">--Evening</option>
                                    <option value="10">--Summer</option>
                                    <option value="11">---sports</option>
                                </select>*/
                                ?>
                                <input type="text" name="search" class="form-control search-form search-key"
                                       placeholder="Enter your search key. "/>
                                <button class="search-button" value="검색" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="header-shipping">
                        <ul>
                            <li>
                                <i class="fa fa-envelope-o"></i>
                                <strong>Email:</strong>
                                nohseong21@naver.com
                            </li>
                            <li>
                                <i class="fa fa-phone"></i>
                                <strong>Hotline:</strong>
                                031-2380-9898
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>