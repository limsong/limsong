<h4 id="mainTitle"><?= $title ?></h4>
<form name="boardListForm" method="post" action="boardListDelPost.php?code=<?= $code ?>&page=<?= $page ?>&key=<?= $key ?>&keyfiled=<?= $keyfiled ?>" target="action_frame">
        <table align="center" width="100%" class="memberListTable">
                <tr class="menuTr">
                        <th width="5%">선택</th>
                        <th width="5%">번호</th>
                        <th width="50%">제목</th>
                        <th width="15%">작성자</th>
                        <th width="15%">등록일</th>
                        <th width="10%">상태</th>
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
                $currentTime = time();
                $query = "select * from $code $addQuery order by fid desc,thread asc limit $first,$bnum_per_page";
                $result = mysql_query($query) or die($query);
                $article_num = $total_record - ($page - 1) * $bnum_per_page;   //새로 작성한 글의 번호 지정

                while ($row = mysql_fetch_assoc($result)) {                 //연관 배열
                        $ou_uid = $row["uid"];
                        $ou_subject = stripslashes($row["title"]);        //역슬래시를 없애준다.두개면 하나만 없앤다.stripslashes();
                        $ou_name = stripslashes($row["user_id"]);
                        $ou_signdate = $row["qna_reg_date"];
                        $ou_qna_status = $row["qna_status"];
                        if($ou_qna_status=="0"){
                                $str = "미답변";
                        }elseif($ou_qna_status=="1"){
                                $str ="답변완료";
                        }else{
                                $str = "보류";
                        }
                        ?>
                        <tr class="contentTr">
                                <td class="check" align="center">
                                        <input type="checkbox" value="<?= $ou_uid ?>" name="check[]" />
                                </td>
                                <td class="num" align="center"><?= $article_num ?></td>
                                <td class="memId" style="padding-left:<?= $indentWidth ?>">
                                        <?= $reImg ?>
                                        <a href="javascript:;" data="code=<?= $code ?>&number=<?= $ou_uid ?>&page=<?= $page ?>&keyfield=<?= $keyfield ?>&key=<?= $key ?>" class="ifDiv"><?= $ou_subject ?></a>
                                        <?= $newImg ?>
                                </td>
                                <td class="memName" align="center"><?= $ou_name ?></td>
                                <td class="regNum" align="center"><?= $ou_signdate ?></td>
                                <td align="center"><?= $str ?></td>
                        </tr>
                        <?
                        $article_num--;
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
<form name="searchForm" method="post" action="boardList.php?code=<?= $code ?>">
        <ul class="memberBottom">
                <li>
                        <input type="button" class="memEleB" value="삭제" onclick="brandListDel(document.boardListForm)" />
                </li>
                <li>
                        <input type="button" class="memEleB" value="쓰기" onclick="location.href='boardWrite.php?code=<?= $code ?>'" />
                </li>
                <li>
                        <input type="submit" class="memEleB" value="검색" />
                </li>
                <li>
                        <input type="text" class="border2" name="key" size="10" />
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