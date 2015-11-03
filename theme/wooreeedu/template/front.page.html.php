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
				<span class='text'>조기유학 / 단기캠프</span>
			</div>
			<?php
				$posts = getPostWithImage(0, 1, 'wooreeedu');
				if( !empty( $posts[0] ) ) {
					$post = $posts[0];				
					echo postBannerWithText( $post, 520, 500, 20, 200 );
				}
				$posts = getPostWithImage(1, 2, 'wooreeedu');
				echo postThumbnailWithText( $posts, 100, 75, 100 );
			?>
		</div>
		<div class='b'>	
			<div class='floater-bar'>
				<span class='text'>사진 갤러리</span>
			</div>
			<?php
				$posts = getPostWithImage(3, 1, 'wooreeedu');
				echo postHoverTitleImage( $posts, 444, 334, 30 );
				$posts = getPostWithImage(4, 3, 'wooreeedu');
				echo postThumbnailWithText( $posts, 100, 75, 30 );
			?>
		</div>
		<div class='c'>
			<div class='floater-bar'>				
			</div>
			<?php 
				$posts = getPostWithImage(7, 1, 'wooreeedu');
				echo postHoverTitleImage( $posts, 444, 334, 30 );
				$posts = getPostWithImage(8, 3, 'wooreeedu');
				echo postThumbnailWithText( $posts, 100, 75, 30 );
			?>
		</div>
	</section>
</div>