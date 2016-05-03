<?php
include_once("doctype.php");
/**
 * Created by PhpStorm.
 * User: Livingroom
 * Date: 2016. 4. 30.
 * Time: 오후 8:45
 */
foreach ($_POST as $k => $v) {
        ${ $k} = @addslashes($v);
}


$ipinfo = get_real_ip();
$qna_reg_date = date("Y-m-d H:i:s",time());

$db->query("SELECT uid FROM tbl_bbs WHERE user_id='$uname' AND goods_code='$goods_code'");
$db_tbl_bbs_query = $db->loadRows();
$count = count($db_tbl_bbs_query);
if($count>0){
?>
        <body class="home-1 shop-page sin-product-page">
                <script>
                        alert("리뷰어는 한번만 등록 가능합니다.");
                </script>
        </body>
</html>
<?php
}else {
        $db->query("INSERT INTO tbl_bbs (goods_code,user_id,qna_mod,bbs_ext1,comment,qna_reg_date,ipinfo) VALUES ('$goods_code','$uname','2','$rating','$review_com','$qna_reg_date','$ipinfo')");
?>
        <body class="home-1 shop-page sin-product-page">
                <script>
                        alert("등록 되였습니다.감사합니다.");
                        parent.location.reload();
                </script>
        </body>
</html>
<?
}
$db->disconnect();
?>
