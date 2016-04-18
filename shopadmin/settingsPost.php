<?php
include("common/config.shop.php");
/**
 * Created by PhpStorm.
 * User: limsong
 * Date: 14. 10. 2.
 * Time: 오후 7:33
 */
$Rates = $_POST["Rates"];//환율
$ds = $_POST["ds"];//국내배송비
$is = $_POST["is"];//국제배송비
$fees = $_POST["fees"];//수수료


foreach($_FILES as $k=>$v) {
    if($v["size"]>0) {
        $fieldName=$k;
        $arrUserSelectedFileName=$v["name"];
        $arrFileInfo=explode(".",$arrUserSelectedFileName);
        $fileExt=strtolower($arrFileInfo[count($arrFileInfo)-1]);//대문자를 소문자로
        $upfieldName=$fieldName."='".$arrUserSelectedFileName."'";
        $UploadedFile=$_FILES[$k]["tmp_name"];
        $arrFileInfo=explode("=",$upfieldName);
        $dbfielname=$arrFileInfo[count($arrFileInfo)-2];
        $dbupfieldName=$goods_code.$dbfielname.".".$fileExt;
        $rmDest=$brandImagesDir.$goods_code.$dbfielname.".gif";
        $fileDest=$brandImagesDir.$dbupfieldName;
        //exec("rm -f $rmDest");
        @unlink($rmDest);
        if(!move_uploaded_file($UploadedFile,$fileDest)) {
            die("파일 업로드 실패 관리자에게 문의하세요");
        }
    }
}

$query = "SELECT count(Rates) FROM settings";
$result = mysql_query($query) or die("error");
$count = mysql_result($result,0,0);
if($count > 0){
    $query = "UPDATE settings SET Rates='$Rates',dShipping='$ds',iShipping='$is',fees='$fees'";
}else{
    $query = "INSERT INTO settings (Rates,dShipping,iShipping,fees) VALUES ('$Rates','$ds','$is','$fees')";
}
mysql_query($query);
require_once("common/closedb.php");
?>
<script type="text/javascript">
    <? if($count>0) echo "alert(\"수정 되였습니다.\");";else echo "alert(\"추가 되였습니다.\");" ?>
</script>
<?
require_once("common/closedb.php");
exit;
?>