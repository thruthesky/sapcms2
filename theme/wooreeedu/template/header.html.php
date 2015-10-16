<?php
add_css();
?>
<div id="header-top">
	<ul id="main-menu" class="clearfix">
		<li><a href="<?php echo url_site(); ?>"><span class="logo"><img src="/theme/default/tmp/s.png"></span></a></li>
		<li><a href="<?php echo url_post_list('test', false); ?>"><span><img src="/theme/default/tmp/question.png"></span></a></li>
		<li><a href="<?php echo url_post_list('test-freetalk', false); ?>"><span><img src="/theme/default/tmp/comment.png"></span></a></li>
		<li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/anchor.png"></span></a></li>
		<li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/news.png"></span></a></li>
		<li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/jobs.png"></span></a></li>
		<li><a href="<?php echo url_site(); ?>"><span><img src="/theme/default/tmp/greetings.png"></span></a></li>
		<li><span class="show-panel"><img src="/theme/default/tmp/menu.png"></span></li>
	</ul>
</div>
<?php 
//temporary solution
if( $_SERVER['REQUEST_URI'] == '/' ){ ?>
<div class="front-top-banner">
	<img class='arrow' direction='left' src="/theme/wooreeedu/img/top_arrow_left.png"/>
	<img class='arrow' direction='right' src="/theme/wooreeedu/img/top_arrow_right.png"/>
	<div class='inner'>
		<?php
			$posts = getPostWithImage(0, 5, 'test');
			echo getFrontTopBannerImages( $posts, 1280, 400 );
		?>
	</div>
</div>
<?php } ?>