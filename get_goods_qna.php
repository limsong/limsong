<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 28
 * Time: 오후 12:12
 */
include_once ("session.php");
include_once ("include/check.php");
include_once ("include/config.php");
include_once ("include/sqlcon.php");

$uid = $_POST["tdata"];//tbl_bbs uid
$goods_seq = $_POST["goods_seq"];
$buy_goods_seq = $_POST["buy_goods_seq"];
$mod = $_POST["mod"];//buy_goods  buy_option
if($mod == "goods_qna"){
    $db->query("SELECT * FROM tbl_bbs WHERE user_id='$uname' AND uid='$uid' AND qna_mod='0'");
    $dbdata = $db->loadRows();
    $title = $dbdata[0]["title"];
    $comment = $dbdata[0]["comment"];
    $qna_reg_date = date("Y-m-d H:i",strtotime($dbdata[0]["qna_reg_date"]));
}elseif($mod=="my_qna"){

}
$db->query("SELECT goods_name,goods_code FROM goods WHERE id='$goods_seq'");
$db_goods = $db->loadRows();
$goods_name = $db_goods[0]["goods_name"];
$goods_code = $db_goods[0]["goods_code"];

$db->query("SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code'");
$db_upload_timages = $db->loadRows();
$tImageName = $db_upload_timages[0]["ImageName"];

$html = '<script src="js/tinymce/tinymce.min.js"></script>
<style>
    .submit{
        width:100%;
        line-height: 56px;
    }
    .qna_data{
        width:100%;height: 69px;border:1px solid #ccc;padding:5px;
    }
</style>
    <div class="cart-area-wrapper table-responsive">
    <form name="cancelForm" class="cancelForm" action="" method="post">
        <input type="hidden" name="uid" value="' . $uid . '">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td width="*" style="border-left:0px;">'.$title.'</td>
                    <td style="width:150px;border-right:0px;text-align:left;">
                        '.$qna_reg_date.'
                    </td>
                </tr>
                <tr>
                    <td style="border:0px;text-align:left;" colspan="2">
                        <a href="item_view.php?code='.$goods_code.'" target="_blank">
                            <img src="userFiles/images/brandImages/'.$tImageName.'" width="50" height="50">
                            '.$goods_name.'
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="border:0px;border-top:1px solid #ccc;text-align:left;" colspan="2">
                        '.$comment.'
                    </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">
                        <textarea class="qna_data" name="qna_data"></textarea>
                    </td>
                    <td style="border-right:0px;text-align:left;">
                        <button type="button" class="btn btn-red submit">확인</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <table class="table table-bordered">
        <colgroup>
            <col width="10%">
            <col width="*">
            <col width="20%">
            <col width="8%">
        </colgroup>
        <tbody>';
            $jjCode = $code . "_comment";
            $db->query("SELECT count(uid) FROM tbl_bbs_comment WHERE puid='$uid'");
            $db_query = $db->loadRows();
            $count = count($db_query);
            if($count > 0){
                $db->query("select * from tbl_bbs_comment where puid='$uid' order by uid asc");
                $db_bbs_com = $db->loadRows();
                $dbCount=count($db_bbs_com);
               for($i=0;$i<$dbCount;$i++){
                    $ou_uid = $db_bbs_com[$i]["uid"];
                    $ou_name = stripslashes($db_bbs_com[$i]["user_id"]);
                    $ou_comment = nl2br(stripslashes($db_bbs_com[$i]["comment"]));
                    $ou_signdate = date("Y-m-d H:i",strtotime($db_bbs_com[$i]["qna_reg_date"]));
                    $ou_ipInfo = $db_bbs_com[$i]["ipInfo"];
                   if($ou_name==$uname){
                       $str= '<input type="submit" value="삭제"">';
                   }

    $html.='<tr>
                
                <td style="border-left:0px;">'.$ou_name.'</td>
                <td style="text-align:left;">'.$ou_comment.'</td>
                <td>'.$ou_signdate.'</th>
                <td style="border-right:0px;"><form name="del_form" action="goods_qna.php" method="post">
                <input type="hidden" name="del_data" value="'.$ou_uid.'"/>'.$str.'</form></td>
            </tr>';

                }
            }else{

    $html.='<tr>
                <th colspan="4">등록된 댓글이 없습니다.</th>
            </tr>';
            }
    $html.='</tbody>
    </table>
    </div>';

echo $html;
$db->disconnect();
?>