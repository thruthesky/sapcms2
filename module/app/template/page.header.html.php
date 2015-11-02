<?php
$url_site = url_site();
$idx_user = login('idx');
$post_primary_photo = null;

$my_page_url = "login";
$my_page_text = "Login";
if( !empty( $idx_user ) ){
	$user_photo = data()->loadBy('user', 'primary_photo', 0, $idx_user);	
	if( !empty( $user_photo ) ) $post_primary_photo = "<img class='header-primary-photo' src='".$user_photo[0]->urlThumbnail(40,40)."'/>";
	$my_page_url = "profile";
	$my_page_text = "My Page";
}

?>
<div id="page-header">
    <ul id="main-menu">
        <li class='link logo' route="front_page"><span class="sprite logo"></span><div class='label'>우리에듀</div></li>
		<li class='link sub-menu ask' route="postList" post_id="qna"><span class="sprite ask"></span><div class='label'>Ask</div></li>
		<li class='link sub-menu forum' route="pageView" page="introduction"><span class="sprite forum"></span><div class='label'>학원소개</div></li>
        <li class='link sub-menu news' route="pageView" page="course"><span class="sprite news"></span><div class='label'>어학연수</div></li>
        <li class='link sub-menu market' route="pageView" page="gallery"><span class="sprite market"></span><div class='label'>프로그램</div></li>
        <li class='link sub-menu jobs' route="pageView" page="camp"><span class="sprite jobs"></span><div class='label'>단기캠프</div></li>
		<li class='link sub-menu my_page' route="<?php echo $my_page_url; ?>"><span class="sprite my_page"><?php echo $post_primary_photo; ?></span><div class='label'><?php echo $my_page_text; ?></div></li>
        <li class='menu show-panel'><span class="sprite menu"></span><div class='label'>Menu</div></li>
    </ul>
</div>
