<?
include("common/config.shop.php");
$imgName = $_POST["imgname"];
$imgtype = $_POST["imgtype"];
switch ($imgtype) {
	case 'timg':
		# code...
		$query = "DELETE FROM upload_timages WHERE imageName='$imgName'";
		break;
	case 'simg':
		# code...
		$query = "DELETE FROM upload_simages WHERE imageName='$imgName'";
		break;
	case 'mimg':
		# code...
		$query = "DELETE FROM upload_mimages WHERE imageName='$imgName'";
		break;
	case 'bimg':
		# code...
		$query = "DELETE FROM upload_bimages WHERE imageName='$imgName'";
		break;
	case 'spimg':
		# code...
		$query = "DELETE FROM sp WHERE img='$imgName'";
		break;
	default:
		break;
}
$imgdelDir = $brandImagesDir.$imgName;
if(unlink($imgdelDir)){
	mysql_query($query) or die($query);
	echo "{
            \"status\":\"success\"
        }";
}else{
	echo "{
            \"status\":\"error\"
        }";
}
include("common/closedb.php");
?>