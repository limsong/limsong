<?
include("common/config.shop.php");

$code=$_GET["code"];
$number=$_GET["number"];
$page=$_GET["page"];
$key=$_GET["key"];
$keyfield=$_GET["keyfield"];
foreach($_POST as $k=>$v) {
	${"in_".$k}=addslashes($v);
}
$in_signdate=time();
$query="select userFile1,userFile2 from $code where uid='$number'";
$result=mysql_query($query) or die($query);
$ou_userFile1=mysql_result($result,0,0);
$ou_userFile2=mysql_result($result,0,1);

if($in_mode=="delete") {
	if($ou_userFile1) {
		unlink($userFileDir.$ou_userFile1);
	}
	if($ou_userFile2) {
		unlink($userFileDir.$ou_userFile2);
	}
	$query="delete from $code where uid='$number'";
	mysql_query($query) or die($query);
?>	
<script type="text/javascript">
alert("삭제 되었습니다.");
parent.location.href='boardList.php?code=<?=$code?>&page=<?$page?>&key=<?$key?>&keyfield=<?$keyfield?>';
</script>
<?
include("common/closedb.php");
exit;
} else if($in_mode=="modify") {
	$fileCount=count($_FILES);
	for($i=0;$i<$fileCount;$i++) {
		$fNum=$i+1;							
		if($_FILES["userFile".$fNum]["size"]>0) {
			if(${"ou_userFile".$fNum}) {
				$upFileName[$i]=${"ou_userFile".$fNum};								
			} else {
				$upFileName[$i]=($in_signdate+$i).$code;
			}
			$selectUserFileName[$i]=$_FILES["userFile".$fNum]["name"];		
			$uploadedFile[$i]=$_FILES["userFile".$fNum]["tmp_name"];
		}
	}
	$addQuery="";
	
	for($i=0;$i<$fileCount;$i++) {
		if($uploadedFile[$i]) {
			$fNum=$i+1;
			$fileSource=$uploadedFile[$i];
			$fileDest=$userFileDir.$upFileName[$i];
			if(!move_uploaded_file($fileSource,$fileDest)) {
				die("파일 업로드 실패 관리자에게 문의하세요");
			}
			$addQuery.=",userFile{$fNum}='$upFileName[$i]',userFile{$fNum}Name='$selectUserFileName[$i]'";
		}	
	}
	if($in_notify=="") {
		$in_notify="N";
	} else {
		$in_notify=$in_notify;
	}
	$query="update $code set name='$in_name',subject='$in_subject',comment='$in_comment',notify='$in_notify'
					$addQuery where uid='$number'";
	mysql_query($query) or die($query);

?>
<script type="text/javascript">
    alert("삭제 되였습니다.");
    parent.location.href='boardList.php?code=<?=$code?>&page=<?$page?>&key=<?$key?>&keyfield=<?$keyfield?>';
</script>
<?
include("common/closedb.php");
exit;
}
?>
