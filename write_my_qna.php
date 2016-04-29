<?php
/**
 * Created by PhpStorm.
 * User: livingroom
 * Date: 16. 4. 28
 * Time: 오후 12:12
 */
include_once ("include/config.php");
include_once ("session.php");
include_once ("include/sqlcon.php");

$mod = $_POST["mod"];//qna_goods my_qna
$date = date("Y.m.d",time());
$ipinfo = get_real_ip();

$html = '<script src="js/tinymce/tinymce.min.js"></script>
    <div class="cart-area-wrapper table-responsive">
    <form name="cancelForm" class="cancelForm" action="bbsPost.php" method="post">
        <input type="hidden" name="mod" value="' . $mod . '">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="width:120px;border-left:0px;">문의 분류</td>
                    <td style="border-right:0px;text-align:left;">
                        <div class="checkout-form-list">
                            <div class="col-md-12">
                                <select name="cate_code" style="width:110px;">
                                    <option value="모델지원">모델지원</option>
                                    <option value="배송관련">배송관련</option>
                                    <option value="환불관련">환불관련</option>
                                    <option value="상품문의">상품문의</option>
                                </select>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">제목</td>
                    <td style="border-right:0px;text-align:left;">
                        <div class="checkout-form-list">
                            <div class="col-md-12">
                                <input type="text" name="bbs_title" class="bbs_title">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">작성일</td>
                    <td style="border-right:0px;text-align:left;">
                        '.$date.' <b>['.$ipinfo.']</b>
                    </td>
                </tr>
                <!--<tr>
                    <td style="border-left:0px;">주문정보</td>
                    <td style="border-right:0px;text-align:left;">
                        <button type="button" class="buynow btn btn-purple btn-xs waves-effect waves-light">검색</button>
                    </td>
                </tr>
                <tr>
                    <td style="border-left:0px;">상품정보</td>
                    <td style="border-right:0px;text-align:left;">
                        <button type="button" class="buynow btn btn-purple btn-xs waves-effect waves-light">검색</button>
                    </td>
                </tr>-->
                <tr>
                    <td style="border-left:0px;">문의내용</td>
                    <td style="border-right:0px;text-align:left;">
                        
                        <div class="checkout-form-list">
                            <div class="col-md-12">
                                <textarea id="elm1" name="comment"></textarea>
                            </div>
                        </div>
                    </td>
                </tr>
                <!--<tr>
                    <td style="border-left:0px;">첨부파일</td>
                    <td style="border-right:0px;text-align:left;">
                        <button type="button" class="buynow btn btn-purple btn-xs waves-effect waves-light my_qna">찾아보기</button>
                    </td>
                </tr>-->
            </tbody>
        </table>
    </form>
    ';
$html .= "
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
";
echo $html;
$db->disconnect();
?>