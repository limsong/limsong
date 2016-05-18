<?php
include_once("session.php");
include_once("include/config.php");
include("include/sqlcon.php");
header("Content-Type: text/html; charset=UTF-8");
$goods_name = $_POST["goods_name"];
$goods_code = $_POST["goods_code"];//아이템코드
$goods_opt_type = $_POST["goods_opt_type"];
$goods_opt_num = $_POST["goods_opt_num"];
$itemId = $_POST["itemId"];
$opid = $_POST["opid"];
$itemnum = $_POST["itemnum"];
$opnum = $_POST["opnum"];
$v_oid = generate_password();
$itemIdArr = explode(",", $itemId);
$opidArr = explode(",", $opid);
$itemnumArr = explode(",", $itemnum);
$opnumArr = explode(",", $opnum);
$in_signdate = date("Y-m-d H:i:s", time());

$itemidCount = count($itemIdArr);
for ($i = 0; $i < $itemidCount; $i++) {
    $id = $itemIdArr[$i];
    if ($i == 0) {
        $addQuery = " WHERE id='$id'";
    } else {
        $addQuery .= " OR id='$id'";
    }
}

$db->query("SELECT sellPrice,sb_sale FROM goods WHERE goods_code='$goods_code'");
$dbdata = $db->loadRows();
$ou_sellPrice = $dbdata[0]["sellPrice"];
$ou_sb_sale = (100 - $dbdata[0]["sb_sale"]) / 100;
if ($goods_opt_type == "0") {
    if ($ou_sb_sale > 0) {
        $itemSum = $itemnum * ($ou_sellPrice * $ou_sb_sale);
    } else {
        $itemSum = $itemnum * $ou_sellPrice * $ou_sb_sale;
    }
} else if ($goods_opt_type == "1") {

    $db->query("SELECT sellPrice FROM goods_option_single_value $addQuery ORDER BY id desc");
    $dbdata = $db->loadRows();
    $count = count($dbdata);
    for ($i = 0; $i < $count; $i++) {
        $itemSum = $itemSum + $dbdata[$i]["sellPrice"] * $ou_sb_sale * $itemnumArr[$i];
    }
    $opidCount = count($opidArr);
    if ($opnum != "") {
        for ($i = 0; $i < $opidCount; $i++) {
            $id = $opidArr[$i];
            if ($i == 0) {
                $addQuery = " WHERE id='$id'";
            } else {
                $addQuery .= " OR id='$id'";
            }
        }
        $db->query("SELECT opValue2 FROM goods_option $addQuery ORDER BY id desc");
        $dbdata = $db->loadRows();
        $count = count($dbdata);
        for ($i = 0; $i < $count; $i++) {
            $opSum = $opSum + $dbdata[$i]["opValue2"] * $ou_sb_sale * $opnumArr[$i];
        }
    } else {
        $opSum = 0;
    }
} else {
    $db->query("SELECT opValue2 FROM goods_option_grid_value $addQuery ORDER BY id desc");
    $dbdata = $db->loadRows();
    $count = count($dbdata);
    for ($i = 0; $i < $count; $i++) {
        $itemSum = $itemSum + $dbdata[$i]["opValue2"] * $ou_sb_sale * $itemnumArr[$i];
    }
    $opidCount = count($opidArr);
    if ($opnum != "") {
        for ($i = 0; $i < $opidCount; $i++) {
            $id = $opidArr[$i];
            if ($i == 0) {
                $addQuery = " WHERE id='$id'";
            } else {
                $addQuery .= " OR id='$id'";
            }
        }
        $db->query("SELECT opValue2 FROM goods_option $addQuery ORDER BY id desc");
        $dbdata = $db->loadRows();
        $count = count($dbdata);
        for ($i = 0; $i < $count; $i++) {
            $opSum = $opSum + $dbdata[$i]["opValue2"] * $opnumArr[$i];
        }
    } else {
        $opSum = 0;
    }
}

//$sum = $itemSum + $opSum;
if (!empty($goods_code) & !empty($goods_name)) {
    $db->query("INSERT INTO basket (id,v_oid,orderNum,goods_name,goods_code,sbid,sbnum,opid,opnum,signdate) 
        VALUES 
        ('$uname','$v_oid','X','$goods_name','$goods_code','$itemId','$itemnum','$opid','$opnum','$in_signdate')");
    if($_POST["data_mod"]=="buynow"){
        $db->query("SELECT uid FROM basket WHERE v_oid='$v_oid'");
        $db_basket_query = $db->loadRows();
        $basket_uid = $db_basket_query[0]["uid"];
        echo "success,$basket_uid";
    }else{
        echo "success";
    }
} else {
    echo "error";
}
$db->disconnect();
?>