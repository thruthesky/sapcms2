<?php
add_css();

extract( $variables );
add_css('featured.item.css');
?>
<div class='top-menu'>
	<div class='inner clearfix'>
		<div class='left'>
			<a href='/'>홈</a><span class='bullet'>•</span>
			<!--<a href='#'>우리에듀 소개</a><span class='bullet'>•</span>-->
			<a href='/post/list?id=qna'>질문하기</a><span class='bullet'>•</span>
			<a href='/course/1'>수업과정</a><span class='bullet'>•</span>
			<a href='/ve?page=teacher_list'>레벨테스트</a><span class='bullet'>•</span>
			<a href='/ve?page=teacher_list'>선생님목록</a>
		</div>
		<div class='right'>
			<?php 
				$user_idx = login('idx');
				if( empty( $user_idx ) ){
			?>
				<a href='/user/register'>회원가입</a>
				<span class='bullet'>•</span>			
				<a href='/user/login'>로그인</a>
			<?php } else { ?>
				<a href='/user/profile'>나의 정보</a>
				<span class='bullet'>•</span>
				<a href='/user/logout'>로그아웃</a>
			<?php } ?>
		</div>
	</div>
</div>
<div id="header-top">
	<div class='inner'>
		<a href="/"><img class='logo' src="/theme/englishworld/img/full_logo.png"/></a>
		<ul id="main-menu" class="clearfix">
			<li><a <?php if( !empty( $page ) && $page == 'introduction' ) echo "class='is-active'"; ?> href='/introduction/1'>학원소개</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'course' ) echo "class='is-active'"; ?> href='/ve?page=teacher_list'>강사목록</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'junior' ) echo "class='is-active'"; ?> href='/junior/1'>무료체험</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'camp' ) echo "class='is-active'"; ?> href='/camp/1'>수업신청</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'gallery' ) echo "class='is-active'"; ?> href='/gallery/1'>교재안내</a></li>
			<li><a <?php if( !empty( $page ) && $page == 'videoEnglish' ) echo "class='is-active'"; ?> href='/post/list?id=qna'>고객센터</a></li>
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
						<div class='item fake'><div class='banner'><img src='/theme/englishworld/img/menu_photo_5.jpg'/></div><div class='title text-center'>화상 콜센터 영어 수업</div></div><div class='item'><!--this is a fake banner 화상 콜센터 단합대회-->
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_1.jpg'/></div><div class='title text-center'>선생님 노래자랑</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_2.jpg'/></div><div class='title text-center'>화상 콜센터 바다 여행</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_4.jpg'/></div><div class='title text-center'>화상 콜센터 시상식</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_3.jpg'/></div><div class='title text-center'>화상 콜센터 파티</div></div><div class='item'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_5.jpg'/></div><div class='title text-center'>화상 콜센터 영어 수업</div></div><div class='item fake'>
						<div class='banner'><img src='/theme/englishworld/img/menu_photo_1.jpg'/></div><div class='title text-center'>선생님 노래자랑</div></div><!--this is a fake banner  화상 콜센터 팝송 노래-->
					</div>
				</div>
				<div class='item-list text-center'>
					<table cellpadding=0 cellspacing=0>
						<tr valign='top'>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/introduction/1">인사말</a></li>
										<li><a href="/introduction/3">처음 오신분</a></li>
										<li><a href="/introduction/4">화상 콜센터</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/ve?page=teacher_list">선생님 목록</a></li>
										<li><a href="/ve?page=reservation">수업 시간표</a></li>
										<li><a href="/ve?page=past">수업 평가</a></li>
										<li><a href="/ve?page=solution">강의실 입장</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/junior/1">무료체험 신청</a></li>
										<li><a href="/junior/3">무료체험 진행</a></li>
										<li><a href="/junior/4">무료체험 결과</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/camp/2">수업 신청 안내</a></li>
										<li><a href="/camp/3">수업료 안내</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/gallery/1">교재안내</a></li>
										<li><a href="/gallery/2">파닉스 영어</a></li>
										<!--<li><a href="/gallery/3">어린이 영어</a></li>-->
										<li><a href="/gallery/4">기초 영어 회화</a></li>
										<li><a href="/gallery/5">비지니스 영어</a></li>
										<li><a href="/gallery/6">읽기/독해</a></li>
									</ul>
								</div>
							</td>
							<td width='16.67%'>
								<div class='item'>
									<ul>
										<li><a href="/post/list?id=qna">질문과답변</a></li>
										<li><a href="/post/list?id=story">수업후기</a></li>
										<li><a href="/post/list?id=reminder">공지사항</a></li>
										<li><a href="/forum/1">전화 상담 안내</a></li>
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
	$text = null;
	if( strpos( $page, "post." ) !== false ) {
		$page = 'post';
		//$text = "<a href='/post/list?id=".post_config()->getCurrent()->id."'>".post_config()->getCurrent()->name."</a>";
		$text = 'FORUM';
	}
	else{
		if( !empty( $variables['header_text'] ) ) $text = $variables['header_text'];
		//$text = strtoupper($varia);
	}
	$url = "/theme/englishworld/img/header_".$page .".jpg";
	//$url = "/theme/englishworld/img/header_text.png";
	//if( file_exists( $url ) ){
	?>
	<div class='header-image<?php if( !empty( $page ) ) echo ' '.$page; ?>'>	
		<img src='<?php echo $url; ?>'/>
		<div class='label'>
			<div class='inner'>
				<?php if( !empty( $text ) ) { ?>
				<div class='text'>
					<?php echo $text; ?>
					<div class='bottom_bar'></div>
				</div>
				<?php } ?>
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
		<img src="/theme/englishworld/img/top_arrow_left.png"/>
	</div>
	<div class='arrow' direction='right'>
		<img src="/theme/englishworld/img/top_arrow_right.png"/>
	</div>
	<div class='inner'>
		<div class='banner-wrapper five'>
			<img class='banner fake' src='/theme/englishworld/img/banner_5.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>읽고, 토론하며, 함께 배우는 우리에듀.</div><br>
						<div class='text bottom'>배움의 지름길 우리에듀</div><br>
						<div class='text more'>자세히 보기<div class='triangle'></div></div>
					</div>
				</div>
				<?php /*
				<div class='inner'>
					<div class='text top'>우리에듀 홈페이지에 오신 것을 환영합니다.</div><br>
					<div class='text bottom'>배움의 지름길 우리에듀!</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
				*/ ?>
			</div>
		</div><div class='banner-wrapper one '>
			<img class='banner' src='/theme/englishworld/img/banner_1.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>						
						<div class='text top'>영어는 언어이며 소통! 각 나라의 친구와 함께!</div><br>
						<div class='text bottom'>배움의 지름길 우리에듀!</div><br>
						<div class='text more'>자세히 보기<div class='triangle'></div></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper two'>
			<img class='banner' src='/theme/englishworld/img/banner_2.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<img class='fake-image' src='/theme/englishworld/img/banner_fake_image_perfect_sides.png'/>
						<div class='text-items'>
							<div class='text top'>어학연수, 단기 캠프, 조기유학</div>
							<div class='text bottom'>우리에듀와 함께 신나는 영어 공부를 합시다.</div>
							<div class='text more'><a href='#'>자세히 보기<div class='triangle'></div></a></div>
						</div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper three'>
			<img class='banner' src='/theme/englishworld/img/banner_3.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>우리에듀의 자랑. 멋진 선생님과 알찬 수업 과정.</div><br>
						<div class='text bottom'>새로운 친구들을 사귀어 보세요.</div><br>
						<div class='text more'><a href='#'>자세히 보기<div class='triangle'></div></a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper four'>
			<img class='banner' src='/theme/englishworld/img/banner_4.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>영어공부는 암기가 아닌 생활 습관! 지겨운 공부는 시간 낭비!</div><br>
						<div class='text bottom'>우리에듀에서 진정한 배움의 시간을 가지세요.</div><br>
						<div class='text more'><a href='#'>자세히 보기</a></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper five'>
			<img class='banner' src='/theme/englishworld/img/banner_5.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
						<div class='text top'>읽고, 토론하며, 함께 배우는 우리에듀.</div><br>
						<div class='text bottom'>배움의 지름길 우리에듀</div><br>
						<div class='text more'>자세히 보기<div class='triangle'></div></div>
					</div>
				</div>
			</div>
		</div><div class='banner-wrapper one'>
			<img class='banner fake' src='/theme/englishworld/img/banner_1.jpg'/>
			<div class='text-info'>
				<div class='inner'>
					<div class='wrapper'>
							<div class='text top'>영어는 언어이며 소통! 각 나라의 친구와 함께!</div><br>
							<div class='text bottom'>배움의 지름길 우리에듀!</div><br>
							<div class='text more'>자세히 보기<div class='triangle'></div></div>
					</div>
				</div>
				<?php /*
				<div class='inner'>					
					<div class='text top'>지금 바로 문의 해 주세요!</div><br>
					<div class='text bottom'>우리에듀</div><br>
					<div class='text more'>자세히 보기<div class='triangle'></div></div>
				</div>
				*/ ?>
			</div>
		</div>
	</div>
</div>
<?php } ?>