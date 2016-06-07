<?php
include_once("session.php");
if ($uname != "") {
    echo '<script language="javascript">window.top.document.location.href="/";</script>';
    header("Location:/");
    exit;
}
include_once("doctype.php");
?>
    <body class="home-1 shop-page sin-product-page">
        <? include_once("footer.php") ?>
        <!--FOOTER AREA END-->
        <!-- JS START-->
        <script src="js/vendor/jquery-1.11.3.min.js"></script>
        <!-- cookie js
        ============================================ -->
        <script src="js/jquery.cookie.js"></script>
        <script>
            $(document).ready(function () {
                var cookienum = $.cookie("cookieNum");
                if (cookienum != null) {
                    for (var i = 0; i <= cookienum; i++) {
                        if ($.cookie("goods_name" + i) != null) {
                            var goods_name = $.cookie('goods_name' + i);
                            var goods_code = $.cookie('goods_code' + i);
                            var totalsum = $.cookie('totalsum' + i);
                            var itemid = $.cookie('itemid' + i);
                            var opid = $.cookie('opid' + i);
                            var itemnum = $.cookie('itemnum' + i);
                            var opnum = $.cookie('opnum' + i);
                            var imgSrc = $.cookie('imgSrc' + i);
                            var goods_opt_type = $.cookie('goods_opt_type' + i);
                            var goods_opt_num = $.cookie('goods_opt_num' + i);
                            var cookieNum = $.cookie('cookieNum');
                            delitemtocookie(i);
                            var url = "basketAddPost.php";
                            var form_data = {
                                goods_name: goods_name,
                                goods_code: goods_code,
                                itemId: itemid,
                                opid: opid,
                                itemnum: itemnum,
                                opnum: opnum,
                                goods_opt_type: goods_opt_type,
                                goods_opt_num: goods_opt_num
                            };
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: form_data,
                                success: function (response) {
                                }
                            });
                        }
                    }
                }
                function delitemtocookie(del_cookie_num) {
                    var cookienum = $.cookie("cookieNum");
                    for (var i = 0; i <= cookienum; i++) {
                        if (i == del_cookie_num) {
                            $.cookie("goods_name" + i, null);
                            $.cookie("goods_code" + i, null);
                            $.cookie("imgSrc" + i, null);
                            $.cookie("totalsum" + i, null);
                            $.cookie("itemid" + i, null);
                            $.cookie("opid" + i, null);
                            $.cookie("itemnum" + i, null);
                            $.cookie("opnum" + i, null);
                            $.cookie("goods_opt_type" + i, null);
                            $.cookie("goods_opt_num" + i, null);
                        }
                    }
                    var resetCookieNum = false;
                    for (var i = 0; i <= cookienum; i++) {
                        if ($.cookie("goods_name" + i) == null) {
                            resetCookieNum = true;
                        } else {
                            resetCookieNum = false;
                        }
                    }
                    if (resetCookieNum == true) {
                        $.cookie("cookieNum", null);
                    }
                }
            });
        </script>
    </body>
</html>

