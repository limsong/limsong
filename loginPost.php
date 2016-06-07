<?
require_once("session.php");
require_once("include/config.php");
$in_uname = $_POST["user_id"];
$in_upasswd = $_POST["user_pw"];
$url = $_POST["url"];
if(!empty($in_uname) && !empty($in_upasswd)){
    include("include/sqlcon.php");
    $db->query("SELECT passwd FROM shopMembers WHERE id = '$in_uname'");
    if($db->countRows()==1)
        $dbdata = $db->loadRows();
    @$realPasswd = $dbdata[0]["passwd"];
    $ou_upasswd = crypt($in_upasswd,$realPasswd);
    if(!strcmp($ou_upasswd,$realPasswd)){
        $lastlogin = time();
        $_SESSION["uname"] = $in_uname;
        //$db->query("UPDATE basket SET id='$in_uname' WHERE tempId='$sessid'");
        //mysql_query($query) or die(mysql_error());
        $db->query("UPDATE shopMembers SET lastlogin='$lastlogin' WHERE id='$in_uname'");
        //mysql_query($query) or die(mysql_error());
        include_once("get_cookie.php");
        $db->disconnect();
        echo '<script language="javascript">window.top.document.location.href="'.$url.'";</script>';
        header("Location:$url");
    }else{
        echo "<script language='javascript'>window.top.document.location.href='login.php';</script>";
        header("Location: /login.php");
    }
}else{
    echo "<script language='javascript'>window.top.document.location.href='login.php';</script>";
    header("Location: /login.php");
}

?>