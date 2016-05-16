var total = false;
var total_num = 0;
var total_sum = 0;
var addItemArr = new Array();
var addOPItemArr = new Array();
var cookieNum;
var itemnumArr = new Array();//메인상품 구매개수
var opnumArr = new Array();//옵션상품 구매개수
var login;
(function ($) {
    "use strict";
    /*--tooltip--*/
    $('[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        placement: 'top',
        container: 'body'
    });
    /*left category menu*/
    $('.rx-parent').on('click', function () {
        $('.rx-child').slideToggle();
        $(this).toggleClass('rx-change');
    });
    $(".embed-responsive iframe").addClass("embed-responsive-item");
    $(".carousel-inner .item:first-child").addClass("active");

    $('.category-heading').on('click', function () {
        $('.category-menu-list').slideToggle(300);

    });
    /*---countdown---*/
    $('[data-countdown]').each(function () {
        var $this = $(this), finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span class="cdown day">' +
                '<span class="time-count separator">%-D</span>' +
                '<p class="cdown-tex">Days</p>  </span> ' +
                '<span class="cdown hour"><span class="time-count separator">%-H</span>' +
                ' <p class="cdown-tex">Hrs</p>  </span> ' +
                '<span class="cdown minutes"><span class="time-count separator">%M</span>' +
                ' <p class="cdown-tex">Min</p>  </span> <span class="cdown"><span class="time-count">%S</span> <p class="cdown-tex">Sec</p> </span>'));
        });
    });

    /*----- main slider -----*/
    $('#mainSlider').nivoSlider({
        directionNav: true,
        animSpeed: 500,
        slices: 18,
        pauseTime: 5000,
        pauseOnHover: false,
        controlNav: false,
        prevText: '<i class="fa fa-angle-left nivo-prev-icon"></i>',
        nextText: '<i class="fa fa-angle-right nivo-next-icon"></i>'
    });

    /*---Owl Carousel hot deals---*/
    $(".product-carousel").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 2,
        itemsDesktop: [1199, 1],
        itemsTablet: [991, 3],
        itemsTabletSmall: [767, 2],
        itemsMobile: [480, 1],
        autoPlay: false
    });

    /*---Owl Carousel hot deals---*/
    $(".left-carousel").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 1,
        itemsDesktop: [991, 2],
        itemsTablet: [768, 2],
        itemsTabletSmall: [680, 2],
        itemsMobile: [480, 1],
        autoPlay: false
    });

    /*Owl Carousel tab*/
    $(".tab-carosel-start").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 5,
        itemsDesktop: [1600, 4],
        itemsTablet: [1199, 3],
        itemsTabletSmall: [767, 2],
        itemsMobile: [480, 1],
        autoPlay: false
    });

    /*---Owl Carousel category---*/
    $(".cat-carousel").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 4,
        itemsDesktop: [1599, 3],
        itemsTablet: [500, 2],
        itemsTabletSmall: [767, 2],
        itemsMobile: [480, 1],
        autoPlay: false
    });

    /*---Owl Carousel clients---*/
    $(".client-carousel").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 10,
        itemsDesktop: [1199, 6],
        itemsTablet: [991, 5],
        itemsTabletSmall: [767, 4],
        itemsMobile: [480, 3],
        autoPlay: false
    });


    /*--mobile-menu--*/

    jQuery('.mobile-menu-start').meanmenu();

    /*--------------------------
     Index two start
     --------------------------*/

    /*---Owl Carousel tab--*/
    $(".tab-carosel-h2-start").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 5,
        itemsDesktop: [1199, 4],
        itemsTablet: [767, 2],
        itemsTabletSmall: [680, 1],
        itemsMobile: [480, 1]
    });

    /*latest  Carousel */
    $(".latest-post-carousel-two").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 4,
        itemsDesktop: [1199, 3],
        itemsTablet: [767, 2],
        itemsTabletSmall: [680, 1],
        itemsMobile: [480, 1],
        autoPlay: false
    });

    /*---price slider---- */
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 500,
        values: [75, 300],
        slide: function (event, ui) {
            $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
        }
    });
    $("#amount").val("$" + $("#slider-range").slider("values", 0) + "-$" + $("#slider-range").slider("values", 1));

    /*---zoom---*/
    $("#zoom1").elevateZoom({
        gallery: 'gallery_01',
        cursor: 'pointer',
        galleryActiveClass: "active",
        imageCrossfade: true,
        easing: true,
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 500,
        lensFadeIn: 500,
        lensFadeOut: 500
    });

    /*---zoom  Carousel ---*/
    $(".zoom-slider").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: false,
        items: 4,
        itemsDesktop: [1199, 4],
        itemsTablet: [767, 3],
        itemsTabletSmall: [680, 3],
        itemsMobile: [480, 3],
        autoPlay: false
    });

    /*---Plus Minus Start--- */
    $(".cart-plus-minus-button").append();
    $(".qtybutton").on("click", function () {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal);
    });

    /*---cart page---*/
    $(".cart-carousel-start").owlCarousel({
        navigation: false,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: true,
        items: 2,
        itemsDesktop: [1199, 1],
        itemsTablet: [767, 2],
        itemsTabletSmall: [680, 2],
        itemsMobile: [480, 1],
        autoPlay: false
    });

    /*----blog page---*/
    $(".sin-blog-carousel").owlCarousel({
        navigation: true,
        navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        pagination: true,
        items: 1,
        itemsDesktop: [1199, 1],
        itemsTablet: [991, 1],
        itemsTabletSmall: [680, 1],
        itemsMobile: [480, 1],
        autoPlay: false
    });


    /* ---payment-accordion---*/
    $(".payment-accordion").collapse({
        accordion: true,
        open: function () {
            this.slideDown(550);
        },
        close: function () {
            this.slideUp(550);
        }
    });


    /*---mixitup active---*/

    $('.mixitup-content').mixItUp();

    /*---fancybox active---- */
    $('.fancybox').fancybox();

    /*---showlogin toggle function----*/
    $('#showlogin').on('click', function () {
        $('#checkout-login').slideToggle(900);
    });

    /*---showcoupon toggle function----*/
    $('#showcoupon').on('click', function () {
        $('#checkout_coupon').slideToggle(900);
    });

    /*---Create an account toggle function---*/
    $('#cbox').on('click', function () {
        $('#cbox_info').slideToggle(900);
    });

    /*---Create an account toggle function----*/
    $('#ship-box').on('click', function () {
        $('#ship-box-info').slideToggle(1000);
    });

    /*---scrollUp---*/
    $.scrollUp({
        scrollText: '<i class="fa fa-chevron-up"></i>',
        easingType: 'linear',
        scrollSpeed: 100,
        animation: 'fade'
    });

    /*---check join_step1 ----*/
    $(".join_step1_sb").on('click', function () {
        if ($("input[name='join_step1_check']:checked").val() == "o") {
            location.href = "join_step2.php";
        } else if ($("input[name='join_step1_check']:checked").val() == "x") {
            location.href = "index.php";
        } else {
            alert("약관을 동의해 주세요.");
            $("input[name='join_step1_check']:first").focus();
        }
    });

    /*--- join_step2 check_id ----*/
    $(".join_step2_check_id").on('click', function () {
        var user_id = $(".user_id").val();
        if (4 > $(".user_id").val().length || $(".user_id").val().length > 12) {
            alert("아이디는 4~12자 여야 합니다.");
            $(".user_id").focus();
            $(".user_id").val("");
            return false;
        }
        var Regx = /^[A-Za-z0-9]*$/;
        if (!Regx.test($(".user_id").val())) {
            alert("아이디는 4~12자 영문,숫자 여야 합니다.");
            $(".user_id").focus();
            $(".user_id").val("");
            return false;
        }
        if (user_id != "") {
            $.ajax({
                url: 'checkid.php',
                type: 'POST',
                data: {userid: user_id},
                success: function (response) {
                    if (response == "true") {
                        alert("사용 가능한 아이디 입니다.");
                        $(".check_id").val("o");
                        //location.reload();
                    } else {
                        alert("사용중인 아이디 입니다.");
                        $(".check_id").val("x");
                    }
                }
            });
        } else {
            alert("아이디를 입력해주세요.");
            return false;
        }
    });

    /*--- join_step2 select zipcode pop ----*/
    $(".join_submit").on('click', function () {
        if($(".check_id").val()!="o"){
            alert("아이디 중복 확인을 해주세요.");
            return false;
        }
        if (4 > $(".user_id").val().length || $(".user_id").val().length > 12) {
            alert("아이디는 4~12자 여야 합니다.");
            $(".user_id").focus();
            return false;
        }
        var Regx = /^[A-Za-z0-9]*$/;
        if (!Regx.test($(".user_id").val())) {
            alert("아이디는 4~12자 영문,숫자 여야 합니다.");
            $(".user_id").focus();
            return false;
        }
        if ($(".user_id").val() == "") {
            alert("아이디를 입력해주세요.");
            $(".user_id").focus();
            return false;
        } else if ($(".check_id").val() != "o") {
            alert("아이디 중복 체크를 해주세요.");
            return false;
        }
        if ($(".passwd").val() == "") {
            alert("비밀번호를 입력해주세요.");
            return false;
        }
        if ($(".passwd2").val() == "") {
            alert("확인비밀번호를 입력해주세요.");
            return false;
        }
        if ($(".passwd").val() != $(".passwd2").val()) {
            alert("확인 비밀번호가 틀립니다.");
            $(".passwd2").focus();
            $(".passwd2").val("");
            return false;
        }
        if ($(".user_name").val() == "") {
            alert("이름을 입력해주세요.");
            $(".user_name").focus();
            return false;
        }
        var regexp = /[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\"'\\]/g;
        var v = $(".user_name").val();
        if (regexp.test(v)) {
            alert("한글만 입력가능 합니다.");
            $(".user_name").focus();
            $(".user_name").val("");
            return false;
        }
        if ($(".add2").val() == "") {
            alert("나머지 주소를 입력해주세요.");
            $(".add2").focus();
            return false;
        }
        if (!Regx.test($(".phone1").val())) {
            alert("전화번호는,숫자 여야 합니다.");
            $(".phone1").focus();
            $(".phone1").val("");
            return false;
        }
        if (!Regx.test($(".phone2").val())) {
            alert("전화번호는,숫자 여야 합니다.");
            $(".phone2").focus();
            $(".phone2").val("");
            return false;
        }
        if (!Regx.test($(".phone3").val())) {
            alert("전화번호는,숫자 여야 합니다.");
            $(".phone3").focus();
            $(".phone3").val("");
            return false;
        }

        if (!Regx.test($(".hphone1").val())) {
            alert("휴대전화번호는,숫자 여야 합니다.");
            $(".hphone1").focus();
            $(".hphone1").val("");
            return false;
        }

        if (!Regx.test($(".hphone2").val())) {
            alert("휴대전화번호는,숫자 여야 합니다.");
            $(".hphone2").focus();
            $(".hphone2").val("");
            return false;
        }

        if (!Regx.test($(".hphone3").val())) {
            alert("휴대전화번호는,숫자 여야 합니다.");
            $(".hphone3").focus();
            $(".hphone3").val("");
            return false;
        }

        if ($(".phone1").val() == "" || $(".phone2").val() == "" || $(".phone3").val() == "" || $(".hphone1").val() == "" || $(".hphone2").val() == "" || $(".hphone3").val() == "") {
            alert("연락가능한 번호를 입력해주세요");
            return false;
        }

        if ($(".mail1").val() == "") {
            alert("메일주소를 입력해 주세요.");
            $(".mail1").focus();
            return false;
        }
        if ($('.mail2 option:selected').val() == "11") {
            if ($(".mail3").val() == "") {
                alert("메일 나머지 주소를 입력해주세요.");
                $(".mail3").focus();
                return false;
            }
        } else if ($('.mail2 option:selected').val() == "00") {
            alert("메일 주소를 선택해주세요.");
            return false;
        }
        $(".userinfoform").submit();
    });

    //로그인 안된상태면 쿠키에서 장바구니 를 가져온다.
    $.ajax({
        type: "POST",
        url: "c_login.php",
        success: function (response) {
            if (response == "false") {
                getCookie(false);
                login = false;
            } else {
                getCookie(true);
                login = true;
            }
        }
    });

    //장바구니에 아이템 추가 .
    $(".addbasket").on('click', function () {
        var goods_opt_type = $(".goods_opt_type").val();
        var goods_opt_num = $(".optNum").val();
        if (goods_opt_type == "2") {

            var bsitem1 = $(".bsitem1")[0].selectedIndex;
            var bsitem2 = $(".bsitem2")[0].selectedIndex;
            if (bsitem1 == 0) {
                alert("선택된 옵션이 없습니다.");
                return false;
            }
            if (bsitem2 == 0) {
                alert("선택된 옵션이 없습니다.");
                return false;
            }
            if (goods_opt_num == "3") {
                var bsitem3 = $(".bsitem3")[0].selectedIndex;
                if (bsitem3 == 0) {
                    alert("선택된 옵션이 없습니다.");
                    return false;
                }
            }
        }
        var id = 0;
        if ($.cookie('cookieNum') == null) {
            id = 0;
        } else {
            id = parseInt($.cookie('cookieNum')) + 1;
        }

        var goods_name = $(".goods_name").val();
        var goods_code = $(".goods_code").val();
        var imgSrc = $("#gallery_01").find("img").first().attr("src");
        var goods_opt_type = $(".goods_opt_type").val();
        //alert(goods_name+goods_code+imgSrc+goods_opt_type);
        //alert(addItemArr.length);
        //return false;
        if (addItemArr.length < 1 && goods_opt_type != "0") {
            alert("상품을 먼저 선택해 주세요.");
            $(".bsitem").focus();
            return false;
        }
        total_sum = $(".totalSum").attr("data");


        //if(itemId==undefined){//장바구니에 아이템이 없을 경우 추가한다..

        if (login == false) {
            var rHtm = '<div class="single-cart" id="item_' + id + '">' +
                '<div class="cart-img">' +
                '<img src="' + imgSrc + '" alt="">' +
                //'<span>1</span>'+
                '</div>' +
                '<div class="cart-title">' +
                '<p><a href="item_view.php?code=' + goods_code + '">' + goods_name + '</a></p>' +
                '</div>' +
                '<div class="cart-price">' +
                '<p>₩<span data-sum="' + total_sum + '">' + formatNumber(total_sum) + '</span></p> ' +
                '</div>' +
                '<a href="#"><i class="fa fa-times"></i></a>' +
                '</div>';
            var totalsum = $(".cart-sub-total").find("span").first().attr("data-sum");
            totalsum = parseInt(totalsum) + parseInt(total_sum);
            $(".cart-sub-total").find("span").first().text("₩" + formatNumber(totalsum));
            $(".cart-sub-total").find("span").first().attr("data-sum", totalsum);
            $('.cart-drop-box').append(rHtm).find('div#item_' + id + ':last').fadeIn(400).find('i').bind('click', function () {
                //var cookienum = $.cookie("cookieNum");
                var itemId = $(this).parent().parent().attr("id");
                var item_pric = $("#" + itemId).find("p").last().text();
                var item_pricArr = item_pric.split("₩");
                item_pric = parseInt(item_pricArr[1]);
                var str = $(".cart-sub-total").find("span").first().text();
                var num2Arr = str.split("₩");
                var num2 = parseInt(num2Arr[1]) - parseInt(item_pric);
                $(".cart-sub-total").find("span").first().text("₩" + num2);
                $(".cart-sub-total").find("span").first().attr("data-sum", num2);
                //alert(parseInt(num2Arr[1])+"=="+parseInt(item_pric));
                var del_cookie_numArr = itemId.split("item_");
                var del_cookie_num = del_cookie_numArr[1];
                delitemtocookie(del_cookie_num);
                $(this).parent().parent().remove();
                return false;
            });
        }
        var opid = "";
        var itemId = "";
        var itemnum = "";
        var opnum = "";
        if (goods_opt_type > 0) {
            if (addOPItemArr.length > 0) {
                for (var i = 0; i < addOPItemArr.length; i++) {
                    if (i == addOPItemArr.length - 1) {
                        opid += addOPItemArr[i];
                        opnum += opnumArr[i];
                    } else {
                        opid += addOPItemArr[i] + ",";
                        opnum += opnumArr[i] + ",";
                    }
                }
            } else {
                opid = "";
                opnum = "";
            }
            for (var i = 0; i < addItemArr.length; i++) {
                if (i == addItemArr.length - 1) {
                    itemId += addItemArr[i];
                    itemnum += itemnumArr[i];
                } else {
                    itemId += addItemArr[i] + ",";
                    itemnum += itemnumArr[i] + ",";
                }
            }
        } else {
            itemId = $("input[name=itemid]").val();
            itemnum = $(".item_num").val();
            opid = "";
            opnum = "";
        }

        additems(goods_name, goods_code, imgSrc, total_sum, itemId, opid, itemnum, opnum, goods_opt_type, goods_opt_num);

        //delCookieAll();
        /*
         }else{
         //아이템이 이미 추가된경우
         //추가된 아이템 가격을 찾아 옵션가가격을 더한가격에 더한다.
         var item_pric = $("#"+itemId).find("p").last().text();
         var item_pricArr = item_pric.split("₩");
         item_pric = parseInt(item_pricArr[1]) + parseInt(pric);
         $("#"+itemId).find("p").last().text("₩"+item_pric);
         //같은 아이템 개수 더해준다.
         var num = $("#"+itemId).find("span").first().text();
         num = parseInt(num)+1;
         $("#"+itemId).find("span").first().text(num);
         //토탈 가격
         var str = $(".cart-sub-total").find("span").first().text();
         var num2Arr = str.split("₩");
         var num2 = parseInt(num2Arr[1])+parseInt(pric);
         $(".cart-sub-total").find("span").first().text("₩"+num2);
         addbasket(false,goods_name,goods_code,imgSrc,pric,id,name1,name2,num2);
         }
         */
    });

    /* 상품 추가 시작 */
    function additems(goods_name, goods_code, imgSrc, totalsum, itemId, opid, itemnum, opnum, goods_opt_type, goods_opt_num) {
        $.ajax({
            type: "POST",
            url: "c_login.php",
            success: function (response) {
                if (response == "false") {
                    additemtocookie(goods_name, goods_code, imgSrc, totalsum, itemId, opid, itemnum, opnum, goods_opt_type, goods_opt_num);
                } else {
                    additemtodb(goods_name, goods_code, imgSrc, totalsum, itemId, opid, itemnum, opnum, goods_opt_type, goods_opt_num);
                }
            }
        });
    }

    /* 디비에  상품추가 시갖 */
    function additemtodb(goods_name, goods_code, imgSrc, totalsum, itemId, opid, itemnum, opnum, goods_opt_type, goods_opt_num) {
        var url = "basketAddPost.php";
        var form_data = {
            goods_name: goods_name,
            goods_code: goods_code,
            itemId: itemId,
            opid: opid,
            itemnum: itemnum,
            opnum: opnum,
            goods_opt_type: goods_opt_type,
            goods_opt_num: goods_opt_num
        };
        $.ajax({
            type: "POST",
            url: url,
            //dataType    : "JSON",
            data: form_data,
            success: function (response) {
                //alert(response);
                if (response == "success") {
                    alert("상품이 추가되였습니다.");
                    getCookie(true);
                } else {
                    alert("상품추가 실패.판매자에게 문의해주세요.");
                }

            }
        });
    }

    /* 쿠키에 상품추가 시작 */
    function additemtocookie(goods_name, goods_code, imgSrc, totalsum, itemId, opid, itemnum, opnum, goods_opt_type, goods_opt_num) {
        if ($.cookie('cookieNum') == null) {
            $.cookie('cookieNum', '0');
            cookieNum = 0;
        } else {
            cookieNum = parseInt($.cookie('cookieNum')) + 1;
            $.cookie('cookieNum', cookieNum);
        }
        $.cookie('goods_name' + cookieNum, goods_name, {expires: 7, path: '/'});//新建一个cookie，名称为cookie1，值为"hello",有效期到浏览器关闭
        $.cookie('goods_code' + cookieNum, goods_code, {expires: 7, path: '/'});
        $.cookie('imgSrc' + cookieNum, imgSrc, {expires: 7, path: '/'});
        $.cookie('totalsum' + cookieNum, totalsum, {expires: 7, path: '/'});
        $.cookie('itemid' + cookieNum, itemId, {expires: 7, path: '/'});
        $.cookie('opid' + cookieNum, opid, {expires: 7, path: '/'});
        $.cookie('itemnum' + cookieNum, itemnum, {expires: 7, path: '/'});
        $.cookie('opnum' + cookieNum, opnum, {expires: 7, path: '/'});
        $.cookie('goods_opt_type' + cookieNum, goods_opt_type, {expires: 7, path: '/'});
        $.cookie('goods_opt_num' + cookieNum, goods_opt_num, {expires: 7, path: '/'});
        alert("상품이 추가 되였습니다.");
        return true;
    }

    //장바구니 쿠키 함수 get
    function getCookie(str) {
        if (str == false) {
            var cookienum = $.cookie("cookieNum");
            if (cookienum != null) {
                var total = 0;
                for (var i = 0; i <= cookienum; i++) {
                    if ($.cookie("goods_name" + i) != null) {
                        var rHtm = '<div class="single-cart" id="item_' + i + '">' +
                            '<div class="cart-img">' +
                            '<img src="' + $.cookie('imgSrc' + i) + '" alt="">' +
                            '</div>' +
                            '<div class="cart-title">' +
                            '<p><a href="item_view.php?code=' + $.cookie('goods_code' + i) + '">' + $.cookie('goods_name' + i) + '</a></p>' +
                            '</div>' +
                            '<div class="cart-price">' +
                            '<p>₩<span data-sum="' + $.cookie('totalsum' + i) + '">' + formatNumber($.cookie('totalsum' + i)) + '</span></p> ' +
                            '</div>' +
                            '<a href="#"><i class="fa fa-times"></i></a>' +
                            '</div>';

                        var wHtml = '<div style="margin-bottom:10px;background-color:pink;" class="col-md-12"><ul><li>' + 'goods_code=' + $.cookie('goods_code' + i) + '</li>' +
                            '<li>' + 'totalsum = ' + $.cookie('totalsum' + i) + '</li>' +
                            '<li>' + 'itemid = ' + $.cookie('itemid' + i) + '</li>' +
                            '<li>' + 'opid = ' + $.cookie('opid' + i) + '</li>' +
                            '<li>' + 'itemnum = ' + $.cookie('itemnum' + i) + '</li>' +
                            '<li>' + 'opnum = ' + $.cookie('opnum' + i) + '</li>' +
                            '<li>' + 'imgSrc = ' + $.cookie('imgSrc' + i) + '</li>' +
                            '<li>' + 'goods_opt_type = ' + $.cookie('goods_opt_type' + i) + '</li>' +
                            '<li>' + 'goods_opt_num = ' + $.cookie('goods_opt_num' + i) + '</li>' +
                            '<li>' + 'cookieNum = ' + $.cookie('cookieNum') + '</li>' +
                            '</ul></div>';

                        $("#pr-description").append(wHtml);

                        $('.cart-drop-box').append(rHtm).find('div#item_' + i + ':last').fadeIn(400).find('i').bind('click', function () {
                            var itemId = $(this).parent().parent().attr("id");
                            var item_pric = $("#" + itemId).find("span").first().attr("data-sum");
                            var str = $(".cart-sub-total").find("span").first().attr("data-sum");
                            var num2 = parseInt(str) - parseInt(item_pric);
                            $(".cart-sub-total").find("span").first().text("₩" + formatNumber(num2));
                            $(".cart-sub-total").find("span").first().attr("data-sum", num2);
                            var del_cookie_numArr = itemId.split("item_");
                            var del_cookie_num = del_cookie_numArr[1];
                            delitemtocookie(del_cookie_num);
                            $(this).parent().parent().remove();
                            return false;
                        });
                        total += parseInt($.cookie('totalsum' + i));
                    }
                    $(".cart-sub-total").find("span").first().text("₩" + formatNumber(total));
                    $(".cart-sub-total").find("span").first().attr("data-sum", total);
                }
            }
        } else {
            $('.cart-drop-box').empty();
            $(".cart-sub-total").find("span").first().text("₩0");
            $(".cart-sub-total").find("span").first().attr("data-sum", "0");
            $.ajax({
                type: "POST",
                url: "getcart.php",
                dataType: "XML",
                data: "",
                error: function (xml) {
                    alert(xml.responseText);
                },
                success: function (response) {
                    $(response).find("items").each(function (i) {
                        var total = $(response).find("items").length;
                        if (i <= total - 1) {
                            var num = $(this).children("num").text();
                            var name = $(this).children("name").text();
                            var code = $(this).children("code").text();
                            var imgSrc = $(this).children("imgSrc").text();
                            var vid = $(this).children("void").text();
                            var sum = $(this).children("sum").text();
                            pushcart(num, name, code, imgSrc, sum, vid);
                        }
                    });
                }
            });
        }
    }

    //로그인 상태 pop 장바구니
    function pushcart(num, name, code, imgSrc, sum, vid) {
        var str = $(".cart-sub-total").find("span").first().attr("data-sum");
        //var strArr = str.split("₩");
        var tsum = parseInt(str) + parseInt(sum);
        var rHtm = '<div class="single-cart" id="item_' + num + '">' +
            '<div class="cart-img">' +
            '<img src="' + imgSrc + '" alt="' + name + '">' +
            '</div>' +
            '<div class="cart-title">' +
            '<p><a href="item_view.php?code=' + code + '">' + name + '</a></p>' +
            '</div>' +
            '<div class="cart-price">' +
            '<p>₩<span data-sum="' + sum + '">' + formatNumber(sum) + '</span></p> ' +
            '</div>' +
            '<a href="#"><i class="fa fa-times"></i></a>' +
            '</div>';
        $('.cart-drop-box').append(rHtm).find('div#item_' + num + ':last').fadeIn(400).find('i').bind('click', function () {
            var itemId = $(this).parent().parent().attr("id");
            var item_pric = $("#" + itemId).find("span").first().attr("data-sum");
            var str = $(".cart-sub-total").find("span").first().attr("data-sum");
            var num2 = parseInt(str) - parseInt(item_pric);
            $(".cart-sub-total").find("span").first().text("₩" + formatNumber(num2));
            $(".cart-sub-total").find("span").first().attr("data-sum", num2);
            var del_cookie_numArr = itemId.split("item_");
            var del_cookie_num = del_cookie_numArr[1];
            $(this).parent().parent().remove();
            delcartitem(vid);
            return false;
        });
        $(".cart-sub-total").find("span").first().text("₩" + formatNumber(tsum));
        $(".cart-sub-total").find("span").first().attr("data-sum", tsum);
    }

    //pop 장바구니 아이템 삭제
    function delcartitem(vid) {
        var form_data = {
            code: vid
        };
        $.ajax({
            type: "POST",
            url: "delcartitem.php",
            data: form_data,
            error: function () {
                alert("상품 삭제 실패하였습니다.판매자에게 문의해주세요.");
            },
            success: function (aa) {
                //alert("상품을 삭제하였습니다.");
            }
        });
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

    //숫자 포맷
    function formatNumber(num, precision, separator) {
        var parts;
        if (!isNaN(parseFloat(num)) && isFinite(num)) {
            num = Number(num);
            num = (typeof precision !== 'undefined' ? num.toFixed(precision) : num).toString();
            parts = num.split('.');
            parts[0] = parts[0].toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1' + (separator || ','));
            return parts.join('.');
        }
        return NaN;
    }

    //=======  shop js
    $(".shop_grid").on('click', function () {
        $.cookie("shopgrid", "in active");
        $.cookie("shoplist", null);
        $("#list").removeClass("in active");
    });
    $(".shop_list").on('click', function () {
        $.cookie("shoplist", "in active");
        $.cookie("shopgrid", null);
        $("#grid").removeClass("in active");
    });
    var shoplist = $.cookie("shoplist");
    var shopgrid = $.cookie("shopgrid");

    if (shoplist != null) {
        $("#grid").removeClass("in active");
        $.cookie("shopgrid", null);
        $("#list").addClass("in active");
        $(".shop_grid").removeClass("active");
        $(".shop_list").addClass("active");
    }
    if (shopgrid != null) {
        $("#list").removeClass("in active");
        $.cookie("shoplist", null);
        $("#grid").addClass("in active");
        $(".shop_list").removeClass("active");
        $(".shop_grid").addClass("active");
    }
})(jQuery);