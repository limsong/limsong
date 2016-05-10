<?php
$baseUrl = $_SERVER['PHP_SELF'];
?>
<div class="col-md-3 col-lg-2">
    <div class="small-cat-menu">
        <ul class="cat-menu-ul">
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/notice.php") echo 'class="active"'; ?> href="notice.php">공지글</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/memtomem.php") echo 'class="active"'; ?> href="memtomem.php">자주하는질문</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/qna.php") echo 'class="active"'; ?> href="qna.php">질문관답변</a>
            </li>
        </ul>
    </div>
</div>