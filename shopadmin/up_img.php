<?php
    include("common/config.shop.php");
    $query = "select * from goods";
    $result = mysql_query($query) or die("error");
    while($row=mysql_fetch_array($result)){
        $in_goods_code = $row["goods_code"];
        $in_inputDate = date("Y-m-d H:i:s",time());
        $in_simg = $row["smImage"];
        $in_mimg = $row["mdImage1"];
        mysql_query("INSERT INTO upload_simages(goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$in_simg','$in_inputDate')");
        mysql_query("INSERT INTO upload_mimages(goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$in_mimg','$in_inputDate')");
        for($i=1;$i<=30;$i++){
            $in_bigImage = $row["bigImage".$i];
            if($in_bigImage != ""){
                $in_inputDate = date("Y-m-d H:i:s",time());
                mysql_query("INSERT INTO upload_bimages(goods_code,ImageName,inputDate) VALUES ('$in_goods_code','$in_bigImage','$in_inputDate')");
            }
        }
    }
    mysql_close($db);
?>