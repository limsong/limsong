<?
include("common/config.shop.php");
include("check.php");
$code="shopMembers";
$page=$_GET["page"];
if(!$_POST['key']) {
    $key=$_GET['key'];
} else {
    $key=$_POST['key'];
}
if(!$_POST['keyfield']) {
    $keyfield=$_GET['keyfield'];
} else {
    $keyfield=$_POST['keyfield'];
}
if(empty($page)) {
    $page=1;
}
if(empty($key)) {
    $addQuery="";
} else {
    $addQuery=" where $keyfield like '%$key%'";
}
$query="select count(*) from $code $addQuery";
$result=mysql_query($query) or die($query);
$total_record=mysql_result($result,0,0);		//전체 게시물의 개수
if($total_record==0) {
    $first=1;
} else {
    $first=($page-1)*$bnum_per_page;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>회원관리</title>
    <script type="text/javascript" src="common/jslb_ajax.js"></script>
    <script type="text/javascript" src="common/common1.js"></script>
    <link rel="stylesheet" type="text/css" href="css/common.css" />
    <link rel="stylesheet" type="text/css" href="css/layout.css" />
    <link rel="stylesheet" type="text/css" href="css/boardList.css" />
    <link rel="stylesheet" type="text/css" href="css/mask.css" />
    <style type="text/css">
        .memberBottom {
            margin:10px 0px 0px 0px;
            padding:0px;
            list-style:none;
            width:453px;
            float:left;
        }
        .memberBottom li {
            float:right;
            margin:0px;
            padding:0px 4px 0px 4px;
        }
    </style>
</head>
<body>
<div id="total">
    <?
    include("include/include.header.php");
    ?>
    <div id="main">
        <div id="loading-mask" style=""></div>
        <div id="loading">
            <div class="loading-indicator"><img src="img/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/><span id="loading-msg">처리중.....</span></div>
        </div>
        <script type="text/javascript">
            loadingMask('on');
        </script>
        <h4 id="mainTitle">회원 관리</h4>
        <form name="boardListForm" method="post" action="boardListDelPost.php?code=<?=$code?>&page=<?=$page?>&keyfield=<?=$keyfield?>&key=<?=$key?>" target="action_frame">
            <div class="maninfo">
                <table align="center" width="100%" class="memberListTable">
                    <tr class="menuTr">
                        <th align="center" width="8%">선택</th>
                        <th align="center" width="20%">아이디</th>
                        <th align="center">이름</th>
                        <th align="center" width="20%">이메일</th>
                        <th align="center" width="20%">전화</th>
                        <th align="center">가입날자</th>
                    </tr>
                    <?
                    $currentTime=time();		//현재시간
                    $query="select id,name,email,phone,signdate from $code $addQuery order by signdate desc limit $first,$bnum_per_page";
                    $result=mysql_query($query) or die($query);
                    while($row=mysql_fetch_assoc($result)) {
                        $ou_id=$row["id"];
                        $ou_Mail=stripslashes($row["email"]);
                        $ou_UserName=stripslashes($row["name"]);
                        $ou_signdate=$row["signdate"];		//글작성한 시간
                        //$ou_QQ=$row["QQ"];
                        //$ou_msn=$row["msn"];
                        $ou_phone=$row["phone"];
                        $ou_ipaddres=$row["ipaddres"];
                        ?>
                        <tr class="contentTr">
                            <td align="center"><input type="checkbox" value="<?=$ou_id?>" name="check[]" /></td>
                            <td align="center"><a href="userRead.php?id=<?=$ou_id?>"><?=$ou_id?></a></td>
                            <td align="center"><?=$ou_UserName?></td>
                            <td align="center"><?=$ou_Mail?></td>
                            <td align="center"><?=$ou_phone?></td>
                            <td align="center"><?=$ou_signdate?></td>
                        </tr>
                    <?
                    }
                    ?>
                </table>
            </div>
        </form>
        <div class="pageNavi">
            <?
            $total_page=ceil($total_record/$bnum_per_page);		//35
            $total_block=ceil($total_page/$bpage_per_block);
            $block=ceil($page/$bpage_per_block);

            $first_page=($block-1)*$bpage_per_block+1;
            if($block>=$total_block) {
                $last_page=$total_page;
            } else {
                $last_page=$block*$bpage_per_block;
            }
            if($page>1) {
                echo("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=1'> <img src='images/ico_first.gif' class='ico_arr' alt='처음으로가기' /></a>");
            }
            if($block>1) {
                $bPage=$first_page-1;
                echo "[<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$bPage'>[이전 ".$bpage_per_block."개]</a>] ";
            }
            if($page>1) {
                $bfPage=$page-1;
                echo("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$bfPage'> <img src='images/ico_pre.gif' class='ico_arr' alt='이전페이지' /></a>");
            }


            for($my_page=$first_page;$my_page<=$last_page;$my_page++) {
                if($page==$my_page) {
                    echo (" [<b>".$my_page."</b>]");
                } else {
                    echo(" [<a href='userList.php?code=$code&key=$key&keyfield=$keyfield&page=$my_page'>".$my_page."</a>]");
                }
            }
            if($page<$total_page) {
                $nxPage=$page+1;
                echo("<a href='userList.php?code=$code&key=$key&keyfield=$keyfield&page=$nxPage'> <img src='images/ico_next.gif' class='ico_arr' alt='다음페이지' /></a>");
            }
            if($block<$total_block) {
                $nPage=$last_page+1;
                echo "[<a href='userList.php?code=$code&key=$key&keyfield=$keyfield&page=$nPage'>[다음 ".$bpage_per_block."개]</a>]";
            }
            if($page<$total_page) {
                echo("<a href='userList.php?code=$code&key=$key&keyfield=$keyfield&page=$total_page'> <img src='images/ico_last.gif' class='ico_arr' alt='마지막으로가기' /></a>");
            }
            ?>

        </div>
        <form name="searchForm" id="searchForm" method="post"  action="userList.php">
            <ul class="memberBottom">
                <li><input type="button" value="삭제" onclick="boardListDel(document.boardListForm)" class="memEleB" /></li>
                <li><input type="submit"  value="검색" class="memEleB" /></li>
                <li><input type="text" class="border2"  name="key" size="10" /></li>
                <li>
                    <select name="keyfield" class="border3">
                        <option value="id">이름</option>
                        <option value="email">E-mail</option>
                    </select>
                </li>
            </ul>
        </form>
    </div>
</div>
<? mysql_close($db); ?>
<iframe name="action_frame" width="500" height="400" style="display:none"></iframe>
</body>
</html>