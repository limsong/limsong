<?
include("common/config.shop.php");
//$code=$_GET['code'];
$code="tbl_freeboard";
@$page=$_GET['page'];
if(!@$_POST['key']) {
	@$key=$_GET['key'];
} else {
	@$key=$_POST['key'];
}
if(!@$_POST['keyfield']) {
@$keyfield=$_GET['keyfield'];
} else {
	@$keyfield=$_POST['keyfield'];
}
if(empty($page)) {
	$page=1;
}
if(empty($key)) {
	$addQuery=" where notify!='Y'";
} else {
	$addQuery=" where notify!='Y' $keyfield like '%$key%'";
}
$query="select count(*) from $code $addQuery";
$result=mysql_query($query) or die($query);
$total_record=mysql_result($result,0,0);
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
<title>AdminboardList</title>
	<link rel="stylesheet" type="text/css" href="css/common1.css" />
	<link rel="stylesheet" type="text/css" href="css/layout.css" />
	<link rel="stylesheet" type="text/css" href="css/boardList.css" />
	<link rel="stylesheet" type="text/css" href="css/nv.css" />
	<script type="text/javascript" src="common/common2.js"></script>
</head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>
	<div id="main">
		<h4 id="mainTitle">게시글 관리</h4>
	<form name="boardListForm" method="post" action="boardListDelPost.php?code=<?=$code?>&page=<?=$page?>&key=<?=$key?>&keyfiled=<?=$keyfiled?>"  target="action_frame">
		<table align="center" width="100%" class="memberListTable">
			<tr class="menuTr">
			  <th width="5%">선택</th>
			  <th width="5%">번호</th>
			  <th width="40%">제목</th>
			  <th width="15%">작성자</th>
			  <th width="25%">날짜</th>
			  <th width="10%">조회수</th>
			</tr>
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
				?>
				<!-- 공지쪽글//-->
				<?
				if($page=='1') {
					$currentTime=time();
					$query="select uid,subject,name,signdate,ref from $code where notify='Y' order by uid asc";
					$result=mysql_query($query) or die($query);
					$article_num=$total_record-($page-1)*$bnum_per_page;   //새로 작성한 글의 번호 지정
				while($row=mysql_fetch_assoc($result)) {                 //연관 배열
					$ou_uid=$row["uid"];
					$ou_subject=stripslashes($row["subject"]);		//역슬래시를 없애준다.두개면 하나만 없앤다.stripslashes();
					$ou_name=stripslashes($row["name"]);
					$ou_signdate=date("Y-m-d",$row["signdate"]);
					$ou_ref=$row["ref"];
				?>
				<tr class="contentTr">
					<td class="check" align="center"><input type="checkbox" value="<?=$ou_uid?>" name="check[]" /></td>
					<td class="num" align="center">공지</td>
					<td class="memId">
							<a href="boardRead.php?code=<?=$code?>&number=<?=$ou_uid?>&page=<?=$page?>
							&keyfield=<?=$keyfield?>&key=<?=$key?>"><?=$ou_subject?></a>
					</td>
					<td class="memName" align="center"><?=$ou_name?></td>
					<td class="regNum" align="center"><?=$ou_signdate?></td>
					<td align="center"><?=$ou_ref?></td>
				</tr>
				<?
				$article_num--;
					}
				}
				?>
				<!-- 일반쪽글//-->
				<?
				$currentTime=time();
				$query="select uid,subject,name,signdate,ref,thread from $code $addQuery order by fid desc,thread asc limit $first,$bnum_per_page";
				$result=mysql_query($query) or die($query);
				$article_num=$total_record-($page-1)*$bnum_per_page;   //새로 작성한 글의 번호 지정
				
				while($row=mysql_fetch_assoc($result)) {                 //연관 배열
					$ou_uid=$row["uid"];
					$ou_subject=stripslashes($row["subject"]);		//역슬래시를 없애준다.두개면 하나만 없앤다.stripslashes();
					$ou_name=stripslashes($row["name"]);
					$ou_signdate=date("Y-m-d",$row["signdate"]);
					$ou_ref=$row["ref"];
					$ou_thread=$row["thread"];
					$indentNum=strlen($ou_thread)-1; //문자열 길이게산 strlen();
					$indentWidth=($indentNum*15)."px";    //들여쓰기
				if($indentNum>0) {
				$reImg="<img src='img/tiger-version.gif' width='30' height='15' />";
				} else {
					$reImg="";
				}
				$timeGap=$currentTime-$row["signdate"];
				if($timeGap<=$notify_new_article) {
				$newImg="<img src='img/new.gif'  width='21' height='9' />";
				} else {
					$newImg="";
				}
				?>
				<tr class="contentTr">
					<td class="check" align="center"><input type="checkbox" value="<?=$ou_uid?>" name="check[]" /></td>
					<td class="num" align="center"><?=$article_num?></td>
					<td class="memId" style="padding-left:<?=$indentWidth?>">
						<?=$reImg?>
							<a href="boardRead.php?code=<?=$code?>&number=<?=$ou_uid?>&page=<?=$page?>&keyfield=<?=$keyfield?>&key=<?=$key?>"><?=$ou_subject?></a>
						<?=$newImg?>
					</td>
					<td class="memName" align="center"><?=$ou_name?></td>
					<td class="regNum" align="center"><?=$ou_signdate?></td>
					<td align="center"><?=$ou_ref?></td>
				</tr>
				<?
				$article_num--;
				}
				?>
		</table>
	</form>
	<div class="pageNavi">
	<dl class="Dl">
		<dt class="Dt Dt1">
			<?
			if($block>1) {
			$bPage=$first_page-1;   	//이전 목록
			echo "<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$bPage'>[이전".$bpage_per_block."개]</a>";
			}
			?>
		</dt>
		<dd class="Dd">
			<?
			if($page>1) {
			$bfPage=$page-1;   //이전페이지
			echo ("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$bfPage'><img src='img/prev3.gif' width='19' height='13' class='nvimg' /></a>");
			}
			?>
		</dd>
		<dd class="Dd Dd1">
			<?
			for($my_page=$first_page;$my_page<=$last_page;$my_page++) {					//현재 페이지
				if($page==$my_page) {
				echo ("[<b><span class='clll'>".$my_page."</span></b>]");
				} else {
				   echo("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$my_page'>[".$my_page."]</a>");
				}
			}
			?>
		</dd>
		<dd class="Dd">
			<?
			if($page<$total_page) {
			$nxPage=$page+1;  //다음 페이지
			echo ("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$nxPage'><img src='img/next3.gif' width='19' height='13' class='nvimg' /></a>");
		}
			?>
		</dd>
		<dt class="Dt Dt1">
			<?
			if($page<$total_page) {
			$npage=$last_page+1;   //다음 목록
			echo "<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$npage'>[다음".$bpage_per_block."개]</a>";
			}
			?>
		</dt>
	</dl>
	</div>
		<form name="searchForm" method="post"  action="boardList.php?code=<?=$code?>">
		<ul class="memberBottom">
			<li>
				<input type="button" class="memEleB" value="삭제" onclick="brandListDel(document.boardListForm)" />
			</li>
			<li>
				<input type="button" class="memEleB" value="쓰기" onclick="location.href='boardWrite.php?code=<?=$code?>'" />
			</li>
			<li><input type="submit" class="memEleB"  value="검색" /></li>
			<li><input type="text" class="border2"  name="key" size="10" /></li>
			<li>
				<select name="keyfield">
					<option value="name">작성자</option>
					<option value="subject">제목</option>
				</select>
			</li>
		</ul>
		</form>
	<iframe name="action_frame" width="600" height="350" style="display:none"></iframe>
	</div>
</div>
</body>
</html>
