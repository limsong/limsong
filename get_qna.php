<?php
include_once ("session.php");
include_once ("include/check.php");
include_once ("include/config.php");
include_once ("include/sqlcon.php");
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 20
 * Time: 오후 4:02
 * getcancelprodInfoajax.php
 */
$tdata = $_POST["tdata"];
$db->query("SELECT * FROM tbl_bbs WHERE uid='$tdata' AND user_id='$uname'");
$db_query = $db->loadRows();
$title = $db_query[0]["title"];
$tbl_bbs_comment = $db_query[0]["comment"];
$qna_status = $db_query[0]["qna_status"];


$db->query("SELECT * FROM tbl_bbs_comment WHERE puid='$tdata'");
$db_bbs_comment_query = $db->loadRows();
$user_id = $db_bbs_comment_query[0]["user_id"];
$tbl_bbs_comment_comment = $db_bbs_comment_query[0]["comment"];
$tbl_bbs_qna_reg_date = $db_bbs_comment_query[0]["qna_reg_date"];

if($qna_status == "0"){
    $str = "미답변";
}elseif($qna_status == "1"){
    $str = "답변완료";
    $tbl_bbs_qna_reg_date = "(".$tbl_bbs_qna_reg_date.")";
}else{
    $str = "보류";
    $tbl_bbs_qna_reg_date = "(".$tbl_bbs_qna_reg_date.")";
}

$html ='<div class="cart-area-wrapper table-responsive">
        <table class="table table-bordered">';


$html .='<tbody>';
$html .='<tr>';
$html .='<th colspan="2" style="background-color: #eee;">제목:'.$title.'</th>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="width:60px;color:darkred;font-size:60px!important;font-weight: bold;">Q.</td>';
$html .='<td style="text-align:left;">'.nl2br($tbl_bbs_comment).'</td>';
$html .='</tr>';


$html .='<tr>';
$html .='<td style="width:60px;color:#777;font-size:60px!important;font-weight: bold;">A.</td>';
$html .='<td style="margin:0px !important;padding:0px;vertical-align: top;">
    <table class="table table-bordered" style="margin:0px!important;padding:0px;border:0px;;">
        <tr>
            <td style="border-left:0px;border-top:0px;text-align: left;">
                답변인 : '.$user_id.'
            </td>
            <td style="border-right:0px;border-top:0px;text-align:left;">
                답변여부 : '.$str.' '.$tbl_bbs_qna_reg_date.'
            </td>
        </tr>
        <tr>
            <td colspan="2" style="line-height:50px;border:0px;text-align:left;">';
                if($qna_status != "0"){
                        $html .= nl2br($tbl_bbs_comment_comment);
                }
           $html .= ' </td>
        </tr>
    </table>
</td>';
$html .='</tr>';


echo $html;
$db->disconnect();
?>
