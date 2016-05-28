<?php
include_once("doctype.php");
$sign = $_GET["sign"];
if($sign !="") {

        $time = date("Y-m-d H:i:s", time());
        $db->query("SELECT * FROM user_auth_email WHERE auth_email_token='$sign' AND auth_email_expire_date >='$time' AND auth_email_complete='0'");
        $db_user_auth_email_query = $db->loadRows();
        $count = count($db_user_auth_email_query);
        $user_email = $db_user_auth_email_query[0]["auth_email_address"];

}
$passwd = $_POST["passwd"];
if($passwd != ""){
    $sign = $_POST["sign"];
    $db->query("SELECT auth_email_address FROM user_auth_email WHERE auth_email_token='$sign' AND auth_email_complete='0'");
    $db_user_auth_email_query = $db->loadRows();
    $user_email = $db_user_auth_email_query[0]["auth_email_address"];
    $in_passwd = crypt($passwd);
    $db->query("UPDATE shopmembers set `passwd`='$in_passwd' WHERE email='$user_email'");
    $db->query("UPDATE user_auth_email set `auth_email_complete`='1' WHERE auth_email_token='$sign'");
    echo '<script>alert("비밀번호를 초기화 하였습니다.");location.href="/"</script>';
    exit;
}



/*`auth_email_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '이메일 인증 요청페이지 구분 (1:회원가입, 2:비밀번호찾기)',
    `auth_email_address` varchar(100) NOT NULL DEFAULT '' COMMENT '이메일 인증 주소',
    `auth_email_token` varchar(100) NOT NULL DEFAULT '' COMMENT '이메일 인증 토큰 (이메일+시간)',
    `auth_email_request_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '이메일 인증 요청일시',
    `auth_email_expire_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '이메일 인증 만료일시',
    `auth_email_complete` int(11) NOT NULL DEFAULT '0' COMMENT '이메일 인증 완료 여부',*/
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
                            <li>비밀번호 초기화</li>
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
                    <h1 class="sin-page-title">비밀번호 초기화</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 coupon-accordion" style="margin :0 auto;float:none;">
                    <div id="checkout-login" class="coupon-content" style="display: block;">
                        <div class="coupon-info">
                            <?
                            if($count == "0") {
                                echo "비밀번호 초기화 기한이 만료 되였습니다.";
                            }else{
                            ?>
                            <form action="" method="post">
                                <input type="hidden" name="sign" value="<?=$sign?>">
                                <p class="form-row-first">
                                    <label>새비밀번호
                                        <span class="required">*</span>
                                    </label>
                                    <input type="password" name="passwd" class="passwd">
                                </p>
                                <p class="form-row-last">
                                    <label>비밀번호 확인
                                        <span class="required">*</span>
                                    </label>
                                    <input type="password" class="passwd2">
                                </p>
                                <p class="form-row">
                                    <input type="submit" value="확인">
                                </p>
                            </form>
                            <?
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header no-border-bottom">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><span class="myModalLabel"></span> | <span class="message"></span></h4>
                </div>
                <div class="modal-body no-padding user-info">
                    <table class="table no-margin">
                        <tr>
                            <th>이름</th>
                            <td>
                                <div class="form-row-first">
                                    <input type="text" class="user_name" style="width:100%;">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td>
                                <div class="form-row-first">
                                    <input type="text" class="user_email" style="width:100%;">
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer no-border-top">
                    <button type="button" class="btn btn-red find_id_pw_submit">확인</button>
                </div>
            </div>
        </div>
    </div>
    <!--CART AREA END-->
    <!--FOOTER AREA START-->
    <? include_once("footer.php") ?>
    <!--FOOTER AREA END-->

    <!-- JS -->
    <? include_once("js.php") ?>
    <script>

    </script>
</body></html>