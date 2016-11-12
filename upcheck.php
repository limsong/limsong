<?php
/**
 * Created by PhpStorm.
 * User: limsong
 * Date: 2016. 4. 9.
 * Time: 오후 6:24
 */
require_once("session.php");
require_once("include/config.php");
include_once("include/sqlcon.php");

$ordernum = $_POST["ordernum"];

foreach ($_POST as $key => $value) {
    ${$key} = $value;
    $_SESSION[$ordernum."_".$key] = $value;
}

$ipadd = get_real_ip();
$_SESSION[$ordernum."_ipadd"] = $ipadd;


$basketidArr = explode("_", $bid);
foreach ($basketidArr as $k => $v) {
    if ($basketQuery == "") {
        $basketQuery = "WHERE v_oid='$v'";
    } else {
        $basketQuery .= " OR v_oid='$v'";
    }
}
$db->query("UPDATE basket SET ordernum='$ordernum',user_id='$user_id',phone='$phone',zipcode='$zipcode',add1='$oldadd',add2='$newadd',add3='$alladd',ship_message='$ship_message',ipadd='$ipadd',new_addr='$addr_type' $basketQuery");
echo "success";
$db->disconnect();
?>