<?
include("common/config.shop.php");
$spitems=$_GET["spitems"];
$arrgoods_code=explode("|",$_GET["goods_codeGroup"]);
for($i=0;$i<count($arrgoods_code);$i++) {
    if($i==0){
        $addQuery=" WHERE goods_code='$arrgoods_code[$i]' ";
    }else {
        $addQuery.=" or goods_code='$arrgoods_code[$i]'";
    }
}
if($addQuery) {
    $query="UPDATE goods SET spitems='$spitems' $addQuery";
    mysql_query($query) or die($query);
    echo $query;
?>
    <script type="text/javascript">
        alert("추가 되었습니다");
        parent.location.reload();
    </script>
<?
}
?>
