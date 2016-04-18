<?
include("common/config.shop.php");
$query = "SELECT * FROM settings";
$result = mysql_query($query) or die($query);
$row = mysql_fetch_assoc($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>설정 페이지</title>
		<link rel="stylesheet" type="text/css" href="css/common1.css" />
		<link rel="stylesheet" type="text/css" href="css/layout.css" />
		<link rel="stylesheet" type="text/css" href="css/goodsSortManageBrand.css" />
		<link rel="stylesheet" type="text/css" href="css/brandRead.css" />
		<link rel="stylesheet" type="text/css" href="css/nv.css" />
	</head>
	<body>
		<div id="total">
			<? include("include/include.header.php"); ?>
			<div id="main">
				<h4 id="mainTitle">설정</h4>
				<form action="settingsPost.php" method="post" target="action_frame" enctype="multipart/form-data">
					<dl class="readContent">
						<dt>환율</dt>
						<dd class="inputDd"><input type="text" name="Rates" class=" wd30" value="<?=$row['Rates']?>" /></dd>
						<dt>국내배송비</dt>
						<dd class="inputDd"><input type="text" name="ds" class=" wd30" value="<?=$row['dShipping']?>" /></dd>
						<dt>국제배송비</dt>
						<dd class="inputDd"><input type="text" name="is" class=" wd30" value="<?=$row['iShipping']?>" /></dd>
						<dt>수수료</dt>
						<dd class="inputDd"><input type="text" name="fees" class=" wd30" value="<?=$row['fees']?>" /></dd>
					</dl>
					<dl class="readContent dlspimg">
						<?
						$query = "SELECT * FROM sp";
						$reset = mysql_query($query) or die("error");
						$i=1;
						while ($row = mysql_fetch_array($reset)) {
							$spimg = $row["img"];
						?>
						<dt>특수코드<?=$i?></dt>
						<dd class="inputDd spimg">
							<?
							if($i==1) 
								echo '<a href="#" style="float:left;padding-top:2px;padding-right:3px;">'.
									 '<img src="images/i_add.gif" class="addspImage" data="dlspimg" /></a>';
							if($i>1){
								echo '<img src="images/i_del.gif" class="remove_project_file" data="dlsp" data_id="'.$spimg.'" /><input type="file" name="thumImage[]" class="inputItem fileHeight" />';
							}else{
								echo '<input type="file" name="sp'.$i.'image" class="inputItem fileHeight" />';
							}
							
							?>
							<img src="<? echo $brandImagesWebDir.$spimg;?>" />
						</dd>
						<?
						$i++;
						}
						?>
					</dl>
					<div class="buttonBox" style="margin-top:20px;">
						<input type="submit" value=" save " class="memEleB" />
					</div>
				</form>
				<iframe name="action_frame" width="600" height="350" style="display:none"></iframe>
			</div>
		</div>
		
		<script type="text/javascript" src="assets/plugins/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
		<script type="text/javascript" src="common/common2.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.addspImage').click(function(e) {
					e.preventDefault();
					var cls = $(this).attr("data");
					$("."+cls).append(
						'<dt style="background-color:white;"></dt>'
						+ '<dd class="inputDd">'
						+ '<img src="images/i_del.gif" class="remove_project_file" data="dlt" />'
						+ '<input type="file" name="bigImage[]" class="inputItem fileHeight" />'
						+ '</dd>');
				});
				$('.dlspimg').on('click', '.remove_project_file', function(e) {
					var spimgName = $(this).attr("data_id");
					$.ajax({
						url: 'img_del.php',
						type: 'POST',
						dataType    :   "JSON",
						data: {
							imgname: spimgName,
							imgtype: "spimg"
						},
						success :   function(response){
							if(response.status=="success"){
								alert("이미지를 삭제 하였습니다.");
							}
						}
					});
					e.preventDefault();
					$(this).parent().prev().remove();
					$(this).parent().remove();
				});
			});
		</script>
		<? require_once("common/closedb.php"); ?>
	</body>
</html>
