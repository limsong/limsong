<?php include_once("doctype.php"); ?>
<style type="text/css">
    .row{
        margin:0px;
    }
</style>
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
					<h1 class="sin-page-title">회원가입</h1>
				</div>
			</div>
			<div class="row">
				<form name="userinfoform" class="userinfoform" method="post" action="joinPost.php">
					<div class="coupon-accordion">
						<div class="col-lg-9 col-md-9" style="margin :0 auto;float:none;">
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
												<input type="button" value="ID중복확인" class="join_step2_check_id" style="height:42px;margin:0px;">
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
									<div class="col-md-4
									">
										<div class="checkout-form-list">
											<label> <span class="required">&nbsp;</span></label>     
											<div class="order-button-payment">                                 
												<input type="button" value="우편번호검색" id="search_button" style="height:42px;margin:0px;">
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
											<select style="height:42px;margin-top:5px;" name="mail2" class="mail2">
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
	<section class="footer-area">
	   <img class="add" src="img/ads.jpg" alt="">
		<div class="container-fluid">
			<div class="row">
				<div class="footer-top">
				   <div class="col-sm-6 col-md-2 border-right">
						<div class="single-footer">
							<h3 class="footer-top-heading">About Sozo</h3>
							<div class="footer-list">
								<ul>
									<li class="footer-list-item"><a href="#">Company History</a></li>
									<li class="footer-list-item" ><a href="#">Social Responsibility</a></li>
									<li class="footer-list-item"><a href="#">Investor Relations</a></li>
									<li class="footer-list-item" ><a href="#">Healijy on Papers</a></li>
								</ul>
							</div>							
						</div>
					</div>
					<div class="col-sm-6 col-md-2 border-right">
						<div class="single-footer">
							<h3 class="footer-top-heading">Information</h3>
							<div class="footer-list">
								<ul>
									<li class="footer-list-item"><a href="#">our blog</a></li>
									<li class="footer-list-item" ><a href="#">about our shop</a></li>
									<li class="footer-list-item"><a href="#">secure shopping</a></li>
									<li class="footer-list-item" ><a href="#">privacy policy</a></li>
									<li class="footer-list-item" ><a href="#">dekivery information</a></li>
								</ul>
							</div>							
						</div>
					</div>
					<div class="col-sm-6 col-md-2 border-right ">
						<div class="single-footer">
							<h3 class="footer-top-heading">my account</h3>
							<div class="footer-list">
								<ul>
									<li class="footer-list-item"><a href="#">my account</a></li>
									<li class="footer-list-item" ><a href="#">shopping cart</a></li>
									<li class="footer-list-item"><a href="#">custom link</a></li>
								</ul>
							</div>							
						</div>
					</div>
					<div class="col-sm-6 col-md-3 border-right">
						<div class="contact-us">
							<ul>
								<li><i class="fa fa-phone"></i>PHONE: (012) 345 6789</li>
								<li><i class="fa fa-truck"></i>FREE SHIPPING ANYWHERE WORLDWIDE</li>
								<li><i class="fa fa-unlock-alt"></i>100% SECURE FOR PAYMENT</li>
								<li><i class="fa fa-headphones"></i>24/24 ONLINE SUPPORT CUSTOME</li>
							</ul>						
						</div>   
					</div>
					<div class="col-sm-6 col-md-3">
						<div class="news-letter">
							<h3 class="footer-top-heading">send newsletter</h3>
							<div class="newsletter-wrapper">
								<div class="subscribe-inner">
									<input type="text" id="subscribe_email">
									<a class="sub-button" href="">subscribe</a>
								</div>
							</div> 
							<div class="payment">
								<img src="img/payment.png" alt="">
							</div>
						</div>
					</div>
				</div>
				<div class="footer-bottom">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
						<div class="logo-footer">
							<img src="img/logo.png" alt="">
						</div>
						<div class="footer-copyright ">
							Copyright &copy; 2015 <a href="http://admin@bootexperts.com/">BootExperts</a>. All rights reserved						
						</div>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
						<div class="social-icon-footer">
							<ul class="social-icons">
								<li><a data-toggle="tooltip" data-placement="top" title="Facebook" href="#" ><i class="fa fa-facebook"></i></a></li>
								<li><a data-toggle="tooltip" title="Twitter" href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a data-toggle="tooltip" title="Pinterest" href="#"><i class="fa fa-pinterest"></i></a></li>
								<li><a data-toggle="tooltip" title="Google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
								<li><a data-toggle="tooltip" title="Dribbble" href=""><i class="fa fa-dribbble"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--FOOTER AREA END-->
	
	<!-- JS -->
		
		
		<!-- jQuery와 Postcodify를 로딩한다 -->
		<!-- jquery-1.11.3.min js
		============================================ -->         
		<script src="js/vendor/jquery-1.11.3.min.js"></script>
		<!-- price-slider js -->
		<script src="js/price-slider.js"></script>
		
		<!-- bootstrap js
		============================================ -->         
		<script src="js/bootstrap.min.js"></script>
		
		<!-- nevo slider js 
		============================================ --> 
		<script src="js/jquery.nivo.slider.pack.js"></script>
		
		<!-- owl.carousel.min js
		============================================ -->       
		<script src="js/owl.carousel.min.js"></script>
		
		<!-- count down js 
		============================================ -->  
		<script src="js/jquery.countdown.min.js" type="text/javascript"></script>
		
		<!--zoom plugin
		============================================ --> 
		<script src='js/jquery.elevatezoom.js'></script>
		
		<!-- wow js
		============================================ -->       
		<script src="js/wow.js"></script>
		
		<!--Mobile Menu Js
		============================================ --> 
		<script src="js/jquery.meanmenu.js"></script>
		
		<!-- jquery.fancybox.pack js -->
		<script src="js/fancybox/jquery.fancybox.pack.js"></script>	
		
		<!-- jquery.scrollUp js 
		============================================ -->
		<script src="js/jquery.scrollUp.min.js"></script>
		
		<!-- mixit-up js
		============================================ -->       
		<script src="js/jquery.mixitup.min.js"></script>
		
		<!-- plugins js
		============================================ -->         
		<script src="js/plugins.js"></script>
		
		<!-- main js
		============================================ -->           
		<script src="js/main.js"></script>

		
		<script src="js/search.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#search_button").postcodifyPopUp();
			});
		</script>
	</body>
</html>
