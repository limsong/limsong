<?
include("common/config.shop.php");
$page=@$_GET['page'];
if(!@$_POST['key']) {
    $key=@$_GET['key'];
} else {
    $key=$_POST['key'];
}
if(!@$_POST['keyfield']) {
    $keyfield=@$_GET['keyfield'];
} else {
    $keyfield=$_POST['keyfield'];
}
$special=@$_GET["special"];
$spitems=@$_GET["sp_option"];
if(empty($page)) {
    $page=1;
}
if(empty($key)) {
    $addQuery="";
} else {
    $addQuery=" AND $keyfield like '%$key%'";
}
if(empty($special)) {
    $addQuery1="";
} else {
    $addQuery1=" AND $special='Y' ";
}
if(!empty($spitems)){
    $addQuery1 = " AND sp_option LIKE '%$spitems%'";
}
$xcode=@$_GET["xcode"];
$mcode=@$_GET["mcode"];
$scode=@$_GET["scode"];
$query="SELECT COUNT(*) FROM goods WHERE goods_code LIKE '$xcode$mcode$scode%' $addQuery $addQuery1";

$result=mysql_query($query) or die($query);
$total_record=mysql_result($result,0,0);

if($total_record==0) {
    $first=1;
} else {
    $first=($page-1)*$gnum_per_page;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/common.css" />
    <link rel="stylesheet" type="text/css" href="css/brandList.css" />
    <link rel="stylesheet" type="text/css" href="css/nv.css" />
</head>
<body>
    <div id="main">
        <form name="brandForm" id="brandForm" method="post" action="brandPost.php" enctype="multipart/form-data" target="action_frame" onsubmit="return checkBrandForm(this)">
            <input type="hidden" name="xcode" />
            <input type="hidden" name="mcode" />
            <input type="hidden" name="scode" />
            <table align="center" class="memberListTable">
                <tr class="menuTr">
                    <th width="3%"><input type="checkbox" onclick="CheckAll(this.checked)" /></th>
                    <th width="3%">번호</th>
                    <th width="13%">상품코드</th>
                    <th width="54%" align="left">상품명</th>
                    <!--
                    <th width="13%">판매가격</th>
                    -->
                    <th width="17%">입고일</th>
                    <!--
                    <th width="6%">수정</th>
                    <th width="6%">삭제</th>
                    -->
                </tr>
                <?

                //$query="select goods_code,goods_name,sellPrice,spitems,inputDate from goods WHERE goods_code like '$xcode$mcode$scode%' $addQuery $addQuery1 order by inputDate desc limit $first,$gnum_per_page";
                $query="select goods_code,goods_name,inputDate from goods WHERE goods_code like '$xcode$mcode$scode%' $addQuery $addQuery1 order by id desc limit $first,$gnum_per_page";

                $result=mysql_query($query) or die($query);
                $article_num=$total_record-($page-1)*$gnum_per_page;


                while($row=mysql_fetch_assoc($result)) {

                    $ou_goods_code=$row["goods_code"];
                    $ou_goods_name=stripslashes($row["goods_name"]);
                    //$ou_sellPrice=$row["sellPrice"];
                    $ou_inputDate=$row["inputDate"];
                    ?>
                <tr class="contentTr">
                    <td><input type="checkbox" name="check[]" value="<?=$ou_goods_code?>"></td>
                    <td><?=$article_num?></td>
                    <td><a href="brandRead.php?goods_code=<?=$ou_goods_code?>&page=<?=$page?>&xcode=<?=$xcode?>&mcode=<?=$mcode?>&scode=<?=$scode?>&key=<?=$key?>&keyfield=<?=$keyfield?>" target="_parent"><?=$ou_goods_code?></a></td>
                    <td><a style="width:100%!important;float:left;text-align: left;" href="brandRead.php?goods_code=<?=$ou_goods_code?>&page=<?=$page?>&xcode=<?=$xcode?>&mcode=<?=$mcode?>&scode=<?=$scode?>&key=<?=$key?>&keyfield=<?=$keyfield?>" target="_parent"><?=$ou_goods_name?></a></td><!--onclick="parent.brandRead(this);return false"-->
                    <!--<td><input type="text" name="sellPrice<?=$ou_goods_code?>" id="sellPrice" class="border" value="<?=$ou_sellPrice?>" /></td>-->
                    <td><?=$ou_inputDate?></td>
                    <!--<td>[<a href="brandSubChangePost.php" onclick="parent.brandSubChange('modify','<?=$ou_goods_code?>',this);return false">수정</a>]</td>
                    <td>[<a href="brandSubChangePost.php" onclick="parent.brandSubChange('delete','<?=$ou_goods_code?>',this);return false">삭제</a>]</td>
                            -->
                </tr>
                <?
                $article_num--;
                }
                ?>
            </table>
        </form>
            <div class="pageNavi">
                <?
                $total_page=ceil($total_record/$gnum_per_page); //젠체 페이지수
                $total_block=ceil($total_page/$gpage_per_block); //젠체 block수
                $block=ceil($page/$gpage_per_block);  //현재 목록
                $first_page=($block-1)*$gpage_per_block+1;   //[4][5][6] $first_page=[4];
                if($block>=$total_block) {
                    $last_page=$total_page;
                } else {
                    $last_page=$block*$gpage_per_block;
                }
                ?>
                <dl class="Dl">
                    <dt class="Dt Dt1">
                        <?
                        if($block>1) {
                        $bPage=$first_page-1;       //이전 목록
                        echo "<a href='iframeBrandList.php?xcode=$xcode&mcode=$mcode&scode=$scode&spitems=$spitems&key=$key&keyfield=$keyfield&page=$bPage'>이전".$gpage_per_block."개</a>";
                    }
                    ?>
                </dt>
                <dd class="Dd">
                    <?
                    if($page>1) {
                        $bfPage=$page-1;   //이전페이지
                        echo ("<a href='iframeBrandList.php?xcode=$xcode&mcode=$mcode&scode=$scode&spitems=$spitems&key=$key&keyfield=$keyfield&page=$bfPage'> 이전 </a>");
                    }
                    ?>
                </dd>
                <dd class="Dd Dd1 pg">
                    <?
                    for($my_page=$first_page;$my_page<=$last_page;$my_page++) {                 //현재 페이지
                        if($page==$my_page) {
                            echo ("<a href='#' class='clll'>".$my_page."</a>");
                        } else {
                            echo("<a href='iframeBrandList.php?xcode=$xcode&mcode=$mcode&scode=$scode&spitems=$spitems&key=$key&keyfield=$keyfield&page=$my_page'>".$my_page."</a>");
                        }
                    }
                    ?>
                </dd>
                <dd class="Dd">
                    <?
                    if($page<$total_page) {
                        $nxPage=$page+1;  //다음 페이지
                        echo ("<a href='iframeBrandList.php?xcode=$xcode&mcode=$mcode&scode=$scode&spitems=$spitems&key=$key&keyfield=$keyfield&page=$nxPage'> 다음 </a>");
                    }
                    ?>
                </dd>
                    <!--
                    <dt class="Dt Dt1">
                    <?
                    if($page<$total_page) {
                        $npage=$last_page;   //다음 목록
                        echo "<a href='iframeBrandList.php?xcode=$xcode&mcode=$mcode&scode=$scode&spitems=$spitems&key=$key&keyfield=$keyfield&page=$npage'>다음".$gpage_per_block."개</a>";
                    }
                    ?>
                    </dt>
                -->
            </dl>
        </div>
        <form name="searchForm" id="searchForm" action="iframeBrandList.php?xcode=<?=$xcode?>&mcode=<?=$mcode?>&scode=<?=$scode?>">
            <ul class="memberBottom">
                <li>
                    <select name="keyfield" class="">
                        <option value="goods_code">상품코드</option>
                        <option value="goods_name">상품명</option>
                        <option value="inputDate">입고일</option>
                    </select>
                    <input type="text" class=""  name="key" size="10" />
                    <input type="submit" class="memEleB"  value="상품검색" />
                </li>
                <li>
                    <input type="button" value=" 상품추가 " class="memEleB" onclick="parent.location.href='brandWrite.php'" />
                    <input type="button" value=" 상품삭제  " class="memEleB" onclick="parent.brandListDel(document.brandForm)" />
                </li>
                <!--
                <li>
                    <?
                    //$query = "SELECT name FROM sp";
                    //$result = mysql_query($query) or die($query);
                    //$reHtm = '<select name="spitems">';
                    //$reHtm .= '<option>스페셜 상품 선택</option>';
                    //while ($rows=mysql_fetch_assoc($result)) {
                            # code...
                    //      $sp_name = $rows["name"];
                    //      $reHtm .= '<option value="'.$sp_name.'">'.$sp_name.'</option>';
                    //}
                    //$reHtm .= '</select>';
                    //echo $reHtm;
                    ?>
                    <input type="button" value=" 확인" class="memEleB" onclick="parent.brandListadd(document.brandForm,'bestitems')" />
                    <input type="button" value=" 스페셜 상품 삭제 " class="memEleB" onclick="parent.brandListadd(document.brandForm,' ')" />
                </li>
                -->
            </ul>
        </form>
        <iframe name="action_frame" width="500" height="100" style="display:none"></iframe>
        </div>
        <script type="text/javascript" src="assets/plugins/jquery-1.10.2.min.js"></script>
        <script type="text/javascript">
        function CheckAll(val) {
            $("input[name='check[]']").each(function() {
                this.checked = val;
            });
        }
        </script>
    </body>
</html>