<?
include("common/config.shop.php");
$code=$_GET["code"];
$in_name=addslashes($_POST["name"]); //addslashes()  = ' = 이 있으면 \'으로 박워준다.
$in_comment=addslashes($_POST["comment"]);
$in_subject=addslashes($_POST["subject"]);
if($_POST["notify"]) {
	$in_notify=$_POST["notify"];
} else {
	$in_notify="N";
}
$in_signdate=time();
$query="select userFile1,userFile2 from $code where uid='$number'";
$result=mysql_query($query) or die($query);
$ou_userFile1=mysql_result($result,0,0);
$ou_userFile2=mysql_result($result,0,1);
$fileCount=count($_FILES);
for($i=0;$i<$fileCount;$i++) {
	$fNum=$i+1;
	if($_FILES["userFile".$fNum]["size"]>0) {
		if(${"ou_userFile".$fNum}) {
			$upFileName[$i]=${"ou_userFile".$fNum};
		}else {
			$upFileName[$i]=($in_signdate+$i).$code;                 //서버에 올리는 파일이름   수정된곳
		}
		$selectUserFileName[$i]=$_FILES["userFile".$fNum]["name"];  //사용자가 올리는 이름
		$uploadedFile[$i]=$_FILES["userFile".$fNum]["tmp_name"];    //실제 파일이 올라간 위치 
	}
}
$addQuery="";
for($i=0;$i<count($upFileName);$i++) {
	if($uploadedFile[$i]) {
		$fNum=$i+1;
		$fileSource=$uploadedFile[$i];
		$fileDest=$userFileDir.$upFileName[$i];
		if(!move_uploaded_file($fileSource,$fileDest)) {
			die("파일 업로드 실패");
		}
		$addQuery.=" ,userFile{$fNum}='$upFileName[$i]',userFile{$fNum}Name='$selectUserFileName[$i]'";
	}
}
$query="update $code set  name='$in_name',notify='$in_notify',subject='$in_subject',comment='$in_comment' $addQuery where uid='$number'";
mysql_query($query) or die($query);
$queryString=makeQueryString();
$goUrl="boardList.php".$queryString;
goPURL("수정되었습니다.",$goUrl);
?>
