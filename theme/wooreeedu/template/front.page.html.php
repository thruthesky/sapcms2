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
				<span class='text'>Title Here</span>
			</div>
			<?php
				$posts = getPostWithImage(0, 1, 'test');
				if( !empty( $posts[0] ) ) $posts = $posts[0];				
				echo postBannerWithText( $posts, 520, 500, 20, 200 );
				$posts = getPostWithImage(1, 2, 'test');
				echo postThumbnailWithText( $posts, 100, 75, 100 );
			?>
		</div>
		<div class='b'>	
			<div class='floater-bar'>
				<span class='text'>Title Here</span>
			</div>
			<?php
				$posts = getPostWithImage(1, 1, 'test');
				echo postHoverTitleImage( $posts, 444, 330, 30 );
				$posts = getPostWithImage(5, 3, 'test');
				echo postThumbnailWithText( $posts, 100, 75, 30 );
			?>
		</div>
		<div class='c'>
			<div class='floater-bar'>				
			</div>
			<?php 
				$posts = getPostWithImage(2, 1, 'test');
				echo postHoverTitleImage( $posts, 444, 330, 30 );
				$posts = getPostWithImage(8, 3, 'test');
				echo postThumbnailWithText( $posts, 100, 75, 30 );
			?>
		</div>
	</section>
	<section class='wooree-grid3'>
		<div class='a'>
			<?php
				$posts = getPostWithImage(0, 1, 'test');
				if( !empty( $posts[0] ) ) $posts = $posts[0];				
				echo postBannerWithText( $posts, 520, 500, 20, 200 );
				$posts = getPostWithImage(1, 2, 'test');
				echo postThumbnailWithText( $posts, 100, 75, 100 );
			?>
		</div>
		<div class='b'>	
			<?php
				$posts = getPostWithImage(1, 1, 'test');
				echo postHoverTitleImage( $posts, 444, 330, 30 );
				$posts = getPostWithImage(5, 3, 'test');
				echo postThumbnailWithText( $posts, 100, 75, 30 );
			?>
		</div>
		<div class='c'>
			<?php 
				$posts = getPostWithImage(2, 1, 'test');
				echo postHoverTitleImage( $posts, 444, 330, 30 );
				$posts = getPostWithImage(8, 3, 'test');
				echo postThumbnailWithText( $posts, 100, 75, 30 );
			?>
		</div>
	</section>
</div>