<?
include("common/config.shop.php");
$code=$_GET["code"];
$in_name=addslashes($_POST["name"]); //addslashes()  = ' = 이 있으면 \'으로 박워준다.
if($_POST['notify']) {
	$in_notify=$_POST['notify'];
} else {
	$in_notify="N";
}
$in_comment=addslashes($_POST["comment"]);
$in_subject=addslashes($_POST["subject"]);
$query="select max(fid) from $code";
$result=mysql_query($query)or die("쿼리 실패");
$in_fid=mysql_result($result,0,0);
if(!$in_fid) {
	$in_fid=1;
}else {
	$in_fid+=1;
}
$in_thread="A";
$in_ref=0; 
$in_signdate=time();
$in_ipInfo=$_SERVER["REMOTE_ADDR"];
$fileCount=count($_FILES);
for($i=0;$i<$fileCount;$i++) {
	$fNum=$i+1;
	if($_FILES["userFile".$fNum]["size"]>0) {
		$upFileName[]=($in_signdate+$i).$code;               //서버에 올리는 파일이름
		$selectUserFileName[]=$_FILES["userFile".$fNum]["name"];  //사용자가 올리는 이름
		$uploadedFile[]=$_FILES["userFile".$fNum]["tmp_name"];    //실제 파일이 올라간 위치 
	}
}
$addFields="";
$addValues="";
for($i=0;$i<count($upFileName);$i++) {
	$fNum=$i+1;
	$fileSource=$uploadedFile[$i];
	$fileDest=$userFileDir.$upFileName[$i];
	if(!move_uploaded_file($fileSource,$fileDest)) {
		die("파일 업로드 실패");
	}
	$addFields.=" ,userFile{$fNum},userFile{$fNum}Name";
	$addValues.=" ,'$upFileName[$i]','$selectUserFileName[$i]'";
}
$query="insert into $code (name,subject,comment,signdate,ipInfo,ref,notify,fid,thread $addFields)
				 values ('$in_name','$in_subject','$in_comment','$in_signdate','$in_ipInfo','$in_ref','$in_notify','$in_fid','$in_thread' 	$addValues)";
mysql_query($query) or die("쿼리 실패1");
$queryString=makeQueryString();
$goUrl="boardList.php".$queryString;
goPURL("입력되었습니다.",$goUrl);
?>
