<?
include("common/config.shop.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>디자인 관리</title>
                <link rel="stylesheet" type="text/css" href="css/common1.css" />
                <link rel="stylesheet" type="text/css" href="css/layout.css" />
                <link rel="stylesheet" type="text/css" href="css/goodsSortManageBrand.css" />
                <link rel="stylesheet" type="text/css" href="css/brandRead.css" />
                <link rel="stylesheet" type="text/css" href="css/mask.css" />
        </head>
        <body>
                <div id="total">
                        <? include("include/include.header.php"); ?>
                        <div id="main" style="width:100%;">
                                <div id="loading-mask" style="background-color: #191919;"></div>
                                <div id="loading" style="top:65%;">
                                        <img src="img/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/>
                                </div>
                                <h4 id="mainTitle">디자인 관리</h4>
                                <form name="bannerForm" id="bannerForm" method="post" target="action_frame"  enctype="multipart/form-data">
                                        <dl class="readContent dltimg">
                                                <dt style="background-color:#3a5795;color:white;">배너</dt>
                                                <dd class="inputDd" style="background-color: #3a5795;padding-left:9px;height:17px;padding-top:4px;color:white;">asdfsad</dd>
                                        </dl>
                                        <?
                                        $id1=array();
                                        $id2=array();
                                        $id3=array();
                                        $id4=array();
                                        $imgName1=array();
                                        $imgName2=array();
                                        $imgName3=array();
                                        $imgName4=array();
                                        $link1=array();
                                        $link2=array();
                                        $link3=array();
                                        $link4=array();
                                        $query = "SELECT id,imgName,link,type FROM banner order by id asc";
                                        $result = mysql_query($query) or die($query);
                                        while($rows=mysql_fetch_array($result)) {
                                                $type = $rows["type"];
                                                $id=$rows["id"];
                                                $imgName = $rows["imgName"];
                                                $link = $rows["link"];
                                                if($type=="banner1"){
                                                        array_push($id1,$id);
                                                        array_push($imgName1,$imgName);
                                                        array_push($link1,$link);
                                                }
                                                if($type=="banner2"){
                                                        array_push($id2,$id);
                                                        array_push($imgName2,$imgName);
                                                        array_push($link2,$link);
                                                }
                                                if($type=="banner3"){
                                                        array_push($id3,$id);
                                                        array_push($imgName3,$imgName);
                                                        array_push($link3,$link);
                                                }
                                                if($type=="banner4"){
                                                        array_push($id4,$id);
                                                        array_push($imgName4,$imgName);
                                                        array_push($link4,$link);
                                                }
                                        }
                                        ?>
                                        <?
                                        if(count($id1)>0){
                                                ?>
                                                <dl class="readContent banner1">
                                                        <dt>배너1</dt>
                                                        <dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner1" /></a><span style="margin-top:3px;float:left;color:#3a5795;">( 1920x820 ) * 개수제한 무</span></dd>
                                                        <?
                                                        for($i=0;$i<count($id1);$i++){
                                                                $imgwh=@getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$imgName1[$i]);
                                                                $img_width=$imgwh[0];
                                                                $img_height=$imgwh[1];
                                                                $img_src=$brandImagesWebDir.$imgName1[$i];
                                                                ?>
                                                                <dt style="background-color:white;"></dt>
                                                                <dd class="inputDd">
                                                                        <?
                                                                        echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="'.$imgName1[$i].'" /><span><input type="file" name="type[]" class="inputItem fileHeight" /></span>';
                                                                        ?>
                                                                        <input type="button" value="취소" class="fileClear memEleB" />
                                                                        <input type="button" value="이미지보기" imgwid="<?=$img_width?>" imghei="<?=$img_height?>"  imgsrc="<?=$img_src?>" class="memEleB" onmouseover="addEvent(this,'click',showBrandImage)"/>
                                                                        <input type="hidden" name="timg_id[]" value="<?=$img_id?>" />
                                                                </dd>
                                                                <dt style="background-color:white;text-align: right;"> </dt>
                                                                <dd><input type="text" name="link[]" class="fileHeight" style="padding-left:37px;" /></dd>
                                                                <?
                                                        }
                                                        ?>
                                                </dl>
                                                <?
                                        }else{
                                                ?>
                                                <dl class="readContent banner1">
                                                        <dt>배너1</dt>
                                                        <dd class="inputDd">
                                                                <a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner1" /></a>
                                                                <span style="margin-top:3px;float:left;color:#3a5795;">( 1920x820 ) * 개수제한 무</span>
                                                        </dd>
                                                        <dt style="background-color:white;"></dt>
                                                        <dd class="inputDd">
                                                                <span><input style="margin-left:37px;" type="file" name="banner1[]" id="img1" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" />
                                                        </dd>
                                                </dl>
                                                <?
                                        }
                                        ?>
                                        <?
                                        if(count($id2)>0){
                                                ?>
                                                <dl class="readContent banner2">
                                                        <dt>배너2</dt>
                                                        <dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner2" /></a><span style="margin-top:3px;float:left;color:#3a5795;">( 620x396 ) *개수제한3개</span></dd>
                                                        <?
                                                        for($i=0;$i<count($id2);$i++){
                                                                $imgwh=@getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$imgName2[$i]);
                                                                $img_width=$imgwh[0];
                                                                $img_height=$imgwh[1];
                                                                $img_src=$brandImagesWebDir.$imgName2[$i];
                                                                ?>
                                                                <dt style="background-color:white;"></dt>
                                                                <dd class="inputDd">
                                                                        <?
                                                                        echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="'.$imgName2[$i].'" /><span><input type="file" name="type[]" class="inputItem fileHeight" /></span>';
                                                                        ?>
                                                                        <input type="button" value="취소" class="fileClear memEleB" />
                                                                        <input type="button" value="이미지보기" imgwid="<?=$img_width?>" imghei="<?=$img_height?>"  imgsrc="<?=$img_src?>" class="memEleB" onmouseover="addEvent(this,'click',showBrandImage)"/>
                                                                        <input type="hidden" name="timg_id[]" value="<?=$img_id?>" />
                                                                </dd>
                                                                <dt style="background-color:white;text-align: right;"> </dt>
                                                                <dd><input type="text" name="link[]" class="fileHeight" style="padding-left:37px;" /></dd>
                                                                <?
                                                        }
                                                        ?>
                                                </dl>
                                                <?
                                        }else{
                                                ?>
                                                <dl class="readContent banner2">
                                                        <dt>배너2</dt>
                                                        <dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner2" /></a><span style="margin-top:3px;float:left;color:#3a5795;">( 620x396 ) *개수제한3개</span></dd>
                                                        <dt style="background-color:white;"></dt>
                                                        <dd class="inputDd">
                                                                <span><input style="margin-left:37px;" type="file" name="banner2[]" id="img2" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" />
                                                        </dd>
                                                </dl>
                                                <?
                                        }
                                        ?>
                                        <?
                                        if(count($id3)>0){
                                                ?>
                                                <dl class="readContent banner3">
                                                        <dt>배너3</dt>
                                                        <dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner3" /></a><span style="margin-top:3px;float:left;color:#3a5795;">(620x396 - 620x396 - 620x812 - 620x396 - 620x396 ) *개수제한5개</span></dd>
                                                        <?
                                                        for($i=0;$i<count($id3);$i++){
                                                                $imgwh=@getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$imgName3[$i]);
                                                                $img_width=$imgwh[0];
                                                                $img_height=$imgwh[1];
                                                                $img_src=$brandImagesWebDir.$imgName3[$i];
                                                                ?>
                                                                <dt style="background-color:white;"></dt>
                                                                <dd class="inputDd">
                                                                        <?
                                                                        echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="'.$imgName3[$i].'" /><span><input type="file" name="type[]" class="inputItem fileHeight" /></span>';
                                                                        ?>
                                                                        <input type="button" value="취소" class="fileClear memEleB" />
                                                                        <input type="button" value="이미지보기" imgwid="<?=$img_width?>" imghei="<?=$img_height?>"  imgsrc="<?=$img_src?>" class="memEleB" onmouseover="addEvent(this,'click',showBrandImage)"/>
                                                                        <input type="hidden" name="timg_id[]" value="<?=$img_id?>" />
                                                                </dd>
                                                                <dt style="background-color:white;text-align: right;"> </dt>
                                                                <dd><input type="text" name="link[]" class="fileHeight" style="padding-left:37px;" /></dd>
                                                                <?
                                                        }
                                                        ?>
                                                </dl>
                                                <?
                                        }else{
                                                ?>
                                                <dl class="readContent banner3">
                                                        <dt>배너3</dt>
                                                        <dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner3" /></a><span style="margin-top:3px;float:left;color:#3a5795;">(620x396 - 620x396 - 620x812 - 620x396 - 620x396 ) *개수제한5개</span></dd>
                                                        <dt style="background-color:white;"></dt>
                                                        <dd class="inputDd">
                                                                <span><input style="margin-left:37px;" type="file" name="banner3[]" id="img3" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" />
                                                        </dd>
                                                </dl>
                                                <?
                                        }
                                        ?>
                                        <?
                                        if(count($id4)>0){
                                                ?>
                                                <dl class="readContent banner4">
                                                        <dt>배너4</dt>
                                                        <dd class="inputDd"><a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner4" /></a><span style="margin-top:3px;float:left;color:#3a5795;">( 380x447 ) *개수제한5개</span></dd>
                                                        <?
                                                        for($i=0;$i<count($id4);$i++){
                                                                $imgwh=@getimagesize("http://sozo.bestvpn.net/userFiles/images/brandImages/".$imgName4[$i]);
                                                                $img_width=$imgwh[0];
                                                                $img_height=$imgwh[1];
                                                                $img_src=$brandImagesWebDir.$imgName4[$i];
                                                                ?>
                                                                <dt style="background-color:white;"></dt>
                                                                <dd class="inputDd">
                                                                        <?
                                                                        echo '<img src="images/i_del.gif" class="remove_project_file" data="dlt" data_id="'.$imgName4[$i].'" /><span><input type="file" name="type[]" class="inputItem fileHeight" /></span>';
                                                                        ?>
                                                                        <input type="button" value="취소" class="fileClear memEleB" />
                                                                        <input type="button" value="이미지보기" imgwid="<?=$img_width?>" imghei="<?=$img_height?>"  imgsrc="<?=$img_src?>" class="memEleB" onmouseover="addEvent(this,'click',showBrandImage)"/>
                                                                        <input type="hidden" name="timg_id[]" value="<?=$img_id?>" />
                                                                </dd>
                                                                <dt style="background-color:white;text-align: right;"> </dt>
                                                                <dd><input type="text" name="link[]" class="fileHeight" style="padding-left:37px;" /></dd>
                                                                <?
                                                        }
                                                        ?>
                                                </dl>
                                                <?
                                        }else{
                                                ?>
                                                <dl class="readContent banner4">
                                                        <dt>배너4</dt>
                                                        <dd class="inputDd">
                                                                <a href="#" style="float:left;padding-top:2px;padding-right:3px;"><img src="images/i_add.gif" class="addimg" data="banner4" /></a>
                                                                <span style="margin-top:3px;float:left;color:#3a5795;">( 380x447 ) *개수제한5개</span>
                                                        </dd>
                                                        <dt style="background-color:white;"></dt>
                                                        <dd class="inputDd">
                                                                <span><input style="margin-left:37px;" type="file" name="banner4[]" id="img4" class="inputItem fileHeight" /></span><input type="button" value="취소" class="fileClear memEleB" />
                                                        </dd>
                                                </dl>
                                                <?
                                        }
                                        ?>

                                        <div class="buttonBox">
                                                <input type="button" value=" 추가 " class="memEleB add" />
                                                <input type="button" value=" 수정 " class="memEleB edit" />
                                                <input type="button" value=" 목록 " class="memEleB" onclick="location.href='brandList.php?key=<?=$key?>&xcode=<?=$xcode?>&mcode=<?=$mcode?>&scode=<?=$scode?>&keyfield=<?=$keyfield?>'" />
                                        </div>
                                </form>
                                <iframe name="action_frame" width="99%" height="200" style="display:none;"></iframe>
                        </div>
                </div>
                <div id="light" class="white_content" onclick="closeBox()">asdadsa</div>
                <div id="fade" class="black_overlay"></div>
                <script type="text/javascript" src="assets/plugins/jquery-1.10.2.min.js"></script>
                <script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
                <script type="text/javascript" src="common/jslb_ajax.js"></script>
                <script type="text/javascript" src="common/brandWrite.js"></script>
                <script type="text/javascript">
                        $(document).ready(function(){
                                $(".add").click(function(){
                                        $("#bannerForm").attr("action","designPost.php");
                                        $("#bannerForm").submit();
                                });
                                $(".edit").click(function(){
                                        $("#bannerForm").attr("action","designchPost.php");
                                        $("#bannerForm").submit();
                                });
                                jQuery.fn.center = function () {
                                        this.css("position","absolute");
                                        this.css("top", Math.max(0, (($(window).height() - $(this).outerHeight()) / 2) + $(window).scrollTop()) + "px");
                                        this.css("left", Math.max(0, (($(window).width() - $(this).outerWidth()) / 2) + $(window).scrollLeft()) + "px");
                                        return this;
                                }
                                $(".fileClear").click(function() {
                                        var file = $(this).prev();
                                        file.after(file.clone().val(""));
                                        file.remove();
                                });
                                // Add new input with associated 'remove' link when 'add' button is clicked.
                                $('.addimg').click(function(e) {
                                        e.preventDefault();
                                        var cls = $(this).attr("data");
                                        $("."+cls).append(
                                                '<dt style="background-color:white;"></dt>'
                                                + '<dd class="inputDd">'
                                                + '<img src="images/i_del.gif" class="remove_project_file img" data="dlt" />'
                                                + '<input type="file" name="'+cls+'[]" class="inputItem fileHeight" />'
                                                + '<input type="text" name="'+cls+'link[]" class="inputItem fileHeight" />'
                                                + '</dd>'
                                                +'<dt style="background-color:white;text-align: right;"> </dt>'
                                                + '<dd class="inputDd">'
                                                + '<input type="text" name="'+cls+'link[]" class="fileHeight" style="padding-left:34px;" />'
                                                + '</dd>'
                                        );
                                });

                                // Remove parent of 'remove' link when link is clicked.
                                $('.banner1').on('click', '.remove_project_file', function(e) {
                                        var imgName = $(this).attr("data_id");
                                        if(imgName != undefined){
                                                $.ajax({
                                                        url: 'banner_del.php',
                                                        type: 'POST',
                                                        dataType    :   "JSON",
                                                        data: {
                                                                imgname: bimgName,
                                                                imgtype: "img"
                                                        },
                                                        success :   function(response){
                                                                if(response.status=="success"){
                                                                        alert("이미지를 삭제 하였습니다.");
                                                                        e.preventDefault();
                                                                        $(this).parent().prev().remove();
                                                                        $(this).parent().remove();
                                                                }
                                                        }
                                                });
                                        }else{
                                                e.preventDefault();
                                                $(this).parent().prev().remove();
                                                $(this).parent().remove();
                                        }
                                });
                                $('.banner2').on('click', '.remove_project_file', function(e) {
                                        var imgName = $(this).attr("data_id");
                                        if(imgName != undefined){
                                                $.ajax({
                                                        url: 'banner_del.php',
                                                        type: 'POST',
                                                        dataType    :   "JSON",
                                                        data: {
                                                                imgname: bimgName,
                                                                imgtype: "img"
                                                        },
                                                        success :   function(response){
                                                                if(response.status=="success"){
                                                                        alert("이미지를 삭제 하였습니다.");
                                                                        e.preventDefault();
                                                                        $(this).parent().prev().remove();
                                                                        $(this).parent().remove();
                                                                }
                                                        }
                                                });
                                        }else{
                                                e.preventDefault();
                                                $(this).parent().prev().remove();
                                                $(this).parent().remove();
                                        }
                                });
                                $('.banner3').on('click', '.remove_project_file', function(e) {
                                        var imgName = $(this).attr("data_id");
                                        if(imgName != undefined){
                                                $.ajax({
                                                        url: 'banner_del.php',
                                                        type: 'POST',
                                                        dataType    :   "JSON",
                                                        data: {
                                                                imgname: bimgName,
                                                                imgtype: "img"
                                                        },
                                                        success :   function(response){
                                                                if(response.status=="success"){
                                                                        alert("이미지를 삭제 하였습니다.");
                                                                        e.preventDefault();
                                                                        $(this).parent().prev().remove();
                                                                        $(this).parent().remove();
                                                                }
                                                        }
                                                });
                                        }else{
                                                e.preventDefault();
                                                $(this).parent().prev().remove();
                                                $(this).parent().remove();
                                        }
                                });
                                $('.banner4').on('click', '.remove_project_file', function(e) {
                                        var imgName = $(this).attr("data_id");
                                        if(imgName != undefined){
                                                $.ajax({
                                                        url: 'banner_del.php',
                                                        type: 'POST',
                                                        dataType    :   "JSON",
                                                        data: {
                                                                imgname: bimgName,
                                                                imgtype: "img"
                                                        },
                                                        success :   function(response){
                                                                if(response.status=="success"){
                                                                        alert("이미지를 삭제 하였습니다.");
                                                                        e.preventDefault();
                                                                        $(this).parent().prev().remove();
                                                                        $(this).parent().remove();
                                                                }
                                                        }
                                                });
                                        }else{
                                                e.preventDefault();
                                                $(this).parent().prev().remove();
                                                $(this).parent().remove();
                                        }
                                });
                        });
                </script>
        </body>
</html>
