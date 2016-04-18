<div class="modal fade" id="szip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="padding:0px;">
    <div class="modal-dialog" style="width: 550px;padding:0px;">
        <div class="modal-content btn-radius">
            <div class="modal-header" style="border: none;padding: 0px;">
                <div class="logo" style="text-align:center;font-size:16px;padding-top:10px;background-color:#9585bf;color:white;margin:0px;">
                    검색된 주소
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
            </div>
            <div class="modal-body" id="zip" style="padding:0px;overflow-y:auto;"></div>
        </div>
    </div>
</div>
<?
@$shipping=$_POST['shipping'];
if($shipping==""){
    $shipping = "Bundle_delivery";
}
if(empty($uname)) {  //empty  비어 잇다면
    echo "<div class=\"container\">
                <div class='row'>
                    <div class='alert alert-danger txt-ag-center'>주문 페이지에 접근할수 없습니다.로그인을 해주세요.</div>
                    <div class=\"center\" style=\"margin-top:50px;\">
                        <a href=\"javascript:location.href='/'\" class=\"btn btn-danger\">
                            <i class=\"icon-arrow-left\"></i>
                            Go Back
                        </a>
                    </div>
                </div>
        ";
}else{
    ?>
    <style>
        .help-block {
            width : 100%;
            float: left;
            color:#d16e6c;
        }
    </style>
    <div class="container">
    <!-- Main component for a primary marketing message or call to action -->
    <div class="row MbasketList">
        <div class="itme-line" style="padding-bottom:0px;margin-bottom:10px;"><span style="font-weight: bold;font-size: 15px;">ORDER</b></span></div>
        <div class="col-xs-12" style="border-bottom: 1px dotted #d5e4f1;margin:2px 0px 6px 0px;"></div>
        <?
         
          //initializing by credentials.
        include("include/sqlcon.php"); //unicode support
        ?>
        <div class="col-xs-12" style="padding:0px;">
            <form action="orderPost.php" method="post" name="MorderForm" id="MorderForm">
                <table border="0" style="width:100%">
                    <?
                    $tempId = session_id();
                    @$arrUid=$_POST["check"];
                    $arrUidLen = count($arrUid);
                    for($i=0;$i<$arrUidLen;$i++) {
                        if($i==0){
                            $addQuery=" b.v_oid='$arrUid[$i]' AND b.id='$uname'
				                    AND b.orderNum='X'
				                    AND b.delivery='N'
				                    AND a.goods_code=b.goods_code
				                    AND a.goods_code=c.goods_code
				                    AND a.goods_code=d.goods_code";
                        }else{
                            $addQuery.=" OR b.v_oid='$arrUid[$i]' AND b.id='$uname'
				                    AND b.orderNum='X'
				                    AND b.delivery='N'
				                    AND a.goods_code=b.goods_code
				                    AND a.goods_code=c.goods_code
				                    AND a.goods_code=d.goods_code";
                        }
                    }
                    //echo $addQuery;
                    $query="SELECT a.goods_code,a.goods_name,a.summary,a.sellPrice,a.milage,
                                   b.opValue1,b.opValue2,b.v_amount,b.signdate,b.num,b.v_oid,b.v_oid,
                                   c.opName1,c.opName2,
                                   d.ImageName
                            FROM goods a,basket b,optionName c,upload_simages d
                            WHERE ".@$addQuery."
                            ORDER BY b.signdate ASC";
                    //echo $query;
                    $result = mysql_query($query);
                    $totalMoney=0;
                    while(@$row=mysql_fetch_assoc($result)){
                        $totalMoney = $totalMoney+$row["sellPrice"]*$row["num"];
                        $ou_smImage = $row["ImageName"];
                        $smImagesrc = $brandImagesWebDir.$ou_smImage;
                        ?>
                        <input type="hidden" name="itemcode[]" value="<?=$row['v_oid']?>">
                        <tr>
                            <td width="20%" align="center">
                                <a href="?pg=shopItems&code=<?=$ou_goods_code?>"><img src="<?=$smImagesrc?>" alt="상품 섬네일" title="상품 섬네일" width="62"></a>
                            </td>
                            <td valign="top">
                                <table border="0" style="width:100%">
                                    <tr>
                                        <td width="60" align="right">상품명 :</td>
                                        <td width="10"></td>
                                        <td align="left">
                                            <a href="?pg=shopItems&code=<?=$ou_goods_code?>"><span style="color:#555555;font-size:12;font-family:굴림;"><?=$ou_goods_name?></span></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">판매가 :</td>
                                        <td width="10"></td>
                                        <td align="left"><i class="icon-yen"></i> <?=number_format($row["sellPrice"])?>원</td>
                                    </tr>
                                    <tr>
                                        <td align="right">수량 :</td>
                                        <td width="10"></td>
                                        <td align="left"><?=$row["num"]?></td>
                                    </tr>
                                    <tr>
                                        <td align="right">적립금 :</td>
                                        <td width="10"></td>
                                        <td align="left"><i class="icon-money"></i> <?=$row['milage']?>원</td>
                                    </tr>
                                    <tr>
                                        <td align="right">합계 :</td>
                                        <td width="10"></td>
                                        <td align="left"><?=number_format($row["sellPrice"]*$row["num"])?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr><td colspan="2" style="height:8px;"></td></tr>
                    <?
                    }
                    $query = "SELECT * FROM settings";
                    $result = mysql_query($query) or die("erro1r");
                    $row = mysql_fetch_assoc($result);
                    $Rates = $row["Rates"];
                    $ds = $row["dShipping"];
                    $is = $row["iShipping"];
                    $fees = $row["fees"];
                    $raeg = $row["raeg"];
                    $query = "SELECT * FROM shopMembers WHERE id='$uname'";
                    $result = mysql_query($query) or die($query);
                    $row = mysql_fetch_assoc($result);
                    $hPostarr = explode("-",$row["hPost"]);
                    ?>
                    <tr>
                        <input type="hidden" name="oPost" value="<?=$row['hPost']?>">
                        <input type="hidden" name="oAddr1" value="<?=$row['hAddr1']?>">
                        <input type="hidden" name="oAddr2" value="<?=$row['hAddr2']?>">
                        <input type="hidden" name="uname" value="<?=$row['name']?>">
                        <input type="hidden" name="spp" value="<?=$shipping?>">
                    </tr>
                    <tr><td colspan="2" style="border-bottom: 1px dotted #d5e4f1;"></td></tr>
                    <tr>
                        <td valign="middle" colspan="8">
                            <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                <tr>
                                    <td>
                                        <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                            <tr>
                                                <td align="right" style="padding:7px 12px 7px 0px">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#F6F6F6">
                                                        <tr>
                                                            <td align="right" height="20">상품 합계금액&nbsp;&nbsp;:</td>
                                                            <td align="right" style="padding-left:20px;"> <?=number_format($totalMoney)?>원</td>
                                                        </tr>
                                                        <tr>
                                                            <td align="right" height="20">
                                                                <?
                                                                if($raeg == "Y"){
                                                                    if($shipping=="Bundle_delivery"){
                                                                        echo "묶음배송";
                                                                    }else{
                                                                        echo "빠른배송";
                                                                    }
                                                                }else{
                                                                    echo "배송비";
                                                                }
                                                                ?>
                                                                &nbsp;&nbsp;:
                                                            </td>
                                                            <td align="right" style="padding-left:20px;"> <?=number_format($ds)?>원</td>
                                                        </tr>
                                                        <?
                                                        if($raeg == "Y"){
                                                        ?>
                                                        <tr>
                                                            <td align="right" height="20">적용환율&nbsp;&nbsp;:</td>
                                                            <td align="right" style="padding-left:20px;"> <?=$Rates?></td>
                                                        </tr>
                                                        <?
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td align="right" height="20">
                                                                <strong>총 주문합계 금액</strong>&nbsp;&nbsp;:</td>
                                                            <td align="right" style="padding-left:20px;">
                                                                <strong>
                                                                    <span style="color: #ff7300">
                                                                        <?
                                                                        if($raeg == "Y")
                                                                            echo number_format($totalMoney+$totalMoney*$Rates+$ds);
                                                                        else
                                                                            echo number_format($totalMoney+$ds);
                                                                        ?>원
                                                                    </span>
                                                                </strong>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td colspan="2" style="border-bottom: 1px dotted #d5e4f1;"></td></tr>
                </table>
                <table border="0" width="99%">
                    <tr><td height="20" colspan="2"></td></tr>
                    <tr>
                        <td colspan="2">주문자 정보</td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">성명</td>
                        <td class="td-border pd"><?=$row["name"]?></td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">입금자명</td>
                        <td class="td-border pd">
                            <input type="text" name="oName" id="oName" size="10" maxlength="10">
                            <span>(주문자와 같을경우 생략 가능)</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">휴대전화</td>
                        <td class="td-border pd">
                            <div class="form-group">
                                <input type="text" name="oPhone" value="<?=$row["phone"]?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">E-mail</td>
                        <td class="td-border pd">
                            <table border="0">
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input type="email" id="oEmail" name="oEmail" class="col-sm-9" value="<?=$row["email"]?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>제품구입시 E-mail을 통해 주문처리과정을 보내 드립니다.</td>
                                </tr>
                                <tr>
                                    <td>E-mail 주소란에는 반드시 수신가능한 E-mail 주소를 입력해 주십시오.</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table border="0" width="99%">
                    <tr><td height="20" colspan="2"></td></tr>
                    <tr>
                        <td>배송지 정보</td>
                        <td align="right">
                            <label>
                                배송지 정보가 주문자 정보와 동일합니까?
                                <input type="checkbox" class="ace" id="Mall_yes">
                                <span class="lbl"></span>
                                예
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">성명</td>
                        <td class="td-border pd">
                            <div class="form-group">
                                <input type="text" name="rName" id="MrName" style="width:99%;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">주소</td>
                        <td class="td-border pd">
                            <table border="0">
                                <tr>
                                    <td>
                                        <div class="input-group" style="margin-top:10px;">
                                            <input class="form-control input-mask-date" type="text" id="zipadd" placeholder="주소찾기" />
                                            <span class="input-group-btn">
                                               <button class="btn btn-sm btn-purple zipadd" type="button" data-toggle="modal" data-target="#szip">
                                                   <i class="icon-home bigger-110"></i>
                                                   주소찾기
                                               </button>
                                           </span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group" style="margin-top:10px;">
                                            <input type="text" name="rPost1" id="rPost1" value="<?=$hPostarr[0]?>" style="width:45%;" class="no-float" readonly /> -
                                            <input type="text" name="rPost2" id="rPost2" value="<?=$hPostarr[1]?>" style="width:45%;" class="no-float" readonly />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group" style="margin-top:10px;">
                                            <input type="text" name="rAddr1" id="rAddr1" value="<?=$row["hAddr1"]?>" style="width:99%;" readonly />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group" style="margin-top:10px;">
                                            <input type="text" name="rAddr2" id="rAddr2" value="<?=$row["hAddr2"]?>" style="width:99%;" />
                                            나머지주소
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">휴대전화</td>
                        <td class="td-border pd">
                            <div class="form-group">
                                <input type="text" id="MrPhone" name="rPhone" style="width:100%;" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">배송메세지</td>
                        <td class="td-border pd">
                            <div class="form-group">
                                <input type="text" name="comment" style="width:100%;" />
                            </div>
                        </td>
                    </tr>
                </table>
                <table width="99%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="10" colspan="2"></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <button class="btn btn-danger" type="submit">결제하기</button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" height="10"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div class="row PbasketList">
        <form action="orderPost.php" method="post" name="orderForm" id="orderForm">
            <table border="0" style="width: 100%;">
                <tr>
                    <td>
                        <table border="0" style="width: 100%;">
                            <tr>
                                <td><span style="font-weight: bold;">장바구니</span> | <b style="font-size: 12px;">일반상품</b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" width="100%;" style="font-size: 12px;">
                            <tr style="border-top:1px solid gray;border-bottom: 1px solid gray;">
                                <td height="25" width="69%">상품명</td>
                                <td width="10%">판매가</td>
                                <td width="5%">수량</td>
                                <td width="10%">적립금</td>
                                <td width="6%">합계</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" style="width: 100%;font-size:12px;" class="table-hover">
                            <tr>
                                <td colspan="8" height="1"></td></tr>
                            <?
                            $tempId = session_id();
                            @$arrUid=$_POST["check"];
                            $arrUidLen = count($arrUid);
                            for($i=0;$i<$arrUidLen;$i++) {
                                if($i==0){
                                    $addQuery=" b.v_oid='$arrUid[$i]' AND b.id='$uname'
				                    AND b.orderNum='X'
				                    AND b.delivery='N'
				                    AND a.goods_code=b.goods_code
				                    AND a.goods_code=c.goods_code
				                    AND a.goods_code=d.goods_code";
                                }else{
                                    $addQuery.=" OR b.v_oid='$arrUid[$i]' AND b.id='$uname'
				                    AND b.orderNum='X'
				                    AND b.delivery='N'
				                    AND a.goods_code=b.goods_code
				                    AND a.goods_code=c.goods_code
				                    AND a.goods_code=d.goods_code";
                                }
                            }
                            //echo $addQuery;
                            $query="SELECT a.goods_code,a.goods_name,a.summary,a.sellPrice,
                                           b.opValue1,b.opValue2,b.v_amount,b.signdate,b.num,b.v_oid,
                                           c.opName1,c.opName2,
                                           d.ImageName
				                    FROM goods a,basket b,optionName c,upload_simages d
				                    WHERE ".$addQuery."
				                    ORDER BY b.signdate ASC";
                            //echo $query;
                            $result = mysql_query($query);
                            $totalMoney=0;
                            while(@$row=mysql_fetch_assoc($result)){
                                $totalMoney = $totalMoney+$row["sellPrice"]*$row["num"];
                                $ou_smImage = $row["ImageName"];
                                $smImagesrc = $brandImagesWebDir.$ou_smImage;
                                ?>
                                <input type="hidden" name="itemcode[]" value="<?=$row['v_oid']?>">
                                <tr>
                                    <td width="69%">
                                        <table>
                                            <tr>
                                                <td style="height:60px;"><a href="?pg=shopItems&code=<?=$row["goods_code"]?>"><img src="<?=$smImagesrc?>" alt="상품 섬네일" title="상품 섬네일" width="50" height="50"></a></td>
                                                <td>
                                                    &nbsp; <span class="rm_p_name"><a href="?pg=shopItems&code=<?=$row["goods_code"]?>"><span style="color:#555555;font-size:12;font-family:굴림;"><?=$row["goods_name"]?></span></a></span>
                                                    <br>&nbsp; <span class="rm_p_option">색상 : <?=$row["opValue1"]?> <?=$row["num"]?>개</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="10%" style="color:#555555;font-size:12;font-family:굴림;padding-top:7px;"><i class="icon-yen"></i> <?=number_format($row["sellPrice"])?>원</td>
                                    <td width="5%">
                                        <?=$row["num"]?>
                                    </td>
                                    <td width="10%" style="color:#555555;font-size:12;font-family:굴림;padding-top:7px;"><i class="icon-money"></i> <?=$row['milage']?></td>
                                    <td width="6%" style="color:#555555;font-size:12;font-family:굴림;padding-top:7px;"><i class="icon-yen"></i> <?=number_format($row["sellPrice"]*$row["num"])?>원<br></td>
                                </tr>
                            <?
                            }
                            $query = "SELECT * FROM settings";
                            $result = mysql_query($query) or die("erro1r");
                            $row = mysql_fetch_assoc($result);
                            $Rates = $row["Rates"];
                            $ds = $row["dShipping"];
                            $is = $row["iShipping"];
                            $fees = $row["fees"];
                            $raeg = $row["raeg"];
                            $query = "SELECT * FROM shopMembers WHERE id='$uname'";
                            $result = mysql_query($query) or die($query);
                            $row = mysql_fetch_assoc($result);
                            $hPostarr = explode("-",$row["hPost"]);
                            $db->disconnect();
                            ?>
                            <input type="hidden" name="oPost" value="<?=$row['hPost']?>">
                            <input type="hidden" name="oAddr1" value="<?=$row['hAddr1']?>">
                            <input type="hidden" name="oAddr2" value="<?=$row['hAddr2']?>">
                            <input type="hidden" name="uname" value="<?=$row['name']?>">
                            <input type="hidden" name="spp" value="<?=$shipping?>">
                            <tr><td colspan="8" height="1" bgcolor="#cccccc"></td></tr>
                            <tr>
                                <td valign="middle" colspan="8">
                                    <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                        <tr>
                                            <td>
                                                <table width="100%" border="0" cellspacing="2" cellpadding="0">
                                                    <tr>
                                                        <td width="240">&nbsp;<strong>고객님의 총 주문 합계 금액입니다.</strong></td>
                                                        <td align="right" style="padding:7px 12px 7px 0px">
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#F6F6F6">
                                                                <tr>
                                                                    <td align="right" height="20">상품 합계금액&nbsp;&nbsp;:</td>
                                                                    <td align="right" style="padding-left:20"> <?=number_format($totalMoney)?>원</td>
                                                                </tr>
                                                                <?
                                                                if($raeg == "Y"){
                                                                ?>
                                                                <tr>
                                                                    <td align="right" height="20">
                                                                        <?
                                                                        if($shipping=="Bundle_delivery"){
                                                                            echo "묶음배송";
                                                                        }else{
                                                                            echo "빠른배송";
                                                                        }
                                                                        ?>
                                                                        &nbsp;&nbsp;:
                                                                    </td>
                                                                    <td align="right" style="padding-left:20"> <?=number_format($ds)?>원</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="right" height="20">적용환율&nbsp;&nbsp;:</td>
                                                                    <td align="right" style="padding-left:20"> <?=$Rates?></td>
                                                                </tr>
                                                                <?
                                                                }else{
                                                                ?>
                                                                <tr>
                                                                    <td align="right" height="20">배송비&nbsp;&nbsp;:</td>
                                                                    <td align="right" style="padding-left:20"> <?=number_format($ds)?>원</td>
                                                                </tr>
                                                                <?
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td align="right" height="20">
                                                                        <strong>총 주문합계 금액</strong>&nbsp;&nbsp;:</td>
                                                                    <td align="right" style="padding-left:20">
                                                                        <strong>
                                                                            <span style="color: #ff7300">
                                                                                <?
                                                                                if($raeg == "Y")
                                                                                    echo number_format($totalMoney+$totalMoney*$Rates+$ds);
                                                                                else
                                                                                    echo number_format($totalMoney+$ds);
                                                                                ?>원
                                                                            </span>
                                                                        </strong>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr><td colspan="8" height="1" bgcolor="#cccccc"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table border="0" width="100%">
                <tr><td height="20" colspan="2"></td></tr>
                <tr>
                    <td colspan="2">주문자 정보</td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">성명</td>
                    <td class="td-border pd"><span id="uname"><?=$row["name"]?></span></td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">입금자명</td>
                    <td class="td-border pd">
                        <input type="text" name="oName" id="oName" size="10" maxlength="10">
                        <span>(주문자와 같을경우 생략 가능)</span>
                    </td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">휴대전화</td>
                    <td class="td-border pd">
                        <div class="form-group">
                            <input type="text" id="oPhone" name="oPhone" value="<?=$row["phone"]?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">E-mail</td>
                    <td class="td-border pd">
                        <table border="0">
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <input type="email" id="oEmail" name="oEmail" class="col-sm-9" value="<?=$row["email"]?>" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>제품구입시 E-mail을 통해 주문처리과정을 보내 드립니다.</td>
                            </tr>
                            <tr>
                                <td>E-mail 주소란에는 반드시 수신가능한 E-mail 주소를 입력해 주십시오.</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table border="0" width="100%">
                <tr><td height="20" colspan="2"></td></tr>
                <tr>
                    <td>배송지 정보</td>
                    <td align="right">
                        <label>
                            배송지 정보가 주문자 정보와 동일합니까?
                            <input type="checkbox" class="ace" id="all_yes">
                            <span class="lbl"></span>
                            예
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">성명</td>
                    <td class="td-border pd">
                        <div class="form-group">
                            <input type="text" name="rName" id="rName">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">주소</td>
                    <td class="td-border pd">
                        <table border="0">
                            <tr>
                                <td>
                                    <div class="input-group" style="margin-top:10px;">
                                        <input class="form-control input-mask-date" type="text" style="width:250px;" id="zipadd" placeholder="여기에 입력후 주소찾기를 눌러주세요" />
                                       <span class="input-group-btn">
                                           <button class="btn btn-sm btn-purple zipadd" type="button" data-toggle="modal" data-target="#szip">
                                               <i class="icon-home bigger-110"></i>
                                               주소찾기
                                           </button>
                                       </span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group" style="margin-top:10px;">
                                        <input type="text" name="rPost1" id="rPost1" value="<?=$hPostarr[0]?>" class="col-md-3 no-float" readonly /> -
                                        <input type="text" name="rPost2" id="rPost2" value="<?=$hPostarr[1]?>" class="col-md-3 no-float" readonly />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group" style="margin-top:10px;">
                                        <input type="text" name="rAddr1" id="rAddr1" value="<?=$row["hAddr1"]?>" size="50" readonly />
                                        기본주소
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group" style="margin-top:10px;">
                                        <input type="text" name="rAddr2" id="rAddr2" value="<?=$row["hAddr2"]?>" size="50" />
                                        나머지주소
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">휴대전화</td>
                    <td class="td-border pd">
                        <div class="form-group">
                            <input type="text" id="rPhone" name="rPhone" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="td-w-p20 txt-ag-center td-h-30 td-border bg-gray pd">배송메세지</td>
                    <td class="td-border pd">
                        <table border="0" width="100%">
                            <tr>
                                <td>
                                    <textarea name="comment" cols="100%" rows="5"></textarea>
                                    <p>배송메세지란에는 배송시 참고할 사항이 있으면 적어주십시오.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td height="10" colspan="2"></td>
                </tr>
                <tr>
                    <td align="center">
                        <!--<button class="btn btn-danger" type="submit">결제하기</button>-->
                        <button class="btn btn-purple" type="button" data-toggle="modal" data-target="#buyModal">결제하기</button>
                        <!-- Modal -->
                        <div class="modal fade" id="buyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header" style="background-color:#357ebd;color:white;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel" style="text-align:left;">결제방법 선택</h4>
                              </div>
                              <div class="modal-body" style="text-align:left;">
                                <p>
                                    <label>
                                        <input name="paymethod" value="B" type="radio" class="ace">
                                        <span class="lbl">무통장입금</span>
                                        [<span class="lbl" style="color:red;font-weight:bold;">결제금액 : 
                                            <?
                                            if($raeg == "Y")
                                                echo number_format($totalMoney+$totalMoney*$Rates+$ds);
                                            else
                                                echo number_format($totalMoney+$ds);
                                            ?>
                                        원</span>]
                                    </label>
                                </p>
                                <p style="padding-left:20px;">
                                    입금계좌 :
                                    <select name="paydata1" size="1" style="font-size=9pt;" onchange="bank_selected()">;
                                        <option>입금 계좌번호 선택(반드시 주문자 성함으로 입금)</option><option value="신한은행 140007571174 (예금주:싸니커머스)">신한은행 140007571174 (예금주:싸니커머스)</option>
                                        <option value="농협중앙회 3550001778783 (예금주:싸니커머스)">농협중앙회 3550001778783 (예금주:싸니커머스)</option>
                                        <option value="국민은행 87960101187370 (예금주:싸니커머스)">국민은행 87960101187370 (예금주:싸니커머스)</option>
                                        <option value="기업은행 04108008101026 (예금주:싸니커머스)">기업은행 04108008101026 (예금주:싸니커머스)</option>
                                    </select>
                                </p>
                                <ul style="margin:0px;padding-left:20px;">
                                    <li>입금계좌를 선택하시고, [결제하기] 클릭 후 인터넷뱅킹, 은행방문등을 통해 입금해 주세요.</li>
                                    <li>상점에서 입금확인후, 안전하고 빠르게 상품을 고객님께 배송해 드리겠습니다.</li>
                                    <li>입금 계좌번호 및 금액을 고객의 핸드폰으로 발송해 드립니다!</li>
                                </ul>
                                <hr>
                                <p>
                                    <label>
                                        <input name="paymethod" value="B" type="radio" class="ace">
                                        <span class="lbl">신용카드</span>
                                        [<span class="lbl" style="color:red;font-weight:bold;">결제금액 : 
                                            <?
                                            if($raeg == "Y")
                                                echo number_format($totalMoney+$totalMoney*$Rates+$ds);
                                            else
                                                echo number_format($totalMoney+$ds);
                                            ?>
                                        원</span>]
                                    </label>
                                </p>
                                <ul style="margin:0px;padding-left:20px;">
                                    <li>안심클릭 및 인터넷안전결제(IPS)서비스로 128bit SSL로 암호화된 결제창이 새로 뜹니다! </li>
                                    <li>결제후, 카드명세서에 [이니시스(INICIS)]로 표시되며, 카드 정보는 상점에 남지 않습니다.</li>
                                </ul>
                                <hr>
                                <p>
                                    <label>
                                        <input name="paymethod" value="B" type="radio" class="ace">
                                        <span class="lbl">실시간 계좌이체</span>
                                        [<span class="lbl" style="color:red;font-weight:bold;">결제금액 : 
                                            <?
                                            if($raeg == "Y")
                                                echo number_format($totalMoney+$totalMoney*$Rates+$ds);
                                            else
                                                echo number_format($totalMoney+$ds);
                                            ?>
                                        원</span>]
                                    </label>
                                    <button type="button" class="btn btn-minier btn-purple banktime">이용시간 안내</button>
                                    <div id="banktime" style="position: absolute; z-index: 100; width: 200px; height: 20px; left: 80px; top: 330px; visibility: visible;display:none;">
                                        <img src="/assets/images/payments_time_pop.png">
                                    </div>
                                </p>
                                <ul style="margin:0px;padding-left:20px;">
                                    <li>안심클릭 및 인터넷안전결제(IPS)서비스로 128bit SSL로 암호화된 결제창이 새로 뜹니다! </li>
                                    <li>결제후, 카드명세서에 [이니시스(INICIS)]로 표시되며, 카드 정보는 상점에 남지 않습니다.</li>
                                </ul>
                                <hr>
                                <p>
                                    <label>
                                        <input name="paymethod" value="B" type="radio" class="ace">
                                        <span class="lbl">핸드폰결제</span>
                                        [<span class="lbl" style="color:red;font-weight:bold;">결제금액 : 
                                            <?
                                            if($raeg == "Y")
                                                echo number_format($totalMoney+$totalMoney*$Rates+$ds);
                                            else
                                                echo number_format($totalMoney+$ds);
                                            ?>
                                        원</span>]
                                    </label>
                                </p>
                                <ul style="margin:0px;padding-left:20px;">
                                    <li>결제정보가 상점에 남지 않으며, 보안 적용된 결제창이 새로 뜹니다! </li>
                                    <li>결제후, 핸드폰 요금청구서에 '소액결제'로 표시됩니다!</li>
                                    <li>결제후, 결제건의 취소는 해당 달에만 가능합니다!</li>
                                </ul>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">주문최소</button>
                                <button type="submit" class="btn btn-purple">결제하기</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" height="10"></td>
                </tr>
            </table>
        </form>
    </div>
    <iframe name="action_fram" style="width:100%;display: none;border: 1px solid;"></iframe>
<?
}
?>