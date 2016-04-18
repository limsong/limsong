<?
include("common/config.shop.php");
$mode = $_PSOT["mode"];
$ImageName = $_PSOT["ImageName"];//이미지 이름
$imgType = $_PSOT["imgType"];//이미지 유형
$itemcode = $_PSOT["itemcode"];//id

if($mode=="modify"){
	switch ($imgType) {
		case 's':
			$query = "UPDATE upload_simages SET ImageName='$ImageName' WHERE id='$itemcode'";
			break;
		case 'm':
			$query = "UPDATE upload_mimages SET ImageName='$ImageName' WHERE id='$itemcode'";
			break;

		case 'b':
			$query = "UPDATE upload_bimages SET ImageName='$ImageName' WHERE id='$itemcode'";
			break;
		case 't':
			$query = "UPDATE upload_timages SET ImageName='$ImageName' WHERE id='$itemcode'";
			break;
		default:
			# code...
			break;
	}
}else{
	
}






include("common/closedb.php");
?>