<?php
$url_site = url_site();
$idx_user = login('idx');

if( !empty( $idx_user ) ) $post_primary_photo = "<img class='header-primary-photo' src='".data()->loadBy('user', 'primary_photo', 0, $idx_user)[0]->urlThumbnail(40,40)."'/>";
else $post_primary_photo = null;
?>
<div id="page-header">
    <ul id="main-menu">
        <li class='logo'><span class="link sprite logo" route="front_page"></span></li>
        <li class='sub-menu ask'><span class="link sprite ask" route="postList" post_id="test"></span><div class='label'>Ask</div></li>
        <li class='sub-menu forum'><span class="link sprite forum" route="postList" post_id="qna"></span><div class='label'>Forum</div></li>
        <li class='sub-menu news'><span class="link sprite news" route="login"></span><div class='label'>News</div></li>
        <li class='sub-menu market'><span class="link sprite market" url="index.html"></span><div class='label'>Market</div></li>
        <li class='sub-menu jobs'><span class="link sprite jobs" url="index.html"></span><div class='label'>Jobs</div></li>		
        <li class='sub-menu my_page'><span class="link sprite my_page" url="index.html"><?php echo $post_primary_photo; ?></span><div class='label'>My Page</div></li>
        <li class='menu'><span class="show-panel sprite menu"></span><div class='label'>Menu</div></li>
    </ul>
</div>
