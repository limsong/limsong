<?
//header('Content-Type: text/html; charset=utf-8');
include("common/config.shop.php");
include("check.php");
$debug = false;
foreach($_POST as $k=>$v) {
    ${"in_".$k}=addslashes($v);
}
$in_inputDate=date("Y-m-d H:i:s",time());
foreach($_FILES as $k=>$v) {
    for($i=0;$i < count($_FILES[$k]["name"]);$i++){
        if($_FILES[$k]["size"][$i]>0) {
            $fieldName=$k;
            $arrUserSelectedFileName=explode(".",$_FILES[$k]["name"][$i]);
            $imageExt=$arrUserSelectedFileName[count($arrUserSelectedFileName)-1];
            if(in_array($imageExt,$arr_allow_image_ext)) {
                $arrFieldName[]=$fieldName;
                $arrUploadedFile[]=$_FILES[$k]["tmp_name"][$i];
                $arrImgExt[]=$imageExt;
            } else {
                echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
                alertExit("상품 이미지에러");
            }
        }
    }

    /*
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";
    */
}
$addFields="";
$addValues="";
for($i=0;$i<count($arrFieldName);$i++) {
    $fileSource=$arrUploadedFile[$i];
    $insertFileName=generate_password().$arrFieldName[$i].".".$arrImgExt[$i];
    $dest=$brandImagesDir.$insertFileName;
    if($debug=="true"){
        echo "$"."fileSource = ".$fileSource."<br>";
        echo "$"."dest = ".$dest."<br>";
    }else{
        if(!move_uploaded_file($fileSource,$dest)) {
            echo "<script type=\"text/javascript\">setTimeout(\"parent.loadingMask('off')\",parent.maskTime);</script>";
            alertExit("파일 업로드 실패 관리자 문의");
        }
    }
    $addFields.=",".$arrFieldName[$i];
    $addValues.=",'".$insertFileName."'";
    $query = "INSERT INTO banner (type,imgName,inputDate) VALUES ('$arrFieldName[$i]','$insertFileName','$in_inputDate')";
    mysql_query($query) or die($query);
    
    if($debug=="true"){
        echo "$"."addFields = ".$addFields."<br>";
        echo "$"."addValues = ".$addValues."<br>";
    }
}
if($debug=="true") {
}else{
?>
<script type="text/javascript">
    alert("입력되었습니다.");
    //setTimeout("parent.loadingMask('off')",parent.maskTime);
    //parent.location.reload();
    parent.location.href="design.php";
</script>
<?
}
mysql_close($db);
exit;
?>