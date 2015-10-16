<?php
add_css();
?>
<div id="header-top">
	<div class='inner'>
		<img class='logo' src="/theme/wooreeedu/img/full_logo.png"/>
		<ul id="main-menu" class="clearfix">
			<li><a class='is-active' href='/'>Home</a></li>
			<li><a href='#'>Products</a></li>
			<li><a href='#'>News</a></li>
			<li><a href='#'>About Us</a></li>
			<li><a href='#'>Contact Us</a></li>
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