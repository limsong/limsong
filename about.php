<?php
include_once("session.php");
include_once("doctype.php");
?>
    <body class="home-1 contact-page">
        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="box-container">
            <!--HEADER AREA START-->
            <? include_once("sub_head.php") ?>
            </section>
            <!--HEADER AREA END-->
            <!--CONTACT TOP AREA START-->
            <section class="contact-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="page-heading">
                                <h2><strong>찾아오시는길</strong></h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="contact-info-area">
                                <div class="contact-info">
                                    <p><span><strong>Contact info</strong></span></p>
                                    <p>phone:0(1234) 567 890</p>
                                    <p>Mail:Infor@roadthemes.com</p>
                                    <p>Address : No 40 Baria Sreet 133/2 NewYork City, NY, United States.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--CONTACT TOP AREA END-->
            <!--CONTACT BOTTOM AREA START-->
            <div class="contact-bottom-area">
                <div class="container-fluid">
                    <div class="row contact-wrapper">
                        <div class="col-sm-12 col-md-6">
                            <div class="contact-map">
                                <div id="googleMap" style="width:100%;height:460px;"></div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 no-padding-right">
                            <form class="contact-form" action="#">
                                <span class="con-name">
                                    <input type="text"  placeholder="name">
                                </span>
                                <span class="con-main">
                                    <input type="text" placeholder="Email">
                                </span>
                                <span class="con-subject">
                                    <input type="text" placeholder="Subject">
                                </span>
                                <span class="con-subject">
                                    <textarea rows="10" cols="60" name="comment" placeholder="Message" ></textarea>
                                </span>
                                <a class="button-link pull-right" href="#">Send mail</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--CONTACT BOTTOM AREA END-->
            <!--FOOTER AREA START-->
            <? include_once("footer.php") ?>
            <!--FOOTER AREA END-->
        </div>

        <!-- JS -->
        <? include_once("js.php") ?>
        <script src="https://maps.googleapis.com/maps/api/js"></script>
        <script>
            function initialize() {
                var mapOptions = {
                    zoom: 15,
                    scrollwheel: false,
                    center: new google.maps.LatLng(37.244667, 127.031750)
                };
                var map = new google.maps.Map(document.getElementById('googleMap'),
                    mapOptions);
                var marker = new google.maps.Marker({
                    position: map.getCenter(),
                    animation:google.maps.Animation.BOUNCE,
                    icon: 'img/map-marker.png',
                    map: map
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
    </body>
</html>
