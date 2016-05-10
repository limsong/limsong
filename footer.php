<section class="footer-area">
    <!--<img class="add" src="img/ads.jpg" alt="">-->
    <div class="container-fluid">
        <div class="row">
            <div class="footer-top">
                <div class="col-sm-6 col-md-2 border-right">
                    <div class="single-footer">
                        <h3 class="footer-top-heading">notice</h3>
                        <div class="footer-list">
                            <ul>
                                <?php
                                $db->query("SELECT * FROM tbl_notice ORDER BY uid ASC LIMIT 0,7");
                                $db_tbl_notice_query = $db->loadRows();
                                $count = count($db_tbl_notice_query);
                                for($i=0;$i<$count;$i++) {
                                    $uid = $db_tbl_notice_query[$i]["uid"];
                                ?>
                                <li class="footer-list-item">
                                    <a href="notice.php?no=<?=$uid?>" style="display: block;width:100%;text-overflow : ellipsis;overflow: hidden;white-space: nowrap;"><?=$db_tbl_notice_query[$i]["subject"]?></a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>							
                    </div>
                </div>
                <div class="col-sm-6 col-md-2 border-right">
                    <div class="single-footer">
                        <h3 class="footer-top-heading">Information</h3>
                        <div class="footer-list">
                            <ul>
                                <li class="footer-list-item"><a href="private.php">개인정보보호정책</a></li>
                                <li class="footer-list-item" ><a href="agreement.php">이용약관</a></li>
                                <li class="footer-list-item"><a href="about.php">찾아오는길</a></li>
                            </ul>
                        </div>							
                    </div>
                </div>
                <div class="col-sm-6 col-md-2 border-right ">
                    <div class="single-footer">
                        <h3 class="footer-top-heading">service center</h3>
                        <div class="footer-list">
                            <ul>
                                <li class="footer-list-item"><a href="memtomem.php">자주하는질문</a></li>
                                <li class="footer-list-item" ><a href="qna.php">질문과 답변</a></li>
                            </ul>
                        </div>							
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 border-right">
                    <div class="contact-us">
                        <ul>
                            <li><i class="fa fa-phone"></i>PHONE: (012) 345 6789</li>
                            <li><i class="fa fa-truck"></i>FREE SHIPPING ANYWHERE WORLDWIDE</li>
                            <li><i class="fa fa-unlock-alt"></i>100% SECURE FOR PAYMENT</li>
                            <li><i class="fa fa-headphones"></i>24/24 ONLINE SUPPORT CUSTOME</li>
                        </ul>						
                    </div>   
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="news-letter">
                        <h3 class="footer-top-heading">send newsletter</h3>
                        <div class="newsletter-wrapper">
                            <div class="subscribe-inner">
                                <input type="text" id="subscribe_email">
                                <a class="sub-button" href="">subscribe</a>
                            </div>
                        </div> 
                        <div class="payment">
                            <img src="img/payment.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-6">
                    <div class="logo-footer" style="margin-top:15px;">
                        <a href="index.php" style="font-size:20px;">NEWNS</a>
                    </div>
                    <div class="footer-copyright ">
                        Copyright &copy; 2015 <a href="http://admin@bootexperts.com/">BootExperts</a>. All rights reserved
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
                    <div class="social-icon-footer">
                        <ul class="social-icons">
                            <li><a data-toggle="tooltip" data-placement="top" title="Facebook" href="#" ><i class="fa fa-facebook"></i></a></li>
                            <li><a data-toggle="tooltip" title="Twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a data-toggle="tooltip" title="Pinterest" href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a data-toggle="tooltip" title="Google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>                                                   <li><a data-toggle="tooltip" title="Dribbble" href=""><i class="fa fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<? $db->disconnect(); ?>