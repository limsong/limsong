<?php
$baseUrl = $_SERVER['PHP_SELF'];
?>
<div class="col-md-3 col-lg-2">
    <div class="small-cat-menu">
        <ul class="cat-menu-ul">
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/mypage.php") echo 'class="active"'; ?> href="mypage.php">주문/배송조회</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/cancelstatus.php") echo 'class="active"'; ?> href="cancelstatus.php">취소/반품/교환 현황</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/point.php") echo 'class="active"'; ?> href="point.php">적립금현황</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/my_qna.php") echo 'class="active"'; ?> href="my_qna.php">qna</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/goods_qna.php") echo 'class="active"'; ?> href="goods_qna.php">상품문의</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/mem_modify.php") echo 'class="active"'; ?> href="mem_modify.php">회원정보수정</a>
            </li>
        </ul>
    </div>
</div>