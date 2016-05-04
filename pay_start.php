<?
include_once("include/config.php");
include_once("include/sqlcon.php");
include_once("session.php");
?>
<!DOCTYPE html><!--[if IE]><![endif]--><!--[if lt IE 7 ]>
<html lang="en" class="ie6">    <![endif]--><!--[if IE 7 ]>
<html lang="en" class="ie7">    <![endif]--><!--[if IE 8 ]>
<html lang="en" class="ie8">    <![endif]--><!--[if IE 9 ]>
<html lang="en" class="ie9">    <![endif]--><!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="">
    <head>
        <meta charset="euc-kr">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>BLUE START</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript">

            addEventListener("load", function()
            {
                setTimeout(updateLayout, 0);
            }, false);

            var currentWidth = 0;

            function updateLayout()
            {
                if (window.innerWidth != currentWidth)
                {
                    currentWidth = window.innerWidth;

                    var orient = currentWidth == 320 ? "profile" : "landscape";
                    document.body.setAttribute("orient", orient);
                    setTimeout(function()
                    {
                        window.scrollTo(0, 1);
                    }, 100);
                }
            }

            setInterval(updateLayout, 400);

        </script>

        <script language=javascript>
            window.name = "BTPG_CLIENT";

            var width = 330;
            var height = 480;
            var xpos = (screen.width - width) / 2;
            var ypos = (screen.width - height) / 2;
            var position = "top=" + ypos + ",left=" + xpos;
            var features = position + ", width=320, height=440";
            var date = new Date();
            var date_str = "testoid_"+date.getFullYear()+""+date.getMinutes()+""+date.getSeconds();
            if( date_str.length != 16 )
            {
                for( i = date_str.length ; i < 16 ; i++ )
                {
                    date_str = date_str+"0";
                }
            }
            function setOid()
            {
                document.ini.P_OID.value = ""+date_str;
            }

            function on_app()
            {
                var order_form = document.ini;
                var paymethod;
                if(order_form.paymethod.value == "wcard")
                    paymethod = "CARD";
                else if(order_form.paymethod.value == "mobile")
                    paymethod = "HPP";
                else if(order_form.paymethod.value == "vbank")
                    paymethod = "VBANK";
                else if(order_form.paymethod.value == "culture")
                    paymethod = "CULT";
                else if(order_form.paymethod.value == "hpmn")
                    paymethod = "HPMN";

                param = "";
                param = param + "mid=" + order_form.P_MID.value + "&";
                param = param + "oid=" + order_form.P_OID.value + "&";
                param = param + "price=" + order_form.P_AMT.value + "&";
                param = param + "goods=" + order_form.P_GOODS.value + "&";
                param = param + "uname=" + order_form.P_UNAME.value + "&";
                param = param + "mname=" + order_form.P_MNAME.value + "&";
                param = param + "mobile" + order_form.P_MOBILE.value + "&";
                param = param + "paymethod=" + paymethod + "&";
                param = param + "noteurl=" + order_form.P_NOTEURL.value + "&";
                param = param + "ctype=1" + "&";
                param = param + "returl=" + "&";
                param = param + "reqtype=WEB&";
                param = param + "email=" + order_form.P_EMAIL.value;
                var ret = location.href="INIpayMobile://" + encodeURI(param);

                setTimeout
                (
                    function()
                    {
                        if(confirm("INIpayMobile이 설치되어 있지 않아 App Store로 이동합니다. 수락하시겠습니까?"))
                        {
                            document.location="http://phobos.apple.com/WebObjects/MZStore.woa/wa/viewSoftware?id=351845229&;mt=8";
                        }
                        return;
                    }
                )

            }

            function on_web()
            {

                var order_form = document.ini;
                var paymethod = order_form.paymethod.value;
                if (( paymethod == "bank")||(paymethod == "wcard")){
                    order_form.P_APP_BASE.value = "ON";
                }

                order_form.target = "BTPG_WALLET";
                order_form.target = "_self";
                order_form.action = "https://mobile.inicis.com/smart/" + paymethod + "/";
                order_form.submit();
            }

            function onSubmit()
            {
                var order_form = document.ini;
                var inipaymobile_type = order_form.inipaymobile_type.value;
                if( inipaymobile_type == "app" )
                    return on_app();
                else if( inipaymobile_type == "web" )
                    return on_web();
            }

        </script>
    </head>
    <body>
        <form id="form1" name="ini" method="post" action="">
            <?php
            $hp = $_POST["buyertel"];  // 앞에서 넘어온 전화번호
            $email = $_POST["buyeremail"];  // 앞에서 넘어온 주문자 이메일
            $P_OID = $_POST["oid"];  // 주문번호

            $price = $_SESSION[$P_OID . "_price"];     // 앞페이지의 장바구니 또는 앞에서 넘어온 제품가격
            $P_AMT = $price;

            //$name = "나비";  // 앞페이지에서 넘어온 주문자 이름
            $buyername = $_POST["buyername"];
            $P_UNAME = iconv("UTF-8", "EUC-KR", $buyername);  // 앞페이지가 utf-8 인경우 사용

            $goods_name = $_POST["goodsname"];
            $P_GOODS = iconv("UTF-8", "EUC-KR", $goods_name);  // 앞에서 넘어온 주문 상품명

            //$P_GOODS = iconv("UTF-8","EUC-KR",$P_GOODS);   // 앞페이지가 utf-8 인경우 사용

            $P_NOTI = "";  // 기타주문정보 , 800byte 이내 , 사용법: 변수명=변수값,변수명=변수값

            $P_MID = "INIpayTest";    //상점ID  ,  테스트: INIpayTest
            $P_MNAME = iconv("UTF-8", "EUC-KR", "해피정닷컴");  // 상점이름

            // $P_NEXT_URL : VISA3D (가상계좌를 제외한 기타지불수단) , 인증결과를 브라우저에서 해당 URL로 POST 합니다.
            // $P_NEXT_URL ="https://mobile.inicis.com/smart/testmall/next_url_test.php";
            //결제창이 끝난 후 이동할 페이지의 URL입니다. 실험해보진 않았으나 전체 경로를 적어야할 것으로 보입니다
            $P_NEXT_URL = "http://sozo.bestvpn.net/m/pay_save.php";

            // $P_NOTI_URL : 가상계좌, ISP 인증 및 결제 후 상점의 결제 수신 서버URL로 결제 결과를 통보합니다.
            // $P_NOTI_URL = "http://ts.inicis.com/~esjeong/mobile_rnoti/rnoti.php";
            //카드 결제 진행시 결과를 저장할 때 쓰이는 URL입니다. 실험해보진 않았으나 전체 경로를 적어야할 것으로 보입니다.
            $P_NOTI_URL = "http://sozo.bestvpn.net/m/rnoti.php";

            // $P_RETURN_URL : ISP 인증 및 결제 완료 후 상점으로 이동하기 위한 APP URL 또는 상점 홈페이지 URL
            // $P_RETURN_URL = "http://ts.inicis.com/~esjeong/mobile_rnoti/rnoti.php";
            //카드 결제 진행 완료시 넘어가는 페이지입니다. 아무런 정보도 받을 수 없는 페이지 입니다. 실험해보진 않았으나 전체 경로를 적어야할 것으로 보입니다.
            //실시간 계좌이체
            $P_RETURN_URL = "http://sozo.bestvpn.net/mypage.php";

            $paymethod = $_POST["paymethod"];
            ?>
            <input type="hidden" name="inipaymobile_type" value="web"/>
            <input type="hidden" name="P_OID" value="<? echo $P_OID; ?>"/>
            <input type="hidden" name="P_GOODS" value="<?= $P_GOODS ?>"/>
            <input type="hidden" name="P_AMT" value="<?php echo $P_AMT; ?>"/>
            <input type="hidden" name="P_UNAME" value="<?php echo $P_UNAME;?>" />
            <input type="hidden" name="P_MNAME" value="<?php echo $P_MNAME; ?>"/>
            <input type="hidden" name="P_MOBILE" value="<?php echo $P_MOBILE; ?>"/>
            <input type="hidden" name="P_EMAIL" value="<?php echo $email;?>"/>
            <input type="hidden" name="P_APP_BASE" value="">
            <input type="hidden" name="paymethod" class="paymethod" value="<?php echo $paymethod;?>">

            <input type="hidden" name="P_MID" value="<?php echo $P_MID; ?>"/>
            <input type="hidden" name="P_NEXT_URL" value="<?php echo $P_NEXT_URL; ?>"/>
            <input type="hidden" name="P_NOTI_URL" value="<?php echo $P_NOTI_URL; ?>"/>
            <input type="hidden" name="P_RETURN_URL" value="<?php echo $P_RETURN_URL; ?>"/>
            <input type="hidden" name="P_HPP_METHOD" value="1"/>
            <a href="javascript:onSubmit();" class="submit" style="display: none;">submit</a>
        </form>
    </body>
    <script src="js/vendor/jquery-1.11.3.min.js"></script>
    <script>
        $(document).ready(function(){
            onSubmit();
        });
    </script>

</html>