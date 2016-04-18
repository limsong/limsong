<?php
//session_save_path("/www/web/worimall/adminsessions");
session_start();
session_unset();
session_destroy();
echo "<script language='javascript'>window.top.document.location.href='index.php';</script>";
?>
