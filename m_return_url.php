<?php
if ($_POST['P_STATUS'] === '00') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $_POST['P_REQ_URL']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'P_MID=INIpayTest&P_TID='.$_POST['P_TID']) ; // 여기 수정하세요!
    $inipay = iconv('euc-kr', 'utf-8', curl_exec($ch));
    if(curl_errno($ch)){//出错则显示错误信息
        print curl_error($ch);
    }
    curl_close($ch); //关闭curl链接

echo $response;//显示返回信息
    curl_close($ch);
    $result = array();
    parse_str($inipay, $result);

    if ($result['P_STATUS'] == '00' && (int)$cashmoney === (int)$result['P_AMT']) {
        //save_into_db();
        //header('Location: /shop/success/');
    } else {
        //kickban();
        //header('Location: /shop/fail/');
    }
}