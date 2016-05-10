<?php
include_once("doctype.php");
?>
<body class="home-2 blog">
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
                                    <h3>* 공지사항</h3>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <?php
                                        $uid = $_GET["no"];
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
                                        <table class="table">
                                            <thead>
                                                <th>번호</th>
                                                <th>제목</th>
                                                <th>이름</th>
                                                <th>날짜</th>
                                                <th>조회</th>
                                            </thead>
                                            <tbody>
                                                <td>1</td>
                                                <td>테스트</td>
                                                <td>master</td>
                                                <td>2016.05.10</td>
                                                <td></td>
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
                                            <td><a href="notice.php?no=1">BACK</a> . <a href="notice.php?no=2">NEXT</a></td>
                                            <td style="text-align: right;"><a href="notice.php">글목록</a></td>
                                        </tr>
                                    </table>
                                    <?
                                    }else{
                                    ?>
                                    <div class="pagination">
                                        <a href="#" class="page-numbers current">1</a>
                                        <a href="#" class="page-numbers">2</a>
                                        <a href="#" class="next page-numbers">Next</a>
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