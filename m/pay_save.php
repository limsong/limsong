<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 5. 3
 * Time: 오후 12:34
 */
if ($_POST['P_STATUS'] === '00') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_POST['P_REQ_URL']);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'P_MID=INIpayTest&P_TID='.$_POST['P_TID']) ; // 여기 수정하세요!
    $inipay = iconv('euc-kr', 'utf-8', curl_exec($ch));
    curl_close($ch);
    $result = array();
    parse_str($inipay, $result);

    if ($result['P_STATUS'] == '00' && (int)$cashmoney === (int)$result['P_AMT']) {
        save_into_db();
        header('Location: /shop/success/');
    } else {
        kickban();
        header('Location: /shop/fail/');
    }
}
?>