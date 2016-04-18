<?
include("common/config.shop.php");
include("fckeditor/fckeditor.php");
$code=$_GET['code'];
$page=$_GET['page'];
$key=$_GET['key'];
$keyfield=$_GET['keyfield'];
$number=$_GET['number'];
$query="select * from $code where uid='$number'";
$result=mysql_query($query) or die($query);
$row=mysql_fetch_assoc($result);
$ou_name=stripslashes($row['name']);
$ou_subject=stripslashes($row['subject']);
$ou_passwd=$row['passwd'];
$ou_notify=$row['notify'];
$ou_signdate=date("Y-m-d",$row['signdate']);
$ou_ipInfo=$row['ipInfo'];
$ou_ref=$row['ref'];
$ou_userFile1Name=$row['userFile1Name'];
$ou_userFile2Name=$row['userFile2Name'];
$ou_comment=stripslashes($row['comment']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>boardRead</title>
<link rel="stylesheet" type="text/css" href="css/common1.css" />
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<link rel="stylesheet" type="text/css" href="css/boardRead.css" />
<script type="text/javascript" src="common/jslb_ajax.js"></script>
<script type="text/javascript" src="common/common2.js"></script>
<script type="text/javascript">
window.onload=function() {
	var obj=document.getElementById("jjList").getElementsByTagName("a");
	for(var i=0; i < obj.length;i++) {
		if(obj[i].addEventListener) {
			obj[i].addEventListener("click",showChBox,false);
		} else {
			obj[i].attachEvent("onclick",showChBox);
		}
	}
}
</script>
</head>
<body>
<div id="total">
    <? include("include/include.header.php"); ?>

	<div id="main" style="width:99%;">
		<dl id="readContent" style="width: 97%;">
			<dt>작성일</dt>
			<dd><?=$ou_signdate?></dd>
			<dt>조회수</dt>
			<dd><?=$ou_ref?></dd>
			<dt>제목</dt>
			<dd><?=$ou_subject?></dd>
			<dt>이름</dt>
			<dd><?=$ou_name?></dd>
			<dt>파일1</dt>
			<dd><a href="downFile.php?code=<?=$code?>&number=<?=$number?>&fileNum=1"><?=$ou_userFile1Name?></a></dd>
			<dt>파일2</dt>
			<dd><a href="downFile.php?code=<?=$code?>&number=<?=$number?>&fileNum=2"><?=$ou_userFile2Name?></a></dd>
			<dt>공지사항</dt>
			<dd><input type="checkbox" name="notify" value="Y" <?if($ou_notify=='Y'){echo "checked='checked'";}?> />(공지글일 경우 체크합니다.)</dd>
			<dt>내용</dt>
			<dd class="inputDate">
				<?php
					$sBasePath ="fckeditor/";

					$oFCKeditor = new FCKeditor('comment');
					$oFCKeditor->BasePath	= $sBasePath;
					$oFCKeditor->Width='90%';
					$oFCKeditor->Height=500;
					$oFCKeditor->Value=$ou_comment;
					$oFCKeditor->ToolbarSet='BoardSet'; 					//fckconfig.js P99
					$oFCKeditor->Create();
				?>
			</dd>
		</dl>
		<div class="buttonBox">
			<?
				if($ou_notify=='N') {
			?>
			<input type="Image" src="img/btn_opinion1.gif" alt="답변" width="59" height="25"	onclick="location.href='boardReply.php?code=<?=$code?>&number=<?=$number?>'" />
			<?
			}
			?>
			<input type="Image" src="img/btn_modify2.gif" alt="수정" width="63" height="25" onclick="checkPasswd('modify')" />
			<input type="Image" src="img/btn_delete2.gif" alt="삭제" onclick="checkPasswd('delete')" id="Delete" tUrl="chPasswd.php?code=<?=$code?>&number=<?=$number?>&key=<?=$key?>&keyfield=<?=$keyfield?>&page=<?=$page?>" />
			<input type="Image" src="img/netpop_btnall.gif" alt="목록" onclick="location.href='boardList.php?code=<?=$code?>&key=<?=$key?>&keyfield=<?=$keyfield?>'"/>
		</div>
		<div id="jjList">
			<?php
			$jjCode=$code."_comment";
			$query="select uid,name,comment,signdate,ipInfo from $jjCode where puid='$number' order by uid asc";
			$result=mysql_query($query) or die($query);
			while($row=mysql_fetch_assoc($result)) {
				$ou_uid=$row["uid"];
				$ou_name=stripslashes($row["name"]);
				$ou_comment=nl2br(stripslashes($row["comment"]));
				$ou_signdate=date("Y-m-d: H:i:s",$row["signdate"]);
				$ou_ipInfo=$row["ipInfo"];
			?>
			<table cellpadding="1" cellspacing="1" bgcolor="#333333" border="0" width="90%" id="jjokUnit<?=$ou_uid?>" class="jjokTbl">
				<colgroup>
					<col width="10%" align="center"  valign="center"/>
					<col width="50%" align="center"  valign="center"/>
					<col width="20%" align="center"  valign="center"/>
					<col width="15%" align="center"  valign="center"/>
				</colgroup>
				<tr bgcolor="#ffffff">
					<td valign="center"><?=$ou_name?></td>
					<td valign="center"><?=$ou_comment?></td>
					<td valign="center"><?=$ou_signdate?><br /><?=$ou_ipInfo?></td>
					<td valign="center"><a href="#A" type="x" jjuid="<?=$ou_uid?>" tQuery="<?=$_SERVER['QUERY_STRING']?>">
									<img src="img/reply_delete.gif" alt="" /></a>
						  <a href="#A" type="e" jjuid="<?=$ou_uid?>" tQuery="<?=$_SERVER['QUERY_STRING']?>">
							 		<img src="img/reply_check.gif" alt="" /></a>
					</td>
				</tr>
			</table>
			<?
			}
			?>
		</div>
		<div class="jjokInputForm">
		<?
		if($ou_notify=='N') {
		?>
		<form name="jjokInputForm">
			<table cellpadding="0" cellspacing="1" border="0" width="610" bgcolor="#163973">
				<colgroup bgcolor="#f4f4f4">
					<col width="15%" align="center" />
					<col width="30%" />
					<col width="15%" align="center" />
					<col width="30%" />
					<col width="10%" />
				</colgroup>
				<tr bgcolor="#eaebea">
					<td>Name:</td>
					<td class="Whrmf"><input type="text" name="jjName" id="jjName" size="18" class="border" /></td>
					<td>Password:</td>
					<td><input type="Password" name="jjPasswd" id="jjPasswd" size="18" class="border" /></td>
					<td rowspan="2" bgcolor="#ffffff">
					<a href="#A">
						<img src="img/tgs14_tmp.gif" id="jjBtn" onclick="checkJJForm()" tQuery="<?=$_SERVER['QUERY_STRING']?>" />
					</a>
					</td>
				</tr>
				<tr>
					<td colspan="4" bgcolor="#eaebea">
					<textarea name="jjComment" id="jjComment" cols="75%" rows="3"></textarea>
					</td>
				</tr>
			</table>
		</form>
		<?
		}
		?>
		<!------jjokModiForm------>
		<form name="jjokModiForm" id="jjokModiForm">
			<input type="hidden" name="jjuid" />
			<table width="610" border="0" cellpadding="3" cellspacing="1">
				<colgroup>
					<col width="10%" align="center" />
					<col width="40%" />
					<col width="10%" align="center" />
					<col width="22%" />
					<col width="18%" />
				</colgroup>
				<tr>
					<td>작성자</td>
					<td>
							<input type="text" name="jjName" size="18" class="border" />
					</td>
				</tr>
				<tr>
				<td>내용</td>
				<td colspan="3"><textarea name="jjComment" class="comCon"></textarea></td>
				<td>
					<input type="button" value="확인" class="memEleB" onclick="checkJJMForm(this)" tQuery="<?=$_SERVER['QUERY_STRING']?>&type=modify" />				
					<input type="button" value="취소" class="memEleB" onclick="this.form.reset();this.form.style.display='none'" />
				</td>
				</tr>
			</table>
		</form>
		<!-------jjokDelForm------->
		<form name="jjokDelForm" id="jjokDelForm">
			<input type="hidden" name="jjuid" />
			<table border="0" cellpadding="3" cellspacing="0">
				<tr>
					<td>
						<input type="button" value="삭제" class="memEleB" tQuery="<?=$_SERVER['QUERY_STRING']?>&type=delete" onclick="checkJJDForm(this)" />
						<input type="button" value="취소" class="memEleB" onclick="this.form.reset();this.form.style.display='none'" />
					</td>
				</tr>
			</table>
		</form>
	</div>
	</div>
	<iframe name="action_frame" width="610"  height="100" style="display:none"></iframe>
</div>
</body>
</html>
