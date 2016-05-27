<?php
/**
 * Created by PhpStorm.
 * User: ONE
 * Date: 2016. 5. 17.
 * Time: 오전 9:39
 */
include_once ("session.php");
include_once("include/check.php");
include_once("include/config.php");
include_once("include/sqlcon.php");

$db->query("SELECT * FROM user_address WHERE user_id='$uname'");
$db_user_address_query = $db->loadRows();
$count = count($db_user_address_query);
$str = '
    <table class="table">
        <colgroup>
            <col width="50px">
            <col width="100px">
            <col width="*">
            <col width="100px">
        </colgroup>
        <tr>
            <th>선택</th>
            <th>받는사람</th>
            <th>배송지정보</th>
            <th>삭제</th>
        </tr>
';
for($i=0;$i<$count;$i++) {
    $id = $db_user_address_query[$i]["id"];
    $user_name = $db_user_address_query[$i]["user_name"];
    $zipcode = $db_user_address_query[$i]["zipcode"];
    $addr1 = $db_user_address_query[$i]["addr1"];
    $addr2 = $db_user_address_query[$i]["addr2"];
    $addr3 = $db_user_address_query[$i]["addr3"];
    $phone = $db_user_address_query[$i]["phone"];
    $str .= '
        <tr>
            <td><input type="radio" name="oadd" id="get_add'.$id.'" class="get_add" data-name="'.$user_name.'" data-zipcode="'.$zipcode.'" data-addr1="'.$addr1.'" data-addr2="'.$addr2.'" data-addr3="'.$addr3.'" data-phone="'.$phone.'"></th>
            <td class="cross">'.$user_name.'</th>
            <td class="cross"><label style="width:100%;cursor:pointer;" for="get_add'.$id.'"><p style="text-align:left;">'.$phone.'</p><p style="text-align:left;">['.$zipcode.'] '.$addr2.' '.$addr3.'</p></label></th>
            <td class="cross"><button type="button" class="btn btn-danger btn-sm del_addr" data-no="'.$id.'">삭제</button></th>
        </tr>';
}
$str .= '</table>';
echo $str;
$db->disconnect();
?>