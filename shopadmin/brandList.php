<?
include("common/config.shop.php");
include("check.php");
$xcode=@$_GET["xcode"];
$mcode=@$_GET["mcode"];
$scode=@$_GET["scode"];
if($xcode) {
	$xObj="x".$xcode."a";
} else {
	$xObj="";
}
if($mcode) {
	$mObj="m".$mcode."a";
} else {
	$mObj="";
}
if($scode) {
	$sObj="s".$scode."a";
} else {
	$sObj="";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>brandList</title>
	<link rel="stylesheet" type="text/css" href="css/common1.css" />
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/goodsSortManageBrand.css" />
	<link rel="stylesheet" type="text/css" href="css/brandList.css" />
	<link rel="stylesheet" type="text/css" href="css/mask.css" />
	<script type="text/javascript" src="common/jslb_ajax.js"></script>
	<script type="text/javascript" src="common/brandList.js"></script>
	<script type="text/javascript">
		var displayNum=0;
		var arrClickId=["<?=$xObj?>","<?=$mObj?>","<?=$sObj?>"];
		window.onload=function() {
				displaySortList('00','00','0');
		}
	</script>
</head>
<body>
	<div id="total">
		<? include("include/include.header.php"); ?>
		<div id="left">
				<h3 id="leftTitle">상품카테고리</h3>
				<ul id="leftMenu">
				<?
				$query = "SELECT name FROM sp";
				$result = mysql_query($query) or die($query);
				while ($rows=mysql_fetch_assoc($result)) {
						# code...
						$sp_name = $rows["name"];
						echo '<li><a href="iframeBrandList.php?sp_option='.$sp_name.'" target="brandListFrame">'.$sp_name.'</a></li>';
				}
				?>
				</ul>
				<p>&nbsp;</p>
		</div>
		<div id="main">
			<div id="loading-mask" style=""></div>
			<div id="loading">
					<div class="loading-indicator"><img src="img/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/><span id="loading-msg">처리중.....</span></div>
			</div>
			<script type="text/javascript">
					//loadingMask('on');
			</script>
			<h4 id="mainTitle">상품 목록</h4>
			<ul class="sortBigBox" id="sortBox">
					<li class="depth1">
							<h5 class="sortTitle">대분류</h5>
							<ul class="sortMidBox" id="xSortList"></ul>
					</li>
					<li class="depth1">
							<h5 class="sortTitle">중분류</h5>
							<ul class="sortMidBox"  id="mSortList"></ul>
					</li>
					<li class="depth1">
							<h5 class="sortTitle">소분류</h5>
							<ul class="sortMidBox"  id="sSortList"></ul>
					</li>
			</ul>
			<ul class="sortBigBox hiddenBox">
					<li class="depth1">
							<form name="xForm" id="xForm">
							<input type="hidden" name="sortCode" />
							<input type="hidden" name="uxCode" value="00" />
							<input type="hidden" name="umCode" value="00" />
							<input type="hidden" name="liId" value="" />
							</form>
					</li>
					<li class="depth1">
							<form name="mForm" id="mForm">
							<input type="hidden" name="sortCode" />
							<input type="hidden" name="mode" />
							<input type="hidden" name="uxCode" value="" />
							<input type="hidden" name="umCode" value="00" />
							<input type="hidden" name="liId" value="" />
							</form>
					</li>
					<li class="depth1">
							<form name="sForm" id="sForm">
							<input type="hidden" name="sortCode" />
							<input type="hidden" name="mode" />
							<input type="hidden" name="uxCode" value="" />
							<input type="hidden" name="umCode" value="" />
							<input type="hidden" name="liId" value="" />
							</form>
					</li>
			</ul>
			<h3 id="sortNavi" style="display: none;"></h3>
			<iframe name="brandListFrame" id="brandListFrame" src="iframeBrandList.php" frameborder="0"></iframe>
		</div>
	</div>
</body>
</html>
