<?php
add_css();

extract( $variables );

?>
<div id="header-top">
	<div class='inner'>
		<a href="/"><img class='logo' src="/theme/wooreeedu/img/full_logo.png"/></a>
		<ul id="main-menu" class="clearfix">
			<li><a <?php if( $_SERVER['REQUEST_URI'] == '/' ) echo "class='is-active'"; ?> href='/'>Home</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'course' ) echo "class='is-active'"; ?> href='/course'>Course</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'junior' ) echo "class='is-active'"; ?> href='/junior'>Junior</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'camp' ) echo "class='is-active'"; ?> href='/camp'>Camp</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'gallery' ) echo "class='is-active'"; ?> href='/gallery'>Gallery</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'videoEnglish' ) echo "class='is-active'"; ?> href='/ve'>Video English</a></li>
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