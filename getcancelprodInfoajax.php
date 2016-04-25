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

$sum=$sum2=0;
$html ='<div class="cart-area-wrapper table-responsive">
    <form name="cancelForm" class="cancelForm" action="cancelPost.php" method="post">
        <input type="hidden" name="cancel_mod" value="'.$mod.'">
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
            $db->query("SELECT buy_goods_seq,buy_seq,buy_goods_code,buy_goods_name,buy_goods_prefix,buy_goods_option,buy_goods_price,buy_goods_count,buy_goods_price_total,buy_goods_dlv_type,buy_goods_status FROM buy_goods $buy_seq_query ");
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
                    $buy_goods_status = $db_buy_goods[$j]["buy_goods_status"];//주문상태(bitwise) - 0:주문중, 1:입금대기, 2:입금완료, 4:배송대기, 8:배송중, 16:배소완료, 32:취소신청, 64:취소완료, 128:환불신청, 256:환불완료, 512: 반품신청, 1024:반품배송중, 2048:반품환불, 4096:반품완료, 8192:교환신청, 16384:교환배송중, 32768:재주문처리, 65536:교환완료
                    $buy_seq = $db_buy_goods[$j]["buy_seq"];
                    if($j==0){
                        $html.='<input type="hidden"" name="cancel_sb_buy_seq" value="'.$buy_seq.'">';
                    }
                    $ou_dlv_str= "0";
                    if($buy_goods_dlv_type=="1"){
                        $dlv_str = "무료";
                    }else{
                        $dlv_str = "2,500원";
                    }
                    if($dlv_str == ""){
                        if($buy_goods_status <=4){
                            $ou_dlv_str= "0";
                            $cancel_dlv_free = 0;
                        }else{
                            $ou_dlv_str= "2,500";
                            $cancel_dlv_free = 2500;
                        }
                    }else if($dlv_str!="무료"){
                        $ou_dlv_str= "2,500";
                        $cancel_dlv_free = 2500;
                    }
                    $sum += $buy_goods_price_total;
                    $sum2 +=$buy_goods_price;



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
                                $html.=number_format($buy_goods_price_total).'원';
                            $html.='</td>';
                            $html.='<td>';

                            $html.='<input type="hidden" class="cancel_sb_price_total" value="'.($buy_goods_price_total).'">';
                            $html.='<input type="hidden" class="cancel_sb_price" value="'.($buy_goods_price).'">';
                            $html.='<input type="hidden"" name="cancel_sb_buy_goods_seq[]" value="'.($buy_goods_seq).'">';

                            $html.='<input type="hidden"" name="sb_org_count[]" value="'.($buy_goods_count).'">';
                            $html.='<input type="hidden" class="cancel_sb_instant_discount" value="'.($buy_goods_price-$buy_goods_price_total).'">';
                                if($mod=="cAll"){
                                    $html.='<input type="hidden" name="sb_num[]" value="'.$buy_goods_count.'">'.$buy_goods_count;
                                }else {
                                    $html .= '<select class="sb_num" name="sb_num[]" data="' . $buy_goods_seq . '">';
                                    for ($c = 0; $c < $buy_goods_count; $c++) {
                                        $html .= '<option value="' . ($c + 1) . '">' . ($c + 1) . '</option>';
                                    }
                                    $html .= '</select>';
                                }
                            $html.='</td>';
                            $html.='<td>';
                            $html.=$ou_dlv_str."원";
                            $html.='</td>
                            <td class="cart-total-price">입금대기중</td>
                        </tr>';

                        $class_check++;
                    } elseif ($buy_goods_option == "1") {
                        $html.='<tr>
                            <td>
                                <div style="width:100%;float: left;">
                                    <div style="overflow:hidden;text-align: left;padding-left:5px;">
                                        <p style="word-break: break-all;border-collapse: collapse;">[추가상품]'.$buy_goods_name."_".$buy_goods_prefix.'</p>
                                    </div>
                                </div>
                            </td>
                            <td>'.number_format($buy_goods_price).'원</td>';
                    $html.='<td>';
                        $html.='<input type="hidden" class="cancel_op_price" value="'.$buy_goods_price.'">';
                        $html.='<input type="hidden"" name="cancel_op_buy_goods_seq[]" value="'.($buy_goods_seq).'">';
                        $html.='<input type="hidden"" name="cancel_op_buy_seq[]" value="'.($buy_seq).'">';
                        $html.='<input type="hidden"" name="op_org_count[]" value="'.($buy_goods_count).'">';
                                    if($mod=="cAll"){
                                        $html.='<input type="hidden" name="op_num[]" value="'.$buy_goods_count.'">'.$buy_goods_count;
                                    }else {
                                        $html .= '<select class="op_num" name="op_num[]" data="' . $buy_goods_seq . '">';
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
            $html.='<input type="hidden" class="cancel_dlv_free" name="cancel_dlv_free" value="'.$cancel_dlv_free.'">';
            $html.='</tbody>
        </table>
    </form>
</div>';
$html.='<div class="col-lg-12 col-md-12 no-padding">
            <div class="your-order no-padding">
                <h3 style="margin:0px;margin-top:20px;">환불예상금액 <span style="font-size:11px;color#333;">| 환불확정금액은 아래 예상금액과 다를수있습니다.</span></h3>
                <div class="your-order-table table-responsive">
                    <table class="table checkout-table checkout" style="border-top:2px solid #666;">
                        <thead>
                            <tr>
                                <th class="cross">주문금액</th>
                                <th class="cross">배송비</th>
                                <th class="cross">할인금액</th>
                                <th>
                                    <span class="checkout-price">결제 예정금액</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="sb_price">'.number_format($sum2).'</span><span class="won">원</span></td>
                                <td class="cross">
                                    <i class="fa fa-plus-square"></i> '. $ou_dlv_str .'<span class="won">원
                                    </span>
                                </td>
                                <td class="cross">
                                    <i class="fa fa-minus-square"></i> <span class="price_discount">'.number_format($sum2-$sum).'</span><span class="won">원</span>
                                </td>
                                <td>
                                    <span class="checkout-price">'.number_format($sum+$cancel_dlv_free).'</span>
                                    <span class="won2">원
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>';
echo $html;
?>
