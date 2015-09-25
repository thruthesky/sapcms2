<?php
$url_site = url_site();
$idx_user = login('idx');
$post_primary_photo = null;

$my_page_url = "my_page";
if( !empty( $idx_user ) ){
	$user_photo = data()->loadBy('user', 'primary_photo', 0, $idx_user);	
	if( !empty( $user_photo ) ) $post_primary_photo = "<img class='header-primary-photo' src='".$user_photo[0]->urlThumbnail(40,40)."'/>";
	$my_page_url = "profile";
}

?>
<div id="page-header">
    <ul id="main-menu">
        <li class='link logo' route="front_page"><span class="sprite logo"></span></li>
        <li class='link sub-menu ask' route="postList" post_id="test"><span class="sprite ask"></span><div class='label'>Ask</div></li>
        <li class='link sub-menu forum' route="postList" post_id="qna"><span class="sprite forum"></span><div class='label'>Forum</div></li>
        <li class='link sub-menu news' route="login"><span class="sprite news"></span><div class='label'>News</div></li>
        <li class='link sub-menu market' url="index.html"><span class="sprite market"></span><div class='label'>Market</div></li>
        <li class='link sub-menu jobs' url="index.html"><span class="sprite jobs"></span><div class='label'>Jobs</div></li>		
        <li class='link sub-menu my_page' url="index.html"><span class="sprite <?php echo $my_page_url; ?>"><?php echo $post_primary_photo; ?></span><div class='label'>My Page</div></li>
        <li class='menu show-panel'><span class="sprite menu"></span><div class='label'>Menu</div></li>
    </ul>
</div>
