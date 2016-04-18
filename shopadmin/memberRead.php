<?
include("common/config.shop.php");
$in_id=$_GET["id"];
$page=$_GET['page'];
$key=$_GET['key'];
$keyfield=$_GET['keyfield'];
$query="select * from shopMembers where id='$in_id'";
$result=mysql_query($query) or die($query);
$row=mysql_fetch_assoc($result);

foreach($row as $k=>$v) {
	${"ou_".$k}=stripslashes($v);
}
$arrregNum=explode("-",$ou_regNum);
$arrphone=explode("-",$ou_phone);
$arrmphone=explode("-",$ou_mphone);
$arrhpost=explode("-",$ou_hPost);
$arropost=explode("-",$ou_oPost);
$ou_signdate=date("Y-m-d",$row['signdate']);
$arrChecked=array("Y"=>"checkED='checked'","N"=>"");
$arrUnChecked=array("Y"=>"","N"=>"checked='checked'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>memberRead</title>
<link rel="stylesheet" type="text/css" href="css/common1.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/memberRead.css" />
<link rel="stylesheet" type="text/css" href="css/mask.css" />
<script type="text/javascript" src="common/jslb_ajax.js"></script>
<script type="text/javascript" src="common/common.js"></script>
<script type="text/javascript">
	window.onload=function() {
		memberReadInit(document.memberForm);
	}
</script>
</head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>
	<div id="left">
		<h3 id="leftTitle">Manager List</h3>
		<ul id="leftMenu">
			<li>테스터</li>
		</ul>
		<p>&nbsp;</p>
	</div>
	<div id="main">
	<div id="loading-mask" style=""></div>
		<div id="loading">
		    <div class="loading-indicator"><img src="img/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/><span id="loading-msg">처리중.....</span></div>
		</div>
		<h4 id="mainTitle">회원상세정보</h4>
		<form name="memberForm" method="post" action="memberChangePost.php?id=<?=$memId?>&page=<?=$page?>&keyfield=<?=$keyfield?>&key=<?=$key?>" target="action_frame">
				<input type="hidden" name="mode" />
		<dl id="readContent">
			<dt>이름</dt>
			<dd><input type="text" name="memName" class="memEle" id="memName" value="<?=$ou_name?>" /></dd>
			<dt>아이디</dt>
			<dd><input type="text" name="memId" class="memEle" id="memId" value="<?=$in_id?>" readonly="readonly" /></dd>
			<dt>이메일</dt>
			<dd><input type="text" name="memEmail" class="memEle" id="memEmail" value="<?=$ou_email?>" /></dd>
			<dt>비밀번호</dt>
			<dd><input type="text" name="memPasswd" class="memEle" id="memPasswd" /></dd>
			<dt>주민등록번호</dt>
			<dd>
			<input type="text" name="memRegNum1" class="memEle" id="memRegNum1" value="<?=$arrregNum[0]?>" /> -
			<input type="text" name="memRegNum2" class="memEle" id="memRegNum2" value="<?=$arrregNum[1]?>" />
			</dd>
			<dt>일반전화</dt>
			<dd>
			<input type="text" name="memPhone1" id="memPhone1" class="memEle" value="<?=$arrphone[0]?>" /> -
			<input type="text" name="memPhone2" id="memPhone2" class="memEle" value="<?=$arrphone[1]?>" /> -
			<input type="text" name="memPhone3" id="memPhone3" class="memEle" value="<?=$arrphone[2]?>" />
			</dd>
			<dt>휴대폰</dt>
			<dd>
			<input type="text" name="memMphone1" id="memMphone1" class="memEle" value="<?=$arrmphone[0]?>" /> -
			<input type="text" name="memMphone2" id="memMphone2" class="memEle" value="<?=$arrmphone[1]?>" /> -
			<input type="text" name="memMphone3" id="memMphone3" class="memEle" value="<?=$arrmphone[2]?>" />
			</dd>
			<dt>집우편번호</dt>
			<dd>
			<input type="text" name="memHpost1" id="memHpost1" class="memEle" value="<?=$arrhpost[0]?>" /> -
			<input type="text" name="memHpost2" id="memHpost2" class="memEle" value="<?=$arrhpost[1]?>" />
			</dd>
			<dt>집 주소1</dt>
			<dd><input type="text" name="memHaddr1" id="memHaddr1" class="memEle" value="<?=$ou_hAddr1?>" /></dd>
			<dt>집 주소2</dt>
			<dd><input type="text" name="memHaddr2" id="memHaddr2" class="memEle" value="<?=$ou_hAddr2?>" /></dd>
			<dt>직장우편번호</dt>
			<dd>
			<input type="text" name="memOpost1" id="memOpost1" class="memEle" value="<?=$arropost[0]?>" /> -
			<input type="text" name="memOpost2" id="memOpost2" class="memEle" value="<?=$arropost[1]?>" />
			</dd>
			<dt>직장 주소1</dt>
			<dd><input type="text" name="memOaddr1" id="memOaddr1" class="memEle" value="<?=$ou_oAddr1?>" /></dd>
			<dt>직장 주소2</dt>
			<dd><input type="text" name="memOaddr2" id="memOaddr2" class="memEle" value="<?=$ou_oAddr2?>" /></dd>
			<dt>이메일 수신</dt>
			<dd>
			Y<input type="radio" name="memYesEmail" id="memYesEmail" value="Y"<?=$arrChecked[$ou_yesEmail]?> />
			N<input type="radio" name="memYesEmail" id="memYesEmail" value="N"<?=$arrUnChecked[$ou_yesEmail]?> />
			</dd>
			<dt>문자 수신</dt>
			<dd>
			Y<input type="radio" name="memYesSMS" id="memYesSMS" value="Y"<?=$arrChecked[$ou_yesSMS]?> />
			N<input type="radio" name="memYesSMS" id="memYesSMS" value="N"<?=$arrUnChecked[$ou_yesSMS]?> />
			</dd>
			<dt>가입일</dt>
			<dd><input type="text" class="memEle" id="memPasswd" value="<?=$ou_signdate?>" readonly="readonly" /></dd>
			<dt>마일지리</dt>
			<dd><input type="text" name="memMilage" class="memEle" id="memMilage" value="<?=$ou_milage?>" /></dd>
		</dl>
		<div class="buttonBox">
			<input type="button" value=" 수정 " class="memEleB" />
			<input type="button" value=" 삭제 " class="memEleB"  />
			<input type="button" value=" 목록 " class="memEleB" onclick="location.href='memberList.php?page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>'" />
		</div>
		</form>
	</div>
</div>
<iframe name="action_frame" style="display:none"></iframe>
</body>
</html>
