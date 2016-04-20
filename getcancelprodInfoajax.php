<?php
include_once ("include/config.php");
include_once ("session.php");
include_once ("include/sqlcon.php");
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 20
 * Time: 오후 4:02
 * getcancelprodInfoajax.php
 */
$buy_seq = $_POST["seq"];
$mod = $_POST["mod"];//부분취소 전부취소 cAll   cList
$buy_seqArr = explode(",",$buy_seq);

$buy_seq_query = "";
foreach ($buy_seqArr as $key => $value){
    if($buy_seq_query == "")
    {
        $buy_seq_query = "WHERE buy_goods_seq IN (".$value."";
    }
    else
    {
        $buy_seq_query .= " ,".$value."";
    }
}
if($buy_seq_query!=""){
    $buy_seq_query .= ")";
}


$html ='<div class="cart-area-wrapper table-responsive">
    <form name="cancelForm" class="cancelForm" action="cancelPost.php">
    <table class="table table-bordered">
        <thead>
            <tr>
                <td>상품명</td>
                <td>상품금액</td>
                <td>수량</td>
                <td>배송비</td>
                <td>주문상태</td>
            </tr>
        </thead>';

        $class_check=0;//checkbox class sb and op number maching
        $dlv_str="";//배송비 무료 유료
        $db->query("SELECT buy_goods_seq,buy_goods_code,buy_goods_name,buy_goods_prefix,buy_goods_option,buy_goods_price,buy_goods_count,buy_goods_price_total,buy_goods_dlv_type FROM buy_goods $buy_seq_query ");
        $db_buy_goods = $db->loadRows();
        $cbuy_goods = count($db_buy_goods);

        $html .='<tbody>';

            FOR($j=0;$j<$cbuy_goods;$j++) {
                $buy_goods_seq = $db_buy_goods[$j]["buy_goods_seq"];
                $buy_goods_code = $db_buy_goods[$j]["buy_goods_code"];
                $buy_goods_name = $db_buy_goods[$j]["buy_goods_name"];
                $buy_goods_prefix = $db_buy_goods[$j]["buy_goods_prefix"];
                $buy_goods_suffix = $db_buy_goods[$j]["buy_goods_suffix"];
                $buy_goods_option = $db_buy_goods[$j]["buy_goods_option"];
                $buy_goods_price = $db_buy_goods[$j]["buy_goods_price"];
                $buy_goods_count = $db_buy_goods[$j]["buy_goods_count"];
                $buy_goods_price_total = $db_buy_goods[$j]["buy_goods_price_total"];
                $buy_goods_dlv_type = $db_buy_goods[$j]["buy_goods_dlv_type"];
                if ($buy_goods_option == "0") {

                    $html.='<tr>
                        <td>
                            <div style="width:100%;float: left;">
                                <span style="float: left;margin-left:5px;">
                                    <img src="userFiles/images/brandImages/0201000024thumImage.jpg" width="50" height="50">
                                </span>
                                <div style="overflow:hidden;text-align: left;padding-left:5px;">';
                                    $db->query("SELECT goods_name,goods_opt_type,goods_opt_num FROM goods WHERE goods_code='$buy_goods_code'");
                                    $db_goods=$db->loadRows();
                                    $goods_opt_type = $db_goods[0]["goods_opt_type"];
                                    $goods_opt_num = $db_goods[0]["goods_opt_num"];
                                    $goods_name = $db_goods[0]["goods_name"];
                                    $html.='<p style="word-break: break-all;border-collapse: collapse;">'.$goods_name.'</p>';
                                    $html.='<p>';
                                        if($goods_opt_type=="1"){
                                            $db->query("select * from goods_option_single_name where goods_code='$buy_goods_code' and opName2='$buy_goods_prefix' or opName2='$buy_goods_suffix'");
                                        }else{
                                            if($goods_opt_num=="2"){
                                                $db->query("select * from goods_option_grid_name where goods_code='$buy_goods_code' and opName2='$buy_goods_prefix' or opName2='$buy_goods_suffix'");

                                            }else{
                                                $db->query("select * from goods_option_grid_name where goods_code='$buy_goods_code' and opName2='$buy_goods_prefix' or opName2='$buy_goods_suffix'");
                                            }
                                        }
                                        $dbquery = $db->loadRows();
                                        $cdbquery = count($dbquery);
                                        for($k=0;$k<$cdbquery;$k++){
                                            if($k==0){
                                                $str_op_name = $dbquery[$k]["opName1"]." : ".$dbquery[$k]["opName2"];
                                            }else{
                                                $str_op_name .= "<br>".$dbquery[$k]["opName1"]." : ".$dbquery[$k]["opName2"];
                                            }
                                        }
                                        $html.= $str_op_name;
                                    $html.='</p>
                                </div>
                            </div>
                        </td>
                        <td>';
                            $html.=number_format($buy_goods_price).'원';
                        $html.='</td>';
                        $html.='<td>';
                                    if($mod=="cAll"){
                                        $html.='<input type="hidden" name="sb_num[]" value="'.$buy_goods_count.'">'.$buy_goods_count;
                                    }else {
                                        $html .= '<select name="sb_num[]" data="' . $buy_goods_seq . '">';
                                        for ($c = 0; $c < $buy_goods_count; $c++) {
                                            $html .= '<option value="' . ($c + 1) . '">' . ($c + 1) . '</option>';
                                        }
                                        $html .= '</select>';
                                    }
                                $html.='</td>';
                        $html.='<td>';
                            if($buy_goods_dlv_type=="1"){
                                $dlv_str = "무료";
                            }else{

                                $dlv_str = "2,500원";
                            }
                            if($dlv_str == ""){
                                $html.="무료";
                            }else if($dlv_str!="무료"){
                                $html.="2,500원";
                            }
                        $html.='</td>
                        <td class="cart-total-price">입금대기중</td>
                    </tr>';

                    $class_check++;
                } elseif ($buy_goods_option == "1") {

                    $html.='<tr>
                        <td>
                            <div style="width:100%;float: left;">
                                <div style="overflow:hidden;text-align: left;padding-left:5px;">
                                    <p style="word-break: break-all;border-collapse: collapse;">[추가상품]F-ZS915E-블루-FREE</p>
                                </div>
                            </div>
                        </td>
                        <td>'.number_format($buy_goods_price).'원</td>';
                $html.='<td>';
                                if($mod=="cAll"){
                                    $html.='<input type="hidden" name="op_num[]" value="'.$buy_goods_count.'">'.$buy_goods_count;
                                }else {
                                    $html .= '<select name="op_num[]" data="' . $buy_goods_seq . '">';
                                    for ($c = 0; $c < $buy_goods_count; $c++) {
                                        $html .= '<option value="' . ($c + 1) . '">' . ($c + 1) . '</option>';
                                    }
                                }
                        $html.='</select>
                        </td>
                        <td>무료</td>
                        <td>입금대기중</td>
                    </tr>';

                }
            }
        $html.='</tbody>
    </table>
    </form>
</div>';

echo $html;
?>