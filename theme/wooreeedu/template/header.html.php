<?php
add_css();

extract( $variables );
add_css('featured.item.css');
?>
<div class='top-menu'>
	<div class='inner clearfix'>
		<div class='left'>
			Welcome to Wooreeedu.com !!
		</div>
		<div class='right'>
			<?php 
				$user_idx = login('idx');
				if( empty( $user_idx ) ){
			?>
				<a href='/user/register'>Register</a>			
				<a href='/user/login'>Login</a>
			<?php } else { ?>
				<a href='/user/register'>My Profile</a>			
				<a href='/user/logout'>Logout</a>
			<?php } ?>
		</div>
	</div>
</div>
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
		<div class='sub-menu'>
			<div class='inner clearfix'>
				<div class='featuredPost'>
				<?php 
					$posts = getPostWithImage(0, 1, 'test'); 
					if( !empty( $posts ) ) echo postFeaturedItem( $posts, 280, 180, 15 );
				?>		
				</div>
				<div class='item-list text-center'>
					<table cellpadding=0 cellspacing=0>
						<tr valign='top'>
							<td width='25%'>
								<div class='item'>
									<div class='label'>Course</div>
									<ul>
										<li><a href="/course/lecture">Lecture</a></li>
										<li><a href="/course/trainingCost">Training Cost</a></li>
									</ul>
								</div>
							</td>
							<td width='25%'>
								<div class='item'>
									<div class='label'>Junior</div>
									<ul>
										<li><a href="/junior/juniorEarlyStudy">Early Study</a></li>
										<li><a href="/junior/advantagesInPH">Advantages in Philippines</a></li>
										<li><a href="/junior/earlyCost">Early Cost</a></li>
										<li><a href="/junior/recommended">Recommendations</a></li>
									</ul>
								</div>
							</td>
							<td width='25%'>
								<div class='item'>
									<div class='label'>Camp</div>
									<ul>
										<li><a href="/camp/campInformation">Information</a></li>
										<li><a href="/camp/schedule">Schedule</a></li>
										<li><a href="/camp/preparation">Preparation</a></li>
										<li><a href="/camp/weekendActivities">Weekend</a></li>
										<li><a href="/camp/requirement">Requirements</a></li>
									</ul>
								</div>
							</td>
							<td width='25%'>
								<div class='item'>
									<div class='label'>Gallery</div>
									<ul>
										<li><a href="/gallery/popsong">Pop Song</a></li>
										<li><a href="/gallery/tripping">Tripping</a></li>
										<li><a href="/gallery/speech">Speech</a></li>
										<li><a href="/gallery/xmas">Christmas</a></li>
										<li><a href="/gallery/seminar">Seminar</a></li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				</div><!--/item-list-->
			</div><!--/inner-->
		</div><!--/sub-menu-->
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