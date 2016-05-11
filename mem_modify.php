<?php
include_once ("session.php");
include_once ("include/check.php");
include_once("doctype.php");
?>
<body class="home-2">
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong>
        browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a>
        to improve your experience.
    </p>        <![endif]-->
    <? include_once("head.php") ?>
    <section class="category-area-one control-car mar-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="cat-area-heading">
                    <h4>
                        <strong>My</strong>
                        account
                    </h4>
                </div>
                <? include_once "mypage_side.php";?>
                <style type="text/css">
                    .active {
                        background: #76caf1 none repeat scroll 0 0 !important;
                    }

                    .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th {
                        border: none;
                        vertical-align: middle;
                        text-align: center;
                        cursor: pointer;
                    }

                    .table-bordered {
                        border: none;
                        border-bottom: 1px solid #ddd;
                    }

                    .txt_ag_left {
                        text-align: left !important;
                        padding-left: 20px !important;
                    }
                </style>

                <div class="col-md-9 col-lg-10 no-padding">
                    <section class="cart-area-wrapper">
                        <div class="container-fluid">
                            <div class="row cart-top">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="border:none;">
                                        <div class="col-md-12 no-padding">
                                            <form name="userinfoform" class="userinfoform" method="post" action="mem_modifyPost.php">
                                                <div class="coupon-accordion">
                                                    <div class="checkbox-form">
                                                        <h3>회원 정보</h3>
                                                        <div class="row" style="margin:0px;">
                                                            <?
                                                            $db->query("SELECT * FROM shopMembers WHERE id = '$uname'");
                                                            $dbdata = $db->loadRows();
                                                            ?>
                                                            <div class="col-md-12 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>아이디</label>
                                                                    <?= $dbdata[0]['id'] ?>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>비밀번호 (6-18자 영문,숫자)
                                                                        <span class="required">*</span>
                                                                    </label>
                                                                    <input type="password" name="passwd"
                                                                           class="passwd" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>비밀번호 확인
                                                                        <span class="required">*</span>
                                                                    </label>
                                                                    <input type="password" name="passwd2"
                                                                           class="passwd2" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>이름
                                                                        <span class="required">*</span>
                                                                    </label>
                                                                    <?= $dbdata[0]['name'] ?>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>우편번호
                                                                        <span class="required">*</span>
                                                                    </label>
                                                                    <input type="text" readonly="readonly" name="zipcode" value="<?= $dbdata[0]['hPost'] ?>" class="zipcode" id="postcode" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>
                                                                        <span class="required">&nbsp;</span>
                                                                    </label>
                                                                    <div class="order-button-payment">
                                                                        <input type="button" value="우편번호찾기" onclick="javascript:DaumPostcode('zipcode','add1','add2');" style="height:35px;margin:0px;">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="col-md-12 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>주소</label>
                                                                    <input type="text" readonly="readonly" name="add1" value="<?= $dbdata[0]['hAddr1'] ?>" id="address" class="add1" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>나머지 주소</label>
                                                                    <input type="text" name="add2" value="<?= $dbdata[0]['hAddr2'] ?>" class="add2" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>전화번호 (- 없이 입력해주세요)
                                                                        <span class="required"></span>
                                                                    </label>
                                                                    <input type="text" name="phone"
                                                                           value="<?= $dbdata[0]['phone'] ?>"
                                                                           class="phone" placeholder="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>휴대전화 (- 없이 입력해주세요)
                                                                        <span class="required"></span>
                                                                    </label>
                                                                    <input type="text" name="hphone"
                                                                           value="<?= $dbdata[0]['mphone'] ?>"
                                                                           class="hphone" placeholder="">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>이메일
                                                                        <span class="required"></span>
                                                                    </label>
                                                                    <?= $dbdata[0]['email'] ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>
                                                                        <span class="required">&nbsp;</span>
                                                                    </label>
                                                                    <div class="order-button-payment">
                                                                        <input type="submit" value="정보수정"
                                                                               style="height:42px;margin:0px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 no-padding">
                                                                <div class="checkout-form-list">
                                                                    <label>
                                                                        <span class="required">&nbsp;</span>
                                                                    </label>
                                                                    <div class="order-button-payment">
                                                                        <input type="button" value="취소"
                                                                               style="height:42px;margin:0px;background-color:#6e6e6e;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!--FOOTER AREA START-->
    <? include_once("footer.php") ?>
    <!--FOOTER AREA END-->


    <!-- JS -->
    <?php include_once ("js.php");?>
    <!-- 다움 주소검색 스크립트 -->
    <script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>f
    <script type="text/javascript">
        function DaumPostcode(zipcode, addr1, addr2) {
            new daum.Postcode({
                oncomplete: function (data) {
                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                    var fullAddr = ''; // 최종 주소 변수
                    var extraAddr = ''; // 조합형 주소 변수
                    // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                    // if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    fullAddr = data.roadAddress;
                    // } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    fullAddr2 = data.jibunAddress;
                    //  }
                    // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                    if (data.userSelectedType === 'R') {
                        //법정동명이 있을 경우 추가한다.
                        if (data.bname !== '') {
                            extraAddr += data.bname;
                        }
                        // 건물명이 있을 경우 추가한다.
                        if (data.buildingName !== '') {
                            extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                        }
                        // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                        fullAddr += (extraAddr !== '' ? ' (' + extraAddr + ')' : '');
                    }
                    var postcode = data.postcode1 + "" + data.postcode2;
                    // 우편번호와 주소 정보를 해당 필드에 넣는다.
                    $('.' + zipcode).val(postcode);
                    $('.' + addr1).val(fullAddr2);
                    $('.' + addr2).val(fullAddr);
                    //$('#etc_a34').val(data.addressEnglish);
                    // 커서를 상세주소 필드로 이동한다.
                }
            }).open();
        }
    </script>
</body></html>