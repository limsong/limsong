<?php
/**
 * Created by PhpStorm.
 * User: ONE
 * Date: 2016. 5. 17.
 * Time: 오후 12:24
 */
include_once ("session.php");
include_once("include/check.php");
include_once("include/config.php");
include_once("include/sqlcon.php");
$no = $_POST["no"];
$db->query("DELETE FROM user_address WHERE id='$no'");
echo "ok";
$db->disconnect();
?>