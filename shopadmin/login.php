<?php
include_once("session.php");
include("common/config.shop.php");
$UserName = $_POST["UserName"];
$Password = $_POST["Password"];
$query = "select * from adminuser where UserName='$UserName'";
$result = mysql_query($query) or die ("$query");
$row = mysql_fetch_assoc($result);
$ou_Password = $row["Password"];
?>
<!doctype html>
<html lang="ko">
	<body>
		<head>
			<meta charset="utf-8">
			<?
			if(strcmp($Password,$ou_Password)){
			?>
			<script>
				alert("아이디 혹은비밀번호가 맞지않습니다.");
				location.href="index.php";
			</script>
			<?
			}else{
				$_SESSION["UserName"]=$UserName;
				$_SESSION["Password"]=$Password;
			?>
			<script>
				location.href="orderList.php";
			</script>
			<?
			}
			?>
		</head>
	</body>
</html>
<?
include("common/closedb.php");
?>