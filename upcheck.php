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
$basketid = $_POST["bid"];
$ordernum = $_POST["ordernum"];
$uname = $_POST["user_id"];
$phone = $_POST["phone"];
$oldadd = $_POST["oldadd"];
$newadd = $_POST["newadd"];
$alladd = $_POST["alladd"];
$ship_message = $_POST["ship_message"];
$_SESSION["bid"] = "";
$_SESSION["user_id"] = "";
$_SESSION["phone"] = "";
$_SESSION["oldadd"] = "";
$_SESSION["newadd"] = "";
$_SESSION["alladd"] = "";
$_SESSION["ship_message"] = "";
$_SESSION["zipcode"] = "";
foreach ($_POST as $key => $value) {
    $_SESSION[$key] = $value;
}

$basketidArr = explode("_", $basketid);
foreach ($basketidArr as $k => $v) {
    if ($basketQuery == "") {
        $basketQuery = "WHERE v_oid='$v'";
    } else {
        $basketQuery .= " OR v_oid='$v'";
    }
}
$db->query("UPDATE basket SET ordernum='$ordernum' $basketQuery");
echo "success";
$db->disconnect();
?>