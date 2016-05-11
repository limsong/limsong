<?php
include_once ("session.php");
include_once("doctype.php");
if ($uname != "") {
    echo '<script languate="javascript">top.window.location.href="index.php";</script>';
    exit;
}
?>
	<body class="home-1 shop-page cart-page">
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
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
							<li class="bc-home"><a href="#">Home</a></li>
							<li>회원가입</li>
						</ul>
					</div>
				</div>
			</div>
		</div>   
	</div>
	<!--BREADCRUMB AREA END-->
	<!--CART AREA START-->
	<section class="cart-area-wrapper">
		<div class="container-fluid">
			<div class="row cart-top">
				<div class="col-md-12">
					<h1 class="sin-page-title" style="padding-bottom:10px;">회원가입</h1>
				</div>
			</div>
			<div class="row" style="margin-bottom:60px;">
				<form name="userinfoform" class="userinfoform" method="post" action="joinPost.php">
					<div class="coupon-accordion">
						<div class="col-lg-12 col-md-12" style="margin :0 auto;float:none;">
							<div class="checkbox-form">
								<h3>회원 정보</h3>
								<div class="row">
									<div class="col-md-8">
										<div class="checkout-form-list">
											<label>아이디 (4~12자 영문,숫자,가입후 ID변경 불가)<span class="required">*</span></label>
											<input type="text" name="user_id" class="user_id" placeholder="">
										</div>
									</div>
									<div class="col-md-4">
										<div class="checkout-form-list">
											<label> <span class="required">&nbsp;</span></label>     
											<div class="order-button-payment">
												<INPUT type="hidden" class="check_id">
												<input type="button" value="ID중복확인" class="btn btn-red join_step2_check_id" style="height:35px;margin:0px;">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkout-form-list">
											<label>비밀번호 (6-18자 영문,숫자)<span class="required">*</span></label>                                        
											<input type="password" name="passwd" class="passwd" placeholder="">
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkout-form-list">
											<label>비밀번호 확인  <span class="required">*</span></label>                                       
											<input type="password" name="passwd2" class="passwd2" placeholder="">
										</div>
									</div>
									<div class="col-md-12">
										<div class="checkout-form-list">
											<label>이름<span class="required">*</span></label>                                        
											<input type="text" name="user_name" class="user_name" placeholder="">
										</div>
									</div>
									
									<div class="col-md-8">
										<div class="checkout-form-list">
											<label>우편번호<span class="required">*</span></label>  
											<input type="text" readonly="readonly" name="zipcode" class="zipcode postcodify_postcode" id="postcode" placeholder="">
										</div>
									</div>
									<div class="col-md-4">
										<div class="checkout-form-list">
											<label> <span class="required">&nbsp;</span></label>     
											<div class="order-button-payment">
												<input type="button" value="우편번호검색" onclick="javascript:DaumPostcode('zipcode','add1','add2');" style="height:35px;margin:0px;">
											</div>
										</div>
									</div>



									<div class="col-md-12">
										<div class="checkout-form-list">
											<label>주소</label>
											<input type="text" readonly="readonly" name="add1" id="address" class="add1 postcodify_address" placeholder="">
										</div>
									</div>
									<div class="col-md-12">
										<div class="checkout-form-list">
											<label>나머지 주소</label>
											<input type="text" name="add2" class="add2" placeholder="">
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkout-form-list">
											<label>전화번호 (- 없이 입력해주세요)  <span class="required"></span></label>                                       
											<input type="text" name="phone" class="phone" placeholder="">
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkout-form-list">
											<label>휴대전화 (- 없이 입력해주세요)  <span class="required"></span></label>                                       
											<input type="text" name="hphone" class="hphone"  placeholder="">
										</div>
									</div>

									<div class="col-md-4">
										<div class="checkout-form-list">
											<label>이메일 <span class="required"></span></label>                                        
											<input type="email" name="mail1" class="mail1" placeholder="">
										</div>
									</div>
									<div class="col-md-4">
										<div class="country-select">
											<label>@ <span class="required"></span></label>
											<select style="height:35px;margin-top:5px;" name="mail2" class="mail2">
												<option value="00" selected="">선택해주세요.</option>
												<option value="dreamwiz.com">dreamwiz.com</option>
												<option value="empal.com">empal.com</option>
												<option value="hanmail.net">hanmail.net</option>
												<option value="daum.net">daum.net</option>
												<option value="hanmir.com">hanmir.com</option>
												<option value="hotmail.com">hotmail.com</option>
												<option value="lycos.co.kr">lycos.co.kr</option>
												<option value="naver.com">naver.com</option>
												<option value="yahoo.co.kr">yahoo.co.kr</option>
												<option value="chollian.net">chollian.net</option>
												<option value="hitel.net">hitel.net</option>
												<option value="freechal.com">freechal.com</option>
												<option value="korea.com">korea.com</option>
												<option value="nate.com">nate.com</option>
												<option value="paran.com">paran.com</option>                                                        
												<option value="11">직접입력</option>
											</select>                                       
										</div>
									</div>
									<div class="col-md-4">
										<div class="checkout-form-list">
											<label>&nbsp; <span class="required"></span></label>                                        
											<input type="text" name="mail3" class="mail3" placeholder="">
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkout-form-list">
											<label> <span class="required">&nbsp;</span></label>     
											<div class="order-button-payment">                                 
												<input type="button" value="회원가입" class="join_submit" style="height:42px;margin:0px;">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="checkout-form-list">
											<label> <span class="required">&nbsp;</span></label>     
											<div class="order-button-payment">                                 
												<input type="button" value="취소" style="height:42px;margin:0px;background-color:#6e6e6e;" onclick="location.href='index.php'">
											</div>
										</div>
									</div>
								</div>                                                  
							</div>
						</div>
					</div>
				</form>
			</div>

		</div>

	</section>
	<!--CART AREA END-->
	<!--FOOTER AREA START-->
	<?php include_once ("footer.php");?>
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
	</body>
</html>
