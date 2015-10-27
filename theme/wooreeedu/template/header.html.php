<?php
add_css();

extract( $variables );
add_css('featured.item.css');
?>
<div class='top-menu'>
	<div class='inner clearfix'>
		<div class='left'>
			<a href='/'>홈</a><span class='bullet'>•</span>
			<a href='#'>우리에듀 소개</a><span class='bullet'>•</span>
			<a href='#'>질문하기</a><span class='bullet'>•</span>
			<a href='/pricing'>Pricing</a><span class='bullet'>•</span>
			<a href='/great'>Great</a>
		</div>
		<div class='right'>
			<?php 
				$user_idx = login('idx');
				if( empty( $user_idx ) ){
			?>
				<a href='/user/register'>Register</a>
				<span class='bullet'>•</span>			
				<a href='/user/login'>Login</a>
			<?php } else { ?>
				<a href='/user/register'>My Profile</a>
				<span class='bullet'>•</span>		
				<a href='/user/logout'>Logout</a>
			<?php } ?>
		</div>
	</div>
</div>
<div id="header-top">	
	<div class='inner'>
		<a href="/"><img class='logo' src="/theme/wooreeedu/img/full_logo.png"/></a>
		<ul id="main-menu" class="clearfix">
			<li><a <?php if( !empty( $page ) && $page == 'introduction' ) echo "class='is-active'"; ?> href='/introduction'>학원소개</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'course' ) echo "class='is-active'"; ?> href='/course'>어학연수</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'junior' ) echo "class='is-active'"; ?> href='/junior'>조기유학</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'camp' ) echo "class='is-active'"; ?> href='/camp'>단기캠프</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'gallery' ) echo "class='is-active'"; ?> href='/gallery'>프로그램</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'videoEnglish' ) echo "class='is-active'"; ?> href='/ve'>화상영어</a></li>
			<!--<li><a class='contactUs' href='#'>Contact Us</a></li>-->
		</ul>
		<div class='sub-menu'>
			<div class='inner clearfix'>
				<div class='featuredPost'>
					<div class='page-navigator'>
				<?php
					for( $i = 1; $i<=5; $i++ ){
						if( $i == 1 ) $is_active = ' is-active';
						else $is_active = null;
						echo "<div class='page-item$is_active' page='$i'></div>";
					}
				?>
				</div>
					<div class='inner'>
						<div class='item fake'><div class='banner'><img src='/theme/wooreeedu/img/popsong_5.jpg'/></div><div class='title text-center'>Title 5</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/popsong_1.jpg'/></div><div class='title text-center'>Title 1</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/popsong_2.jpg'/></div><div class='title text-center'>Title 2</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/popsong_3.jpg'/></div><div class='title text-center'>Title 3</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/popsong_4.jpg'/></div><div class='title text-center'>Title 4</div></div><div class='item'>
						<div class='banner'><img src='/theme/wooreeedu/img/popsong_5.jpg'/></div><div class='title text-center'>Title 5</div></div><div class='item fake'>
						<div class='banner'><img src='/theme/wooreeedu/img/popsong_1.jpg'/></div><div class='title text-center'>Title 1</div></div>				
					</div>
				</div>
				<div class='item-list text-center'>
					<table cellpadding=0 cellspacing=0>
						<tr valign='top'>
							<td width='16.67%'>
								<div class='item'>
									<div class='label'>학원소개</div>
									<ul>
										<li><a href="/introduction/multiLanguage">Multi Language</a></li>
										<li><a href="/introduction/multiLanguage_2">Preparation</a></li>
										<li><a href="/introduction/schoolDormitory">Dormitories</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<div class='label'>어학연수</div>
									<ul>
										<li><a href="/course/lecture">Lecture</a></li>
										<li><a href="/course/trainingCost">Training Cost</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<div class='label'>조기유학</div>
									<ul>
										<li><a href="/junior/juniorEarlyStudy">Early Study</a></li>
										<li><a href="/junior/advantagesInPH">Advantages</a></li>
										<li><a href="/junior/earlyCost">Early Cost</a></li>
										<li><a href="/junior/recommended">Recommend</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<div class='label'>단기캠프</div>
									<ul>
										<li><a href="/camp/campInformation">Information</a></li>
										<li><a href="/camp/schedule">Schedule</a></li>
										<li><a href="/camp/preparation">Preparation</a></li>
										<li><a href="/camp/weekendActivities">Weekend</a></li>
										<li><a href="/camp/requirement">Requirements</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<div class='label'>프로그램</div>
									<ul>
										<li><a href="/gallery/popsong">Pop Song</a></li>
										<li><a href="/gallery/tripping">Tripping</a></li>
										<li><a href="/gallery/speech">Speech</a></li>
										<li><a href="/gallery/xmas">Christmas</a></li>
										<li><a href="/gallery/seminar">Seminar</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<div class='label'>화상영어</div>
									<ul>
										<li><a href="#">Teachers</a></li>
										<li><a href="#">Schedule</a></li>
										<li><a href="#">Reservation</a></li>
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
if( !empty( $variables['page'] )  ){
	$page = $variables['page'];
	
	if( strpos( $page, "post." ) !== false ) {
		$page = 'post';
		$text = "<a href='/post/list?id=".post_config()->getCurrent()->id."'>".post_config()->getCurrent()->name."</a>";
	}
	else{
		$text = strtoupper($page);
		if( $text == "VIDEOENGLISH" ) $text = "VIDEO ENGLISH";
	}
	$url = "/theme/wooreeedu/img/header_".$page .".jpg";
	//if( file_exists( $url ) ){
	?>
	<div class='header-image'>	
		<img src='<?php echo $url; ?>'/>
		<div class='label'>
			<div class='text'>
				<?php echo $text; ?>
				<div class='bottom_bar'></div>
			</div>
		</div>
	</div>
	<?php 
	//}
} 
?>
<?php 
//temporary solution
if( $_SERVER['REQUEST_URI'] == '/' ){ ?>
<div class="front-top-banner">
	<div class='arrow' direction='left'>
		<img src="/theme/wooreeedu/img/top_arrow_left.png"/>
	</div>
	<div class='arrow' direction='right'>
		<img src="/theme/wooreeedu/img/top_arrow_right.png"/>
	</div>
	<div class='inner'>
		<img class='banner fake' src='/theme/wooreeedu/img/banner_5.jpg'/><img class='banner' src='/theme/wooreeedu/img/banner_1.jpg'/><img class='banner' src='/theme/wooreeedu/img/banner_2.jpg'/><img class='banner' src='/theme/wooreeedu/img/banner_3.jpg'/><img class='banner' src='/theme/wooreeedu/img/banner_4.jpg'/><img class='banner' src='/theme/wooreeedu/img/banner_5.jpg'/><img class='banner fake' src='/theme/wooreeedu/img/banner_1.jpg'/>
	</div>
</div>
<?php } ?>