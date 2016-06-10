<?php
header("Content-Type: text/html; charset=UTF-8");
include_once ("session.php");
include_once("check.php");
include_once ("common/Database.class.php");
include_once ("common/sqlcon.php");
//error_reporting(E_ALL);
//date_default_timezone_set('Asia/Seoul');
require_once 'execel/Classes/PHPExcel.php';
$in_buy_seq = $_POST["check"];
foreach ($in_buy_seq as $item => $item_val) {
    if($buy_addQuery==""){
        $buy_addQuery = " buy_seq IN ('$item_val'";
    } else {
        $buy_addQuery .= ",'$item_val'";
    }
}
$buy_addQuery .= ")";
$db_buy_query = $db->query("SELECT * FROM buy WHERE $buy_addQuery AND  buy_status='2' ORDER BY buy_seq DESC");
$db_buy_rows = $db->loadRows();
foreach ($db_buy_rows as $key => $value){

        $buy_seq = $value["buy_seq"];
        if ($addQuery == "") {
            $addQuery = " WHERE buy_seq='$buy_seq'";
        } else {
            $addQuery .= " or buy_seq='$buy_seq'";
        }
}

$data=array();
$db_buy_goods_query = $db->query("SELECT * FROM buy_goods  $addQuery ORDER BY buy_goods_seq DESC");
$db_buy_goods_rows = $db->loadRows();
$count = count($db_buy_goods_rows);
$j = 0;
for($i=0;$i<$count;$i++){
    $buy_goods_buy_goods_code = $db_buy_goods_rows[$i]["buy_goods_code"];
    $buy_goods_count = $db_buy_goods_rows[$i]["buy_goods_count"];
    $buy_goods_option = $db_buy_goods_rows[$i]["buy_goods_option"];
    $db_goods_query = $db->query("SELECT goods_name,goods_opt_type,goods_opt_Num FROM goods WHERE goods_code='$buy_goods_buy_goods_code'");
    $db_goods_rows = $db->loadRows();
    $goods_name = $db_goods_rows[0]["goods_name"];
    $goods_opt_type=$db_goods_rows[0]["goods_opt_type"];
    $goods_opt_Num = $db_goods_rows[0]["goods_opt_Num"];
    $buy_goods_name = $db_buy_goods_rows[$i]["buy_goods_name"];
    $buy_goods_prefix = $db_buy_goods_rows[$i]["buy_goods_prefix"];
    $buy_goods_suffix = $db_buy_goods_rows[$i]["buy_goods_suffix"];
    if ($goods_opt_type == "0") {
        //옵션없음
        //기본상품 / 사이즈 : S / 색상 : 연두 / 1개(30, 000원
        if($buy_goods_option=="0"){
            $goods_info = $goods_name;
            $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
            $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
        }else{
            //추가 옵션상품
            $goods_info = "추가옵션 / $buy_goods_name : $buy_goods_prefix";
            $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
            $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
        }

    }elseif($goods_opt_type=="1"){
        //일반옵션
        if($buy_goods_option == "0") {
            $goods_info = "기본상품 / $buy_goods_name : $buy_goods_prefix";
            $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
            $total_buy_goods_sale += ($buy_goods_price - $buy_goods_price_total) * $buy_goods_count;
        } else {
            //추가 옵션상품
            $goods_info = "추가옵션 / $buy_goods_name : $buy_goods_prefix";
            $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
            $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
        }
    }elseif($goods_opt_type=="2"){
        //가격선택옵션
        if($goods_opt_Num=="2"){
            //가격선택옵션2
            if($buy_goods_option=="0") {
                $db_goods_grid_name_query = $db->query("select opName1 from goods_option_grid_name where opName2='$buy_goods_name'");
                $db_goods_grid_name_rows = $db->loadRows();
                $opName1 = $db_goods_grid_name_rows[0]["opName1"];

                $db_goods_grid_name_query = $db->query("select opName1 from goods_option_grid_name where opName2='$buy_goods_prefix'");
                $db_goods_grid_name_rows = $db->loadRows();
                $opName2 = $db_goods_grid_name_rows[0]["opName1"];
                $goods_info = "기본상품 / $opName1 : $buy_goods_name / $opName2 : $buy_goods_prefix";
                $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                $total_buy_goods_sale += ($buy_goods_price - $buy_goods_price_total) * $buy_goods_count;
            } else {
                //추가 옵션상품
                $goods_info = "추가옵션 / $buy_goods_name : $buy_goods_prefix";
                $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
            }
        }elseif($goods_opt_Num=="3"){
            //가격선택옵션3
            if($buy_goods_option == "0") {
                $db_goods_grid_name_query = $db->query("select opName1 from goods_option_grid_name where opName2='$buy_goods_name'");
                $db_goods_grid_name_rows = $db->loadRows();
                $opName1 = $db_goods_grid_name_rows[0]["opName1"];

                $db_goods_grid_name_query = $db->query("select opName1 from goods_option_grid_name where opName2='$buy_goods_prefix'");
                $db_goods_grid_name_rows = $db->loadRows();
                $opName2 = $db_goods_grid_name_rows[0]["opName1"];

                $db_goods_grid_name_query = $db->query("select opName1 from goods_option_grid_name where opName2='$buy_goods_suffix'");
                $db_goods_grid_name_rows = $db->loadRows();
                $opName3 = $db_goods_grid_name_rows[0]["opName1"];

                $goods_info = "기본상품 / $opName1 : $buy_goods_name / $opName2 : $buy_goods_prefix / $opName3 : $buy_goods_suffix";
                $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                $total_buy_goods_sale += ($buy_goods_price - $buy_goods_price_total) * $buy_goods_count;
            } else {
                //추가 옵션상품
                $goods_info = "추가옵션 / $buy_goods_name : $buy_goods_prefix";
                $total_buy_goods_price += $buy_goods_price_total * $buy_goods_count;
                $total_buy_goods_sale += ($buy_goods_price-$buy_goods_price_total)*$buy_goods_count;
            }
        }
    }
    if($tmp_buy_seq=="" || $db_buy_goods_rows[$i]["buy_seq"]==$db_buy_rows[$j]["buy_seq"]){
        $tmp_buy_seq  = $db_buy_rows[$j]["buy_seq"];
    }else{
        $j++;
    }
    $array = array(
        '상품명'=>$goods_name,
        '옵션명'=>$goods_info,
        '수량'=>$buy_goods_count,
        '수취인'=>$db_buy_rows[$j]["buy_dlv_name"],
        '핸드폰번호'=>$db_buy_rows[$j]["buy_dlv_mobile"],
        '우편번호'=>$db_buy_rows[$j]["buy_dlv_zipcode"],
        '주소'=>$db_buy_rows[$j]["buy_dlv_addr_base"],
        '배송메모'=>$db_buy_rows[$j]["buy_memo"]
    );
    array_push($data,  $array);
}

//var_dump($data);


/*$data=array(

    0=>array(
        'id'=>1001,
        'username'=>'张飞',
        'password'=>'123456',
        'address'=>'三国时高老庄250巷101室'
    ),
    1=>array(
        'id'=>1002,
        'username'=>'关羽',
        'password'=>'123456',
        'address'=>'三国时花果山'
    ),
    2=>array(
        'id'=>1003,
        'username'=>'曹操',
        'password'=>'123456',
        'address'=>'延安西路2055弄3号'
    ),
    3=>array(
        'id'=>1004,
        'username'=>'刘备',
        'password'=>'654321',
        'address'=>'愚园路188号3309室'
    )
);*/

$objPHPExcel=new PHPExcel();
$objPHPExcel->getProperties()->setCreator('http://www.phpernote.com')
    ->setLastModifiedBy('http://www.phpernote.com')
    ->setTitle('Office 2007 XLSX Document')
    ->setSubject('Office 2007 XLSX Document')
    ->setDescription('Document for Office 2007 XLSX, generated using PHP classes.')
    ->setKeywords('office 2007 openxml php')
    ->setCategory('Result file');
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1','상품명')
    ->setCellValue('B1','옵션명')
    ->setCellValue('C1','수량')
    ->setCellValue('D1','수취인')
    ->setCellValue('E1','핸드폰번호')
    ->setCellValue('F1','우편번호')
    ->setCellValue('G1','주소')
    ->setCellValue('H1','배송메모');

$i=2;
foreach($data as $k=>$v){
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i,$v['상품명'])
        ->setCellValue('B'.$i,$v['옵션명'])
        ->setCellValue('C'.$i,$v['수량'])
        ->setCellValue('D'.$i,$v['수취인'])
        ->setCellValue('E'.$i,$v['핸드폰번호'])
        ->setCellValue('F'.$i,$v['우편번호'])
        ->setCellValue('G'.$i,$v['주소'])
        ->setCellValue('H'.$i,$v['배송메모']);
    $i++;
}
$objPHPExcel->getActiveSheet()->setTitle('뉴엔에스');
$objPHPExcel->setActiveSheetIndex(0);
//$filename=urlencode('学生信息统计表').'_'.date('Y-m-dHis');
$filename='뉴엔에스_주문_'.date('Y-m-dHis');
//生成xlsx文件

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');


//生成xls文件
/*header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');*/

$objWriter->save('php://output');
?>
