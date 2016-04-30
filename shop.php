<? 
include_once("doctype.php");
$name1=$_GET["name1"];
if($name==""){
	$name1=$_POST["name1"];
}
$name2=@$_GET["name2"];
if($name2==""){
	$name2=$_POST["name2"];
}
$code1 = $_GET["code1"];
if($code1==""){
	$code1=$_POST["code1"];
}
$code2 = @$_GET["code2"];
if($code2==""){
	$code2=$_POST["code2"];
}
$code= $code1.$code2;

$serch_key =$_POST["search"];

$serch_key = str_replace(' ', '', $serch_key);
$page=@$_GET["page"];
if(empty($page))
	$page=1;
if($serch_key != ""){
	$db->query("SELECT goods_code  FROM goods WHERE goods_tag LIKE '$serch_key%'");
}else{
	$db->query("SELECT goods_code  FROM goods WHERE goods_code LIKE '$code%' $addQuery");
}
$db->query("SELECT goods_code  FROM goods WHERE goods_code LIKE '$code%' $addQuery");
$total_record=$db->countRows();

if($total_record==0) {
	$first=1;
} else {
	$first=($page-1)*$gnum_per_page;
}
?>
<style type="text/css">
	.row{
		margin:0px;
	}
</style>
	<body class="home-1 shop-page">
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
	<!--HEADER AREA START-->
	<? include_once("sub_head.php"); ?>
	<!--HEADER AREA END-->
	<!--BREADCRUMB AREA START-->
	<div class="breadcrumb-area">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="bread-crumb">
						<ul>
							<li class="bc-home"><a href="index.php">Home</a></li>
							<?
							if($name2==""){
								echo '<li>'.$name1.'</li>';
							}else{
								echo '<li class="bc-home"><a href="shop.php?code1='.$code1.'&name1='.$name1.'&name2=">'.$name1.'</a></li>';
								echo '<li>'.$name2.'</li>';
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>   
	</div>
	<!--BREADCRUMB AREA END-->
	<!--SHOP AREA START-->
	<div class="shop-area">
		<div class="container-fluid">
			<div class="row">
				<? include_once("shop_left.php"); ?>
				<div class="col-md-9 col-lg-10">
					<div class="shop-area">
						<div class="shop-short-wrapper">
							<div class="shop-sort">
								<ul class="grid-list-button">
									<li class="active shop_grid"><a data-toggle="tab" href="#grid"><i class="fa fa-th"></i></a></li>
									<li class="shop_list"><a data-toggle="tab" href="#list"><i class="fa fa-th-list"></i></a></li>
								</ul>
							</div>
							<div class="orderby-wrapper">
								<label>등록 제품 : <b><?=$total_record?></b>개 <span style="margin-left:25px;">정렬</span></label>
								<select class="orderby" name="orderby">
									<option value="menu_order">신상품</option>
									<option value="popularity">상품명</option>
									<option value="rating">낮은가격</option>
									<option value="date">높은가격</option>
									<option value="price">제조사</option>
									<option selected="selected" value="price-desc">상용후기</option>
								</select>
							</div>
						</div>
						<div class="shop-product">
							<div class="tab-content">

								<div id="grid" class="tab-pane fade in active">
									<div class="product-grid">
										<div class="row">
											<?
											$db->connect();
											if($first == "1"){
												$tFirst = 0;
											}else{
												$tFirst = $first;
											}
											if($serch_key != ""){
												$db->query("SELECT goods_code,goods_name,commonPrice,sellPrice,sb_sale,shipping FROM goods WHERE goods_tag LIKE '$serch_key%' ORDER BY id ASC LIMIT $tFirst,$gnum_per_page");
											}else{
												$db->query("SELECT goods_code,goods_name,commonPrice,sellPrice,sb_sale,shipping FROM goods WHERE goods_code LIKE '$code%' ORDER BY id ASC LIMIT $tFirst,$gnum_per_page");
											}

											$db_shop = $db->loadRows();
											foreach ($db_shop as $key => $value) {
											?>
											<div class="col-sm-4 col-md-4 col-lg-3">
												<div class="single-product">
													<?
													if($value[sb_sale] >0) echo '<span class="sale-on">sale '.$value[sb_sale] .'%</span> ';
													?>
													<!--
													<span >
														<a class="quick-view" 
														data-toggle="tooltip" title="Quick View" href="#"><i class="fa fa-external-link"></i></a>
													</span> 
													-->
													<div class="product-image">
														<?
														$db->query("SELECT imageName FROM upload_simages WHERE goods_code='$value[goods_code]' ORDER BY id ASC");
														$db_upload_simages = $db->loadRows();
														?>
														<div class="show-img">
															 <a href="item_view.php?code=<?=$value[goods_code]?>&name1=<?=$name1?>&name2=<?=$name2?>"><img src="<? echo $brandImagesWebDir.$db_upload_simages[0]["imageName"]; ?>" alt=""></a>
														</div>
														<?
														if($db_upload_simages[1]["imageName"] != ""){
														?>
														<div class="hide-img">
															<a href="item_view.php?code=<?=$value[goods_code]?>&name1=<?=$name1?>&name2=<?=$name2?>"><img src="<? echo $brandImagesWebDir.$db_upload_simages[1]["imageName"]; ?>" alt=""></a>
														</div>
														<?
														}
														?>
													</div>
													<div class="prod-info">
														<h2 class="pro-name">
															<a href="item_view.php?code=<?=$value[goods_code]?>&name1=<?=$name1?>&name2=<?=$name2?>"><?=$value["goods_name"]?></a>
														</h2>
														<div class="rating">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-half-o"></i>
															<i class="fa fa-star-half-o"></i>
														</div>
														<div class="price-box">
															<div class="price">
																<i class="fa fa-krw"></i> <span><?=number_format($value["sellPrice"]*(100-$value[sb_sale])/100)?></span>        
															</div>
															<div class="old-price">
																<span><i class="fa fa-krw"></i> <?=number_format($value["commonPrice"])?></span>    
															</div>
														</div>
														<div class="actions">
															<span>
																<?
																if($value[shipping] =="Y"){
																	echo '<a href="#" data-toggle="tooltip" title="유료배송"><i class="fa fa-truck"></i><span> 유료배송</span></a>';
																}else{
																	echo '<a href="#" data-toggle="tooltip" title="무료배송"><i class="fa fa-truck"></i><span> 무료배송</span></a>';
																}
																?>
															</span>
															<span class="new-pro-wish">
																	<a href="#" data-toggle="tooltip" title="Add to wishlist"><i class="fa fa-heart-o"></i></a>
															</span>
															<!--
															<span class="new-pro-compaire">
																	<a href="#" data-toggle="tooltip" title="Add to compare"><i class="fa fa-bar-chart"></i></a>
															</span>
															-->
														</div>
													</div>
												</div> 
											</div>
											<?
											}
											?>
										</div>
									</div>
								</div>
								<div id="list" class="tab-pane fade">
									<div class="product-list">
										<div class="row">
											<div class="col-md-12 ">
												<?
												foreach ($db_shop as $key => $value) {
												?>
												<div class="single-list-product">
													<div class="col-sm-4 col-md-4 product-image">
														<?
														if($value["sb_sale"] >0) echo '<span class="sale-on">sale '.$value["sb_sale"] .'%</span> ';
														$goods_code = $value["goods_code"];
														$db->query("SELECT imageName FROM upload_mimages WHERE goods_code='$goods_code' ORDER BY id ASC");

														$db_upload_mimages = $db->loadRows();
														?>
														<div class="show-img">
															 <a href="item_view.php?code=<?=$value[goods_code]?>&name1=<?=$name1?>&name2=<?=$name2?>"><img src="<? echo $brandImagesWebDir.$db_upload_mimages[0]["imageName"]; ?>" alt=""></a>
														</div>
														<?
														if($db_upload_mimages[1]["imageName"] != ""){
														?>
														<div class="hide-img">
															 <a href="item_view.php?code=<?=$goods_code?>&name1=<?=$name1?>&name2=<?=$name2?>"><img src="<? echo $brandImagesWebDir.$db_upload_mimages[0]["imageName"]; ?>" alt=""></a>
														</div>
														<?
														}
														?>
													</div>
													<div class="col-sm-8 col-md-8">
														<div class="prod-list-detail">
															<div class="prod-info">
																<h2 class="pro-name">
																	<a href=""><?=$value[goods_name]?></a>
																</h2>
																<div class="price-box">
																	<div class="price">
																		<span><i class="fa fa-krw"></i> <?=number_format($value["sellPrice"])?></span>        
																	</div>
																	<div class="old-price">
																		<span><i class="fa fa-krw"></i> <?=number_format($value["commonPrice"])?></span>    
																	</div>
																</div>
																<div class="rating">
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star"></i>
																	<i class="fa fa-star-half-o"></i>
																	<i class="fa fa-star-half-o"></i>
																</div>
																<p class="prod-des">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id nulla.</p>
																<div class="actions">
																	<span>
																		<?
																		if($value[shipping] =="Y"){
																			echo '<a href="#" data-toggle="tooltip" title="유료배송"><i class="fa fa-truck"></i><span> 유료배송</span></a>';
																		}else{
																			echo '<a href="#" data-toggle="tooltip" title="무료배송"><i class="fa fa-truck"></i><span> 무료배송</span></a>';
																		}
																		?>
																	</span>
																	<span>
																		<a href="#" data-toggle="tooltip" title="Add to wishlist"><i class="fa fa-heart-o"></i></a>
																	</span>
																	<!--
																	<span>
																		<a href="#" data-toggle="tooltip" title="Add to compare"><i class="fa fa-bar-chart"></i></a>
																	</span>
																	<span>
																		<a href="#" data-toggle="tooltip" title="Quick View"><i class="fa fa-external-link"></i></a>
																	</span>
																	-->
																</div>
															</div>   
														</div>
													</div>
												</div>
												<?
												}
												?>
											</div>
										</div>
									</div> 
								</div>
							</div>
						</div>
						<div class="pagination-shop">
							<nav class="woocommerce-pagination">
								<ul class="page-numbers">
									<?
									$total_page=ceil($total_record/$gnum_per_page); //젠체 페이지수
									$total_block=ceil($total_page/$gpage_per_block); //젠체 block수
									$block=ceil($page/$gpage_per_block);  //현재 목록
									$first_page=($block-1)*$gpage_per_block+1;   //[4][5][6] $first_page=[4];
									if($block>=$total_block) {
										$last_page=$total_page;
									} else {
										$last_page=$block*$gpage_per_block;
									}
									if($page>1) {
										$bfPage=$page-1;   //이전페이지
										echo '<li ><a href="shop.php?code1='.$code1.'&name1='.$name1.'&page='.$bfPage.'" class="#"><i class="fa fa-angle-left"></i></a></li>';
									}
									for($my_page=$first_page;$my_page<=$last_page;$my_page++) {					//현재 페이지
										if($page==$my_page) {
											echo '<li><a class="current" >'.$my_page.'</a></li>';
										} else {
											echo '<li><a href="shop.php?code1='.$code1.'&name1='.$name1.'&page='.$my_page.'" class="#">'.$my_page.'</a></li>';
										}
									}
									if($page<$total_page) {
										$nxPage=$page+1;  //다음 페이지
										echo '<li><a href="shop.php?code1='.$code1.'&name1='.$name1.'&page='.$nxPage.'" class="#"><i class="fa fa-angle-right"></i></a></li>';
									}
									?>
								</ul>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--SHOP AREA END-->
	<!--FOOTER AREA START-->
 	<? include_once("footer.php") ?>
	<!--FOOTER AREA END-->
	<!-- JS START-->
	<? include_once("js.php") ?>
	<!-- JS END -->
	<script>
		$(".search-button").click(function () {
			if(!$(".search-key").val()){
				alert("검색할 키워드를 입력해 주세요");
				return false;
			}
			$(".search-form").submit();
		});
	</script>
	</body>
</html>
