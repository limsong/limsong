<?
include_once ("session.php");
//include_once ("include/check.php");
include_once("include/config.php");
include_once("include/sqlcon.php");
//header("Content-Type: text/html; charset=UTF-8");
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<shopBrand>';
$db->query("SELECT uid,goods_code,sbid,sbnum,opid,opnum,v_oid FROM basket WHERE id='$uname' order by uid desc");
$dbdata = $db->loadRows();
foreach ($dbdata as $k => $v) {
    $uid = $v["uid"];
    $basketuid = $v["v_oid"];
    $sbid = $v["sbid"];
    $sbidArr = explode(",", $sbid);
    $sbnum = $v["sbnum"];
    $sbnumArr = explode(",", $sbnum);
    $goods_code = $v["goods_code"];
    $i = 0;
    $sbidQuery = "";
    foreach ($sbidArr as $a => $b) {
        if ($b != "") {
            if ($i == 0) {
                $sbidQuery = "WHERE id IN (" . $b . "";
            } else {
                $sbidQuery .= "," . $b . "";
            }
            $i++;
        }
    }
    $sbidQuery .= ")";
    $opid = $v["opid"];
    $opidArr = explode(",", $opid);
    $opnum = $v["opnum"];
    $opnumArr = explode(",", $opnum);
    $i = 0;
    $opidQuery = "";
    foreach ($opidArr as $c => $d) {
        if ($d != "") {
            if ($i == 0) {
                $opidQuery = "WHERE id IN (" . $d . "";
            } else {
                $opidQuery .= " ," . $d . "";
            }
            $i++;
        }
    }
    if ($opidQuery != "") {
        $opidQuery .= ")";
    }

    $db->query("SELECT goods_name,sb_sale,sellPrice,goods_opt_type FROM goods WHERE goods_code='$goods_code'");
    $goods_value_query = $db->loadRows();
    $sb_sale = (100 - $goods_value_query[0]["sb_sale"]) / 100;
    $goods_name = $goods_value_query[0]["goods_name"];
    $goods_opt_type = $goods_value_query[0]["goods_opt_type"];
    $goods_sellPrice = $goods_value_query[0]["sellPrice"];

    $db->query("SELECT imageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id ASC limit 0,1");
    $dbdata = $db->loadRows();
    $imgSrc = $brandImagesWebDir . $dbdata[0]["imageName"];
    if($dbdata[0]["imageName"]==""){
        $db->query("SELECT imageName FROM upload_simages WHERE goods_code='$goods_code' ORDER BY id ASC limit 0,1");
        $dbdata = $db->loadRows();
        $imgSrc = $brandImagesWebDir . $dbdata[0]["imageName"];
    }

    if ($goods_opt_type == "0") {
        // 옵션없음
        $goods_count = count($goods_value_query);
    } else if ($goods_opt_type == "1") {
        //일반옵션
        $db->query("SELECT sellPrice FROM goods_option_single_value $sbidQuery ORDER BY id ASC");
        $goods_value_query = $db->loadRows();
        $goods_count = count($goods_value_query);
    } else {
        //가격선택옵션 opValue2 판매가
        $db->query("SELECT opValue2 FROM goods_option_grid_value $sbidQuery ORDER BY id ASC");
        $goods_value_query = $db->loadRows();
        $goods_count = count($goods_value_query);
    }
    $sum = 0;
    for ($i = 0; $i < $goods_count; $i++) {
        if ($goods_opt_type == "2") {
            $sum += $goods_value_query[$i]["opValue2"] * $sbnumArr[$i] * $sb_sale;
        } else {
            $sum += $goods_value_query[$i]["sellPrice"] * $sbnumArr[$i] * $sb_sale;
        }
    }

    if ($goods_opt_type != "0") {
        $db->query("SELECT opValue2 FROM goods_option $opidQuery ");
        $goods_option = $db->loadRows();
        $goods_optionCount = count($goods_option);
        for ($i = 0; $i < $goods_optionCount; $i++) {
            $sum += $goods_option[$i]["opValue2"] * $opnumArr[$i];
        }
    }

    $xml .= '<items>
                <num>' . $uid . '</num>
                <name>' . $goods_name . '</name>
                <code>' . $goods_code . '</code>
                <imgSrc>' . $imgSrc . '</imgSrc>
                <void>' . $basketuid . '</void>
                <sum>' . $sum . '</sum>
            </items>';
}
$xml .= '</shopBrand>';
echo $xml;
$db->disconnect();
?>