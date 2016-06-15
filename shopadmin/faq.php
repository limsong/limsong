<form name="boardListForm" method="post"
      action="boardListDelPost.php?code=<?= $code ?>&page=<?= $page ?>&key=<?= $key ?>&keyfiled=<?= $keyfiled ?>"
      target="action_frame">
    <input type="hidden" name="tbl" value="tbl_notice">
    <table align="center" width="100%" class="memberListTable">
        <tr class="menuTr">
            <th width="5%">선택</th>
            <th width="5%">#</th>
            <th width="65%">제목</th>
            <th width="10%">작성자</th>
            <th width="10%">날짜</th>
            <th width="5%">조회수</th>
        </tr>
        <?
        $total_page = ceil($total_record / $bnum_per_page); //젠체 페이지수
        $total_block = ceil($total_page / $bpage_per_block); //젠체 block수
        $block = ceil($page / $bpage_per_block);  //현재 목록
        $first_page = ($block - 1) * $bpage_per_block + 1;   //[4][5][6] $first_page=[4];
        if ($block >= $total_block) {
            $last_page = $total_page;
        } else {
            $last_page = $block * $bpage_per_block;
        }
        ?>
        <!-- 공지쪽글//-->
        <?
        $currentTime = time();
        if($addQuery == " where") {
            $query = "select uid,subject,name,signdate,ref from tbl_notice $addQuery notify='q' order by uid desc limit $first,$gnum_per_page";
        }else{
            $query = "select uid,subject,name,signdate,ref from tbl_notice $addQuery and notify='q' order by uid desc limit $first,$gnum_per_page";
        }
        $result = mysql_query($query) or die($query);
        while ($row = mysql_fetch_assoc($result)) {                 //연관 배열
            $ou_uid = $row["uid"];
            $ou_subject = stripslashes($row["subject"]);        //역슬래시를 없애준다.두개면 하나만 없앤다.stripslashes();
            $ou_name = stripslashes($row["name"]);
            $ou_signdate = $row["signdate"];
            $ou_ref = $row["ref"];
            ?>
            <tr class="contentTr">
                <td class="check" align="center">
                    <input type="checkbox" value="<?= $ou_uid ?>" name="check[]"/>
                </td>
                <td class="num" align="center"><?=$ou_uid?></td>
                <td class="memId" style="padding-left:10px;">
                    <a href="noticeRead.php?code=q&number=<?= $ou_uid ?>&page=<?= $page ?>&keyfield=<?= $keyfield ?>&key=<?= $key ?>"><?= $ou_subject ?></a>
                </td>
                <td class="memName" align="center"><?= $ou_name ?></td>
                <td class="regNum" align="center"><?= $ou_signdate ?></td>
                <td align="center"><?= $ou_ref ?></td>
            </tr>
            <?
        }
        ?>
    </table>
</form>
<div class="pageNavi">
    <dl class="Dl">
        <dt class="Dt Dt1">
            <?
            if ($block > 1) {
                $bPage = $first_page - 1;    //이전 목록
                echo "<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$bPage'>[이전" . $bpage_per_block . "개]</a>";
            }
            ?>
        </dt>
        <dd class="Dd">
            <?
            if ($page > 1) {
                $bfPage = $page - 1;   //이전페이지
                echo("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$bfPage'><img src='img/prev3.gif' width='19' height='13' class='nvimg' /></a>");
            }
            ?>
        </dd>
        <dd class="Dd Dd1">
            <?
            for ($my_page = $first_page; $my_page <= $last_page; $my_page++) {                    //현재 페이지
                if ($page == $my_page) {
                    echo("[<b><span class='clll'>" . $my_page . "</span></b>]");
                } else {
                    echo("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$my_page'>[" . $my_page . "]</a>");
                }
            }
            ?>
        </dd>
        <dd class="Dd">
            <?
            if ($page < $total_page) {
                $nxPage = $page + 1;  //다음 페이지
                echo("<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$nxPage'><img src='img/next3.gif' width='19' height='13' class='nvimg' /></a>");
            }
            ?>
        </dd>
        <dt class="Dt Dt1">
            <?
            if ($page < $total_page) {
                $npage = $last_page + 1;   //다음 목록
                echo "<a href='boardList.php?code=$code&key=$key&keyfield=$keyfield&page=$npage'>[다음" . $bpage_per_block . "개]</a>";
            }
            ?>
        </dt>
    </dl>
</div>
<form name="searchForm" method="post" action="boardList.php?bbs_code=faq">
    <ul class="memberBottom">
        <li>
            <input type="button" class="memEleB" value="삭제"
                   onclick="brandListDel(document.boardListForm)"/>
        </li>
        <li>
            <input type="button" class="memEleB" value="쓰기" onclick="location.href='noticeWrite.php?code=faq'"/>
        </li>
        <li>
            <input type="submit" class="memEleB" value="검색"/>
        </li>
        <li>
            <input type="text" class="border2" name="key" size="10"/>
        </li>
        <li>
            <select name="keyfield">
                <option value="name">작성자</option>
                <option value="subject">제목</option>
            </select>
        </li>
    </ul>
</form>
<iframe name="action_frame" width="600" height="350" style="display:none"></iframe>