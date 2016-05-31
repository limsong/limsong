<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 28
 * Time: 오후 12:12
 */
include_once ("session.php");
include_once ("include/check.php");
include_once("include/config.php");
include_once("include/sqlcon.php");

$tdata = $_POST["tdata"];//qna onetoone
$goods_seq = $_POST["goods_seq"];
$buy_goods_seq = $_POST["buy_goods_seq"];
$mod = $_POST["mod"];//buy_goods  buy_option
$db->query("SELECT goods_name,goods_code FROM goods WHERE id='$goods_seq'");
$db_goods = $db->loadRows();
$goods_name = $db_goods[0]["goods_name"];
$goods_code = $db_goods[0]["goods_code"];
$db->query("SELECT ImageName FROM upload_timages WHERE goods_code='$goods_code'");
$db_upload_timages = $db->loadRows();
$tImageName = $db_upload_timages[0]["ImageName"];
//<script src="js/tinymce/tinymce.min.js"></script>
if ($tdata != "goods_review") {
        $html = '
    <div class="cart-area-wrapper table-responsive">
    <form name="cancelForm" class="cancelForm" action="bbsPost.php" method="post">
        <input type="hidden" name="mod" value="' . $mod . '">
        <input type="hidden" name="tdata" value="' . $tdata . '">
        <input type="hidden" name="goods_seq" value="' . $goods_seq . '">
        <input type="hidden" name="buy_goods_seq" value="' . $buy_goods_seq . '">
        <input type="hidden" name="goods_code" value="' . $goods_code . '">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="border-left:0px;">글제목</td>
                    <td style="border-right:0px;text-align:left;">
                        <div class="checkout-form-list">
                            <div class="col-md-12">
                                <input type="text" name="bbs_title" class="bbs_title">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">상품정보</td>
                    <td style="border-right:0px;text-align:left;">
                        <a href="item_view.php?code=' . $goods_code . '" target="_blank">
                            <img src="userFiles/images/brandImages/' . $tImageName . '" width="50" height="50">
                            ' . $goods_name . '
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">글내용</td>
                    <td style="border-right:0px;text-align:left;">
                        
                        <div class="checkout-form-list">
                            <div class="col-md-12">
                                <textarea id="elm1" name="comment"></textarea>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">선택사항</td>
                    <td style="border-right:0px;text-align:left;">
                        <input type="checkbox" value="1" name="bbs_secret"><lable>비공개</lable>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>';
/*        $html .= "
<script>
        tinymce.init({
            selector: \"textarea#elm1\",
            language : \"ko_KR\",
            theme: \"modern\",
            menubar: false, 
            height:300,
            plugins: [
                \"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker\",
                \"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking\",
                \"save table contextmenu directionality emoticons template paste textcolor\"
            ],
            toolbar: \"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview\",
            style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                {title: 'Example 1', inline: 'span', classes: 'example1'},
                {title: 'Example 2', inline: 'span', classes: 'example2'},
                {title: 'Table styles'},
                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
            ]
    });
    </script>
";*/
} else {
        $html = '
    <div class="cart-area-wrapper table-responsive">
    <form name="cancelForm" class="cancelForm" action="bbsreviewPost.php" method="post">
        <input type="hidden" name="mod" value="' . $mod . '">
        <input type="hidden" name="tdata" value="' . $tdata . '">
        <input type="hidden" name="goods_seq" value="' . $goods_seq . '">
        <input type="hidden" name="buy_goods_seq" value="' . $buy_goods_seq . '">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="border-left:0px;">상품정보</td>
                    <td style="border-right:0px;text-align:left;">
                        <a href="item_view.php?code=' . $goods_code . '" target="_blank">
                            <img src="userFiles/images/brandImages/' . $tImageName . '" width="50" height="50">
                            ' . $goods_name . '
                        </a>
                    </td>
                </tr>
                <tr>
                        <td style="border-left:0px;">평점</td>
                        <td style="border-right:0px;text-align:left;">
                                <fieldset class="rating" style="float:left;">
                                  <input type="radio" id="star5" name="rating" value="5">
                                  <label for="star5" title="Rocks!"></label>
                                  <input type="radio" id="star4" name="rating" value="4">
                                  <label for="star4" title="Pretty good"></label>
                                  <input type="radio" id="star3" name="rating" value="3">
                                  <label for="star3" title="Meh"></label>
                                  <input type="radio" id="star2" name="rating" value="2">
                                  <label for="star2" title="Kinda bad"></label>
                                  <input type="radio" id="star1" name="rating" value="1">
                                  <label for="star1" title="Sucks big time"></label>
                            </fieldset>
                        </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">리뷰어</td>
                    <td style="border-right:0px;text-align:left;">
                        <div class="checkout-form-list">
                            <div class="col-md-12">
                                <textarea aria-required="true" name="comment" class="comment"></textarea>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>';
}
echo $html;
$db->disconnect();
?>