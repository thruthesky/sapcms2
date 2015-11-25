<?php
/*
Do not forget to change the post queries
*/
add_css();
add_css('front.postThumbnailWithText.css');
add_css('front.postHoverTitleImage.css');
add_css('front.postBulletList.css');
add_css('front.postBannerWithText.css');
?>
<div class='page-content top'>
	<a class='left-wing ve' href='/ve?page=solution'><img src="/theme/wooreeedu/img/left_wing_ve.png"></a>
	<a class='left-wing team-viewer' href='/theme/teamviewer.exe' download><img src="/theme/wooreeedu/img/left_wing_team_viewer.png"></a>
	<section class='wooree-grid3'>
		<div class='a'>
			<div class='floater-dotted'>
				<a class='text' href='/post/list?id=wooreeedu'>조기유학 / 단기캠프</a>
			</div>
			<?php
				$posts = getPostWithImageNoComment(0, 3, 'wooreeedu');			
				if( !empty( $posts[0] ) ) echo postBannerWithText( $posts[0], 520, 500, 20, 200 );
				
				$post_items = array_slice( $posts, 1, 2 );
				if( !empty( $posts ) ) echo postThumbnailWithText( $post_items, 'long-version', 100, 75, 100 );
			?>
		</div>
		<div class='b'>	
			<div class='floater-bar'>
				<a class='text' href='/post/list?id=wooreeedu_gallery'>사진 갤러리</a>
			</div>
			<?php
				$posts = getPostWithImageNoComment(0, 8, 'wooreeedu_gallery');
				$post_items = array_slice( $posts, 0, 1 );				
				if( !empty( $posts[0] ) ) echo postHoverTitleImage( $post_items, 444, 334, 30 );
				
				$post_items = array_slice( $posts, 1, 3 );
				if( !empty( $post_items ) ) echo postThumbnailWithText( $post_items, null, 100, 75, 30 );
			?>
		</div>
		<div class='c'>
			<div class='floater-bar'>				
			</div>
			<?php 
				$post_items = array_slice( $posts, 4, 1 );
				echo postHoverTitleImage( $post_items, 444, 334, 30 );
				
				$post_items = array_slice( $posts, 5, 3 );
				echo postThumbnailWithText( $post_items, null, 100, 75, 30 );
			?>
		</div>
	</section>
</div>
<iframe src="http://wooreeedu.begin.kr/iframe_login.php?id=<?php echo login('id')?>&classid=solution&page=teacher_list" width="100%" height="2400" style="border:0; box-sizing:border-box;"></iframe>