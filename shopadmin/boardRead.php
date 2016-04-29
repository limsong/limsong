<?
include_once ("check.php");
include("common/config.shop.php");
include("fckeditor/fckeditor.php");
$code = $_GET['code'];
$page = $_GET['page'];
$key = $_GET['key'];
$keyfield = $_GET['keyfield'];
$number = $_GET['number'];
$query = "select * from $code where uid='$number'";
$result = mysql_query($query) or die($query);
$row = mysql_fetch_assoc($result);
$ou_name = stripslashes($row['user_id']);
$ou_subject = stripslashes($row['title']);
$ou_signdate = $row['qna_reg_date'];
$ou_ipInfo = $row['ipinfo'];
$ou_userFile1Name = $row['userFile1Name'];
$ou_userFile2Name = $row['userFile2Name'];
$ou_comment = stripslashes($row['comment']);
$goods_seq = $row["goods_seq"];
$buy_goods_seq = $row["buy_goods_seq"];
$qna_mod = $row["qna_mod"];
$cate_code = $row["cate_code"];
if($qna_mod == "0") {
    $goods_query = "SELECT * FROM goods WHERE id='$goods_seq'";
    $goods_result = mysql_query($goods_query) or dir("boardRead");
    $goods_row = mysql_fetch_array($goods_result);
    $goods_name = $goods_row["goods_name"];
    $goods_code = $goods_row["g$oods_code"];
    $upload_timage_query = "SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id asc limit 0,1";

    $upload_timage_result = mysql_query($upload_timage_query) or die("boardRead");
    $upload_timage_row = mysql_fetch_array($upload_timage_result);
    $imagename = $upload_timage_row["ImageName"];
    $imgsrc = "../userFiles/images/brandImages/$imagename";
}

$qna_data = $_POST["qna_data"];
$mod = $_POST["mod"];//onetoone or goods_qna
if($qna_data != ""){
    $in_uid = $_POST["uid"];
    $in_qna_reg_date = date("Y-m-d H:i:s",time());
    $in_ipInfo = get_real_ip();
    $in_qna_data = $_POST["qna_data"];
    $query = "UPDATE tbl_bbs set qna_status='$qna_status' WHERE uid='$in_uid'";
    mysql_query($query) or die("boardRead");
    $query = "INSERT INTO tbl_bbs_comment (puid,user_id,comment,qna_reg_date,ipInfo) VALUES ('$in_uid','$uname','$in_qna_data','$in_qna_reg_date','$in_ipInfo')";
    mysql_query($query) or die("boardRead");
}
$del_data = $_POST["del_data"];
if($del_data != ""){
    mysql_query("DELETE FROM tbl_bbs_comment WHERE uid='$del_data'");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>boardRead</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css"/>
        <link rel="stylesheet" type="text/css" href="css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="css/boardRead.css"/>
        <link rel="stylesheet" type="text/css" href="layer/skin/layer.css"/>
        <script type="text/javascript" src="common/jslb_ajax.js"></script>
        <script type="text/javascript" src="common/common2.js"></script>
        <script src="assets/plugins/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            window.onload = function () {
                var obj = document.getElementById("jjList").getElementsByTagName("a");
                for (var i = 0; i < obj.length; i++) {
                    if (obj[i].addEventListener) {
                        obj[i].addEventListener("click", showChBox, false);
                    } else {
                        obj[i].attachEvent("onclick", showChBox);
                    }
                }
            }
        </script>
    </head>
    <body>
        <div id="total">
            <style type="text/css">
                #total{
                    width:100%;
                }
                .qna_border {
                    width:100%;
                    border-collapse: collapse;
                }
                .qna_border th{
                    border-top:1px solid #ccc;
                    border-bottom:1px solid #ccc;
                    padding: 0px 10px;
                    height:35px;
                    line-height:35px;
                    text-align: left;
                    background-color:#ddd;
                }
                .qna_border td {
                    border-top:1px solid #ccc;
                    border-bottom:1px solid #ccc;
                    padding:10px;
                }
            </style>
            <div id="main" style="width:100%;">
                <table border="0" cellpadding="0" cellspacing="0" class="qna_border">
                    <?php
                    if($qna_mod=="1") {
                    ?>
                    <tr>
                        <th style="width:120px;">분류</th>
                        <td><?= $cate_code ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    <tr>
                        <th style="width:120px;">작성일</th>
                        <td><?= $ou_signdate ?></td>
                    </tr>
                    <tr>
                        <th style="width:120px;">제목</th>
                        <td><?= $ou_subject ?></td>
                    </tr>
                    <tr>
                        <th style="width:120px;">이름</th>
                        <td><?= $ou_name ?></td>
                    </tr>
                    <?
                    if($qna_mod == "0") {
                    ?>
                    <tr>
                        <th style="width:120px;">상품정보</th>
                        <td>
                            <a href="http://sozo.bestvpn.net/item_view.php?code=<?= $goods_code ?>" target="_blank"
                               style="line-height: 50px;height:50px;vertical-align:top;">
                                <img src="<?= $imgsrc ?>" width="50" height="50"><?= $goods_name ?>
                            </a>
                        </td>
                    </tr>
                    <?
                    }
                    ?>
                    <tr>
                        <th style="width:120px;">내용</th> 
                        <td><?= $ou_comment ?></td>
                    </tr>
                </table>


                <table border="0" cellpadding="0" cellspacing="0" class="qna_border">
                    <form name="dataForm" id="dataForm" action="" method="post">
                        <input type="hidden" name="uid" value="<?=$number?>" />
                        <input type="hidden" name="mod" value="<?=$qna_mod?>" />
                    <tr>
                        <td>
                            <textarea name="qna_data" style="width:100%;height: 66px;border:1px solid #ccc;padding:5px;"></textarea>
                        </td>
                        <td style="width:80px;text-align: center;">
                            <input type="submit" class="memEleB" value="답변" style="width:100%;height:80px;">
                        </td>
                    </tr>
                    </form>
                </table>


                <table border="0" cellpadding="0" cellspacing="0" class="qna_border">
                    <colgroup>
                        <col width="10%">
                        <col width="*">
                        <col width="20%">
                        <col width="8%">
                    </colgroup>
                    <thead>
                        <?php
                        $jjCode = $code . "_comment";
                        $query = "SELECT count(uid) FROM $jjCode WHERE puid='$number'";
                        $result = mysql_query($query) or die("borderRead");
                        $count = mysql_result($result,0,0);
                        if($count > 0){
                            $query = "select * from $jjCode where puid='$number' order by uid asc";
                            $result = mysql_query($query) or die($query);

                            while ($row = mysql_fetch_assoc($result)) {
                                $ou_uid = $row["uid"];
                                $ou_name = stripslashes($row["user_id"]);
                                $ou_comment = nl2br(stripslashes($row["comment"]));
                                $ou_signdate = $row["qna_reg_date"];
                                $ou_ipInfo = $row["ipInfo"];
                        ?>
                        <tr>
                            <form name="del_form" action="" method="post">
                                <input type="hidden" name="del_data" value="<?=$ou_uid?>"/>
                            <td><?=$ou_name?></td>
                            <td><?=$ou_comment?></td>
                            <td><?=$ou_signdate?></th>
                            <td><input type="submit" class="memEleB" value="삭제""></td>
                            </form>
                        </tr>
                        <?
                            }
                        }else{
                        ?>
                        <tr>
                            <th colspan="4">등록된 댓글이 없습니다.</th>
                        </tr>
                        <?
                        }
                        ?>
                    </thead>
                </table>
            </div>
            <script>
                tinymce.init({
                    selector: "textarea#elm1",
                    language : "ko_KR",
                    theme: "modern",
                    menubar: false,
                    height:300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview",
                    style_formats: [
                        {title: 'Bold text', inline: 'b'},
                        {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                        {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                        {title: 'Example 1', inline: 'span', classes: 'example1'},
                        {title: 'Example 2', inline: 'span', classes: 'example2'},
                        {title: 'Table styles'},
                        {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                    ]
                });
            </script>
            <iframe name="action_frame" width="610" height="100" style="display:none"></iframe>
        </div>
    </body>
</html>
