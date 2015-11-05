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
	<section class='wooree-grid3'>
		<div class='a'>
			<div class='floater-dotted'>
				<a class='text' href='/post/list?id=wooreeedu'>조기유학 / 단기캠프</a>
			</div>
			<?php
				$posts = getPostWithImage(0, 1, 'wooreeedu');
				if( !empty( $posts[0] ) ) {
					$post = $posts[0];				
					echo postBannerWithText( $post, 520, 500, 20, 200 );
				}
				$posts = getPostWithImage(1, 2, 'wooreeedu');
				echo postThumbnailWithText( $posts, 'long-version', 100, 75, 100 );
			?>
		</div>
		<div class='b'>	
			<div class='floater-bar'>
				<a class='text' href='/post/list?id=wooreeedu_gallery'>사진 갤러리</a>
			</div>
			<?php
				$posts = getPostWithImage(0, 1, 'wooreeedu_gallery');
				echo postHoverTitleImage( $posts, 444, 334, 30 );
				$posts = getPostWithImage(1, 3, 'wooreeedu_gallery');
				echo postThumbnailWithText( $posts, null, 100, 75, 30 );
			?>
		</div>
		<div class='c'>
			<div class='floater-bar'>				
			</div>
			<?php 
				$posts = getPostWithImage(4, 1, 'wooreeedu_gallery');
				echo postHoverTitleImage( $posts, 444, 334, 30 );
				$posts = getPostWithImage(5, 3, 'wooreeedu_gallery');
				echo postThumbnailWithText( $posts, null, 100, 75, 30 );
			?>
		</div>
	</section>
</div>