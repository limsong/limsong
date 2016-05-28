<?php
include_once ("session.php");
include_once("doctype.php");
@$uid = $_GET["no"];
@$page = $_GET['page'];
$key = "";
$keyfield = "";
if (!@$_POST['key']) {
    @$key = $_GET['key'];
} else {
    @$key = $_POST['key'];
}
if (!@$_POST['keyfield']) {
    @$keyfield = $_GET['keyfield'];
} else {
    @$keyfield = $_POST['keyfield'];
}
if (empty($page)) {
    $page = 1;
}
if (empty($key)) {
    $addQuery = "WHERE notify='q' ";
} else {
    $addQuery = " WHERE notify='q' AND $keyfield like '%$key%'";
}
$db->query("SELECT uid FROM tbl_notice $addQuery");
$db_tbl_notice_query = $db->loadRows();
$total_record = count($db_tbl_notice_query);
if ($total_record == 0) {
    $first = 1;
} else {
    $first = ($page - 1) * $bnum_per_page;
}
/*for($i=0;$i<1000;$i++){
    $db->query("insert into tbl_notice (name,subject,comment,notify,signdate) values ('master','테스트$i','테스트$i','n','2016-05-11 16:26:30')");
}*/
?>
<body class="home-2 blog">
    <style type="text/css">
        .notice-list th {
            background-color: #E26A6A;
            color: #fff;
        }
    </style>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an
        <strong>outdated</strong>
        browser. Please
        <a href="http://browsehappy.com/">upgrade your browser</a>
        to improve your experience.
    </p><![endif]-->
    <? include_once("head.php") ?>
    <section class="category-area-one control-car mar-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="cat-area-heading">
                    <h4>
                        <strong>N</strong>otice
                    </h4>
                </div>
                <? include_once "bbs_side.php"; ?>
                <div class="col-md-9 col-lg-10 no-padding">
                    <section class="cart-area-wrapper">
                        <div class="container-fluid">
                            <div class="row cart-top">
                                <div class="col-md-12">
                                    <h3>* FAQ</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <?php
                                        if($uid !=""){
                                            $db->query("SELECT * FROM tbl_notice WHERE uid='$uid'");
                                            $db_tbl_notice_query = $db->loadRows();
                                            $name = $db_tbl_notice_query[0]["name"];
                                            $subject = $db_tbl_notice_query[0]["subject"];
                                            $signdate = date("Y.m.d",strtotime($db_tbl_notice_query[0]["signdate"]));
                                            $comment = $db_tbl_notice_query[0]["comment"];
                                            ?>
                                            <table class="table">
                                                <tr>
                                                    <td><span style="width:40px;font-weight: bold;float:left;">작성자</span> | <?=$name?> ( <?=$signdate?> )</td>
                                                </tr>
                                                <tr>
                                                    <td><span style="width:40px;font-weight: bold;float: left;">제목</span> | <?=$subject?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <?=$comment?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?
                                        }else{
                                            ?>
                                            <table class="table notice-list">
                                                <colgroup>
                                                    <col width="50">
                                                    <col width="*">
                                                    <col width="150">
                                                    <col width="150">
                                                    <col width="50">
                                                </colgroup>
                                                <thead>
                                                    <th>번호</th>
                                                    <th>제목</th>
                                                    <th>이름</th>
                                                    <th>날짜</th>
                                                    <th>조회</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $db->query("SELECT * FROM tbl_notice $addQuery ORDER BY uid DESC LIMIT $first,$gnum_per_page");
                                                    $db_tbl_notice_query = $db->loadRows();
                                                    $count = count($db_tbl_notice_query);
                                                    for($i=0;$i<$count;$i++){
                                                        $signdate = date("Y.m.d",strtotime($db_tbl_notice_query[$i]["signdate"]));
                                                        ?>
                                                        <tr>
                                                            <td align="center"><?=$db_tbl_notice_query[$i]["uid"]?></td>
                                                            <td><a href="faq.php?no=<?=$db_tbl_notice_query[$i]["uid"]?>"><?=$db_tbl_notice_query[$i]["subject"]?></a></td>
                                                            <td><?=$db_tbl_notice_query[$i]["name"]?></td>
                                                            <td><?=$signdate?></td>
                                                            <td align="center"><?=$db_tbl_notice_query[$i]["ref"]?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                            <?
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <?
                                    if($uid!=""){
                                        ?>
                                        <table class="table">
                                            <tr>
                                                <?
                                                if($uid>1){
                                                    $back = $uid-1;
                                                }else{
                                                    $uid = 1;
                                                }
                                                ?>
                                                <td></td>
                                                <td style="text-align: right;"><a href="faq.php">글목록</a></td>
                                            </tr>
                                        </table>
                                        <?
                                    }else{
                                        ?>
                                        <div class="pagination">
                                            <?php
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
                                            <?
                                            if($page>1) {
                                                $bfPage=$page-1;   //이전페이지
                                                echo '<a href="faq.php?key='.$key.'&keyfield='.$keyfield.'&page='.$bfPage.'" class="next page-numbers">Prive</a>';
                                            }
                                            for($my_page=$first_page;$my_page<=$last_page;$my_page++) {                 //현재 페이지
                                                if($page==$my_page) {
                                                    echo '<a href="#" class="page-numbers current">'.$my_page.'</a>';
                                                } else {
                                                    echo '<a href="faq.php?key='.$key.'&keyfield='.$keyfield.'&page='.$my_page.'" class="page-numbers">'.$my_page.'</a>';
                                                }
                                            }
                                            if($page<$total_page) {
                                                $nxPage=$page+1;  //다음 페이지
                                                echo '<a href="faq.php?key='.$key.'&keyfield='.$keyfield.'&page='.$nxPage.'" class="next page-numbers">Next</a>';
                                            }
                                            ?>
                                        </div>
                                        <?
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!--FOOTER AREA START-->
    <?php include_once("footer.php") ?>
    <!--FOOTER AREA END-->
    <!-- JS -->
    <? include_once("js.php") ?>
</body>
</html>