<?
include_once("session.php");
include_once("include/check.php");
include_once("include/config.php");
include_once("include/sqlcon.php");
$code = $_POST["code"];//v_oid
$codeArr = explode(",",$code);
$v_oid = $codeArr[0];
$mod = $codeArr[1];
$id = $codeArr[2];
$option = $codeArr[3];

//pop 장바구니 아이템 삭제
if($mod==""){
        $db->query("DELETE FROM basket WHERE v_oid='$code' AND id='$uname'");
        $db->disconnect();
        exit;
}
//shopping_cart페이지 아이템 삭제
if($mod == "all"){
        echo "DELETE FROM basket WHERE uid='$v_oid' AND id='$uname'";
        $db->query("DELETE FROM basket WHERE uid='$v_oid' AND id='$uname'");
}else{
        if($option=="sb"){
                $db->query("SELECT sbid,sbnum FROM basket WHERE v_oid='$v_oid' AND id='$uname'");
                $dbbasket = $db->loadRows();
                $sbid=$dbbasket[0][sbid];
                $sbnum = $dbbasket[0][sbnum];
                $sbidArr = explode(",",$sbid);
                $sbnumArr = explode(",",$sbnum);
                $count = count($sbidArr);
                if($count==1){
                        $db->query("DELETE FROM basket WHERE v_oid='$v_oid' AND id='$uname'");
                }else{
                        for($i=0;$i<$count;$i++){
                                if($i==0){
                                        if($sbidArr[$i]==$id){
                                                $in_sbid=$sbidArr[$i+1];
                                                $in_sbnum = $sbnumArr[$i+1];
                                                $i++;
                                        }else{
                                                $in_sbid=$sbidArr[$i];
                                                $in_sbnum = $sbnumArr[$i];
                                        }
                                }else{
                                        $in_sbid .=",".$sbidArr[$i];
                                        $in_sbnum .=",".$sbnumArr[$i];
                                }
                        }
                        $db->query("UPDATE basket SET sbid='$in_sbid',sbnum='$in_sbnum' WHERE v_oid='$v_oid' AND id='$uname'");
                }
        }elseif($option=="op"){
                $db->query("SELECT opid,opnum FROM basket WHERE v_oid='$v_oid' AND id='$uname'");
                $dbbasket = $db->loadRows();
                $opid=$dbbasket[0][opid];
                $opnum = $dbbasket[0][opnum];
                $opidArr = explode(",",$opid);
                $opnumArr = explode(",",$opnum);
                $count = count($opidArr);
                for($i=0;$i<$count;$i++){
                        if($i==0){
                                if($opidArr[$i]==$id){
                                        $in_opid=$opidArr[$i+1];
                                        $in_opnum = $opnumArr[$i+1];
                                        $i++;
                                }else{
                                        $in_opid=$opidArr[$i];
                                        $in_opnum = $opnumArr[$i];
                                }
                        }else{
                                if($opidArr[$i]==$id){
                                        $in_opid .=",".$opidArr[$i+1];
                                        $in_opnum .=",".$opnumArr[$i+1];
                                        $i++;
                                }else{
                                        $in_opid .=",".$opidArr[$i];
                                        $in_opnum .=",".$opnumArr[$i];
                                }
                        }
                }
                $db->query("UPDATE basket SET opid='$in_opid',opnum='$in_opnum' WHERE v_oid='$v_oid' AND id='$uname'");
        }
}
$db->disconnect();
?>