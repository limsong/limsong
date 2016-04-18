<?php
include_once("session.php");
session_unset();
session_destroy();
echo "<script language='javascript'>window.top.document.location.href='index.php';</script>";
header("Location: /");
?>