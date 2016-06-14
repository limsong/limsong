<?php
/**
 * Created by PhpStorm.
 * User: ONE
 * Date: 2016. 6. 13.
 * Time: 오전 10:14
 */
header("Content-Type: text/html; charset=UTF-8");
include_once ("session.php");
include_once("check.php");
include_once ("common/Database.class.php");
include_once ("common/sqlcon.php");
require_once 'execel/Classes/PHPExcel.php';
$FileDir="/www/web/sozo/public_html/userFiles/file/";
/**
 * PHPEXCEL生成excel文件
 * @desc 支持任意行列数据生成excel文件，暂未添加单元格样式和对齐
 */

$signdate = time();
if($_FILES["excelup"]["size"]>0) {
    $upFileName=$signdate.".xlsx";										                    //실제로 업로드될 파일
    $selectUserFileName=$_FILES["excelup"]["name"];							                //실제로 사용자가 선택한 파일
    $uploadedFile=$_FILES["excelup"]["tmp_name"];
}

$fileSource=$uploadedFile;
$fileDest=$FileDir.$upFileName;
if(!move_uploaded_file($fileSource,$fileDest)) {
    die("파일 업로드 실패 관리자에게 문의하세요");
}

$db->query("SELECT dlv_com_seq FROM delivery_company WHERE dlv_com_flag='1'");
$db_delivery_company = $db->loadRows();
$dlv_com_seq = $db_delivery_company[0]["dlv_com_seq"];

$objReader = PHPExcel_IOFactory::createReader ( 'Excel2007' );
$objReader->setReadDataOnly ( true );
$objPHPExcel = $objReader->load ($fileDest);
//$objWorksheet = $objPHPExcel->getActiveSheet ();
$objWorksheet = $objPHPExcel->getSheet (0);
//取得excel的总行数
$highestRow = $objWorksheet->getHighestRow ();
//取得excel的总列数
$highestColumn = $objWorksheet->getHighestColumn ();
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString ( $highestColumn );
$excelData = array ();
for($row = 2; $row < $highestRow; $row++) {
    for($col = 0; $col < 2; $col++) {
        $excelData[$row][] = $objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ();
        $buy_seq = $excelData[$row][0];
        $buy_goods_dlv_tag_no = $excelData[$row][1];
        if($buy_seq!="" && $buy_goods_dlv_tag_no!=""){
            $buy_goods_query_add_val = '';
            $db->query("UPDATE buy_goods SET buy_goods_dlv_tag_no='$buy_goods_dlv_tag_no',dlv_com_seq='$dlv_com_seq' WHERE buy_seq='$buy_seq'");
            $db->query("UPDATE buy set buy_status='8' WHERE buy_seq='$buy_seq'");
        }
    }
}
/*echo "<pre>";
print_r($excelData);
echo "</pre>";*/
if(!unlink($fileDest)) {
    die("파일 업로드 실패 관리자에게 문의하세요");
}

header('Location: /shopadmin/orderList.php?code=buy&delivery=4');
?>