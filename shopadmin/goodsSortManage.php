<?
include("common/config.shop.php");
include("check.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>goodsSortManage</title>
        <link rel="stylesheet" type="text/css" href="css/common1.css" />
        <link rel="stylesheet" type="text/css" href="css/layout.css" />
        <link rel="stylesheet" type="text/css" href="css/goodsSortManage.css" />
        <link rel="stylesheet" type="text/css" href="css/mask.css" />
        <script type="text/javascript" src="common/jslb_ajax.js"></script>
        <script type="text/javascript" src="common/common.js"></script>
        <script type="text/javascript">
            window.onload=function() {
              displaySortList('00','00','0');
              attachBtnEvt();
            }
        </script>
    </head>
    <body>
        <div id="total">
            <? include("include/include.header.php"); ?>
            <div id="main" style="width: 100%;">
                <div id="loading-mask" style=""></div>
                <div id="loading">
                    <div class="loading-indicator"><img src="img/extanim32.gif" width="32" height="32" style="margin-right:8px;float:left;vertical-align:top;"/><span id="loading-msg">처리중.....</span></div>
                </div>
                <script type="text/javascript">
                    loadingMask('on');
                </script>
                <h4 id="mainTitle">상품 분류관리</h4>
                <ul class="sortBigBox" id="sortBox">
                    <li class="depth1">
                        <h5 class="sortTitle">대분류</h5>
                        <ul class="sortMidBox" id="xSortList">
                            <li class="depth2">
                                <div class="sortTx"></div>
                                <div class="sortNum"></div>
                                <div class="sortName"></div>
                                <div class="sortUrl"></div>
                                <div class="udImg"></div>
                                <div class="udImg"></div>
                            </li>
                        </ul>
                    </li>
                    <li class="depth1">
                        <h5 class="sortTitle">중분류</h5>
                        <ul class="sortMidBox" id="mSortList">
                            <li class="depth2">
                                <div class="sortTx"></div>
                                <div class="sortNum"></div>
                                <div class="sortName"></div>
                                <div class="sortUrl"></div>
                                <div class="udImg"></div>
                                <div class="udImg"></div>
                            </li>
                        </ul>
                    </li>
                    <li class="depth1">
                        <h5 class="sortTitle">소분류</h5>
                        <ul class="sortMidBox" id="sSortList">
                            <li class="depth2">
                                <div class="sortTx"></div>
                                <div class="sortNum"></div>
                                <div class="sortName"></div>
                                <div class="sortUrl"></div>
                                <div class="udImg"></div>
                                <div class="udImg"></div>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="sortBigBox">
                    <li class="depth1">
                        <form name="xForm" id="xForm" method="post" action="goodsSortMangePost.php" target="action_frame" enctype="multipart/form-data">
                            <input type="hidden" name="sortCode" />
                            <input type="Hidden" name="mode" />
                            <input type="hidden" name="uxCode" value="00" />
                            <input type="hidden" name="umCode" value="00" />
                            <input type="hidden" name="liId" />
                            <dl>
                                <dt>분류명:</dt>
                                <dd><input type="text" name="sortName" class="border inp-width" /></dd>
                            </dl>
                            <dl>
                                <dt>분류URL</dt>
                                <dd><input type="text" name="sortUrl" class="border inp-width" /></dd>
                            </dl>
                            <dl>
                                <dt>분류타입:</dt>
                                <dd>
                                    <label>하위분류 있음<input type="radio" name="sortType" value="O" checked="checked" /></label>
                                    <label>하위분류 없음<input type="radio" name="sortType" value="X" /></label>
                                </dd>
                            </dl>
                            <dl>
                                <dt>분류이미지:</dt>
                                <dd>
                                    <input type="file" name="sortImage"  class="btn sortBtn" /><span></span>
                                    <input type="button" value="이미지삭제" class="btn" sytle="display:none" id="xImgDelBtn" />
                                </dd>
                            </dl>
                            <div class="sortButtonBox">
                                <input type="button" value="입력" class="btn" id="xInput" />
                                <input type="button" value="수정" class="btn" id="xModify" />
                                <input type="button" value="삭제" class="btn" id="xDelete" />
                            </div>
                        </form>
                    </li>
                    <li class="depth1">
                        <form name="mForm" id="mForm" method="post" action="goodsSortMangePost.php" target="action_frame" enctype="multipart/form-data">
                            <input type="hidden" name="sortCode" />
                            <input type="hidden" name="mode" />
                            <input type="hidden" name="uxCode" value="" />
                            <input type="hidden" name="umCode" value="00" />
                            <input type="hidden" name="liId" />
                            <dl>
                                <dt>분류명:</dt>
                                <dd><input type="text" name="sortName" class="border inp-width" /></dd>
                            </dl>
                            <dl>
                                <dt>분류URL</dt>
                                <dd><input type="text" name="sortUrl" class="border inp-width" /></dd>
                            </dl>
                            <dl>
                                <dt>분류타입:</dt>
                                <dd>
                                    <label>하위분류 있음<input type="radio" name="sortType" value="M" checked="checked"  /></label>
                                    <label>하위분류 없음<input type="radio" name="sortType" value="G" /></label>
                                </dd>
                            </dl>
                            <dl>
                                <dt>분류이미지:</dt>
                                <dd>
                                    <input type="file" name="sortImage"  class="btn sortBtn" /><span></span>
                                    <input type="button" value="이미지삭제" class="btn" sytle="display:none" id="mImgDelBtn" />
                                </dd>
                            </dl>
                            <div class="sortButtonBox">
                                <input type="button" value="입력" class="btn" id="mInput" />
                                <input type="button" value="수정" class="btn" id="mModify" />
                                <input type="button" value="삭제" class="btn" id="mDelete" />
                            </div>
                        </form>
                    </li>
                    <li class="depth1">
                        <form name="sForm" id="sForm" method="post" action="goodsSortMangePost.php"  target="action_frame" enctype="multipart/form-data">
                            <input type="hidden" name="sortCode" />
                            <input type="hidden" name="mode" />
                            <input type="hidden" name="uxCode" value="" />
                            <input type="hidden" name="umCode" value="" />
                            <input type="hidden" name="liId" />
                            <dl>
                                <dt>분류명:</dt>
                                <dd><input type="text" name="sortName" class="border inp-width" /></dd>
                            </dl>
                            <dl>
                                <dt>분류URL</dt>
                                <dd><input type="text" name="sortUrl" class="border inp-width" /></dd>
                            </dl>
                            <dl>
                                <dt>분류이미지:</dt>
                                <dd>
                                    <input type="file" name="sortImage"  class="btn sortBtn" /><span></span>
                                    <input type="button" value="이미지삭제" class="btn" sytle="display:none" id="sImgDelBtn" />
                                </dd>
                            </dl>
                            <div class="sortButtonBox">
                                <input type="button" value="입력" class="btn" id="sInput" />
                                <input type="button" value="수정" class="btn" id="sModify" />
                                <input type="button" value="삭제" class="btn" id="sDelete" />
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            <iframe name="action_frame" width="600" height="300"  style="display:none"></iframe>
        </div>
    </body>
</html>
