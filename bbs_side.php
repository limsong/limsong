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
                <a <?php if($baseUrl=="/faq.php") echo 'class="active"'; ?> href="faq.php">FAQ</a>
            </li>
            <li class="cat-menu-li">
                <a <?php if($baseUrl=="/my_qna.php") echo 'class="active"';?> href="my_qna.php">Q&A</a>
            </li>
        </ul>
    </div>
</div>