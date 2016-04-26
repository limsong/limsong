<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 26
 * Time: 오전 11:19
 */
include_once("session.php");
include_once("include/config.php");
include("include/sqlcon.php");
$buy_seq = $_POST['data_seq'];
$db->query("UPDATE buy SET buy_status='16' WHERE buy_seq='$buy_seq' AND user_id='$uname'");
$db->query("UPDATE buy_goods SET buy_goods_status='16' WHERE buy_seq='$buy_seq'");
$db->disconnect();
?>