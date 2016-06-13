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

/**
 * PHPEXCEL生成excel文件
 * @desc 支持任意行列数据生成excel文件，暂未添加单元格样式和对齐
 */

$objReader = PHPExcel_IOFactory::createReader ( 'Excel2007' );
$objReader->setReadDataOnly ( true );
$objPHPExcel = $objReader->load ("test.xls");
//$objWorksheet = $objPHPExcel->getActiveSheet ();
$objWorksheet = $objPHPExcel->getSheet (0);
//取得excel的总行数
$highestRow = $objWorksheet->getHighestRow ();
//取得excel的总列数
$highestColumn = $objWorksheet->getHighestColumn ();
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString ( $highestColumn );
$excelData = array ();
for($row = 2; $row <= $highestRow; $row++) {
    for($col = 1; $col < $highestColumnIndex; $col++) {
        $excelData[$row-2][] = $objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ();
    }
}
echo "<pre>";
print_r($excelData);
echo "</pre>";

?>