<?
include("common/config.shop.php");
include("check.php");
$value = "*.jpeg;*.jpg;*.png;*.gif;*.bmp";
$value2 = ".JPEG, .JPG, .PNG, .GIF, .BMP";
/*
TRUNCATE TABLE `upload_simages`;
TRUNCATE TABLE `upload_mimages`;
TRUNCATE TABLE `upload_bimages`;
TRUNCATE TABLE `upload_timages`;
TRUNCATE TABLE `optionName`;
TRUNCATE TABLE `opName`;
TRUNCATE TABLE `goods`;
TRUNCATE TABLE `goods_option`;
*/
$debug = true;
//0 옵션 없음 1일반옵션 2 가격선택 옵션
$goods_option_type = 2;
$optNum = "3";
if ($debug == true) {
    $goods_name = "옵션없음";
    if ($goods_option_type == 0) {
        $commonPrice = "200000";
        $sellPrice = "180000";
        $qta = "200";
    } elseif ($goods_option_type == 1) {
        $goods_name = "일반옵션";
        $goods_opName1 = "상품명/상품명2";
        $goods_opName2 = "아디다스;나이키;리북;뉴발란스/아디다스2;나이키2;리북2;뉴발란스";
        $commonPrice = "200000;210000;220000;230000/240000;250000;260000;270000";
        $sellPrice = "180000;190000;200000;210000/220000;230000;240000;250000";
        $qta = "210;220;230;240/250;260;270;280";
    } else {

        if ($optNum == "2") {
            $goods_name = "가격선택옵션2";
            $goods_opName1 = "상품명/색상";
            $goods_opName2 = "아디다스;나이키/블루;블랙";
            $commonPrice = "200000;210000;220000;230000";
            $sellPrice = "180000;190000;200000;210000";
            $qta = "200;210;220;230";
        } else {
            $goods_name = "가격선택옵션3";
            $goods_opName1 = "상품명/색상/싸이즈";
            $goods_opName2 = "아디다스;나이키/블루;블랙/255;265";
            $commonPrice = "200000;210000;220000;230000;240000;250000;260000;270000";
            $sellPrice = "180000;190000;200000;210000;220000;230000;240000;250000";
            $qta = "200;210;220;230;240;250;260;270";
        }

    }
    $optionName1 = "aaaaaaa/bbbbbbb/cccccc/dddddd/eeeeeee/fffffff/ggggggg/hhhhhhhh";
    $optionName2 = "aaaaa1;aaaaa2/bbbbbb1;bbbbbb2/ccccc1;ccccc2/dddd1;ddddd2/eeeeee1;eeeeee2/fffff1;fffff2/ggggg1;ggggg2/hhhhh1;hhhhh2";
    $optionValue1 = "1111;1111/222;222/333;3333/4444;4444/5555;5555/66666;66666/77777;777777/88888;88888";
    $optionValue2 = "1111;1111/222;222/333;3333/4444;4444/5555;5555/66666;66666/77777;777777/88888;88888";
    $optionQt = "1111;1111/222;222/333;3333/4444;4444/5555;5555/66666;66666/77777;777777/88888;88888";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>admin</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css"/>
        <link rel="stylesheet" type="text/css" href="css/layout.css"/>
        <link rel="stylesheet" type="text/css" href="css/goodsSortManageBrand.css"/>
        <link rel="stylesheet" type="text/css" href="css/brandWrite.css"/>
        <link rel="stylesheet" type="text/css" href="css/mask.css"/>
        <!--
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="ckfinder/ckfinder.js"></script>
        -->
    </head>
    <body>
        <div id="total">
            <? include("include/include.header.php"); ?>
            <div id="main" style="width: 100%;">
                <div id="loading-mask" style="background-color: #191919;"></div>
                <div id="loading" style="top:80%;">
                    <img src="img/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/>
                </div>
                <h4 id="mainTitle">상품 정보 입력</h4>
                <ul class="sortBigBox" id="sortBox">
                    <li class="depth1">
                        <h5 class="sortTitle">대분류</h5>
                        <ul class="sortMidBox" id="xSortList"></ul>
                    </li>
                    <li class="depth1">
                        <h5 class="sortTitle">중분류</h5>
                        <ul class="sortMidBox" id="mSortList"></ul>
                    </li>
                    <li class="depth1">
                        <h5 class="sortTitle">소분류</h5>
                        <ul class="sortMidBox" id="sSortList"></ul>
                    </li>
                </ul>
                <ul class="sortBigBox hiddenBox">
                    <li class="depth1">
                        <form name="xForm" id="xForm">
                            <input type="hidden" name="sortCode"/>
                            <input type="hidden" name="uxCode" value="00"/>
                            <input type="hidden" name="umCode" value="00"/>
                            <input type="hidden" name="liId" value=""/>
                        </form>
                    </li>
                    <li class="depth1">
                        <form name="mForm" id="mForm">
                            <input type="hidden" name="sortCode"/>
                            <input type="hidden" name="mode"/>
                            <input type="hidden" name="uxCode" value=""/>
                            <input type="hidden" name="umCode" value="00"/>
                            <input type="hidden" name="liId" value=""/>
                        </form>
                    </li>
                    <li class="depth1">
                        <form name="sForm" id="sForm">
                            <input type="hidden" name="sortCode"/>
                            <input type="hidden" name="mode"/>
                            <input type="hidden" name="uxCode" value=""/>
                            <input type="hidden" name="umCode" value=""/>
                            <input type="hidden" name="liId" value=""/>
                        </form>
                    </li>
                </ul>
                <!-- onsubmit="return checkBrandForm(this)" -->
                <form name="brandForm" id="brandForm" method="post" action="brandPost.php" target="action_frame"
                      onsubmit="return checkBrandForm(this)" enctype="multipart/form-data">
                    <input type="hidden" name="xcode" id="xcode"/>
                    <input type="hidden" name="mcode"/>
                    <input type="hidden" name="scode"/>
                    <input type="hidden" name="optNum" value="<?= $optNum ?>"/>
                    <dl id="readContent" class="readContent">
                        <dt style="background-color:#3a5795;color:white;">분류</dt>
                        <dd class="inputDd" style="background-color: #3a5795;padding-left:9px;height:17px;color:white;"></dd>
                        <dt>상품구분 <span class="fontCol">*</span></dt>
                        <dd>
                            <select name="goods_type">
                                <option value="0">일반상품</option>
                                <!--<option value="1">기획전</option>
                                <option value="2">공동구매</option>
                                <option value="3">경매</option>-->
                                <option value="4">구매대행</option>
                            </select>
                        </dd>
                        <dt>옵션타입
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <label>
                                <input type="radio" value="0" name="option_type" checked="checked">
                                옵션없음
                            </label>
                            <label>
                                <input type="radio" value="1" name="option_type">
                                일반옵션
                            </label>
                            <label>
                                <input type="radio" value="2" name="option_type">
                                가격선택옵션
                            </label>
                        </dd>
                        <dt>상품명
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" value="<?= @$goods_name ?>" name="goods_name" id="goods_name" class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt class="option_name">옵션명1
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd option_name">
                            <input type="text" value="<?= @$goods_opName1 ?>" name="opName1" id="opName1" class="inputItem goods_option_inp" style="width:100%;"/>
                        </dd>
                        <dt class="option_name">옵션명2
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd option_name">
                            <input type="text" value="<?= @$goods_opName2 ?>" name="opName2" id="opName2" class="inputItem goods_option_inp" style="width:100%;"/>
                        </dd>
                        <dt>시장가/정찰가
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" value="<?= @$commonPrice ?>" name="commonPrice" id="commonPrice" class="inputItem goods_option_inp" style="width:100%;"/>
                        </dd>
                        <dt>판매가격
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" value="<?= @$sellPrice ?>" name="sellPrice" id="sellPrice" class="inputItem goods_option_inp" style="width:100%;"/>
                        </dd>
                        <dt>재고
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="qta" value="<?= @$qta ?>" id="qta" class="inputItem goods_option_inp" style="width:80%;"/>
                            <input type="Button" class="memEleB DateBoxa" data="option1" style="width:150px;" value="가격.재고 설정하기"/>
                            <div id="qtBoxa"></div>
                        </dd>
                        <dt>재고처리 종류</dt>
                        <dd>
                            <select name="goods_stock_type">
                                <option value="0">무한대</option>
                                <option value="1">품절</option>
                                <option value="2" selected>잔여수량</option>
                            </select>
                        </dd>
                        <dt>검색어</dt>
                        <dd style="height: 35px;;">
                            <input type="text" name="goods_tag" class="inputItem" style="width:100%;">
                            <span style="color:#09a0f7;">※ 상품 검색 시 키워드로 사용되며 일부 단어로도 검색이 가능합니다. 검색어를 열거하여 입력하시면 됩니다.</span>
                        </dd>
                        <dt>진열여부</dt>
                        <dd><input type="radio" name="goods_display" value="0" id="goods_display_hide"><label for="goods_display_hide">숨김</label> <input type="radio" name="goods_display" value="1" id="goods_display_show" checked><label for="goods_display_show">진열</label></dd>
                        <dt>배송정책</dt>
                        <dd class="inputDd">
                            <label>
                                <inputinput type="radio" value="0" class="dlv_special" name="goods_dlv_special" checked>
                                일반배송
                            </label>
                            <label>
                                <inputinput type="radio" value="1" class="dlv_special" name="goods_dlv_special">
                                별도배송
                            </label>
                        </dd>
                        <dt>배송비정책</dt>
                        <dd class="inputDd dlv_dd" style="height: 70px;">
                            <div style="width:100%;float:left;">
                                <ul class="goods_dlv_special0">
                                    <li>
                                        <label>
                                            <input type="radio" value="0" name="goods_dlv_type" checked="checked">
                                            판매자 기본 배송정책 적용
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" value="1" name="goods_dlv_type">
                                            무료
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <INPUT type="radio" value="2" name="goods_dlv_type">
                                            고정금액(선불)
                                        </label>
                                    </li>
                                </ul>
                                <ul class="goods_dlv_special1">
                                    <li>
                                        <label>
                                            <input type="radio" value="1" name="goods_dlv_type">
                                            무료
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" value="2" name="goods_dlv_type">
                                            고정금액(선불)
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" value="3" name="goods_dlv_type">
                                            착불
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" value="4" name="goods_dlv_type">
                                            주문금액별 차등
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" value="5" name="goods_dlv_type">
                                            무게별 차등
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" value="6" name="goods_dlv_type">
                                            부피별 차등
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type="radio" value="7" name="goods_dlv_type">
                                            수량비례
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </dd>
                        <dt>배송비</dt>
                        <dd class="inputDd">
                            <label>
                                <span class="dlv_txt">판매자 기본 배송정책 적용: 고정금액(선불) / 배송료 : 2500원 / 지역할증 : 있음</span>
                                <input type="text" name="goods_dlv_fee" class="inputItem dlv_fee">
                                <span class="dlv_won">원</span>
                            </label>
                        </dd>
                        <dt>세일</dt>
                        <dd class="inputDd">
                            <input type="text" name="sb_sale" id="sb_sale" class="inputItem" style="width:100%;"/>
                        </dd>
                        <!--
                        <dt>적립금</dt>
                        <dd class="inputDd"><input type="text" name="milage" id="milage" class="inputItem" onmouseup="milagea()" /></dd>
                    -->
                        <dt>간략설명</dt>
                        <dd class="inputDd">
                            <input type="text" name="summary" id="summary" class="inputItem" style="width:100%;"/>
                        </dd>
                        <!--
                        <dt>무게</dt>
                        <dd class="inputDd"><input type="text" name="kg" id="kg" class="inputItem" /></dd>
                        -->
                        <dt>제조사</dt>
                        <dd class="inputDd">
                            <input type="text" name="manufacture" class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>원산지</dt>
                        <dd class="inputDd">
                            <input type="text" name="orgin" id="orgin" class="inputItem" style="width:100%;"/>
                        </dd>


                        <!--
                        <dt>상품코드</dt>
                        <dd class="inputDd"><input type="text" name="goods_code" id="goods_code" class="inputItem" /></dd>
                        <dt>*제고량</dt>
                        <dd class="inputDd"><input type="text" name="quantity" id="quantity" class="inputItem" /></dd>
                        -->
                    </dl>
                    <dl class="readContent">
                        <dt style="background-color:#3a5795;color:white;">특수코드</dt>
                        <dd class="inputDd"
                            style="background-color: #3a5795;padding-left:9px;height:17px;color:white;"></dd>
                        <?
                        $query = "SELECT name,img FROM sp";
                        $result = mysql_query($query) or die($query);
                        while ($rows = mysql_fetch_assoc($result)) {
                            # code...
                            ?>
                            <dt>특수코드</dt>
                            <dd class="inputDd">
                                <label>
                                    <input type="checkbox" name="sp[]" value="<?= $rows['name'] ?>"/>
                                    <span>
                                        <img src="<? echo $brandImagesWebDir . $rows['img']; ?>"/>
                                    </span>
                                </label>
                            </dd>
                            <?
                        }
                        ?>
                    </dl>


                    <dl class="readContent dlbimg">
                        <dt style="background-color:#3a5795;color:white;">이미지</dt>
                        <dd class="inputDd"
                            style="background-color: #3a5795;padding-left:9px;height:17px;color:white;"></dd>
                        <dt>대이미지
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addbigImage" data="dlbimg"/>
                            </a>
                            <input type="file" name="bigImage[]" id="bigImage" class="inputItem fileHeight"/>
                            <input type="button" value="취소" class="fileClear memEleB" data="bigImage"/>
                        </dd>
                    </dl>
                    <dl class="readContent dlmimg">
                        <dt>중이미지
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addmdImage" data="dlmimg"/>
                            </a>
                            <input type="file" name="mdImage[]" id="mdImage" class="inputItem fileHeight"/>
                            <input type="button" value="취소" class="fileClear memEleB" data="mdImage"/>
                        </dd>
                    </dl>
                    <dl class="readContent dlsimg">
                        <dt>소이미지
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addsmImage" data="dlsimg"/>
                            </a>
                            <span>
                                <input type="file" name="smImage[]" id="smImage" class="inputItem fileHeight"/>
                            </span>
                            <input type="button" value="취소" class="fileClear memEleB" data="smImage"/>
                        </dd>
                    </dl>
                    <dl class="readContent dltimg">
                        <dt>썸네일 이미지</dt>
                        <dd class="inputDd">
                            <a href="#" style="float:left;padding-top:2px;padding-right:3px;">
                                <img src="images/i_add.gif" class="addthumImage" data="dltimg"/>
                            </a>
                            <input type="file" name="thumImage[]" id="thumImage" class="inputItem fileHeight"/>
                            <input type="button" value="취소" class="fileClear memEleB" data="smImage"/>
                        </dd>
                    </dl>
                    <dl class="readContent">
                        <dt style="background-color:#3a5795;color:white;">추가옵션</dt>
                        <dd class="inputDd" style="background-color: #3a5795;padding-left:9px;height:17px;"></dd>
                        <dt>옵션명1
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" value="<?= @$optionName1 ?>" name="opName3" id="opName3" readonly
                                   class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>옵션명2
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" value="<?= @$optionName2 ?>" name="opName4" id="opName4" readonly
                                   class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>옵션값1
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" value="<?= @$optionValue1 ?>" name="opValue1" id="opValue1" readonly
                                   class="inputItem" style="width:100%;"/>
                        </dd>
                        <!--
                        <dt>옵션명2 [-로 구분]</dt>
                        <dd class="inputDd"><input type="text" name="opName2" id="opName2" value="" class="inputItem" style="width:100%;" /></dd>
                    -->
                        <dt>옵션값2
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" value="<?= @$optionValue2 ?>" name="opValue2" id="opValue2" readonly
                                   class="inputItem" style="width:100%;"/>
                        </dd>
                        <dt>재고
                            <span class="fontCol">*</span>
                        </dt>
                        <dd class="inputDd">
                            <input type="text" name="qt" value="<?= @$optionQt ?>" id="qt" class="inputItem" readonly
                                   style="width:80%;"/>
                            <input type="Button" class="memEleB DateBox" data="option2"
                                   style="width:150px;display: inline;" value="가격.재고 설정하기"/>
                            <div id="qtBox"></div>
                        </dd>
                        <dt>상세정보</dt>
                        <dd class="contentDd"></dd>
                    </dl>
                    <div style="float:left;padding:5px 8px 5px 5px;">
                        <!--
                      <textarea id="editor2" rows="10" cols="80"></textarea>
                        <textarea name="deliverycontent" id="editor" rows="10" cols="80"></textarea>
                        <script type="text/javascript">
                                if (typeof CKEDITOR == 'undefined') {
                                        document.write('Load CKEditor error!!');
                                } else {
                                        var editorContent = CKEDITOR.replace('editor');
                                        editorContent.config.width = '100%';
                                        editorContent.config.height = 500;
                                        CKFinder.setupCKEditor(editorContent, 'ckfinder/');
                                }
                        </script>
                        -->
                        <!-- 加载编辑器的容器 -->
                        <script id="container" name="content" type="text/plain">

                        </script>
                        <!-- 配置文件 -->
                        <script type="text/javascript" src="ueditor/ueditor.config.js"></script>
                        <!-- 编辑器源码文件 -->
                        <script type="text/javascript" src="ueditor/ueditor.all.js"></script>
                        <!-- 实例化编辑器 -->
                        <script type="text/javascript">
                            var ue = UE.getEditor('container');
                        </script>
                    </div>
                    <div class="buttonBox">
                        <input type="submit" value=" 입력 " class="memEleB"/>
                        <input type="reset" value=" 취소 " class="memEleB"/>
                        <input type="button" value=" 목록 " class="memEleB"
                               onclick="location.href='brandList.php?page=<?= @$page ?>&key=<?= @$key ?>&keyfield=<?= @$keyfield ?>'"/>
                    </div>
                </form>
            </div>
            <iframe name="action_frame" width="100%" height="200" style="display:none;background-color:#eee;;"></iframe>
        </div>
        <script type="text/javascript" src="common/brandWrite.js"></script>
        <script type="text/javascript" src="common/jslb_ajax.js"></script>
        <script type="text/javascript" src="assets/plugins/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="assets/plugins/jquery-migrate-1.2.1.min.js"></script>
        <script type="text/javascript" src="assets/scripts/brandWrite.js"></script>
        <?
        mysql_close($db);
        ?>
    </body>
</html>