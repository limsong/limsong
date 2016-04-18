<?
include_once("doctype.php");
$basketuid=$_GET["code"];
$name1=$_GET["name1"];
$name2=$_GET["name2"];
$db->query("SELECT goods_code,sbid,sbnum,opid,opnum FROM basket WHERE uid='$basketuid'");
$dbdata=$db->loadRows();
$goods_code = $dbdata[0][goods_code];
$sbid=$dbdata[0][sbid];
$sbidArr=explode(",", $sbid);
$sbnum=$dbdata[0][sbnum];
$sbnumArr=explode(",",$sbnum);
$opid=$dbdata[0][opid];
$opidArr=explode(",",$opid);
$opnum=$dbdata[0][opnum];
$opnumArr=explode(",", $opnum);
$i=0;
foreach($sbidArr as $a=>$b){
	//echo "sbid=".$b."<br>";
	if($i==0){
		$sbidQuery = "WHERE id='".$b."'";
	}else{
		$sbidQuery .= " or id='".$b."'";
	}
	$i++;
}
$i=0;
foreach($opidArr as $c=>$d){
	//echo "opid=".$d."<br>";
	if($i==0){
		$opidQuery = "WHERE id='".$d."'";
	}else{
		$opidQuery .= " or id='".$d."'";
	}
	$i++;
}
?>
<style type="text/css">

.col-md-12{
	width: 100%!important;
}
.col-md-9{
	width: 75%!important;
}
.col-md-8{
	width: 66.66666667%!important;
}
.col-md-7{
	width: 58.33333333%!important;
}
.col-md-6{
	width: 50%;
}
.col-md-4{
	width: 33.33333333%!important;
}
.col-md-3{
	width: 25%!important;
}
.col-md-2{
	    width: 16.66666667%!important;
}
.col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
	float: left!important;
	padding:0px 3px;
	font-weight: normal;
	font-size: 12px;
	font-family: '돋움', dotum, sans-serif;
}

.col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
    padding:0px 2px;
}
.total{
	display: block;
}
</style>
	<body class="home-1 shop-page sin-product-page">
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
	<!--HEADER AREA START-->

	<!--HEADER AREA END-->
	<!--BREADCRUMB AREA START-->

	<!--BREADCRUMB AREA END-->
	<!--SINGLE PRODUCT AREA START-->
	<section class="single-product-area">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 col-sm-12">
					<div class="col-sm-2 col-md-2">
						<?
						 /* 상품 이미지 시작 */
						$db->query("SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id ASC LIMIT 0,1");
						$db_upload_timages = $db->loadRows();
						echo '<img src="'.$brandImagesWebDir.$db_upload_timages[0][ImageName].'" width="75" height="75">';
						?>
					</div>
					<div class="col-sm-9 col-md-9" style="padding-top:10px;">
						<?
						 /* 상품 정보 추가goods 시작 */
						$db->query("SELECT goods_name,commonPrice,sellPrice,sb_sale,summary,comment FROM goods WHERE goods_code='$goods_code'");
						$db_goodsArr=$db->loadRows();
						echo "<p style='margin:0px;'>".$db_goodsArr[0][goods_name]."</p><p class='btn btn-blue'  style='font-size:12px;margin:0px;padding:0px 5px;height:20px;line-height:20px;'>무료배송</p>";
						?>
					</div>
					<div class="col-sm-12 col-md-12">
						<form name="itemchgform" method="POST" action="basketModify.php" class="itemchgform">
							<input type="hidden" name="buc" value="<?=$basketuid?>">
							<div class="prod-list-detail" style="padding-left:0px;">
								<div class="prod-info">
									<h2 class="pro-name"></h2>
									<div class="price-box">
										<div class="price">
											<input type="hidden" value="<?=$db_goodsArr[0][sellPrice]?>" class="pric1">
											<input type="hidden" value="<?=$goods_code?>" class="code">
											<input type="hidden" value="<?=$db_goodsArr[0][goods_name]?>" class="goods_name">
										</div>
									</div>
									<div class="col-md-12" style="border-bottom:1px solid #aaa;margin:10px 0px;"></div>
									<div class="col-md-12" style="max-height:450px;overflow: hidden;overflow-y:auto;">
										<div class="col-md-12">
											<div class="col-md-3">상품선택</div>
											<div class="col-md-9" style="padding-right: 0px;">
												<div class="country-select" style="margin-bottom:0px;">
													<select style="height:20px;font-size:12px;" class="bsitem">
														<option value="">상품선택</option>
													<?
													 /* 메인상품 옵션 시작 */
													$db->query("SELECT id,goods_name,sellPrice,quantity FROM goods_option WHERE goods_code='$goods_code' ORDER BY id asc");
													$db_goods_optionArr = $db->loadRows();
													$count = count($db_goods_optionArr);
													foreach ($db_goods_optionArr as $key => $value) {
													?>
														<option value="<?=$value[sellPrice]?>" data="<?=$value[id]?>"><?=$value[goods_name]?></option>
													<?
													}
													?>
													</select>                                
												</div>
											</div>
										</div>
										<div class="col-md-12" style="border-bottom:1px dotted #aaa;margin:5px 0px;"></div>
										<div class="col-md-12" style="padding-right: 0px;">-추가구매를 원하시면 추가옵션을 선택하세요</div>
										<div class="col-md-12" style="border-bottom:1px dotted #aaa;margin:5px 0px;"></div>
										<div class="col-md-12 option">
										<?
										 /* 추가옵션 시작 */
										$db->query("SELECT id,opName1 FROM optionName WHERE goods_code='$goods_code' ORDER BY id asc");
										$db_optionNameArr = $db->loadRows();
										$db->query("SELECT id,opValue1,opValue2,quantity FROM optionValue WHERE goods_code='$goods_code' ORDER BY id asc");
										$db_optionValueArr = $db->loadRows();
										$count = count($db_optionNameArr);
										for($i=0;$i<$count;$i++){
										?>
										<div class="col-md-3"><?=$db_optionNameArr[$i][opName1]?></div>
										<div class="col-md-9" style="padding-right: 0px;">
												<div class="country-select" style="margin-bottom:10px;">
													<select style="height:20px;font-size:12px;" id="op_<?=$i?>" class="bsoption">
														<option value="">상품선택</option>
														<option value="<?=$db_optionValueArr[$i][opValue2]?>" data="<?=$db_optionValueArr[$i][id]?>" data2="<?=$db_optionNameArr[$i][id]?>"><?=$db_optionValueArr[$i][opValue1]?></option>
													</select>                                       
												</div>
										</div>
										<?
										}
										?>
										<!--PRODUCT INCREASE BUTTON START-->
										</div>
										<!--PRODUCT INCREASE BUTTON END-->
										<div class="col-md-12" style="border-bottom:1px solid #aaa;margin:5px 0px;"></div>
										<!-- 메인상품 추가 폼 시작-->
										<div class="col-md-12 m-item">
											<?
											$db->query("SELECT id,goods_name,sellPrice FROM goods_option $sbidQuery order by id asc");
											$dbgoods_option=$db->loadRows();
											$i=0;
											foreach ($dbgoods_option as $key => $value) {
												$goods_name=$value[goods_name];
												$id=$value[id];
												$sellPrice=$value[sellPrice];
												echo '<div class="col-md-12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div><input type="hidden" class="itemid" name="itemid[]" value="'.$id.'"><div class="col-md-7 cm12" style="line-height:25px;height:25px;">'.$goods_name.'</div><div class="col-md-2 cm6" style="padding:0px;"><div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-plus item-plus"></i></div><div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="itemnum[]" class="item_num" value="'.$sbnumArr[$i].'"></div><div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-minus item-minus"></i></div></div><div class="col-md-3 cm6" style="line-height:25px;height:25px;text-align:right;padding:0px;"><span data="'.$sellPrice.'" class="sub_pric">'.number_format($sellPrice).'</span><span style="color:#e26a6a;">원</span><i class="fa fa-trash-o"></i></div></div>';
												$totalSum = $totalSum+$sellPrice*$sbnumArr[$i];
												$totalNum = $totalNum+$sbnumArr[$i];
												$i++;
											}
											?>
										</div>
										<!-- 메인상품 추가 폼 끝-->
										<!-- 서브상품 추가 폼 시작-->
										<div class="col-md-12 s-item">
											<?
											$db->query("SELECT id,opValue1,opValue2 FROM optionValue $opidQuery ORDER BY id asc");
											$dboptionValue=$db->loadRows();
											$i=0;
											foreach($dboptionValue as $g=>$h){
												$opValue1=$h[opValue1];
												$opValue2=$h[opValue2];
												$id=$h[id];
												echo '<div class="col-md-12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div><input type="hidden" name="optionid[]" value="'.$id.'"><div class="col-md-7 cm12" style="line-height:25px;height:25px;">'.$opValue1.'</div><div class="col-md-2 cm6" style="padding:0px;"><div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-plus item-plus"></i></div><div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="opnum[]" class="item_num" value="'.$opnumArr[$i].'"></div><div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-minus item-minus"></i></div></div><div class="col-md-3 cm6" style="line-height:25px;height:25px;text-align:right;padding:0px;"><span data="'.$opValue2.'" class="sub_pric">'.number_format($opValue2).'</span><span style="color:#e26a6a;">원</span><i class="fa fa-trash-o"></i></div></div>';
												$totalSum = $totalSum+$opValue2*$opnumArr[$i];
												$totalNum = $totalNum+$opnumArr[$i];
												$i++;
											}
											?>
										</div>
										<!-- 서브상품 추가 폼 끝-->
										<div class="col-md-12" style="margin:5px 0px 0px 0px;"></div>
										<!-- 토탈 폼 시작-->
									</div>
									<div class="col-md-12 total">
										<div class="col-md-8 cm6"><span style="font-size:12px;font-weight:bold;color:#333;">총 합계금액</span><span style="font-size:12px;color:#000;">(수량)</span></div>
										<div class="col-md-4 cm6" style="text-align:right;"><span class="totalSum" data="<?=$totalSum?>" style="font-size:17px;color:#e26a6a;font-weight:bold;"><?=number_format($totalSum)?></span><span style="color:#e26a6a;">원(<span class="totalNum"><?=$totalNum?></span>개)</span></div>
									</div>
									<!-- 토탈폼 끝-->
									<div class="col-md-12" style="margin:20px 0px 0px 0px;"></div>
									<div class="actions" style="text-align: right;">
										<span class="pro-add-to-cart">
											<input type="submit" value="변경하기" class="btn btn-red">
										</span>
										<span class="pro-buy-no">
											<input type="button" value="닫기" class="btn btn-blue" onclick="window.close();">
										</span>
									</div>
								</div>   
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--SINGLE PRODUCT AREA END-->
	<!--PRODUCT REVIEW AREA START-->
	
	<!--PRODUCT REVIEW AREA END-->
	<!--FOOTER AREA START-->

	<!--FOOTER AREA END-->
	 <!-- JS START-->
	<? include_once("js.php") ?>
	<!-- JS END -->
		<script type="text/javascript">
			$(document).ready(function(){
				/* 추가옵션 토탈추가 시작 */
				$(".bsoption").on('change',function(){
					var selVal =$(this,'option:selected').val();
					var mod = true;
					total_sum = $(".totalSum").attr("data");
					if(!selVal){
						return false;
					}
					
					var data = $(this).find("option:selected").attr("data");
					var itemName = $(this).find("option:selected").text();
					$(".s-item").find("input[type=hidden]").each(function(i){
						if($(this).val()==data){
							alert("이미 추가된 상품 입니다.");
							mod=false;
							return false;
						}
					});
					if(mod == false){
						return false;
					}
					if(total == false){$(".total").css("display","block");total=true;}
					addOPItemArr.unshift(data);//unshift      데이터를 배열 첫번째에 넣어준다.
					opnumArr.unshift("1");//옵션 상품 구매개수
					total_num = addOPItemArr.length + addItemArr.length;
					total_sum = parseInt(selVal) + parseInt(total_sum);
					$(".totalSum").text(formatNumber(total_sum));
					$(".totalSum").attr("data",total_sum);
					$(".totalNum").text(total_num);
					var rHtm =  '<div class="col-md-12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div>'+
									'<input type="hidden" name="optionid[]" value="'+data+'">'+
									'<div class="col-md-7 cm12" style="line-height:25px;height:25px;">'+itemName+'</div>'+
									'<div class="col-md-2 cm6"  style="padding:0px;">'+
										'<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">'+
											'<i class="fa fa-plus item-plus"></i>'+
										'</div>'+
										'<div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="itemnum" class="item_num" value="1"></div>'+
										'<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;">'+
											'<i class="fa fa-minus item-minus"></i>'+
										'</div>'+
									'</div>'+
									'<div class="col-md-3 cm6"  style="line-height:25px;height:25px;text-align:right;padding:0px;">'+
										'<span data="'+selVal+'" class="sub_pric">'+formatNumber(selVal)+'</span>'+
										'<span style="color:#e26a6a;">원</span>'+
											'<i data-toggle="tooltip" data-original-title="삭제" class="fa fa-trash-o"></i>'+
									'</div>'+
								'</div>';

					$(".s-item").append(rHtm);
				});
				$(".s-item").on('click','.item-plus',function(){
					var id = $(this).parent().parent().parent().find("input:first").val();
					var sub_pric  = $(this).parent().parent().parent().find(".sub_pric").attr("data");
					var total_sum = $(".totalSum").attr("data");
					var total_sum_tmp = parseInt(total_sum);
					var obj = $(this).parent().parent().find(".item_num");
					var str = obj.val();
					var sub_pric_tmp = parseInt(sub_pric);
					var str2=0;
					var str3=0;
					str = parseInt(str)+1;
					obj.val(str);
					for(var i=0;i<addOPItemArr.length;i++){
						if(addOPItemArr[i]==id){
							opnumArr.splice(i,1,str);
						}
					}
					sub_pric = parseInt(sub_pric);
					total_sum = parseInt(total_sum)+sub_pric_tmp;
					$(".totalSum").text(formatNumber(total_sum));
					$(".totalSum").attr("data",total_sum);
					$(".s-item").find(".item_num").each(function(i){
						str2 = parseInt(str2)+parseInt($(this).val());
					});
					$(".m-item").find(".item_num").each(function(i){
						str3 = parseInt(str3)+parseInt($(this).val());
					});
					$(".totalNum").text(parseInt(str2)+parseInt(str3));
					//$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric*str));
				});
				$(".s-item").on('click','.item-minus',function(){
					var id = $(this).parent().parent().parent().find("input:first").val();
					var str = $(this).parent().parent().find(".item_num").val();
					var sub_pric  = $(this).parent().parent().parent().find(".sub_pric").attr("data");
					var total_sum = $(".totalSum").attr("data");
					var sub_pric_tmp = parseInt(sub_pric);
					var str_tmp = parseInt(str);
					var str2=0;
					var str3=0;
					if(parseInt(str)>1){
						str = parseInt(str)-1;
						$(this).parent().parent().find(".item_num").val(str);
						sub_pric = parseInt(sub_pric);
						total_sum = parseInt(total_sum)-sub_pric;
						$(".totalSum").text(formatNumber(total_sum));
						$(".totalSum").attr("data",total_sum);
						$(".s-item").find(".item_num").each(function(i){
							str2 = parseInt(str2)+parseInt($(this).val());
						});
						$(".m-item").find(".item_num").each(function(i){
							str3 = parseInt(str3)+parseInt($(this).val());
						});
						$(".totalNum").text(parseInt(str2)+parseInt(str3));
						//$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric_tmp*str_tmp-sub_pric));
						for(var i=0;i<addOPItemArr.length;i++){
							if(addOPItemArr[i]==id){
								opnumArr.splice(i,1,str);
							}
						}
					}else{
						$(this).parent().parent().find(".item_num").val("1");
						for(var i=0;i<addOPItemArr.length;i++){
							if(addOPItemArr[i]==id){
								opnumArr.splice(i,1,"1");
							}
						}
					}
				});
				$('.s-item').on('click', '.fa-trash-o', function(e) {
					var id = $(this).parent().parent().find("input:first").val();
					if(id=="no"){
						return false;
					}
					$(this).parent().parent().find("input:first").val("no");
					var total_sum = $(".totalSum").attr("data");
					var sub_pric  = $(this).parent().parent().find(".sub_pric").attr("data");
					var sub_num = $(this).parent().parent().find(".item_num").val();
					$(this).parent().parent().remove();
					for(var i=0;i<addOPItemArr.length;i++){
						if(addOPItemArr[i]==id){
							addOPItemArr.splice(i,1);
							opnumArr.splice(i,1);
						}
					}
					total_sum = parseInt(total_sum);
					//total_num = addItemArr.length + addOPItemArr.length;
					total_num = parseInt($(".totalNum").text())-parseInt(sub_num);
					var total_fsum = total_sum - parseInt(sub_pric)*parseInt(sub_num);
					$(".totalSum").text(formatNumber(total_fsum));
					$(".totalSum").attr("data",total_fsum);
					$(".totalNum").text(total_num);
					if(total_num == 0){
						$(".total").css("display","none");
						total = false;
					}
					
				});
				/* 추가옵션 토탈추가  끝 */

				/* 메인상품 토탈추가 시작 */
				$(".bsitem").on("change",function(){
					var selVal =$(this,'option:selected').val();
					var data = $('.bsitem option:selected').attr("data");
					var itemName = $(".bsitem option:selected").text();
					var idlen = $(".m-item").find("input[type=hidden]").length;
					var mod = true;
					total_sum = $(".totalSum").attr("data");
					if(!selVal){
						return false;
					}
					$(".m-item").find("input[type=hidden]").each(function(i){
						if($(this).val()==data){
							alert("이미 추가된 상품 입니다.");
							mod=false;
							return false;
						}
					});
					if(mod == false){
						return false;
					}
					if(total == false){$(".total").css("display","block");total=true;}
					total_sum = parseInt(selVal) + parseInt(total_sum);
					total_num = addOPItemArr.length + addItemArr.length;
					$(".totalSum").text(formatNumber(total_sum));
					$(".totalSum").attr("data",total_sum);
					$(".totalNum").text(total_num);
					var rHtm = '<div class="col-md-12" style="padding:0px;"><div class="col-md-12" style="margin:5px 0px;"></div>'+
									'<input type="hidden" name="itemid[]" data=" " value="'+data+'">'+
									'<div class="col-md-7 cm12" style="line-height:25px;height:25px;">'+itemName+'</div>'+
									'<div class="col-md-2 cm6"  style="padding:0px;">'+
										'<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-plus item-plus"></i></div>'+
										'<div class="col-md-4 cm4" style="padding:0px;text-align:center;"><input type="text" name="itemnum" class="item_num" value="1"></div>'+
										'<div class="col-md-4 cm4" style="background-color:white;padding:0px;text-align:center;line-height:25px;height:25px;"><i class="fa fa-minus item-minus"></i></div>'+
									'</div>'+
									'<div class="col-md-3 cm6"  style="line-height:25px;height:25px;text-align:right;padding:0px;">'+
										'<span data="'+selVal+'" class="sub_pric">'+formatNumber(selVal)+'</span>'+
										'<span style="color:#e26a6a;">원</span>'+
											'<i data-toggle="tooltip" data-original-title="삭제" class="fa fa-trash-o"></i>'+
									'</div>'+
								'</div>';
					$(".m-item").append(rHtm);
					
				});
				$(".m-item").on('click','.item-plus',function(){
					var id = $(this).parent().parent().parent().find("input:first").val();
					var sub_pric  = $(this).parent().parent().parent().find(".sub_pric").attr("data");
					var total_sum = $(".totalSum").attr("data");
					var obj = $(this).parent().parent().find(".item_num");
					var str = obj.val();
					var sub_pric_tmp = parseInt(sub_pric);
					var str2=0;
					var str3=0;
					str = parseInt(str)+1;
					obj.val(str);
					$(".s-item").find(".item_num").each(function(i){
						str2 = parseInt(str2)+parseInt($(this).val());
					});
					$(".m-item").find(".item_num").each(function(i){
						str3 = parseInt(str3)+parseInt($(this).val());
					});
					$(".totalNum").text(parseInt(str2)+parseInt(str3));
					for(var i=0;i<addItemArr.length;i++){
						if(addItemArr[i]==id){
							itemnumArr.splice(i,1,str);
						}
					}
					sub_pric = parseInt(sub_pric);
					total_sum = parseInt(total_sum)+sub_pric_tmp;
					$(".totalSum").text(formatNumber(total_sum));
					$(".totalSum").attr("data",total_sum);
					//$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric*str));
				});
				$(".m-item").on('click','.item-minus',function(){
					var id = $(this).parent().parent().parent().find("input:first").val();
					var str = $(this).parent().parent().find(".item_num").val();
					var sub_pric  = $(this).parent().parent().parent().find(".sub_pric").attr("data");
					var total_sum = $(".totalSum").attr("data");
					var sub_pric_tmp = parseInt(sub_pric);
					var str_tmp = parseInt(str);
					var str2=0;
					var str3=0;
					if(parseInt(str)>1){
						str = parseInt(str)-1;
						$(this).parent().parent().find(".item_num").val(str);
						sub_pric = parseInt(sub_pric);
						total_sum = parseInt(total_sum)-sub_pric;
						$(".totalSum").text(formatNumber(total_sum));
						$(".totalSum").attr("data",total_sum);
						$(".s-item").find(".item_num").each(function(i){
							str2 = parseInt(str2)+parseInt($(this).val());
						});
						$(".m-item").find(".item_num").each(function(i){
							str3 = parseInt(str3)+parseInt($(this).val());
						});

						$(".totalNum").text(parseInt(str2)+parseInt(str3));
						//$(this).parent().parent().parent().find(".sub_pric").text(formatNumber(sub_pric_tmp*str_tmp-sub_pric));
						for(var i=0;i<addItemArr.length;i++){
							if(addItemArr[i]==id){
								itemnumArr.splice(i,1,str);
							}
						}
					}else{
						$(this).parent().parent().find(".item_num").val("1");
						for(var i=0;i<addItemArr.length;i++){
							if(addItemArr[i]==id){
								itemnumArr.splice(i,1,"1");
							}
						}
					}
				});
				$('.m-item').on('click','.fa-trash-o', function(e) {
					var inpData = $(this).parent().parent().find("input:first").attr("data");
					var idlen = $(".m-item").find("input[type=hidden]").length;
					if(idlen==1){
						alert("옵션은 반드시 1개 이상 설정하셔야 합니다.");
						return false;
					}
					if(inpData=="no"){
						return false;
					}
					$(this).parent().parent().find("input:first").attr("data","no");
					for(var i=0;i<addItemArr.length;i++){
						if(addItemArr[i]==id){
							addItemArr.splice(i,1);
							itemnumArr.splice(i,1);
						}
					}
					var total_sum = $(".totalSum").attr("data");
					var sub_pric  = $(this).parent().parent().find(".sub_pric").attr("data");
					var sub_num = $(this).parent().parent().find(".item_num").val();
					total_sum = parseInt(total_sum);
					total_num = parseInt($(".totalNum").text())-parseInt(sub_num);
					var total_fsum = total_sum - parseInt(sub_pric)*parseInt(sub_num);
					$(".totalSum").text(formatNumber(total_fsum));
					$(".totalSum").attr("data",total_fsum);
					$(".totalNum").text(total_num);
					if(total_num == 0){
						$(".total").css("display","none");
						total = false;
					}
					$(this).parent().parent().remove();
				 });
				 /* 메인상품 토탈추가 끝 */

				 /* 숫자 포맷 시작 */
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
			});
		</script>
	</body>
</html>