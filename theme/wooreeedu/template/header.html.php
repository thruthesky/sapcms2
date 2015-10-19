<?php
add_css();

//di( $_GET );
?>
<div id="header-top">
	<div class='inner'>
		<a href="/"><img class='logo' src="/theme/wooreeedu/img/full_logo.png"/></a>
		<ul id="main-menu" class="clearfix">
			<li><a <?php if( $_SERVER['REQUEST_URI'] == '/' ) echo "class='is-active'"; ?> href='/'>Home</a></li>
			<li><a <?php if( !empty( $_GET['id'] ) && $_GET['id'] == 'course' ) echo "class='is-active'"; ?> href='/post/list?id=course'>Courses</a></li>
			<li><a <?php if( !empty( $_GET['id'] ) && $_GET['id'] == 'program' ) echo "class='is-active'"; ?> href='/post/list?id=program'>Programs</a></li>
			<li><a <?php if( !empty( $_GET['theme_page'] ) && $_GET['theme_page'] == 'schedule' ) echo "class='is-active'"; ?> href='/?theme_page=schedule'>Schedules</a></li>
			<li><a <?php if( !empty( $_GET['id'] ) && $_GET['id'] == 'wooreeedu_blog' ) echo "class='is-active'"; ?> href='/post/list?id=wooreeedu_blog'>Blog</a></li>
			<li><a <?php if(!empty( $_GET['id'] ) &&  $_GET['id'] == 'wooreeedu_gallery' ) echo "class='is-active'"; ?> href='/post/list?id=wooreeedu_gallery'>Gallery</a></li>
			<li><a class='contactUs' href='#'>Contact Us</a></li>
		</ul>
	</div>
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