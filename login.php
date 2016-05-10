<?
include_once("doctype.php");
if ($uname != "") {
    echo '<script language="javascript">window.top.document.location.href="/";</script>';
    header("Location:/");
    exit;
}
?>
<body class="home-1 shop-page cart-page">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong>
        browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a>
        to improve your experience.
    </p><![endif]-->
    <!--HEADER AREA SART-->
    <? include_once("sub_head.php"); ?>
    <!--HEADER AREA END-->
    <!--BREADCRUMB AREA START-->
    <div class="breadcrumb-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="bread-crumb">
                        <ul>
                            <li class="bc-home">
                                <a href="#">Home</a>
                            </li>
                            <li>Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--BREADCRUMB AREA END-->
    <!--CART AREA START-->
    <section class="cart-area-wrapper">
        <div class="container-fluid" style="margin-bottom:30px;">
            <div class="row cart-top">
                <div class="col-md-12">
                    <h1 class="sin-page-title">Login</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 coupon-accordion" style="margin :0 auto;float:none;">
                    <div id="checkout-login" class="coupon-content" style="display: block;">
                        <div class="coupon-info">
                            <p class="coupon-text"></p>
                            <form action="loginPost.php" method="post" name="loginform">
                                <input type="hidden" name="url" value="<?= $_SERVER['HTTP_REFERER'] ?>">
                                <p class="form-row-first">
                                    <label>아이디
                                        <span class="required">*</span>
                                    </label>
                                    <input type="text" name="user_id">
                                </p>
                                <p class="form-row-last">
                                    <label>비밀번호
                                        <span class="required">*</span>
                                    </label>
                                    <input type="password" name="user_pw">
                                </p>
                                <p class="form-row">
                                    <input type="submit" value="로그인">
                                    <input type="checkbox" id="svidpw">
                                    <label for="svidpw">아이디저장</label>
                                </p>
                            </form>
                        </div>
                    </div>
                    <p class="lost-password">
                        <a href="#">이이디 찾기</a>
                        <a href="#">비밀번호 찾기</a>
                        <a href="join_step1.php">회원가입</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!--CART AREA END-->
    <!--FOOTER AREA START-->
    <? include_once("footer.php") ?>
    <!--FOOTER AREA END-->

    <!-- JS -->
    <? include_once("js.php") ?>
</body></html>
