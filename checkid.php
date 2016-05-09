<?php
include_once("session.php");
include_once("include/config.php");
include("include/sqlcon.php");
$ou_uname = $_POST["userid"];
if(!empty($ou_uname)){
    $db->query("SELECT count(id) FROM shopMembers WHERE id = '$ou_uname'");
    if($db->countRows()==1)
        $dbdata = $db->loadRows();
    $db->disconnect();
    $ou_id = $dbdata[0]['count(id)'];
    if($ou_id <= 0){
        echo("true");
    }else{
        echo("false");
    }
}else{
    echo("false");
}
$db->disconnect();
?>