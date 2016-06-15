<?
include_once("check.php");
include("common/config.shop.php");
include("fckeditor/fckeditor.php");
$code = $_GET['code'];
$page = $_GET['page'];
$key = $_GET['key'];
$keyfield = $_GET['keyfield'];
$number = $_GET['number'];
$user_review = $_GET["user_review"];


$qna_data = $_POST["qna_data"];
$qna_status = $_POST["qna_status"];
$mod = $_POST["mod"];//onetoone or goods_qna
if ($qna_status != "") {
    $in_uid = $_POST["uid"];
    $in_qna_reg_date = date("Y-m-d H:i:s", time());
    $in_ipInfo = get_real_ip();
    $query = "UPDATE tbl_bbs set qna_status='$qna_status' WHERE uid='$in_uid'";
    mysql_query($query) or die("boardRead");
    if ($qna_data != "") {
        $query = "INSERT INTO tbl_bbs_comment (puid,user_id,comment,qna_reg_date,ipInfo) VALUES ('$in_uid','$uname','$qna_data','$in_qna_reg_date','$in_ipInfo')";
        mysql_query($query) or die("boardRead");
    }
}
$del_data = $_POST["del_data"];
if ($del_data != "") {
    mysql_query("DELETE FROM tbl_bbs_comment WHERE uid='$del_data'");
}

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
$ou_qna_status = $row["qna_status"];
$query = "SELECT name FROM shopmembers WHERE id='$ou_name'";
$result = mysql_query($query) or die("boardRead1");
$name = mysql_result($result, 0, 0);
if ($qna_mod == "0") {
    $goods_query = "SELECT * FROM goods WHERE id='$goods_seq'";
    $goods_result = mysql_query($goods_query) or dir("boardRead");
    $goods_row = mysql_fetch_array($goods_result);
    $goods_name = $goods_row["goods_name"];
    $goods_code = $goods_row["goods_code"];
    $upload_timage_query = "SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code' ORDER BY id asc limit 0,1";

    $upload_timage_result = mysql_query($upload_timage_query) or die("boardRead");
    $upload_timage_row = mysql_fetch_array($upload_timage_result);
    $imagename = $upload_timage_row["ImageName"];
    $imgsrc = "../userFiles/images/brandImages/$imagename";
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
            <?php
            if ($qna_data != "") {
                echo 'alert("입력되였습니다.");';
            } elseif ($qna_status != "") {
                echo 'alert("수정 되였습니다.");';
            }
            ?>
        </script>
    </head>
    <body>
        <div id="total">
            <style type="text/css">
                #total {
                    width: 100%;
                }

                .qna_border {
                    width: 100%;
                    border-collapse: collapse;
                }

                .qna_border th {
                    border-top: 1px solid #ccc;
                    border-bottom: 1px solid #ccc;
                    padding: 0px 10px;
                    height: 35px;
                    line-height: 35px;
                    text-align: left;
                    background-color: #ddd;
                }

                .qna_border td {
                    border-top: 1px solid #ccc;
                    border-bottom: 1px solid #ccc;
                    padding: 10px;
                }
            </style>
            <div id="main" style="width:100%;">
                <form name="dataForm" id="dataForm" action="" method="post">
                    <table border="0" cellpadding="0" cellspacing="0" class="qna_border">
                        <?php
                        if ($qna_mod == "1") {
                            ?>
                            <tr>
                                <th style="width:120px;">분류</th>
                                <td><?= $cate_code ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <th style="width:120px;">등록일</th>
                            <td><?= $ou_signdate ?></td>
                        </tr>
                        <?
                        if ($user_review == "no") {
                            ?>
                            <tr>
                                <th style="width:120px;">제목</th>
                                <td><?= $ou_subject ?></td>
                            </tr>
                            <?
                        }
                        ?>
                        <tr>
                            <th style="width:120px;">이름</th>
                            <td><?= $name ?></td>
                        </tr>
                        <tr>
                            <th style="width:120px;">아이디</th>
                            <td><?= $ou_name ?></td>
                        </tr>
                        <?
                        if ($qna_mod == "0") {
                            ?>
                            <tr>
                                <th style="width:120px;">상품정보</th>
                                <td>
                                    <a href="http://sozo.bestvpn.net/item_view.php?code=<?= $goods_code ?>" target="_blank" style="line-height: 50px;height:50px;vertical-align:top;">
                                        <img src="<?= $imgsrc ?>" width="50" height="50"><?= $goods_name ?>
                                    </a>
                                </td>
                            </tr>
                            <?
                        } elseif ($qna_mod == "1") {
                            ?>
                            <tr>
                                <th style="width:120px;">처리상태</th>
                                <td>
                                    <input type="radio" name="qna_status" value="0" id="status_i" <? if ($ou_qna_status == "0") echo "checked"; ?> />
                                    <label for="status_i">답변대기</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" name="qna_status" value="1" id="status_ii" <? if ($ou_qna_status == "1") echo "checked"; ?> />
                                    <label for="status_ii">처리완료</label>
                                    &nbsp;&nbsp;
                                    <input type="radio" name="qna_status" value="2" id="status_iii" <? if ($ou_qna_status == "2") echo "checked"; ?> />
                                    <label for="status_iii">보류</label>
                                </td>
                            </tr>
                        <? } ?>
                        <tr>
                            <th style="width:120px;">
                                <?
                                if ($user_review == "no") {
                                    echo "문의내용";
                                } elseif ($user_review == "yes") {
                                    echo "내용";
                                }
                                ?>
                            </th>
                            <td class="review-msg"><?= $ou_comment ?></td>
                        </tr>
                    </table>


                    <table border="0" cellpadding="0" cellspacing="0" class="qna_border">
                        <input type="hidden" name="uid" value="<?= $number ?>"/>
                        <input type="hidden" name="mod" value="<?= $qna_mod ?>"/>
                        <tr>
                            <td>
                                <?php
                                if ($ou_qna_status == "0") {
                                    echo '<textarea name="qna_data" style="width:100%;height: 66px;border:1px solid #ccc;padding:5px;"></textarea>';
                                }
                                ?>
                            </td>
                            <td style="width:80px;text-align: center;">
                                <input type="submit" class="memEleB" value="확인" style="width:100%;height:80px;">
                            </td>
                        </tr>

                    </table>
                </form>

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
                        $count = mysql_result($result, 0, 0);
                        if ($count > 0) {
                            $query = "select * from $jjCode where puid='$number' order by uid asc";
                            $result = mysql_query($query) or die($query);

                            while ($row = mysql_fetch_assoc($result)) {
                                $ou_uid = $row["uid"];
                                $ou_name = stripslashes($row["user_id"]);
                                $ou_comment = stripslashes($row["comment"]);
                                $ou_signdate = $row["qna_reg_date"];
                                $ou_ipInfo = $row["ipInfo"];
                                ?>
                                <tr>
                                    <form name="del_form" action="" method="post">
                                        <input type="hidden" name="del_data" value="<?= $ou_uid ?>"/>
                                        <td><?= $ou_name ?></td>
                                        <td class="review-msg"><?= $ou_comment ?></td>
                                        <td>
                                        <?= $ou_signdate ?></th>
                                        <td>
                                            <input type="submit" class="memEleB" value="삭제"
                                            ">
                                        </td>
                                    </form>
                                </tr>
                                <?
                            }
                        } else {
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
                    language: "ko_KR",
                    theme: "modern",
                    menubar: false,
                    height: 300,
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
