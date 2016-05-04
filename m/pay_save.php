<?php
require_once("../session.php");
require_once("../include/config.php");
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 5. 3
 * Time: 오후 12:34
 */
header("Content-Type: text/html; charset=euc-kr");
if ($_POST['P_STATUS'] === '00') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_POST['P_REQ_URL']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'P_MID=INIpayTest&P_TID=' . $_POST['P_TID']); // 여기 수정하세요!
    $inipay = curl_exec($ch);
    curl_close($ch);
    $result = array();
    parse_str($inipay, $result);
    $cashmoney = $_SESSION[$result['P_OID'] . "_price"];
    if ($result['P_STATUS'] == '00' && (int)$cashmoney === (int)$result['P_AMT']) {
        //save_into_db();
        //header('Location: /shop/success/');
        foreach ($result as $key => $value) {
            echo $key . "==>" . $value . "<br>";
        }
        /*
        P_STATUS==>00
        P_AUTH_DT==>20160504112904
        P_AUTH_NO==>
        P_RMESG1==>성공적으로 처리 하였습니다.
        P_RMESG2==>
        P_TID==>INIMX_VBNKINIpayTest20160504112903950668
        P_FN_CD1==>
        P_AMT==>1000
        P_TYPE==>VBANK
        P_UNAME==>
        P_MID==>INIpayTest
        P_OID==>INIpayTest_1462328917187
        P_NOTI==>
        P_NEXT_URL==>http://sozo.bestvpn.net/m/pay_save.php
        P_MNAME==>해피정닷컴
        P_NOTEURL==>
        P_VACT_NUM==>56211101573948
        P_VACT_DATE==>20160514
        P_VACT_TIME==>235900
        P_VACT_NAME==>이니시스㈜테스트입
        P_VACT_BANK_CODE==>88
         * */
        echo "OK";
    } else {
        //kickban();
        //header('Location: /shop/fail/');
        echo "FAIL";
    }
}

?>