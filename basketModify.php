<?
include_once("session.php");
include_once("include/check.php");
include_once("include/Database.class.php");
include_once("include/sqlcon.php");
foreach($_POST as $k=>$v) {
	${"in_".$k}=$v;
}
//itemid  itemnum  optionid   opnum

$i=0;
foreach ($in_itemid as $key => $value) {
	if($i==0){
		$tmp_itemid = $value;
	}else{
		$tmp_itemid .=  ",".$value;
	}
	$i++;
}
if($tmp_itemid == ""){
        $tmp_itemid = $in_itemid;
}
$i=0;
foreach ($in_itemnum as $key => $value) {
	if($i==0){
		$tmp_itemnum = $value;
	}else{
		$tmp_itemnum .= ",".$value;
	}
	$i++;
}
if($tmp_itemnum==""){
        $tmp_itemnum = $in_itemnum;
}
$i=0;
foreach ($in_optionid as $key => $value) {
	if($i==0){
		$tmp_optionid = $value;
	}else{
		$tmp_optionid .= ",".$value;
	}
	$i++;
}
if($tmp_optionid=""){
        $tmp_optionid = $in_optionid;
}
$i=0;
foreach ($in_opnum as $key => $value) {
	if($i==0){
		$tmp_opnum = $value;
	}else{
		$tmp_opnum .=  ",".$value;
	}
	$i++;
}
if($tmp_opnum==""){
        $tmp_opnum = $in_opnum;
}


$db->query("UPDATE basket set sbid='$tmp_itemid',sbnum='$tmp_itemnum',opid='$tmp_optionid',opnum='$tmp_opnum' WHERE uid='$in_buc' AND id='$uname'");
$db->disconnect()
?>
<html lang="">
    	<head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <script type="text/javascript">
        	alert("옵션/수량을 변경되였습니다.");
		location.href="/shopping_cart.php";
		//parent.location.reload();
		//window.opener.location.reload();
		//window.close();
	</script>
      </head>
      <body></body>
</html>
<?
exit;
?>