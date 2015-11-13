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
	<section class='grid first'>
		<div class='a'>
			<img class='front-banner' src="/theme/englishworld/img/class/main-banner-left.jpg">
			<div class='floater-dotted'>
				<a class='text' href='/post/list?id=englishworld'>조기유학 / 단기캠프</a>
			</div>
			<?php
				$posts = getPostWithImageNoComment(0, 3, 'englishworld');			
				if( !empty( $posts[0] ) ) echo postBannerWithText( $posts[0], 520, 500, 20, 200 );
				
				$post_items = array_slice( $posts, 1, 2 );
				if( !empty( $posts ) ) echo postThumbnailWithText( $post_items, 'long-version', 100, 75, 100 );
			?>
		</div>
		<div class='b'>
			<section class='grid second'>
				<img class='front-banner'  src="/theme/englishworld/img/class/main-banner-right.jpg">
				<div class='floater-bar'>
					<a class='text' href='/post/list?id=englishworld_gallery'>사진 갤러리</a>
				</div>
				<div class='a'>							
					<?php
						$posts = getPostWithImageNoComment(0, 8, 'englishworld_gallery');
						$post_items = array_slice( $posts, 0, 1 );				
						if( !empty( $posts[0] ) ) echo postHoverTitleImage( $post_items, 444, 334, 30 );
						
						$post_items = array_slice( $posts, 1, 3 );
						if( !empty( $post_items ) ) echo postThumbnailWithText( $post_items, null, 100, 75, 30 );
					?>
				</div>
				<div class='b'>
					<?php 
						$post_items = array_slice( $posts, 4, 1 );
						echo postHoverTitleImage( $post_items, 444, 334, 30 );
						
						$post_items = array_slice( $posts, 5, 3 );
						echo postThumbnailWithText( $post_items, null, 100, 75, 30 );
					?>
				</div>
			<section>
		</div>
	</section>
</div>