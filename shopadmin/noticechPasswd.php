<?
include("common/config.shop.php");
$number=$_GET['number'];
$code=$_GET['code'];
$page=$_GET['page'];
$key=$_GET['key'];
$keyfield=$_GET['keyfield'];
$mode=$_POST['mode'];
$name=addslashes($_POST["name"]); //addslashes()  = ' = 이 있으면 \'으로 박워준다.
$comment=addslashes($_POST["comment"]);
$subject=addslashes($_POST["subject"]);
$queryString=makeQueryString();		//----------?code=뒤의 문자열 짤라내기
$arrQueryString=explode("&",$queryString);
array_pop($arrQueryString);		//배열중의 마지막 단원을  꺼내구 array()길이을 -1 array()가 단원이없으면 return null
array_pop($arrQueryString);
$qs="&name=$name&comment=$comment&subject=$subject";
$queryString=implode("&",$arrQueryString);
$goUrl="noticeModiPost.php".$queryString.$qs;
if($mode=='modify') {
	goPURL2($goUrl);
} else if($mode=='delete') {
	//$ou_userFile1=mysql_result($result,0,1);
	//$ou_userFile2=mysql_result($result,0,2);
	$query="delete from $code where uid='$number'";
	mysql_query($query);
	$goUrl="noticeList.php".$queryString;
	goPURL2($goUrl);
}
?>
