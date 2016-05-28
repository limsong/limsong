<?php
include_once("session.php");
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
                        <a href="javascript:void(0);" class="find_id_pw" data-mod="find_id">이이디 찾기</a>
                        <a href="javascript:void(0);" class="find_id_pw" data-mod="find_pw">비밀번호 찾기</a>
                        <a href="join_step1.php">회원가입</a>
                    </p>
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
                    <input type="hidden" class="find_id_pw_mod">
                    <span class="find_id"></span>
                    <table class="table no-margin find_id_pw_tab">
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
        $(".find_id_pw").on("click", function () {
            $(".find_id_pw_tab").show();
            $(".find_id_pw_submit").show();
            $(".find_id").hide();
            $(".message").text("");
            $(".user_name").val("");
            $(".user_email").val("");

            var txt = $(this).text();
            $(".myModalLabel").text(txt);
            var mod = $(this).attr("data-mod");
            $(".find_id_pw_mod").val(mod);
            $(".modal.bs-example-modal-sm").modal("show");
        });
        $(".find_id_pw_submit").on("click", function () {
            var user_name = $(".user_name").val();
            var user_email = $(".user_email").val();
            var mod = $(".find_id_pw_mod").val();
            var regEmail = /([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if(user_name==""){
                $(".message").text("이름을 입력해 주세요.");
                return false;
            }
            if(user_email==""){
                $(".message").text("이메일을 입력해 주세요.");
                return false;
            }
            if(!regEmail.test(user_email)){
                $(".message").text("이메일 형식이 잘못 되었습니다.");
                return false;
            }
            $(".message").text("");
            $.ajax({
                url: 'find_id_pw.php',
                type: "POST",
                data: {
                    user_name: user_name,
                    user_email: user_email,
                    mod: mod
                },
                success: function (response) {
                    if(mod == "find_id"){
                        if(response !="error"){
                            $(".find_id_pw_tab").hide();
                            $(".find_id").append(response);
                            $(".find_id").show();
                            $(".find_id_pw_submit").hide();
                            return false;
                        }
                    }else{
                        if(response == "ok"){
                            $(".message").text("입력사신 메일로 보냈습니다.");
                        }else{
                            $(".message").text("정보를 다시 확인해 주세요.");
                            //alert(response);
                            //$(".modal-body").append(response);
                            return false;
                        }
                    }
                }
            });
        });
    </script>
</body></html>