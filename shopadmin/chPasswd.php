<?
include("common/config.shop.php");
$number=$_GET['number'];
$code=$_GET['code'];
$page=$_GET['page'];
$key=$_GET['key'];
$keyfield=$_GET['keyfield'];
$type=$_GET['type'];
$query="select userFile1,userFile2 from $code where uid='$number'";
$result=mysql_query($query);
$queryString=makeQueryString();		//----------?code=뒤의 문자열 짤라내기
$arrQueryString=explode("&",$queryString);
array_pop($arrQueryString);		//배열중의 마지막 단원을  꺼내구 array()길이을 -1 array()가 단원이없으면 return null
array_pop($arrQueryString);
$queryString=implode("&",$arrQueryString);
$goUrl="boardModify.php".$queryString;
if($type=='modify') {
	goPURL2($goUrl);
} else if($type=="delete") {
	$ou_userFile1=mysql_result($result,0,0);
	$ou_userFile2=mysql_result($result,0,1);
	if($ou_userFile1) {
		unlink($userFileDir.$ou_userFile1);
	}
	if($ou_userFile2) {
		unlink($userFileDir.$ou_userFile2);
	}
	$query="delete from $code where uid='$number'";
	mysql_query($query);
	$goUrl="boardList.php".$queryString;
	goPURL2($goUrl);
}
?>
