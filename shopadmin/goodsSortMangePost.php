<?php
include("common/config.shop.php");
include("check.php");
foreach($_POST as $k=>$v) {
    ${"tr_".$k}=addslashes($v);
}
$in_uxCode=$tr_uxCode;
$in_umCode=$tr_umCode;
$in_sortName=$tr_sortName;
$in_sortUrl = $tr_sortUrl;
$in_liId=$tr_liId;
if($tr_sortType) {
    $in_sortType=$tr_sortType;								//대분류나 중분류
} else {
    $in_sortType='S';										//분류타입이 넘어오지 않았다면 소분류
}
$arrSortListHead=array("x","m","s");

if(substr($tr_mode,0,1)=='x') {						        //해당 버튼의 아이디를 모드에 셋팅(자바스크립트로)
    $in_dType="0";
} else if(substr($tr_mode,0,1)=='m') {
    $in_dType="1";
} else if(substr($tr_mode,0,1)=='s') {
    $in_dType="2";
}

switch($tr_mode) {
    case("xInput"):
        ?>
        <script type="text/javascript">
            parent.document.xForm.reset();						//대분류초기화
            parent.document.mForm.reset();						//중분류초기화
            parent.document.sForm.reset();						//소분류 초기화
            parent.document.getElementById("xSortList").innetHTML="";
            parent.document.getElementById("mSortList").innerHTML="";
            parent.document.getElementById("sSortList").innerHTML="";
            parent.globalVar.oldLinkObjX="";
            parent.globalVar.oldLinkObjM="";
            parent.globalVar.oldLinkObjS="";
            parent.rmSortImage("0");
            parent.rmSortImage("1");
            parent.rmSortImage("2");
        </script>
    <?php
    case("mInput"):
        if($tr_mode=="mInput"){
            ?>
            <script type="text/javascript">
                parent.document.mForm.reset();
                parent.document.sForm.reset();
                parent.document.mForm.uxCode.value='<?=$in_uxCode?>';		//상위 대분류값은 초기화 되지 않는다
                parent.document.getElementById("sSortList").innerHTML="";
                parent.globalVar.oldLinkObjM="";
                parent.globalVar.oldLinkObjS="";
                parent.rmSortImage("1");
                parent.rmSortImage("2");
            </script>
        <?php
        }
    case("sInput"):
        $query="select max(sortCode),max(sortOrder) from sortCodes where uxCode='$in_uxCode' and umCode='$in_umCode'";
        $result=mysql_query($query) or die($query);
        $rows=mysql_num_rows($result);
        if($rows<1) {
            $in_sortCode="01";
            $in_sortOrder="01";
        } else {
            $in_sortCode=mysql_result($result,0,0);
            $in_sortOrder=mysql_result($result,0,1);
            $in_sortCode=substr("00".($in_sortCode+1),-2);
            $in_sortOrder=substr("00".($in_sortOrder+1),-2);
        }
        if($_FILES["sortImage"]['size']>0) {
            if(substr($tr_mode,0,1)=="x") {
                $in_sortImage="sortImagex".$in_sortCode."0000";
            } else if(substr($tr_mode,0,1)=="m") {
                $in_sortImage="sortImagem".$tr_uxCode.$in_sortCode."00";
            } else if(substr($tr_mode,0,1)=="s") {
                $in_sortImage="sortImages".$tr_uxCode.$tr_umCode.$in_sortCode;
            }

            $selectUserFileName=$_FILES["sortImage"]['name'];
            $arrFileInfo=explode(".",$selectUserFileName);
            $fileExt=$arrFileInfo[count($arrFileInfo)-1];
            $upFileName=$in_sortImage.".".$fileExt;
            $uploadedFile=$_FILES["sortImage"]['tmp_name'];

            $fileSource=$uploadedFile;
            $fileDest=$sortImagesDir.$upFileName;

            if(!move_uploaded_file($fileSource,$fileDest)) {
                die("파일 업로드 실패 관리자에게 문의하세요");
            }
            $addFields.=",sortImage";
            $addValues.=",'$upFileName'";
        }
        $query="insert into sortCodes (sortCode,sortName,sortUrl,sortType,uxCode,umCode,sortOrder $addFields) values ('$in_sortCode','$in_sortName','$in_sortUrl','$in_sortType','$in_uxCode','$in_umCode','$in_sortOrder' $addValues)";
        mysql_query($query) or die($query);
        if($upFileName) {
            $in_sortImage=$sortImagesWebDir.$upFileName;		//$sortImagesWebDir---서버상의 경로가 아닌 웹상에서의 경로
        } else {
            $in_sortImage="noImage";
        }
        $query="select count(*) from sortCodes where uxCode='$in_uxCode' and umCode='$in_umCode'";
        $result=mysql_query($query) or die($query);
        $liIndex=mysql_result($result,0,0)-1;		//li이의 아이디는 0부터 시작하기에 -1을 했다
        $resHtml="<li class=\"depth2\" id=\"$arrSortListHead[$in_dType]Item$liIndex\"><div class=\"sortTx\">[$in_sortType]</div><div class=\"sortNum\">[$in_sortCode]</div><div class=\"sortName\"><a href=\"#aa\" sortimage=\"$in_sortImage\" dtype=\"$in_dType\" sortorder=\"$in_sortOrder\">$in_sortName</a></div><div class=\"udImg\"><img src=\"images/up.gif\" alt=\"up\" /></div><div class=\"udImg\"><img src=\"images/down.gif\" alt=\"down\" /></div></li>";
        if($tr_mode=="sInput"){
            ?>
            <script type="text/javascript">
                parent.document.sForm.reset();
                parent.document.sForm.uxCode.value='<?=$in_uxCode?>';
                parent.document.sForm.umCode.value='<?=$in_umCode?>';
                parent.globalVar.oldLinkObjS="";
                parent.rmSortImage("2");
            </script>
        <?php
        }
        ?>
        <script type="text/javascript">
            var pObj=parent.document.getElementById("<?=$arrSortListHead[$in_dType]?>SortList");
            pObj.innerHTML+='<?=$resHtml?>';
            if(parent.document.getElementById("<?=$in_liId?>")) {		//해당 li이가 선택이 되어있다면 초기화시킴
                parent.document.getElementById("<?=$in_liId?>").getElementsByTagName("a")[0].style.fontWeight='400';
                parent.document.getElementById("<?=$in_liId?>").getElementsByTagName("a")[0].style.color='#003300';
            }
        </script>
        <?
        break;
    case("xModify"):
    case("mModify"):
    case("sModify"):
        $in_sortCode=$tr_sortCode;
        if($tr_mode=="xModify") {
            ?>
            <script type="text/javascript">
                var sortType='<?=$in_sortType?>';
                parent.document.xForm.reset();
                parent.document.xForm.sortName.value='<?=$in_sortName?>';
                parent.document.xForm.sortUrl.value='<?=$in_sortUrl?>';
                parent.document.xForm.liId.value='<?=$in_liId?>';
                parent.document.xForm.sortCode.value='<?=$in_sortCode?>';
                if(sortType=='X') {
                    parent.document.xForm.sortType[0].checked=true;
                } else if(sortType=='O') {
                    parent.document.xForm.sortType[1].checked=true;
                }
            </script>
        <?php
        } else if($tr_mode=="mModify") {
            ?>
            <script type="text/javascript">
                var sortType='<?=$in_sortType?>';
                parent.document.mForm.reset();
                parent.document.mForm.sortName.value='<?=$in_sortName?>';
                parent.document.mForm.sortUrl.value='<?=$in_sortUrl?>';
                parent.document.mForm.uxCode.value='<?=$in_uxCode?>';
                parent.document.mForm.liId.value='<?=$in_liId?>';
                parent.document.mForm.sortCode.value='<?=$in_sortCode?>';
                if(sortType=='M') {
                    parent.document.mForm.sortType[0].checked=true;
                } else if(sortType=='G') {
                    parent.document.mForm.sortType[1].checked=true;
                }
            </script>
        <?php
        } else if($tr_mode=="sModify") {
            ?>
            <script type="text/javascript">
                var sortType='<?=$in_sortType?>';
                parent.document.sForm.reset();
                parent.document.sForm.sortName.value='<?=$in_sortName?>';
                parent.document.sForm.sortUrl.value='<?=$in_sortUrl?>';
                parent.document.sForm.uxCode.value='<?=$in_uxCode?>';
                parent.document.sForm.umCode.value='<?=$in_umCode?>';
                parent.document.sForm.sortCode.value='<?=$in_sortCode?>';
                parent.document.sForm.liId.value='<?=$in_liId?>';
            </script>
        <?php
        }
        if($_FILES["sortImage"]['size']>0) {
            if(substr($tr_mode,0,1)=="x") {
                $in_sortImage="sortImagex".$in_sortCode."0000";
            } else if(substr($tr_mode,0,1)=="m") {
                $in_sortImage="sortImagem".$in_uxCode.$tr_sortCode."00";
            } else if(substr($tr_mode,0,1)=="s") {
                $in_sortImage="sortImages".$in_uxCode.$in_umCode.$tr_sortCode;
            }

            $selectUserFileName=$_FILES["sortImage"]['name'];
            $arrFileInfo=explode(".",$selectUserFileName);
            $fileExt=$arrFileInfo[count($arrFileInfo)-1];
            $upFileName=$in_sortImage.".".$fileExt;
            $uploadedFile=$_FILES["sortImage"]['tmp_name'];

            $fileSource=$uploadedFile;
            $fileDest=$sortImagesDir.$upFileName;
            if(!move_uploaded_file($fileSource,$fileDest)) {
                die("파일 업로드 실패 관리자에게 문의하세요");
            }
            $addQuery=",sortImage='$upFileName'";
        }
        $query="update sortCodes set sortType='$in_sortType', sortName='$in_sortName', sortUrl='$in_sortUrl' $addQuery where uxCode='$in_uxCode' and umCode='$in_umCode' and sortCode='$in_sortCode'";
        mysql_query($query) or die($query);
        ?>
        <script type="text/javascript">
            parent.document.getElementById("<?=$in_liId?>").getElementsByTagName("a")[0].innerHTML='<?=$in_sortName?>';
            parent.document.getElementById("<?=$in_liId?>").getElementsByTagName("a")[0].setAttribute("sorturl","<?=$in_sortUrl?>"); //setAttribute("type or class","value")
            //alert(parent.document.getElementById("<?=$in_liId?>").getElementsByTagName("a")[0].getAttribute("sorturl"));
            <?
            if($upFileName) {
                $in_sortImage=$sortImagesWebDir.$upFileName;
            ?>
            parent.document.getElementById("<?=$in_liId?>").getElementsByTagName("a")[0].setAttribute("sortimage","<?=$in_sortImage?>");
            parent.addSortImage('<?=$in_dType?>','<?=$in_sortImage?>');
            <?
            }
            ?>
        </script>
        <?php
        break;
    case("xDelete"):
    case("mDelete"):
    case("sDelete"):
        $in_sortCode=$tr_sortCode;
        $in_liId=$tr_liId;
        if($in_dType=="0") {
            $query="select count(*) from sortCodes where uxCode='$in_sortCode' and umCode='00'";			//중분류가 있는지 체크
            $result=mysql_query($query) or die($query);
            $rows=mysql_result($result,0,0);
            if($rows>0) {
                ?>
                <script type="text/javascript">
                    alert("하위분류먼저 삭제 하셔야 합니다.");
                    setTimeout("parent.loadingMask('off')",parent.maskTime);
                </script>
                <?php
                exit;
            }
        } else if($in_dType=="1") {
            $query="select count(*) from sortCodes where uxCode='$in_uxCode' and umCode='$in_sortCode'";  //소분류가 있는지 체크
            $result=mysql_query($query) or die($query);
            $rows=mysql_result($result,0,0);
            if($rows>0) {
                ?>
                <script type="text/javascript">
                    alert("하위분류먼저 삭제 하셔야 합니다.");
                    setTimeout("parent.loadingMask('off')",parent.maskTime);
                </script>
                <?php
                exit;
            }
        }

        $query="select sortImage from sortCodes where uxCode='$in_uxCode' and umCode='$in_umCode' and sortCode='$in_sortCode'";
        $result=mysql_query($query) or die($query);
        $ou_sortImage=mysql_result($result,0,0);
        if($ou_sortImage) {
            unlink($sortImagesDir.$ou_sortImage);
        }
        $query="delete from sortCodes where uxCode='$in_uxCode' and umCode='$in_umCode' and sortCode='$in_sortCode'";
        mysql_query($query) or die($query);
        ?>
        <script type="text/javascript">
            var tObj=parent.document.getElementById("<?=$in_liId?>");
            var pObj=parent.document.getElementById("<?=$in_liId?>").parentNode;
            pObj.removeChild(tObj);
        </script>
        <?php
        if($tr_mode=="xDelete") {
            ?>
            <script type="text/javascript">
                parent.document.xForm.reset();			//대분류초기화
                parent.document.mForm.reset();			//중분류초기화
                parent.document.sForm.reset();			//소분류 초기화
                parent.document.getElementById("mSortList").innerHTML="";
                parent.document.getElementById("sSortList").innerHTML="";
                parent.globalVar.oldLinkObjX="";
                parent.globalVar.oldLinkObjM="";
                parent.globalVar.oldLinkObjS="";
                parent.rmSortImage("0");
                parent.rmSortImage("1");
                parent.rmSortImage("2");
            </script>
        <?php
        } else if($tr_mode=="mDelete") {
            ?>
            <script type="text/javascript">
                parent.document.mForm.reset();			//중분류초기화
                parent.document.sForm.reset();			//소분류 초기화
                parent.document.mForm.uxCode.value='<?=$in_uxCode?>';
                parent.document.getElementById("sSortList").innerHTML="";
                parent.globalVar.oldLinkObjM="";
                parent.globalVar.oldLinkObjS="";
                parent.rmSortImage("1");
                parent.rmSortImage("2");
            </script>
        <?php
        } else if($tr_mode=="sDelete") {
            ?>
            <script type="text/javascript">
                parent.document.sForm.reset();			//소분류 초기화
                parent.document.sForm.uxCode.value='<?=$in_uxCode?>';
                parent.document.sForm.umCode.value='<?=$in_umCode?>';
                parent.globalVar.oldLinkObjS="";
                parent.rmSortImage("2");
            </script>
        <?
        }
        break;
    default :
        die("error");
        break;
}
?>
    <script type="text/javascript">
        parent.detachEvt('img',parent.chSortOrder);
        parent.detachEvt('a',parent.clickSort);
        parent.attachEvt('img',parent.chSortOrder);
        parent.attachEvt('a',parent.clickSort);
        //parent.location.reload();
        setTimeout("parent.loadingMask('off')",parent.maskTime);
    </script>
<?php
include("closedb.php");
?>