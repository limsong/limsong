<?
include("common/config.shop.php");
$code=$_GET['code'];
$number=$_GET['number'];
$query="select userFile{$fileNum},userFile{$fileNum}Name from $code where uid='$number'";

$result=mysql_query($query) or dir($query);
$row=mysql_fetch_row($result);
$userFile=$row[0];
$userFileName=$row[1];

header("Content-Type:file/unknown");
header("Content-Disposition:attachment;filename=$userFileName");
//Content-Disposition:attachment; IE의 save As 동작을 강제로 작동하는 역할;열린후 보여주는 file의 이름->filename=$userFileName
header("Content-Transfer=Encoding:binary");

$dest=$userFileDir.$userFile;
$fh=fopen($dest,"rb");
fpassthru($fh);
?>
