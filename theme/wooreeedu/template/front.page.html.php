<?php
/*
Do not forget to change the post queries
*/
add_css();
add_css('front.postThumbnailWithText.css');
add_css('front.postHoverTitleImage.css');
add_css('front.postBulletList.css');
?>
<div class="front-top-banner">
	<img src='theme/wooreeedu/img/top-banner.jpg'/>
</div>
<div class='page-content top'>
	<section class='grid4'>
		<div class='content'>
			<div class='a'>				
				<?php
					$posts = post()->getLatestPost('test', 0, 5);
					echo postBulletList( $posts, 20 );
					$posts = getPostWithImage(1, 2, 'test');
					echo postThumbnailWithText( $posts, 100, 75, 30 );
				?>
			</div>
			<div class='b'>				

				<?php				
					$posts = post()->getLatestPost('test', 0, 5);
					echo postBulletList( $posts, 20 );
					$posts = getPostWithImage(3, 2, 'test');
					echo postThumbnailWithText( $posts, 100, 75, 30 );
				?>
			</div>
			<div class='c'>				
				<?php
					$posts = getPostWithImage(1, 1, 'test');
					echo postHoverTitleImage( $posts, 465, 364, 30 );
					$posts = getPostWithImage(5, 3, 'test');
					echo postThumbnailWithText( $posts, 100, 75, 30 );
				?>
			</div>
			<div class='d'>
				<?php 
					$posts = getPostWithImage(2, 1, 'test');
					echo postHoverTitleImage( $posts, 465, 364, 30 );
					$posts = getPostWithImage(8, 3, 'test');
					echo postThumbnailWithText( $posts, 100, 75, 30 );
				?>
			</div>
		</div>
	</section>
	<?php //include template('front.content.text-photo') ?>
</div>