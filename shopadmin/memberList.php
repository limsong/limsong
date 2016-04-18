<?
include("common/config.shop.php");

$page=$_GET['page'];

if(!$_POST['key']) {
	$key=$_GET['key'];
} else {
	$key=$_POST['key'];
}
if(!$_POST['keyfield']) {
	$keyfield=$_GET['keyfield'];
} else {
	$keyfield=$_POST['keyfield'];
}
if(empty($page)) {
	$page=1;
}
if(empty($key)) {
	$addQuery="";
} else {
	$addQuery=" where $keyfield like '%$key%'";
}
$query="select count(*) from shopMembers $addQuery";
$result=mysql_query($query) or die($query);
$total_record=mysql_result($result,0,0);  			//count 결과값 접근 0,0 (row,fild);
if($total_record==0) {
	$first=1;
} else {
	$first=($page-1)*$bnum_per_page;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/memberList.css" />
<link rel="stylesheet" type="text/css" href="css/mask.css" />
<script type="text/javascript" src="common/common.js"></script>
</head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>
	<div id="left">
		<h3 id="leftTitle">Manager List</h3>
		<ul id="leftMenu">
			<li>테스터</li>
			<li>테스터</li>
			<li>테스터</li>
			<li>테스터</li>
			<li>테스터</li>
			<li>테스터</li>
			<li>테스터</li>
		</ul>
		<p>&nbsp;</p>
	</div>
	<div id="main">
	<div id="loading-mask" style=""></div>
		<div id="loading">
			<div class="loading-indicator"><img src="img/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/><span id="loading-msg">처리중.....</span></div>
		</div>
		<h4 id="mainTitle">Content Title</h4>
	<form name="memberForm" method="post" action="memberDelPost.php?page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>" target="action_frame">
		<table align="center" width="98%" class="memberListTable">
			<tr class="menuTr">
				<th width="5%">선택</th>
				<th width="5%">번호</th>
				<th width="8%">ID</th>
				<th width="13%">작성자</th>
				<th width="13%">주민등록번호</th>
				<th width="26%">Email</th>
				<th width="12%">전화번호</th>
				<th width="12%">가입일</th>
			</tr>
				<?
					$query="select id,name,regNum,email,mphone,signdate from shopMembers $addQuery order by id desc limit $first,$bnum_per_page";
					$result=mysql_query($query) or die($query);
					$article_num=$total_record-($page-1)*$bnum_per_page;   //새로 작성한 글의 번호 지정
					while($row=mysql_fetch_assoc($result)) {
						$ou_id=$row["id"];
						$ou_name=$row["name"];
						$ou_regNum=$row["regNum"];
						$ou_email=$row["email"];
						$ou_mphone=$row["mphone"];
						$ou_signdate=date("Y-m-d",$row["signdate"]);
				?>
			<tr class="contentTr" align="center">
				<td class="check" align="center"><input type="checkbox" value="<?=$ou_id?>" name="check[]" /></td>
				<td class="num" align="center"><?=$article_num?></td>
				<td class="memId" align="center">
				  <a href="memberRead.php?id=<?=$ou_id?>&page=<?=$page?>&key=<?=$key?>&keyfield=<?=$keyfield?>"><?=$ou_id?></a><!--Enter치먼 &가표시안됨-->
				</td>
				<td class="memName" align="center"><?=$ou_name?></td>
				<td class="regNum" align="center"><?=$ou_regNum?></td>
				<td class="memEmail" align="center"><?=$ou_email?></td>
				<td class="memMphone" align="center"><?=$ou_mphone?></td>
				<td class="ref" align="center"><?=$ou_signdate?></td>
			</tr>
			<?
			$article_num--;
			}
			?>
		</table>
	</form>
<div class="pageNavi">
	<?
		$total_page=ceil($total_record/$bnum_per_page); //젠체 페이지수
		$total_block=ceil($total_page/$bpage_per_block); //젠체 block수 
		$block=ceil($page/$bpage_per_block);  //현재 목록
		$first_page=($block-1)*$bpage_per_block+1;   //[4][5][6] $first_page=[4];
		if($block>=$total_block) {
			$last_page=$total_page;
		} else {
						$last_page=$block*$bpage_per_block;
					}
		if($block>1) {
			$bPage=$first_page-1;   	//이전 목록
			echo "[<a href='memberList.php?key=$key&keyfield=$keyfield&page=$bPage'>이전".$bpage_per_block."개</a>]";
		}
		if($page>1) {
			$bfPage=$page-1;   //이전페이지
			echo ("<a href='memberList.php?key=$key&keyfield=$keyfield&page=$bfPage'><img src='img/prev3.gif' width='21' height='13' /></a>");
		}
		for($my_page=$first_page;$my_page<=$last_page;$my_page++) {					//현재 페이지
			if($page==$my_page) {
			echo ("[<b><span class='clll'>".$my_page."</span></b>]");
			} else {
							echo("<a href='memberList.php?key=$key&keyfield=$keyfield&page=$my_page'>[".$my_page."]</a>");
						}
		}
		if($page<$total_page) {
			$nxPage=$page+1;  //다음 페이지
			echo ("<a href='memberList.php?key=$key&keyfield=$keyfield&page=$nxPage'><img src='img/next3.gif' width='21' height='13' /></a>");
		}
		if($page<$total_page) {
			$npage=$last_page+1;   //다음 목록
			echo "<a href='memberList.php?key=$key&keyfield=$keyfield&page=$npage'>[다음".$bpage_per_block."개]</a>";
		}
	?>
</div>
		<form name="searchForm" method="post"  action="memberList.php">
		<ul class="memberBottom">
			<li id="memDelButton">
			<input type="button" class="border1" value="삭제" onclick="listMemDel(document.memberForm)" /></li>
			<li><input type="submit" class="border1"  value="검색" /></li>
			<li><input type="text" class="border2"  name="key" size="10" /></li>
			<li>
				<select name="keyfield" class="border3">
					<option value="id">ID</option>
					<option value="email">Email</option>
					<option value="mphone">Mphone</option>
					<option value="name">작성자</option>
					<option value="regNum">주민등록증</option>
				</select>
			</li>
		</ul>
		</form>
	<iframe name="action_frame" style="display:none"></iframe>
	</div>
</div>
</body>
</html>
