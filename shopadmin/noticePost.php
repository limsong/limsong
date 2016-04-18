<?
include("common/config.shop.php");
$code=$_GET["code"];
$in_name=addslashes($_POST["name"]); //addslashes()  = ' = 이 있으면 \'으로 박워준다.
$in_comment=addslashes($_POST["comment"]);
$in_subject=addslashes($_POST["subject"]);
$in_ref=0;  //방문자수
$in_signdate=time();
$query="insert into $code (name,subject,comment,signdate,ref)
				 values ('$in_name','$in_subject','$in_comment','$in_signdate','$in_ref')";
mysql_query($query) or die($query);
$queryString=makeQueryString();
$goUrl="noticeList.php".$queryString;
goPURL("입력되었습니다.",$goUrl);
?>
