<?php
include_once("session.php");
include_once("include/config.php");
$in_uname = $_POST["userid"];
if(!empty($in_uname)){
    include("include/sqlcon.php");
    $ou_uname = $db->siftDown($in_uname);
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
?>