<?php
/*
Do not forget to change the post queries
*/
add_css();
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
					include template('front.postBulletList');
					$posts = getPostWithImage(1, 2, 'test');
					include template('front.postthumbnailWithText');
				?>
			</div>
			<div class='b'>				

				<?php				
					$posts = post()->getLatestPost('test', 0, 5);
					include template('front.postBulletList');
					$posts = getPostWithImage(3, 2, 'test');
					include template('front.postthumbnailWithText');
				?>
			</div>
			<div class='c'>				
				<?php
					$posts = getPostWithImage(1, 1, 'test');
					include template('front.postHoverTitleImage');
					$posts = getPostWithImage(5, 3, 'test');
					include template('front.postthumbnailWithText');
				?>
			</div>
			<div class='d'>
				<?php 
					$posts = getPostWithImage(2, 1, 'test');
					include template('front.postHoverTitleImage');
					$posts = getPostWithImage(8, 3, 'test');
					include template('front.postthumbnailWithText');
				?>
			</div>
		</div>
	</section>
	<?php //include template('front.content.text-photo') ?>
</div>